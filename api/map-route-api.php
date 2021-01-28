<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'/from.php' );
require_once( plugin_dir_path( __FILE__  ).'/to.php' );
require_once( plugin_dir_path( __FILE__  ).'/price.php' );

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
      
      if(isset($_GET['get'])){

        switch($_GET['get']){
            case 'from':
                show_form_list();
                break;
            case 'to':
              show_to_list();
              break;
            case 'price':
              show_price();
              break;
            default:
                echo \json_encode(['message' => 'Welcome to Map Route API']);
                break;
        }
        
      }else{

        echo \json_encode(['message' => 'Welcome to Map Route API']);
      
     }

      die();
     }
  
  }
  add_action('template_redirect', 'AAALRouteMapHelper\MYFUNC_API_PAGE_Hooks');