<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;


function show_price(){
    if(isset($_GET['from']) && isset($_GET['to'])){

       $_from = $_GET['from'];
       $_to = $_GET['to'];
       
       echo get_price_text($_from, $_to);

       // print_r(get_basic_price($_from, $_to));

       // get_column_name_for_airport("Heathrow Airport");
        

    }else{
        echo \json_encode(['message' => 'Please select from and to location.']);
    }

}

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
// make from to price detection


// return price for all four cars
// return [car1 => [s=>50, r=>100], car2 => ..]

// s-12/r-30 devide and return pricing
// return ['s'=> 30, 'r' => 20]; as input S-45/R-80
