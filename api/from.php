<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'/airport_and_from_list.php' );

function show_form_list(){
    // Airports Array
    $airport_arr = get_airport_list();
    $not_airport_arears = get_residential_area_list();

    $all_the_route_names = $airport_arr+$not_airport_arears; 

    echo \json_encode($all_the_route_names, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES);
}
