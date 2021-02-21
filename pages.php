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
 
    if(CURRENT_SLUG == SELECT_CAR){
        header("HTTP/1.1 200 OK");
        
        add_filter("pre_get_document_title", function($old_title){
            return "Select a car - ".get_bloginfo('name');
        });
        
        
        return plugin_dir_path( __FILE__ ) . 'templates/selectcar.php';
    }else{
        return $original_template;
    }
});
