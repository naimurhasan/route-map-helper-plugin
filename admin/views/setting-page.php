<?php
!defined('ABSPATH') && exit;
?>
<div class="wrap">
<h1>Setting - Route Map Helper</h1>
    
    <?php


    if(isset($_POST['product_id'])){
      $route_product_id = get_option(ROUTE_MAP_OPTION_PRODUCT);

      if($route_product_id == null){
        
        // ROUTE_MAP_OPTION_PRODUCT
        add_option(ROUTE_MAP_OPTION_PRODUCT, $_POST['product_id']);
        
      }else{
        
        update_option(ROUTE_MAP_OPTION_PRODUCT, $_POST['product_id']);

      }
      
    }


    /* Query Database And Show the Table */
    // global $wpdb;
    // $result = $wpdb->get_results (
    //   "
    //   SELECT * 
    //   FROM aa_route_pricing
    //   "
    //   );
    // print_r($result[0]->_from);
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
        <input type="submit" class="btn btn-primary">
      </form>
</div><!--container -->
</div><!-- wrap -->