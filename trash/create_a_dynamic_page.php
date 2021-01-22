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