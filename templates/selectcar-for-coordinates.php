<?php
/*
 * Template Name: Select Car
 * description: >-
  Page template for select car url
 */
require_once( plugin_dir_path( __FILE__  ).'../secret.php' );
require_once( plugin_dir_path( __FILE__  ).'../api/price.php' );
require_once( plugin_dir_path( __FILE__  ).'../functions.php' );

wp_enqueue_style( 'leaflet', plugin_dir_url( __FILE__ ).'../css/leaflet/leaflet.css' );
wp_enqueue_script( 'leaflet', plugin_dir_url( __FILE__ ).'../css/leaflet/leaflet.js' );

get_header(); 

?>


<style>
.select-car-form-wrapper {
    box-shadow: 0 2.8px 2.2px rgb(0 0 0 / 3%), 0 6.7px 5.3px rgb(0 0 0 / 5%), 0 12.5px 10px rgb(0 0 0 / 6%), 0 22.3px 17.9px rgb(0 0 0 / 7%), 0 41.8px 33.4px rgb(0 0 0 / 9%), 0 100px 80px rgb(0 0 0 / 12%);
    min-height: 200px;
    margin: 30px auto;
    background: white;
    border-radius: 5px;
    border: 1px solid #eaeaea;
    max-width:700px;
    padding: 5px;
}
#mapid {
        height: 280px;
}
span.location-type {
    font-weight: bold;
    color: #088e8a;
    font-size: 1.2em;
}
.car-option {
    background: linear-gradient(90deg, rgb(183 179 179 / 5%) 0%, rgb(133 133 133 / 25%) 100%);
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
}
.car-image-description p {
    padding-left: 15px;
}

.car-select-action label {
    display: block;
    margin: 5px;
    text-align: right;
}

.car-select-action {
    display: grid;
    place-content: center;
}
.car-options-section {
    padding: 5px;
}

</style>

<div id="primary" class="site-content">
  <div id="content" role="main">
    <div class="select-car-container">
      <div class="select-car-form-wrapper">
          <div>
            <?php print_r($_REQUEST); ?>
          </div>
          <!-- Map Here -->
          <div id="mapid"></div>
          <div class="locations-titles">
            <span class="location-type">From: </span><?php echo esc_html($_REQUEST['from']); ?>
            <span class="location-type">To: </span><?php echo esc_html($_REQUEST['to']); ?>
          </div>
          
            <?php
              foreach ($prices_for_route as $key => $value) {
                ?>
                <div class="car-options-section">
                  <div class="car-option">
                  <div class="car-image-description">
                    <img class="select-car-form-option-img" src="<?php echo plugin_dir_url(__DIR__).'images/'.str_replace(' ','', esc_html($key)).".png"; ?>">
                    <p>
                      <?php echo $key;?>
                      <br />
                      <?php echo $value['car_details']; ?></p>
                  </div>
                  <div class="car-select-action">
                      <label class="btn-action-route-map-api">Single £<?php echo esc_html($value['s']); ?> <input name="vehicle-way" class="vehicle-way" data-car="<?php echo esc_html($key); ?>" data-route="s" type="radio" name="car-select" /></label>
                      <label class="btn-action-route-map-api">Return £<?php echo esc_html($value['r']); ?> <input name="vehicle-way" class="vehicle-way" data-car="<?php echo esc_html($key); ?>" data-route="r" type="radio" name="car-select" /></label>
                  </div>
                  </div>
              </div>
                <?php
              }
            ?>
            
          </div>
      </div>
    </div>
    
  </div><!-- #content -->
</div><!-- #primary -->

<script>
      const mapbox_access_token ="<?php echo MAPBOX_API_KEY; ?>";
      // map bounding box area
      // for faster search
      const bbox = "-1.2262492738026367,50.73269262864986,1.6062172675038084,52.53565994331251"
      
      coordinates = [
        // [51.45799, -0.44339],
        // [51.155738830566406, -0.16346991062164307],
      ];

      var mymap = L.map("mapid").setView([51.45799, -0.44339], 13);

      L.tileLayer(
        "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
        {
          attribution:
            'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
          maxZoom: 8,
          id: "mapbox/streets-v11",
          tileSize: 512,
          zoomOffset: -1,
          accessToken: mapbox_access_token,
        }
      ).addTo(mymap);

      mymap._handlers.forEach(function(handler) {
        handler.disable();
      });
      document.getElementById('mapid').style.cursor='default';
      
      var marker1 = marker2  = null;

      // marker 1
      const param_from = encodeURI( getParameterByName('from') )
      const param_to = encodeURI( getParameterByName('to') )
      
      let map_api_fetch_url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${param_from}.json?access_token=${mapbox_access_token}&limit=1&bbox=${bbox}`;
      setMarker1(map_api_fetch_url)
      
      map_api_fetch_url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${param_to}.json?access_token=${mapbox_access_token}&limit=1&bbox=${bbox}`;
      setMarker2(map_api_fetch_url)
      
      
      // wait for api & draw maker on finihs
      waitAndDrawPoint()

      function waitAndDrawPoint(){
        
        if (marker1 == undefined || marker2 == undefined){
          setTimeout(() => {
            waitAndDrawPoint();
          }, 500);
        }else{
          var markers = [
            L.marker(marker1).addTo(mymap),
            L.marker(marker2).addTo(mymap),
          ];

          mymap.fitBounds([marker1, marker2]);
        }

      }

      // set markert 1
      async function setMarker1(furl){
        marker1 = await getCoordinatesFromUrl(furl)
      }

      async function setMarker2(furl){
        marker2 = await getCoordinatesFromUrl(furl)
      }

      async function getCoordinatesFromUrl(fecthURL){
        try{
          // console.log(fecthURL)
          // console.log(fecthURL)
          const Fresponse = await fetch(fecthURL)
          const data = await Fresponse.json();
          // console.log(data.features[0].geometry.coordinates)
          const marker = data.features[0].geometry.coordinates
          return [marker[1], marker[0]] 
        }catch(error){/* console.log(error) */}
      }


      function getParameterByName(name, url = window.location.href) {
          name = name.replace(/[\[\]]/g, '\\$&');
          var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
              results = regex.exec(url);
          if (!results) return null;
          if (!results[2]) return '';
          return decodeURIComponent(results[2].replace(/\+/g, ' '));
      }
      

      /** Add Event For Each Selection Button */
      var select_car_btns = document.getElementsByClassName('vehicle-way')
      for(var btnI = 0; btnI < select_car_btns.length; btnI++){
          select_car_btns[btnI].addEventListener('click', function(evt){
              console.log('radio clicked')
              console.log(evt.target.dataset.car)
              console.log(evt.target.dataset.route)

              console.log(param_from)
              console.log(param_to)

              window.location.href = "../<?php echo PASSANGER_INFO; ?>/?from="+param_from+
              "&to="+param_to+
              "&car="+evt.target.dataset.car+
              "&route="+evt.target.dataset.route
          })
      }

</script>

<?php get_footer(); ?>