<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

function get_airport_list(){

    // Later I Will Imporove this funciton
    // I will query column name in databse eg. heathrow_airport
    // we will replace _ with space
    // I will Capitalize
    // I Will return A Capitalized
    // Airport Name

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

function get_column_name_for_airport($airport_name){
    
    $name_to_lower = strtolower($airport_name);
    
    $column_name = str_replace(" ", "_", $name_to_lower);

    return $column_name;
    
}
    
