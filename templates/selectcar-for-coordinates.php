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
          <!-- Map Here -->
          <div id="mapid"></div>
          <div class="locations-titles">
            <span class="location-type">From: </span><?php echo esc_html($_REQUEST['from_text']); ?>
            <span class="location-type">To: </span><?php echo esc_html($_REQUEST['to_text']); ?>
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
      
      var marker1 = [<?php echo esc_html($_REQUEST['from_coordinate']); ?>]
      var marker2  = [<?php echo esc_html($_REQUEST['to_coordinate']); ?>];

      // marker 1
      const param_from = "<?php echo esc_html($_REQUEST['from_text']); ?>"
      const param_to = "<?php echo esc_html($_REQUEST['to_text']); ?>"
      
      // let map_api_fetch_url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${param_from}.json?access_token=${mapbox_access_token}&limit=1&bbox=${bbox}`;
      // setMarker1(map_api_fetch_url)
      
      // map_api_fetch_url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${param_to}.json?access_token=${mapbox_access_token}&limit=1&bbox=${bbox}`;
      // setMarker2(map_api_fetch_url)
      
      
      // wait for api & draw maker on finihs
      waitAndDrawPoint()

      function waitAndDrawPoint(){
        
        
          
          var markers = [
            L.marker(marker1).addTo(mymap),
            L.marker(marker2).addTo(mymap),
          ];

          mymap.fitBounds([marker1, marker2]);
        
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

              var form = document.createElement('form');
              form.setAttribute('action', '<?php echo site_url(); ?>/<?php echo PASSANGER_INFO_PER_KM; ?>/');
              form.setAttribute('method', 'POST');

              // from text
              var input1 = document.createElement('input');
              input1.setAttribute('name', 'from_text');
              input1.setAttribute('value', "<?php echo addslashes($_REQUEST['from_text']); ?>")

              // from coordinates
              var input2 = document.createElement('input');
              input2.setAttribute('name', 'from_coordinate');
              input2.setAttribute('value', "<?php echo addslashes($_REQUEST['from_coordinate']); ?>")

              // to text 
              var input3 = document.createElement('input');
              input3.setAttribute('name', 'to_text');
              input3.setAttribute('value', "<?php echo addslashes($_REQUEST['to_text']); ?>")

              // to coordinates 
              var input4 = document.createElement('input');
              input4.setAttribute('name', 'to_coordinate');
              input4.setAttribute('value', "<?php echo addslashes($_REQUEST['to_coordinate']); ?>")


              // distance
              var input5 = document.createElement('input');
              input5.setAttribute('name', 'distance');
              input5.setAttribute('value', "<?php echo addslashes($_REQUEST['distance']); ?>")

              // car
              var input6 = document.createElement('input');
              input6.setAttribute('name', 'car');
              input6.setAttribute('value', evt.target.dataset.car);

              // route
              var input7 = document.createElement('input');
              input7.setAttribute('name', 'route');
              input7.setAttribute('value', evt.target.dataset.route);

              form.appendChild(input1);
              form.appendChild(input2);
              form.appendChild(input3);
              form.appendChild(input4);
              form.appendChild(input5);
              form.appendChild(input6);
              form.appendChild(input7);
              form.style.display = "none";
              document.body.appendChild(form);

              form.submit();
          })
      }

</script>

<?php get_footer(); ?>