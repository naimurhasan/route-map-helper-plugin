<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

function route_map_per_km_form_shortcode(){

    // check if price not set in settings
    $price_per_km = get_option(ROUTE_MAP_PRICE_PER_KM);

    if($price_per_km == null || $price_per_km == ''){
      return "<font color='red'><strong>Please set price per Km:<br/>wp-admin >> route-map-helper >> setting</strong></font>";
    }

    ob_start();
    ?>

<link href="https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
<style>
#map { width: 100%; height: 300px; }
</style>
<div id="map"></div>
<div class="mt-2"><button class="btn btn-info">Confirm</button></div>
 

<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoibmFpbXVyaGFzYW5yd2QiLCJhIjoiY2tqdWVmb3BlMjRiZDJ5azMwYzhlcDB0ZCJ9.auWSAtFMPxNUrcn-xoEZ0g';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-79.4512, 43.6568],
        zoom: 13
    });
 
    map.addControl(
        new MapboxDirections({
        accessToken: mapboxgl.accessToken
    }),
    'top-left'
    );
</script>
 

<?php
  
    return ob_get_clean();
}

add_shortcode( 'route_map_per_km_form', 'AAALRouteMapHelper\route_map_per_km_form_shortcode' );