<?php
!defined('ABSPATH') && exit;
?>
<div class="wrap">
<h1>Route Map Helper</h1>
    
    <?php
    /* Query Database And Show the Table */
    global $wpdb;
    $result = $wpdb->get_results (
      "
      SELECT * 
      FROM aa_route_pricing
      "
      );
    // print_r($result[0]->_from);
    ?>

    <div class="container-fluid">
    <div class="table-responsive table-sm">
    <table class="table table-striped">
  <thead class="text-white bg-primary rounded-top">
    <tr>
      <th scope="col">From</th>
      <th scope="col">To Heathrow Airport</th>
      <th scope="col">To Stanstead Airport</th>
      <th scope="col">To Gatwick Airport</th>
      <th scope="col">To City Airport</th>
      <th scope="col">To Luton Airport</th>
      <th scope="col">Toll £</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach($result as $row){
        echo <<<ROW
        <tr>
          <th>{$row->_from}</th>
          <td>{$row->heathrow_airport}</td>
          <td>{$row->stanstead_airport}</td>
          <td>{$row->gatwick_airport}</td>
          <td>{$row->city_airport}</td>
          <td>{$row->luton_airport}</td>
          <td>{$row->toll}</td>
        </tr>
ROW;
      } 
    ?>
  </tbody>
</table>
</div><!-- table responsive -->
</div><!--container -->
</div><!-- wrap -->