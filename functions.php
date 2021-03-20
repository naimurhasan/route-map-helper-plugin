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


/***  WOOCOMMERCE PRODUCT PRICE UPDATE IF ROUTE MAP PRODUCT */

// add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'delshipping_calc_in_cart', 1000 );
// Change Price Only After Submit For
function woocommerce_custom_price_to_cart_item( $cart_object ) {  
    if( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->cart_contents as $key => $value ) {
            if( isset( $value["custom_price"] ) ) {
                $value['data']->set_price($value["custom_price"]);
            }
        }  
    }  
}
add_action( 'woocommerce_before_calculate_totals', 'AAALRouteMapHelper\woocommerce_custom_price_to_cart_item', 1000 );


/** Cart Meta As Order Meta */
/* Last Function on Order Checkout */
add_action( 'woocommerce_checkout_create_order_line_item', 'AAALRouteMapHelper\save_cart_item_custom_meta_as_order_item_meta', 10, 4 );
function save_cart_item_custom_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {

    if ( isset($values['from']) ) {
        $item->update_meta_data( 'From', $values['from'] );
    }

    if ( isset($values['to']) ) {
        $item->update_meta_data( 'To', $values['to'] );
    }

    if ( isset($values['car']) ) {
        $item->update_meta_data( 'Car', $values['car'] );
    }

    if ( isset($values['route']) ) {
        $item->update_meta_data( 'Route', $values['route'] == 's' ? 'Single' : 'Round' );
    }

    if ( isset($values['head-passenger-name']) ) {
        $item->update_meta_data( 'Head Passenger Name', $values['head-passenger-name'] );
    }

    if ( isset($values['passenger-mobile'])  ) {
        $item->update_meta_data( 'Passenger Mobile', $values['passenger-mobile'] );
    }

    if ( isset($values['passenger-count'])  ) {
        $item->update_meta_data( 'Passenger Count', $values['passenger-count'] );
    }

    if ( isset($values['luggage']) ) {
        $item->update_meta_data( 'Luggage', $values['luggage'] );
    }
    
    if ( isset($values['flight-number'])  ) {
        $item->update_meta_data( 'Flight Number', $values['flight-number'] );
    }

    if ( isset($values['meet-service']) ) {
        $item->update_meta_data( 'Meet Service', $values['meet-service'] );
    }

    if ( isset($values['arrival-time']) && isset($values['arrival-time']) ) {
        $item->update_meta_data( 'Arrival Time', $values['arrival-time'] );
    }

    if(isset($cart_item['arrival-time'])){
        $item_data[] = array(
                    'key'       => 'arrival-time',
                    'value'     => $cart_item['arrival-time'],
                );
    }

    

} // checkout hook


// Display custom cart item meta data (in cart and checkout)
add_filter( 'woocommerce_get_item_data', 'AAALRouteMapHelper\display_cart_item_custom_meta_data', 10, 2 );
function display_cart_item_custom_meta_data( $item_data, $cart_item ) {

    if(isset($cart_item['from'])){
        $item_data[] = array(
                    'key'       => 'from',
                    'value'     => $cart_item['from'],
                );
    }

    if(isset($cart_item['to'])){
        $item_data[] = array(
                    'key'       => 'to',
                    'value'     => $cart_item['to'],
                );
    }

    if(isset($cart_item['car'])){
        $item_data[] = array(
                    'key'       => 'car',
                    'value'     => $cart_item['car'],
                );
    }

    if(isset($cart_item['route'])){
        $item_data[] = array(
                    'key'       => 'route',
                    'value'     => $cart_item['route'] == 's' ? 'Single' : 'Round',
                );
    }

    // if(isset($cart_item['head-passenger-name'])){
    //     $item_data[] = array(
    //                 'key'       => 'head passenger name',
    //                 'value'     => $cart_item['head-passenger-name'],
    //             );
    // }

    // if(isset($cart_item['passenger-mobile'])){
    //     $item_data[] = array(
    //                 'key'       => 'passenger mobile',
    //                 'value'     => $cart_item['passenger-mobile'],
    //             );
    // }

    // if(isset($cart_item['passenger-count'])){
    //     $item_data[] = array(
    //                 'key'       => 'passenger count',
    //                 'value'     => $cart_item['passenger-count'],
    //             );
    // }

    // if(isset($cart_item['luggage'])){
    //     $item_data[] = array(
    //                 'key'       => 'luggage',
    //                 'value'     => $cart_item['luggage'],
    //             );
    // }

    // if(isset($cart_item['flight-number'])){
    //     $item_data[] = array(
    //                 'key'       => 'flight number',
    //                 'value'     => $cart_item['flight-number'],
    //             );
    // }

    // if(isset($cart_item['meet-service'])){
    //     $item_data[] = array(
    //                 'key'       => 'meet service',
    //                 'value'     => $cart_item['meet-service'],
    //             );
    // }

    // if(isset($cart_item['arrival-time'])){
    //     $item_data[] = array(
    //                 'key'       => 'Arrival Time',
    //                 'value'     => $cart_item['arrival-time'],
    //             );
    // }


    return $item_data;
}

/**
 * Admin order page bKash data output
 */
// add_action('woocommerce_admin_order_data_after_order_details', 'AAALRouteMapHelper\route_map_admin_order_data' );
// function route_map_admin_order_data( $order ){
//     echo "<pre>";
//     print_r($order);
//     echo "</pre>";
// }
