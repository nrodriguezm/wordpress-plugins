<?php
/**
* Plugin Name: Integracion CobrosYa a Woocommerce
* Plugin URI: 'http://www.trepcom.com'
* Description: Integracion de la pasarela de pagos CobrosYa a Woocommerce.
* Version: 1.0
* Author: Andres Beraldo
* Author URI: http://www.trepcom.com
**/





add_action( 'admin_notices', 'activar' );
register_activation_hook( __FILE__, 'activar' );
function activar() {
	cargar_contenido();
}


function cargar_contenido() {
		if ( class_exists( 'WooCommerce' ) ) {
			global $wpdb;
			$nombre_tabla = $wpdb->prefix . 'cobrosya';
			if( !($wpdb->get_var("SHOW TABLES LIKE '" . $nombre_tabla . "'") === $nombre_tabla )) {
				$sql= "CREATE TABLE `".$nombre_tabla."` (
					`transaccion` bigint(20) NOT NULL AUTO_INCREMENT,
					`nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
					`apellido` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
					`email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
					`concepto` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
					`moneda` int(3) NOT NULL,
					`monto` double NOT NULL,
					`fecha` date NOT NULL,
					`medioPagoId` int(2) NOT NULL,
					`medioPago` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
					`nroTalon` int(10) NOT NULL,
					`idSecreto` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
					`urlMostrador` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
					`urlPDF` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
					`fechaHoraPago` datetime NOT NULL,
					`paga` tinyint(1) NOT NULL,
					PRIMARY KEY (`transaccion`),
					KEY `nroTalon` (`nroTalon`),
					KEY `idSecreto` (`idSecreto`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=40 ;";
				
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
			}

			crear_pagina();
			
		}else{
			echo('<div class="error"><p>Woocommerce no está activado</p></div>');
			desactivar_plugin();
		}	
}

function desactivar_plugin() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

register_uninstall_hook(__FILE__, 'eliminar_plugin' );
function eliminar_plugin() {
	global $wpdb;
	
	//Eliminar pagina
	$titulo_pagina = 'Confirmacion cobrosYa';
	
	//Obtengo id de la pagina
	$pagina = get_page_by_title( $titulo_pagina );
	//Verifico que la pagina este creada
	if( !(null == $pagina->ID)) {
	
		//Elimino la pagina
		wp_delete_post( $pagina->ID, true );
	}
	
	
	//Eliminar tabla de la base de datos
	$nombre_tabla = $wpdb->prefix . 'cobrosya';
	$sql = 'DROP TABLE '. $nombre_tabla;
	$wpdb->query($sql);
	
}

// Crear página
function crear_pagina() {
	$titulo_pagina = 'Confirmacion cobrosYa';
	
	// Si la página no existe, se crea
	if( null == get_page_by_title( $titulo_pagina )) {
		$pagina = array(
		  'post_title'    => $titulo_pagina,
		  'post_content'  => '[confirmacion_cobrosya]',
		  'post_status'   => 'publish',
		  'post_author'   => 1,
		  'post_type'   => 'page',
		  'comment_status' => 'closed'
		);

		// Insert the post into the database
		wp_insert_post( $pagina );
	}
}

add_action('plugins_loaded', 'cobrosya_gateway', 0);
function cobrosya_gateway(){
	
	if(!class_exists('WC_Payment_Gateway')) return;
			 
	include 'archivos/class-wc-gateway-cobrosya.php';
				
	function woocommerce_agregar_cobrosya($methods) {
		$methods[] = 'WC_Gateway_Cobrosya';
		return $methods;
}
			 
	add_filter('woocommerce_payment_gateways', 'woocommerce_agregar_cobrosya' );
}

function shortcode_confirmacion() {
	
	global $woocommerce;
	global $wpdb;
	
	//Obtengo los datos de la orden
	$order = new WC_Order( $_GET['id']);
	$texto = $_GET['id'];
	$nombre = $order->billing_first_name;
	$apellido = $order->billing_last_name;
	$direccion = $order->billing_address_1;
	$telefono = $order->billing_phone;
	$mail = $order->billing_email;
	$cp = $order->billing_postcode;
	$pais = $order->billing_country;
	$estado = $order->billing_state;
	
	$transaccion = $_GET["id"];

	if (!(isset($transaccion))) {
		return;
	}
	
	$query = 'SELECT * FROM '. $wpdb->prefix . 'cobrosya WHERE transaccion = "'.$transaccion.'"';
	$tapi = $wpdb->get_row($query, ARRAY_A);
	
	if ($tapi["paga"] == 1) { 

		$texto = "<h1 class='gracias_compra'>Gracias por su compra</h1><p class='transaccion'>Su transacción ha sido completada con exito.</p>";
							
		$woocommerce->cart->empty_cart(); 
								  
		$texto .= "<p class='titulo'><h3>Datos de compra</h3></p>
				   <p class='nombre'><strong>Nombre: </strong>".$nombre." ".$apellido."</p>
				   <p class='direccion'><strong>Dirección: </strong>".$direccion."</p>
				   <p class='telefono'><strong>Teléfono: </strong>".$telefono."</p>
				   <p class='mail'><strong>Email: </strong><a href='mailto:".$mail."' target='_blank'>".$mail."</a></p>
				   <p class='cp'><strong>Código postal: </strong>".$cp."</p>
				   <p class='pais'><strong>País: </strong>".$pais."</p>
				   <p class='estado'><strong>Estado: </strong>".$estado."</p>";
	
	}elseif ($tapi["medioPagoId"] == 6) {  // 6 => REDPAGOS 

		$texto = "<h1 class='gracias_compra'>Gracias</h1>
				  <h5 class='redpagos'>Para finalizar su compra deberá descargar, imprimir, y abonar el talon de pagos en cualquier local de REDPAGOS.</h5>
				  <p class='urlpdf'><a style='font-size:14px' href=".$tapi["urlPDF"].">DESCARGAR TALON</a></p>";
			 
		$woocommerce->cart->empty_cart(); 
								  
		$texto .= "<p><h3>Datos de compra</h3></p>
				   <p class='nombre'><strong>Nombre: </strong>".$nombre." ".$apellido."</p>
				   <p class='direccion'><strong>Dirección: </strong>".$direccion."</p>
				   <p class='telefono'><strong>Teléfono: </strong>".$telefono."</p>
				   <p class='mail'><strong>Email: </strong><a href='mailto:".$mail."' target='_blank'>".$mail."</a></p>
				   <p class='cp'><strong>Código postal: </strong>".$cp."</p>
				   <p class='pais'><strong>País: </strong>".$pais."</p>
				   <p class='estado'><strong>Estado: </strong>".$estado."</p>";
	
	}else{

		$texto = "<h1 class='rechazada'>Transacción rechazada</h1>";
	}

	return $texto;
}
add_shortcode('confirmacion_cobrosya', 'shortcode_confirmacion');
?>
