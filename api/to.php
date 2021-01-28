<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'/airport_and_from_list.php' );

function show_to_list(){
    if(isset($_GET['from'])){

        // First we need to Know is user selected airport as from or non airport
        $_from = $_GET['from'];
        
        if(get_location_type($_from) && get_location_type($_from) == LocationType::NON_AIRPORT){

            echo  \json_encode(get_airport_list(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        }else if(get_location_type($_from) && get_location_type($_from) == LocationType::AIRPORT){

            echo  \json_encode(get_residential_area_list(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        }else{

            status_header(404);
            echo "LOCATION DOESN'T EXIST";
            echo \json_encode(['message' => "LOCATION DOESN'T EXIST"]);

        }

        // echo \json_encode(['from' => $_from]);


    }else{
        echo \json_encode(['message' => 'Please select from location.']);
    }
    // Airports Array
    // $airport_arr = get_airport_list();
    // $not_airport_arears = get_residential_area_list();

    // $all_the_route_names = $airport_arr+$not_airport_arears; 

    // echo \json_encode($all_the_route_names, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES);
}

abstract class LocationType
{
    const AIRPORT = 'AIRPORT';
    const NON_AIRPORT = 'NON_AIRPORT';
}

function get_location_type($locaiton){
    
    if(in_array($locaiton, get_airport_list())){
        return LocationType::AIRPORT;
    }else if(in_array($locaiton, get_residential_area_list())){
        return LocationType::NON_AIRPORT;
    }else{
        return false;
    }

}