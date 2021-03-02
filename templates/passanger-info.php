<?php
/*
 * Template Name: Passanger-Info
 * description: >-
  Page template for select car url
 */

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
          <div class="locations-titles">
            <span class="location-type">From: </span><?php echo esc_html($_REQUEST['from']); ?>
            <span class="location-type">To: </span><?php echo esc_html($_REQUEST['to']); ?>
          </div>
          
          <h2>Your details: </h2>
            
          </div>
      </div>
    </div>
    
  </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>