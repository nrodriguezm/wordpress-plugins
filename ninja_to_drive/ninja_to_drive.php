<?php
/**
* Plugin Name: Ninja to Drive
* Plugin URI: ''
* Description: Register submittion form to Google forms.
* Version: 1.0
* Author: Andres Beraldo
* Author URI: http://www.trepcom.com
**/

global $wpdb;
// Subs table name
if ( ! defined( 'NINJA_FORMS_GOOGLE_TABLE_NAME' ) )
	define( 'NINJA_FORMS_GOOGLE_TABLE_NAME', $wpdb->prefix . 'ninja_forms_drive' );

add_action( 'admin_notices', 'activate' );
register_activation_hook( __FILE__, 'activate' );
function activate() {
	load_content();
}

function load_content() {
	if ( class_exists( 'Ninja_Forms' ) ) {
		global $wpdb;
			
		if( !($wpdb->get_var("SHOW TABLES LIKE '" . NINJA_FORMS_GOOGLE_TABLE_NAME . "'") === NINJA_FORMS_GOOGLE_TABLE_NAME )) {
			$sql= "CREATE TABLE `".NINJA_FORMS_GOOGLE_TABLE_NAME."` (
				`form_id` int(3) NOT NULL,
				`settings` varchar(2000) NOT NULL,
				PRIMARY KEY (`form_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
				
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}	
	}else{
		echo('<div class="error"><p>Ninjaforms is not installed or activated</p></div>');
		deactivate_plugin();
	}	
}

function deactivate_plugin() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}


register_uninstall_hook(__FILE__, 'delete_plugin' );
function delete_plugin() {
	global $wpdb;
	//Delete bd table
	$sql = 'DROP TABLE '. NINJA_FORMS_GOOGLE_TABLE_NAME;
	$wpdb->query($sql);
	
}


add_action('plugins_loaded', 'load_options', 0);
function load_options(){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'ninja_to_drive/ninja_to_drive.php' ) ) {
		require_once 'tab/google-drive.php';
		require_once 'add_to_spreadsheet.php';
	}
}

?>