<?php
!defined('ABSPATH') && exit;
?>
<div class="wrap">
<h1>Setting - Route Map Helper</h1>
    
    <?php

    // update product id
    if(isset($_POST['product_id'])){
      // $route_product_id = get_option(ROUTE_MAP_OPTION_PRODUCT);

        
      update_option(ROUTE_MAP_OPTION_PRODUCT, $_POST['product_id']);

      
    }

    // update price per km
    if(isset($_POST['price_per_km'])){
      echo "PRICE PER";
      $price_per_km = get_option(ROUTE_MAP_PRICE_PER_KM);
      echo $price_per_km;

      if($price_per_km == null){
      
        update_option(ROUTE_MAP_PRICE_PER_KM, $_POST['price_per_km']);

      }
    }

    ?>

<div class="container-fluid">
      <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <div class="mb-2">
          <label>Product Id: </label>
          <input class="form-control" required type="number" name="product_id" value="<?php echo get_option(ROUTE_MAP_OPTION_PRODUCT); ?>">
            <div  class="form-text">
              This product will get added to route form cart.
            </div>
        </div>
        <div class="mb-2">
          <label>Price Per Mile (for salon car): </label>
          <input class="form-control" required type="number" name="price_per_km" value="<?php echo get_option(ROUTE_MAP_PRICE_PER_KM); ?>">
            
        </div>
        <input type="submit" class="btn btn-primary">
      </form>
</div><!--container -->
</div><!-- wrap -->