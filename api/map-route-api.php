<?php
namespace AAALRouteMapHelper;
function MYFUNC_API_PAGE_Hooks() {

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
  
     if ($current_slug == 'map-route-api'){
      status_header(200);     
      echo "MY API CONTENTS GOES HERE";
      die();
     }
  
  }
  add_action('template_redirect', 'AAALRouteMapHelper\MYFUNC_API_PAGE_Hooks');