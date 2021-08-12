<?php
namespace AAALRouteMapHelper;
/**
 * Plugin Name: Route Map Helper
 * Plugin URI: hhttps://github.com/naimurhasan/route-map-helper-plugin
 * Description: Route map helper for AA Airport Link
 * Version: 1.3
 * Author: naimurhasan   
 * Author URI: http://naimurhasan.github.io
 */
!defined('ABSPATH') && exit;

// common functions
require_once( plugin_dir_path( __FILE__  ).'/functions.php' );

// add admin page
require_once( plugin_dir_path( __FILE__  ).'/admin/admin.php' );

// api route
require_once( plugin_dir_path( __FILE__  ).'/api/map-route-api.php' );

// shortcode
require_once( plugin_dir_path( __FILE__  ).'/shortcode/route_map_helper_form.php' );
require_once( plugin_dir_path( __FILE__  ).'/shortcode/route_map_per_km.php' );

// add css 
function myplugin_enqueue_style() {
    // plugin custom styles
    wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ).'css/style.css' );

    // sweetalert2
    add_action( 'wp_head', function(){
        echo '<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">';
    } );
}
add_action( 'wp_enqueue_scripts', 'AAALRouteMapHelper\myplugin_enqueue_style' );

// add pages
require_once( plugin_dir_path( __FILE__  ).'/pages.php' );