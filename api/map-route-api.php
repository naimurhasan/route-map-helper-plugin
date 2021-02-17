<?php
namespace AAALRouteMapHelper;
!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'../functions.php' );
require_once( plugin_dir_path( __FILE__  ).'/from.php' );
require_once( plugin_dir_path( __FILE__  ).'/to.php' );
require_once( plugin_dir_path( __FILE__  ).'/price.php' );

function MYFUNC_API_PAGE_Hooks() {

    $current_slug = get_current_slug();
  
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