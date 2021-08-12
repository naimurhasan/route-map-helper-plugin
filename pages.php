<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;


require_once( plugin_dir_path( __FILE__  ).'/api/price.php' );

\define('CURRENT_SLUG',  get_current_slug());




add_filter( 'template_include', function(  $original_template ) {
    
    
    // SELECT CAR
    if( CURRENT_SLUG == SELECT_CAR && isset($_GET['from']) && isset($_GET['to']) ){

        
        $_from = $_GET['from'];
        $_to = $_GET['to'];

        $prices_for_route =  get_price($_from, $_to);
        
        
        if($prices_for_route == null){
            
            return $original_template;
        }
        
        
        setSuccessHeader('Select a car');
        
        // show page
        include_once(plugin_dir_path( __FILE__ ) . 'templates/selectcar.php');
        return;
    }else if( CURRENT_SLUG == PASSANGER_INFO && isset($_GET['from']) && isset($_GET['to']) && isset($_GET['car']) && isset($_GET['route']) ){
        /**********
         * 
         * SELECT CAR PAGE
         * 
         * ************ */
        setSuccessHeader('Passenger Info');

        // show page
        include_once(plugin_dir_path( __FILE__ ) . 'templates/passanger-info.php');
        return;
    }else if( CURRENT_SLUG == PASSANGER_INFO_PER_KM ){
        /**********
         * 
         * SELECT CAR PAGE
         * 
         * ************ */
        setSuccessHeader('Passenger Info');

        // show page
        include_once(plugin_dir_path( __FILE__ ) . 'templates/passanger-info-coordinates.php');
        return;
    }else if( CURRENT_SLUG == SELECT_CAR_PER_MILE_ROUTE ){
        /**********
         * 
         * SELECT CAR PAGE
         * 
         * ************ */
        setSuccessHeader('Select Car');

        // per mile
        $price_per_km = get_option(ROUTE_MAP_PRICE_PER_KM);
        $price_per_km = $price_per_km*$_REQUEST['distance'];
        $price_per_km = round($price_per_km, 2);
        $basic_car_price_arr = ['s' => $price_per_km, 'r'=> $price_per_km*2];
        $prices_for_route = get_prices_for_everycar($basic_car_price_arr);
        
        // show page
        include_once(plugin_dir_path( __FILE__ ) . 'templates/selectcar-for-coordinates.php');
        return;
    }

    return $original_template;
});


