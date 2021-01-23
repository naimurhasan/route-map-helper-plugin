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

