<?php
/*
Plugin Name: Ninja To Drive
Plugin URI: http://www.trepcom.com/
Description: Ninja To Drive is a webform builder with unparalleled ease of use and features. Version compatible with Nija Forms 3.0+
Version: 3.0
Author: Andrés Beraldo
Author URI: http://trepcom.com
Text Domain: ninja-forms
Domain Path: /lang/
*/

define( 'ND_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );




add_filter( 'ninja_forms_register_actions', 'nd_action', 10, 1 );
function nd_action($actions){
	
	include('includes/Actions/NinjaToDrive.php');
	$actions['ninja-to-drive'] = new NinjaToDrive();
	
	return $actions;
	
}
?>