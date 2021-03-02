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

    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

    ?>
    <nav class="nav-tab-wrapper">
    <a href="?page=map-route-helper" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>" >Pricing Table</a>      
    <a href="?page=map-route-helper&tab=setting" class="nav-tab <?php if($tab==='setting'):?>nav-tab-active<?php endif; ?>">Setting</a>
    </nav>
    <?php
    if($tab==='setting'){
        include_once( plugin_dir_path( __FILE__  ).'/views/setting-page.php' );
    }else{
        include_once( plugin_dir_path( __FILE__  ).'/views/home-page.php' );
    }
    
}


function add_bootstrap(){
    if($_GET['page'] == 'map-route-helper'){
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">';
    }
}