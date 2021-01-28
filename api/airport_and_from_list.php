<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

function get_airport_list(){
    // Airports Array
    return [
        "Heathrow Airport",
        "Stanstead Airport",
        "Gatwick Airport",
        "City Airport",
        "Luton Airport"
    ];
}

function get_residential_area_list(){
    $from_list = [];

    // Other Places
    global $wpdb;
    $result = $wpdb->get_results (
      "
      SELECT _from 
      FROM aa_route_pricing
      "
      );

      foreach($result as $item){
          $from_list[] = $item->_from;
      }
      return $from_list;
}
    
