<?php
/*
 * Template Name: Passanger-Info
 * description: >-
  Page template for select car url
 */
require_once( plugin_dir_path( __FILE__  ).'../api/price.php' );


if(isset($_POST['head-passenger-name'])){

  $price = getCartPrice();
  
  // if price empty then stop
  if($price == ''){
    echo '<center><h2>Route not found. Try Again Later.</h2><a class="btn-action-route-map-api" href="'.site_url().'">Try Again.</button></center>';
    get_footer(); 
    return;
  }

  // echo "<pre>";
  // print_r($_REQUEST);
  // echo "</pre>";

  global $woocommerce;
  $woocommerce->cart->empty_cart(); //чистим
  $custom_price = $price;  //$price - переменная с ценой 
  $product_id = get_option(ROUTE_MAP_OPTION_PRODUCT);   //id любого товара
  $quantity = 1;      //кол-во
  $cart_item_data = array(
    'custom_price' => $custom_price,
    'from' => $_REQUEST['from'],
    'to' => $_REQUEST['to'],
    'car' => $_REQUEST['car'],
    'route' => $_REQUEST['route'],
    'head-passenger-name' => $_REQUEST['head-passenger-name'],
    'passenger-mobile' => $_REQUEST['passenger-mobile'],
    'passenger-count' => $_REQUEST['passenger-count'],
    'luggage' => $_REQUEST['luggage'],
    'flight-number' => $_REQUEST['flight-number'],
    'flight-origin' => $_REQUEST['flight-origin'],
    'meet-service' => $_REQUEST['meet-service'],
    'arrival-time' => $_REQUEST['arrival-time'],
  );   
  $woocommerce->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
  $woocommerce->cart->calculate_totals();
  $woocommerce->cart->set_session();
  $woocommerce->cart->maybe_set_cart_cookies();


  header('location: '.wc_get_checkout_url());

}

get_header();

function getCartPrice(){
    return 200;
  }

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

.column-half {
    display: inline-block;
    width: calc(50% - 2px);
}

.form-acitons {
  text-align:right;
}

</style>

<div id="primary" class="site-content">
  <div id="content" role="main">
    <div class="select-car-container">
      <pre>
      <?php
        print_r($_REQUEST); 
      ?>
      </pre>
      <div class="select-car-form-wrapper">
         <form method="POST" action="./?from=<?php 
            echo rawurlencode($_GET['from']);
         ?>&to=<?php 
            echo rawurlencode($_GET['to']); 
          ?>&car=<?php 
            echo rawurlencode($_GET['car']);
          ?>&route=<?php 
            echo rawurlencode($_GET['route']);
          ?>">
          <!-- Map Here -->
          <div class="locations-titles">
            <span class="location-type">From: </span><?php echo esc_html($_REQUEST['from']); ?>
            <span class="location-type">To: </span><?php echo esc_html($_REQUEST['to']); ?>
          </div>
          <div class="locations-titles">
            <span class="location-type">Car: </span><?php echo esc_html($_REQUEST['car']); ?>
          </div>
          <br />
          <h3 class="form-section-title">Your details: </h3>
          
          <div class="mf-input-wrapper">
            <label class="mf-input-label">Head Passenger Full Name </label>
            <input type="text" name="head-passenger-name" required class="mf-input" required placeholder="...">
          </div>

          <div class="mf-input-wrapper">
            <label class="mf-input-label">Passenger Mobile </label>
            <input type="text" name="passenger-mobile" required class="mf-input" required placeholder="...">
          </div>

          <div class="column-half">
            <div class="mf-input-wrapper">
              <label class="mf-input-label">Passengers </label>
              <select name="passenger-count">
                <option value="1">1 Passenger</option>
                <option value="2">2 Passenger</option>
                <option value="3">3 Passenger</option>
                <option value="4">4 Passenger</option>
                <option value="5">5 Passenger (Only for MPV)</option>
              </select>
            </div>
          </div> <!-- column half -->
          <div class="column-half">
            <div class="mf-input-wrapper">
              <label class="mf-input-label">Luggage </label>
              <select name="luggage">
                <option value="1">None</option>
                <option value="2">Hand Luggage</option>
                <option value="3">Suitcases</option>
              </select>
            </div>
          </div>
          <br />
          <h3 class="form-section-title">Journey details: </h3>
          
          <div class="column-half">
            <div class="mf-input-wrapper">
              <label class="mf-input-label">Flight Number</label>
              <input type="text" name="flight-number" required class="mf-input" required placeholder="...">
            </div>
          </div>

          <div class="column-half">
            <div class="mf-input-wrapper">
              <label class="mf-input-label">Flight Origin</label>
              <input type="text" name="flight-origin" required class="mf-input" required placeholder="...">
            </div>
          </div>

          <div class="mf-input-wrapper">
          <label class="mf-input-label">Meet & Greet Service </label>
              <select name="meet-service">
                <option value="False">No (+£0) I will call my driver</option>
                <option value="True">Yes (+£5) meet me on arrival</option>
              </select>
          </div>

          <div class="mf-input-wrapper">
            <label class="mf-input-label">Arrival Date & Time </label>
            <input type="datetime-local" name="arrival-time" required class="mf-input" required placeholder="...">
          </div>

          <div class="form-acitons">
            <button id="get_a_quote_btn" class="btn-action-route-map-api">Go to Checkout</button>
          </div>
          
          </form>
      </div><!-- .form wrapper -->
    </div><!-- .container -->
  </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>