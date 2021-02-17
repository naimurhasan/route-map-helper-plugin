<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'/functions.php' );

\define('CURRENT_SLUG',  get_current_slug());


/**********
 * 
 * SELECT CAR PAGE
 * 
 * ************ */
// function wpse255804_add_page_template ($templates) {
//     $templates['selectcar.php'] = 'SelectCar';
//     return $templates;
//     }
// add_filter ('theme_page_templates', 'wpse255804_add_page_template');

add_filter( 'template_include', function(  $original_template ) {   
 
    if(CURRENT_SLUG == 'select_car'){
        header("HTTP/1.1 200 OK");
        return plugin_dir_path( __FILE__ ) . 'templates/selectcar.php';
    }else{
        return $original_template;
    }
});
