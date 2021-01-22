<?php
namespace AAALRouteMapHelper;
/**
 * Plugin Name: Route Map Helper
 * Plugin URI: http://www.github.com/
 * Description: Route map helper for AA Airport Link
 * Version: 1.0
 * Author: naimurhasan   
 * Author URI: http://naimurhasan.github.io
 */
!defined('ABSPATH') && exit;

// add admin page
require_once( plugin_dir_path( __FILE__  ).'/admin/admin.php' );

function plugin_myown_content() {
    $return = '
  <p>Fill in this form:</p>
  <form action="?" method="post">
    <input type="text" name="foo" value="bar" />
    <input type="submit" value="Connect" />
  </form>
  ';
    return $return;
}

/******* BOTTOM SECTION WILL MOVE TO API FOLDER */
function MYFUNC_Check_Page_Hooks() {
    // echo site_url();
    // echo $_SERVER['REQUEST_URI'];
    // echo "<PRE>";
    // print_r($_SERVER);
    // echo "</PRE>";

}
add_action('template_redirect', 'AAALRouteMapHelper\MYFUNC_Check_Page_Hooks');