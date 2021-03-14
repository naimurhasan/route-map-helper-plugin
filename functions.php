<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

define('SELECT_CAR', 'select_car');
define('PASSANGER_INFO', 'passenger-info');
define('ROUTE_MAP_OPTION_PRODUCT', 'route-map-option-product');

/******
 * Return First url param or Slug Ater removing site address
 * **********/
function get_current_slug(){
    // full link
    $current_url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    // remove wordpress home url
    $current_slug = \str_replace(site_url().'/', '', $current_url);
    // Remove query string
     $current_slug = \str_replace($_SERVER['QUERY_STRING'], '', $current_slug);
     // remove trailing '?'
     if(\substr($current_slug, -1) == '?'){
      $current_slug = \substr($current_slug, 0, -1);
     }
     if(\substr($current_slug, -1) == '/'){
      $current_slug = \substr($current_slug, 0, -1);
     }
     return $current_slug;
}

/* Change Status to 200 from 404
* Also Change Page Not Found to Custom Title
*/
function setSuccessHeader($title){
    // set response status
    header("HTTP/1.1 200 OK");

    // set page title
    add_filter("pre_get_document_title", function($old_title) use ($title){
        return $title." - ".get_bloginfo('name');
    });
}