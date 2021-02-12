<?php
namespace AAALRouteMapHelper;
/**
 * Plugin Name: Route Map Helper
 * Plugin URI: http://www.github.com/
 * Description: Route map helper for AA Airport Link
 * Version: 1.0
 * Author: naimurhasan   
 * Author URI: http://naimurhasan.github.io
 */
!defined('ABSPATH') && exit;

// add admin page
require_once( plugin_dir_path( __FILE__  ).'/admin/admin.php' );

// api route
require_once( plugin_dir_path( __FILE__  ).'/api/map-route-api.php' );

// shortcode
require_once( plugin_dir_path( __FILE__  ).'/shortcode/route_map_helper_form.php' );

// add css 
function myplugin_enqueue_style() {
    wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ).'css/style.css' ); 
}
add_action( 'wp_enqueue_scripts', 'AAALRouteMapHelper\myplugin_enqueue_style' );


