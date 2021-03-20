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
    }

    return $original_template;
});


