<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

function route_map_per_km_form_shortcode(){

    // check if product is
    $route_product_id = get_option(ROUTE_MAP_OPTION_PRODUCT);

    if($route_product_id == null){
      return "<font color='red'><strong>Please set a product id in:<br/>wp-admin >> route-map-helper >> setting</strong></font>";
    }

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
button.btn.btn-info {    background-color: #ffca09; border: 0;  padding: 5px 25px;  color: black;   font-weight: bold;  border-radius: 3px;}
.mt-2 {margin-top: 7px;}
/* popup mile info */
.mapbox-directions-component.mapbox-directions-route-summary h1 {
    color: white;
}
</style>

<div id="map"></div>
<div class="mt-2"><button class="btn btn-info" id="map-confirm-button">Confirm</button></div>


<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoibmFpbXVyaGFzYW5yd2QiLCJhIjoiY2tqdWVmb3BlMjRiZDJ5azMwYzhlcDB0ZCJ9.auWSAtFMPxNUrcn-xoEZ0g';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-79.4512, 43.6568],
        zoom: 13,
    });
    
    var mapBoxDirection = new MapboxDirections({
        accessToken: mapboxgl.accessToken,
        unit : 'imperial',
        controls : {'profileSwitcher' : false},
    })

    map.addControl(
        mapBoxDirection,
        'top-left'
    );

    var headTag = document.getElementsByTagName('head')[0];
    /**********
    * Add jquery if not added already
    *******/
    if(typeof jQuery=='undefined') {
        
        var jqTag = document.createElement('script');
        jqTag.type = 'text/javascript';
        jqTag.src = 'http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
        headTag.appendChild(jqTag);
    }

    /**********
    * POLYFILL
    *******/
    var swalPolyfill = document.createElement('script');
    swalPolyfill.type = 'text/javascript';
    swalPolyfill.src = 'https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js';
    headTag.appendChild(swalPolyfill);

    /**********
    * SWEET ALERT
    *******/
    var swalAlert = document.createElement('script');
    swalAlert.type = 'text/javascript';
    swalAlert.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@10';
    headTag.appendChild(swalAlert);

    

    jQuery('#map-confirm-button').on('click', function(evt){
        
        // check if getOrigin
        let origin = mapBoxDirection.getOrigin()
        let originString = jQuery('#mapbox-directions-origin-input div input')?.val()
        let originCoordinates = origin.geometry?.coordinates?.toString()
        
        
        // if(typeof(originCoordinates) == 'undefined'){
        //     Swal.fire({
        //         icon: 'error',
        //         title:"Invalid input.",
        //         text: "Please select a correct 'from' location.",
        //     })
        //     return  
        // }
        

        // // check if getdestinatin
        // let destination = mapBoxDirection.getDestination()
        // let destinationString = jQuery('#mapbox-directions-destination-input div input')?.val()
        // let destinationCoordinates = destination.geometry?.coordinates?.toString()
        
        // if(typeof(destinationCoordinates) == 'undefined'){
        //     Swal.fire({
        //         icon: 'error',
        //         title:"Invalid input.",
        //         text: "Please select a correct 'to' location.",
        //     })
        //     return
        // }

        var form = document.createElement('form');
        form.setAttribute('action', '<?php echo site_url(); ?>/<?php echo SELECT_CAR_PER_MILE_ROUTE; ?>');
        form.setAttribute('method', 'POST');
 
        // from text
        var input1 = document.createElement('input');
        input1.setAttribute('name', 'from_text');
        input1.setAttribute('value', 'London Heathrow')

        // from coordinates
        var input2 = document.createElement('input');
        input2.setAttribute('name', 'from_coordinate');
        input2.setAttribute('value', [123123, 23213])

        // to text 
        var input3 = document.createElement('input');
        input3.setAttribute('name', 'to_text');
        input3.setAttribute('value', 'SE07')

        // to coordinates 
        var input4 = document.createElement('input');
        input4.setAttribute('name', 'to_coordinates');
        input4.setAttribute('value', [55555, 55555])


        // to coordinates 
        var input5 = document.createElement('input');
        input5.setAttribute('name', 'distance');
        input5.setAttribute('value', 20)


        form.appendChild(input1);
        form.appendChild(input2);
        form.appendChild(input3);
        form.appendChild(input4);
        form.appendChild(input5);
        form.style.display = "none";
        document.body.appendChild(form);

        form.submit();
    
    })

</script>
 

<?php
  
    return ob_get_clean();
}

add_shortcode( 'route_map_per_km_form', 'AAALRouteMapHelper\route_map_per_km_form_shortcode' );