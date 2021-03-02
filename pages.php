<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'/functions.php' );
require_once( plugin_dir_path( __FILE__  ).'/api/price.php' );

\define('CURRENT_SLUG',  get_current_slug());


/**********
 * 
 * SELECT CAR PAGE
 * 
 * ************ */

add_filter( 'template_include', function(  $original_template ) {
    
    // SELECT CAR
    if( CURRENT_SLUG == SELECT_CAR && isset($_GET['from']) && isset($_GET['to']) ){

        
        $_from = $_GET['from'];
        $_to = $_GET['to'];

        $prices_for_route =  get_price($_from, $_to);
        
        if($prices_for_route == null){
            return $original_template;
        }
        
        // set response status
        header("HTTP/1.1 200 OK");

        // set page title
        add_filter("pre_get_document_title", function($old_title){
            return "Select a car - ".get_bloginfo('name');
        });

        
        // show page
        include_once(plugin_dir_path( __FILE__ ) . 'templates/selectcar.php');
        return;
    }

    // INPUT PASSANGER INFO
    
    if( CURRENT_SLUG == PASSANGER_INFO  ){
        // set response status
        header("HTTP/1.1 200 OK");

        // show page
        include_once(plugin_dir_path( __FILE__ ) . 'templates/passanger-info.php');
        return;
    }

    return $original_template;
});
