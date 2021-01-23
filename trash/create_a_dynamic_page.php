<?php
namespace AAALRouteMapHelper;

/****************************
 * HELPING LINKS
 * https://wordpress.stackexchange.com/questions/9870/how-do-you-create-a-virtual-page-in-wordpress
 * https://xaviesteve.com/2851/generate-a-custom-fakevirtual-page-on-the-fly-wordpress-plugin-development/
 ************************/

/******************************
 *  FIRST WAY 
 * ****************************/

 

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

  function plugin_myown_title() {
    return "On the fly foobar form";
  }

  function plugin_myown_template() {
    include(TEMPLATEPATH."/page.php");
    exit;
  }

  if ($_GET['plugin_page'] == "myfakepage") {
    add_filter('the_title','AAALRouteMapHelper\plugin_myown_title');
    add_filter('the_content','AAALRouteMapHelper\plugin_myown_content');
    add_action('template_redirect', 'AAALRouteMapHelper\plugin_myown_template');
  }


  /******************************
 *  Second WAY 
 * ****************************/


  if ($_SERVER['REQUEST_URI'] == "/MyFakePage") {
		get_template_part('header');
		echo "MY PAGE CONTENT HERE!!!";
		get_template_part('footer');
		die();
  }
  

/******************
 * Improvised 2nd Way
 * ********************** */
function MYFUNC_API_PAGE_Hooks() {

  // full link
  $current_url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  // remove wordpress home url
  $current_slug = \str_replace(site_url().'/', '', $current_url);
  // Remove query string
   $current_slug = \str_replace($_SERVER['QUERY_STRING'], '', $current_slug);
   // remove trailing '?'
   if(\substr($current_slug, -1) == '?'){
    $current_slug = \substr($current_slug, 0, -1);
   }
   if(\substr($current_slug, -1) == '/'){
    $current_slug = \substr($current_slug, 0, -1);
   }

   if ($current_slug == 'map-route-api'){
    status_header(200);     
    echo "MY PAGE CONTENT HERE!!!";
    die();
   }

}
add_action('template_redirect', 'AAALRouteMapHelper\MYFUNC_API_PAGE_Hooks');