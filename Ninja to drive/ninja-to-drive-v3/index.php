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
include 'functions/functions.php';
include 'functions/submit_form.php';


//Add ninja forms option to ninja-forms submenu
function add_submenu_option_nd(){
	add_submenu_page("ninja-forms", "Ninja to drive", "Ninja to drive", apply_filters( 'ninja_forms_admin_all_forms_capabilities', 'manage_options' ), "ninja-to-drive", "ninja_to_drive_options_nd");
}
add_action( 'admin_menu', 'add_submenu_option_nd' );

function ninja_to_drive_options_nd(){
	include 'functions/forms.php';
}

register_activation_hook( __FILE__, 'installdb_nd' );
function installdb_nd(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'ninja_forms_drive_nd';
	if( !($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") === $table_name )) { //Check if table exists
		$sql= "CREATE TABLE `".$table_name."` (
				`id_form` int(3) NOT NULL,
				`values` varchar(10000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
				`url_form` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
				PRIMARY KEY (`id_form`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				
		$wpdb->query($sql);
	}
}
?>