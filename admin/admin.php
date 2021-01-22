<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

// Add Bootstrap 
add_action('admin_head', 'AAALRouteMapHelper\add_bootstrap');

// Add First Menu
add_action( 'admin_menu', 'AAALRouteMapHelper\register_my_custom_menu_page' );

function register_my_custom_menu_page() {
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'Route Map Helper', 'Route Map Helper', 'manage_options', 'map-route-helper', 'AAALRouteMapHelper\admin_page_view', 'dashicons-randomize', 3 );
}

function admin_page_view(){
    include_once( plugin_dir_path( __FILE__  ).'/views/page.php' );
}


function add_bootstrap(){
    if($_GET['page'] == 'map-route-helper'){
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">';
    }
}