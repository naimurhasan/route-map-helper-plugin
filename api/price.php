<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;


function show_price(){
    if( isset($_GET['from']) && isset($_GET['to']) ){
        $_from = $_GET['from'];
        $_to = $_GET['to'];

        $get_price = get_price($_from, $_to);
        
        if($get_price == null){
            echo \json_encode(['message' => 'Locations doesn\'t match to any route.']);
        }else{
            echo \json_encode($get_price, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

    }else{
        echo \json_encode(['message' => 'Please select from and to location.']);
    }
}

function get_price($from, $to){
       
       $sorted_location = get_sorted_location($from, $to);
       
       $price_string = get_price_text($sorted_location['from'], $sorted_location['to']);

       if($price_string == ''){
           return null;
       }

       $basic_car_price_arr = string_to_price($price_string);
       
       $prices_for_every_car = get_prices_for_everycar($basic_car_price_arr);

       return $prices_for_every_car;
       
}

// / return S-45/R-80 
function get_price_text($from, $to){

    $column_name = get_column_name_for_airport($to);

    // Mysqli preapre can't preapre column name That's why quering *
    // instead of the specific column from get query
    // https://stackoverflow.com/questions/41598080/mysqli-prepared-statement-column-with-variable

    // get the pricing value
    global $wpdb;
    $sql = $wpdb->prepare (
      "
      SELECT *
      FROM aa_route_pricing
      WHERE _from = %s
      ",
      $from
      );

      $result = $wpdb->get_results( $sql );
      
      
      if(count($result)<1){ return; }

      return $result[0]->$column_name;

    // return S-45/R-80 
}

/***********
 * 
 * 
 * TODO
 * 
 * 
 *
 */

// input S-45/R-80
// return ['s'=> 30, 'r' => 20]
function string_to_price($price_string){
    $string_price_arr = \explode('/', $price_string);
    
    $pattern = '/[^\d.]*/';
    $single_price = \preg_replace($pattern, '', $string_price_arr[0]);
    $return_price = \preg_replace($pattern, '', $string_price_arr[1]);

    // return key name as s and r instead off single and return 
    // so I won't misspell
    return [ 's' => $single_price, 'r' => $return_price ];
}

// return price for all four cars
// Input ['s' => 1, 'r' => 2]
// return [car1 => [s=>50, r=>100], car2 => ..]
function get_prices_for_everycar($basic_car_price){
    // Note: Price will be added as following
    // Salon = $basic_car_price
    // Estate Car: S- £6/ R-12 . 
    // MPV: S-£15/R-£30. 
    // Executive: S-£15/ R-£30	
    $cars_and_addtions = [
        'Saloon' => [
                's' => 0,
                'r' => 0,
                'details' => "4 passengers 2 suitcases 1 hand luggage", 
        ],
        'Estate' => [
                's' => 6,
                'r' => 12,
                'details' => "4 passengers 4 suitcases 1 hand luggage",
        ],
        'Executive Saloon' => [
            's' => 15,
            'r' => 30,
            'details' => "4 passengers 2 suitcases 1 hand luggage",
        ],
        'MPV' => [
            's' => 15,
            'r' => 30,
            'details' => "5 passengers 5 suitcases 1 hand luggage",
        ],
    ];

    $prices_for_everycar = [];

    foreach(array_keys($cars_and_addtions) as $car_name){
        
        $prices_for_everycar[$car_name] = [
            // I'm adding this car price
            // With Basic Car Price
            's' => $basic_car_price['s']+$cars_and_addtions[$car_name]['s'],
            'r' => $basic_car_price['r']+$cars_and_addtions[$car_name]['r'],
            'car_details' => $cars_and_addtions[$car_name]['details'],
        ];

    }

    return $prices_for_everycar;

    
}

    // echo "BASIC CAR <BR>";
    // \print_r($basic_car_price);




// reverse from to if needed.
function get_sorted_location($from, $to){

    // normally from is non airport lcoation
    // and to is airport locaion

    // so if from is airport location
    // we swap the order
    // or just return in exising
    if( 
        in_array( $from, get_airport_list() ) 
      ){
        return ['from' => $to, 'to' => $from];
    }else{
        return ['from' => $from, 'to' => $to];
    }

}