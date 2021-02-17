<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

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