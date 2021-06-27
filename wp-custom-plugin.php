<?php
/**
 * Plugin Name: Custom Plugin
 * Plugin URI: abc
 * Description: abc
 * Version: 1.0
 * Author: Umair Gilani
 * Author URI: http://www.googleee.com
 *
 * @package Custom Plugin
 */

//constants

define("PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define ("PLUGIN_URL", plugins_url());
define ("PLUGIN_VERSION", "1.0");
 
 
function gallery_function(){
  add_menu_page(
  	'Gallery',        // Page Title
  	'My Gallery',     // Menu Title
  	'manage_options', // capability / admin level
  	'my-gallery',     // Page Slug 
  	'add_new_function',     // Callback Function
  	'dashicons-format-gallery', //Icon url
  	11                 // Positions
  	);
  
  add_submenu_page(
  	'my-gallery', //parent slug 
  	'Add New',	//page title
  	'Add New',	//menu title
  	'manage_options',	//capability = user_level access
  	'my-gallery',	//menu slug
  	'add_new_function', //callback function
  	'position'	//postion

  	);

  add_submenu_page(
  	'my-gallery', //parent slug 
  	'All Pages',	//page title
  	'All Pages',	//menu title
  	'manage_options',	//capability = user_level access
  	'all-pages',	//menu slug
  	'all_pages_function', //callback function
  	

  	);

}
add_action('admin_menu','gallery_function');

function add_new_function(){
	// add new function
	include_once PLUGIN_DIR_PATH . "/views/add-new.php";


}
function all_pages_function(){
	// all pages function
	include_once PLUGIN_DIR_PATH . "/views/all-pages.php";

}

// enqueueing styles/scripts
function custom_plugin_assets(){
	wp_enqueue_style("my_style", PLUGIN_URL."/custom-plugin/assets/css/style.css", "", PLUGIN_VERSION);

	wp_enqueue_script("my_script",PLUGIN_URL."/custom-plugin/assets/js/script.js", "", PLUGIN_VERSION, true);

}
add_action("init","custom_plugin_assets");

// creation of table while activating the plugin
function custom_plugin_tables(){
	global $wpdb;
	require_once (ABSPATH . "wp-admin/includes/upgrade.php");

	if (count($wpdb->get_var("SHOW TABLES LIKE 'wp_custom_plugin'")) == 0) {
		$create_table = "CREATE TABLE `wp_custom_plugin` (
						 `id` int(11) NOT NULL AUTO_INCREMENT,
						 `name` varchar(222) NOT NULL,
						 `email` varchar(222) NOT NULL,
						 `phone` varchar(222) NOT NULL,
						 `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
						 PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
						";
		dbDelta($create_table);
	}
}

register_activation_hook(__FILE__,"custom_plugin_tables");


function deactivate_plugin(){
	global $wpdb;
	$wpdb->query("Drop table If Exists wp_custom_plugin");
}
register_deactivation_hook(__FILE__,"deactivate_plugin");




