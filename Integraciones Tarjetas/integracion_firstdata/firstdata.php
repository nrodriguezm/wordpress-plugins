<?php
/**
* Plugin Name: Integracion firstdata a Woocommerce
* Plugin URI: ''
* Description: Integracion de la pasarela de pagos firstadata a Woocommerce.
* Version: 1.0
* Author: Andres Beraldo
* Author URI: http://www.trepcom.com
**/

add_action( 'admin_notices', 'fd_activar' );

register_activation_hook( __FILE__, 'fd_activar' );
function fd_activar() {
	fd_cargar_contenido();
}


function fd_cargar_contenido() {
		if ( class_exists( 'WooCommerce' ) ) {
			global $wpdb;
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$nombre_tabla = $wpdb->prefix . 'firstdata_respuesta';
			if( !($wpdb->get_var("SHOW TABLES LIKE '" . $nombre_tabla . "'") === $nombre_tabla )) {
				$sql ="CREATE TABLE IF NOT EXISTS `".$nombre_tabla."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `ordernumber` int(50) NOT NULL,
				  `fecha` datetime NOT NULL,
				  `merchant` varchar(512) NOT NULL,
				  `approvalcode` varchar(512) NOT NULL,
				  `ammount` text NOT NULL,
				  `currency` varchar(512) NOT NULL,
				  `responsecode` varchar(512) NOT NULL,
				  `responsetext` varchar(512) NOT NULL,
				  `iftiptar` varchar(512) NOT NULL,
				  `ifaplicaley` varchar(512) NOT NULL,
				  `ifdecreto` varchar(512) NOT NULL,
				  `ifimpiva` varchar(512) NOT NULL,
				  `signeddata1` varchar(512) NOT NULL,
				  `signeddata2` varchar(512) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
				
				dbDelta( $sql );
				
				
			}
			
			$nombre_tabla = $wpdb->prefix . 'firstdata_pedidos';
			if( !($wpdb->get_var("SHOW TABLES LIKE '" . $nombre_tabla . "'") === $nombre_tabla )) {
				
			$sql="CREATE TABLE IF NOT EXISTS `".$nombre_tabla."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ordernumber` int(50) NOT NULL,
			`fecha` datetime NOT NULL,
			`nombre` varchar(50) NOT NULL,
			`apellido` varchar(50) NOT NULL,
			`direccion` varchar(50) NOT NULL,
			`telefono` varchar(50) NOT NULL,
			`ciudad` varchar(30) NOT NULL,
			`pais` varchar(30) NOT NULL,
			`email` varchar(30) NOT NULL,
			`amount` varchar(30) NOT NULL,
			`installments` varchar(50) NOT NULL,
			`merchant` varchar(512) NOT NULL,
			`currency` varchar(512) NOT NULL,
			`bincc` varchar(512) NOT NULL,
			`fincc` varchar(512) NOT NULL,
			`ifaplica` varchar(512) NOT NULL,
			`iffac` varchar(512) NOT NULL,
			`ifimp` varchar(512) NOT NULL,
			`iffimp` varchar(512) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";
				
				dbDelta( $sql );
			}
				
		}else{
			echo('<div class="error"><p>Woocommerce no está activado</p></div>');
			fd_desactivar_plugin();
		}	
}

function fd_desactivar_plugin() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

register_uninstall_hook(__FILE__, 'fd_eliminar_plugin' );
function fd_eliminar_plugin() {
	return;
}

add_action('plugins_loaded', 'fd_crear_medios_de_pago', 0);
function fd_crear_medios_de_pago(){
	
	if(!class_exists('WC_Payment_Gateway')) return;
			 
	include 'includes/class-wc-gateway-master.php';
	include 'includes/class-wc-gateway-master-santander.php';
	include 'includes/class-wc-gateway-diners.php';
	include 'includes/class-wc-gateway-lider.php';
	include 'includes/class-wc-gateway-discover.php';
	
	function fd_woocommerce_agregar_master($methods) {
		$methods[] = 'WC_Gateway_Master';
		$methods[] = 'WC_Gateway_MasterSantander';
		$methods[] = 'WC_Gateway_Diners';
		$methods[] = 'WC_Gateway_Lider';
		$methods[] = 'WC_Gateway_Discover';
		return $methods;
	}
			 
	add_filter('woocommerce_payment_gateways', 'fd_woocommerce_agregar_master' );
}



?>