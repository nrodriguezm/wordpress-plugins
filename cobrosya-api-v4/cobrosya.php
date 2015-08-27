<?php
/**
* Plugin Name: Integracion CobrosYa a Woocommerce
* Plugin URI: ''
* Description: Integracion de la pasarela de pagos CobrosYa a Woocommerce.
* Version: 2.0
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
				  `mediosdepago` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
				  `nroTalon` int(10) NOT NULL,
				  `idSecreto` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
				  `urlPDF` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
				  `fechaHoraPago` datetime NOT NULL,
				  `paga` tinyint(1) NOT NULL,
				  `cuotas_codigo` int(2) NOT NULL,
				  `cuotas_texto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
				  `autorizacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
				  `error` int(2) NOT NULL,
				  PRIMARY KEY (`transaccion`),
				  KEY `nroTalon` (`nroTalon`),
				  KEY `idSecreto` (`idSecreto`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=153";
				
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

add_action('plugins_loaded', 'crear_medios_de_pago', 0);
function crear_medios_de_pago(){
	
	if(!class_exists('WC_Payment_Gateway')) return;
			 
	include 'includes/class-wc-gateway-cobrosya.php';	
	include 'includes/class-wc-gateway-ebrou.php';
	include 'includes/class-wc-gateway-santander.php';
	include 'includes/class-wc-gateway-bbva.php';
	include 'includes/class-wc-gateway-paganza.php';
	include 'includes/class-wc-gateway-redpagos.php';
	include 'includes/class-wc-gateway-visa.php';
	include 'includes/class-wc-gateway-mastercard.php';
	include 'includes/class-wc-gateway-diners.php';
	include 'includes/class-wc-gateway-discover.php';
	include 'includes/class-wc-gateway-lider.php';
	include 'includes/class-wc-gateway-oca.php';
	include 'includes/class-wc-gateway-banred.php';
	
	function woocommerce_agregar_cobrosya($methods) {
		$methods[] = 'WC_Gateway_Cobrosya';
		$methods[] = 'WC_Gateway_Ebrou';
		$methods[] = 'WC_Gateway_Santander';
		$methods[] = 'WC_Gateway_Bbva';
		$methods[] = 'WC_Gateway_Paganza';
		$methods[] = 'WC_Gateway_Redpagos';
		$methods[] = 'WC_Gateway_Visa';
		$methods[] = 'WC_Gateway_Mastercard';
		$methods[] = 'WC_Gateway_Diners';
		$methods[] = 'WC_Gateway_Discover';
		$methods[] = 'WC_Gateway_Lider';
		$methods[] = 'WC_Gateway_Oca';
		$methods[] = 'WC_Gateway_Banred';
		return $methods;
	}
			 
	add_filter('woocommerce_payment_gateways', 'woocommerce_agregar_cobrosya' );
}

function shortcode_confirmacion() {
	
	global $woocommerce;
	global $wpdb;
	
	if(isset($_GET['err'])){
		
		if($_GET['err'] == '-1'){
			//Medio de pago no habilitado
			$texto = "<h1 class='gracias_compra'>Medio de pago no habilitado</h1><p class='transaccion'>Su transacci&oacute;n ha sido rechazada. Pongase en contacto con el administrador de la web.</p>";
		} else {
			switch ($_GET['err']) {
				case '1':
					$mensaje = "Falta rellenar campos";
					break;
				case '2':
					$mensaje = "El token no es correcto";
					break;
				case '3':
					$mensaje = "Error al crear talón";
					break;
				case '4':
					$mensaje = "La fecha de vencimiento es incorrecta";
					break;
				case '5':
					$mensaje = "El celular tiene un formato incorrecto";
					break;
				case '6':
					$mensaje = "El mail tiene un formato incorrecto";
					break;
				case '7':
					$mensaje = "La moneda no es valida";
					break;
				case '8':
					$mensaje = "El monto tiene un formato incorrecto";
					break;
				case '9':
					$mensaje = "La transacción ya fue cobrada";
					break;
			}
			$texto = "<h1 class='gracias_compra'>Error en la transacción</h1><p class='transaccion'>Su transacci&oacute;n ha sido rechazada. $mensaje.</p>";
		}
	} else {
		//Obtengo los datos de la orden
		$order = new WC_Order($_GET['id']);
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

		if($tapi["moneda"] == 858){
			$simbolo = "$";
		} else {
			$simbolo = "USD";
		}
		if ($tapi["paga"] == 1) { 

			$texto = "<h1 class='gracias_compra'>Gracias por su compra</h1><p class='transaccion'>Su transacci&oacute;n ha sido completada con exito.</p>";
								
			$woocommerce->cart->empty_cart(); 
									  
			$texto .= "<p class='titulo'><h3>Datos de compra</h3></p>
					   <p class='nombre'><strong>Nombre: </strong>".$nombre." ".$apellido."</p>
					   <p class='direccion'><strong>Direcci&oacute;n: </strong>".$direccion."</p>
					   <p class='telefono'><strong>Tel&eacute;fono: </strong>".$telefono."</p>
					   <p class='mail'><strong>Email: </strong><a href='mailto:".$mail."' target='_blank'>".$mail."</a></p>
					   <p class='cp'><strong>C&oacute;digo postal: </strong>".$cp."</p>
					   <p class='pais'><strong>Pa&iacute;s: </strong>".$pais."</p>
					   <p class='estado'><strong>Estado: </strong>".$estado."</p>
					   <h1>Datos de facturación</h1>
					   <p class='monto'><strong>Monto: </strong>".$simbolo.$tapi["monto"]."</p>
					   <p class='mediopago'><strong>Medio de pago: </strong>".$tapi["medioPago"]."</p>
					   <p class='cuotas'><strong>Cuotas: </strong>".$tapi["cuotas_codigo"]."</p>";
					   
					   
		
		}elseif ($tapi["medioPagoId"] == 5 or $tapi["medioPagoId"] == 6 ) {  // 5 => PAGANZA, 6 => REDPAGOS 
			
			$texto = "<h1 class='gracias_compra'>Gracias</h1>
					  <h5 class='redpagos'>Para finalizar su compra deber&aacute; descargar, imprimir, y abonar el talon de pagos en cualquier local de REDPAGOS.</h5>
					  <p class='urlpdf'><a class='button' style='font-size:14px' href=".$tapi["urlPDF"].">DESCARGAR TALON</a></p>";
				 
			$woocommerce->cart->empty_cart(); 
									  
			$texto .= "<p><h3>Datos de compra</h3></p>
					   <p class='nombre'><strong>Nombre: </strong>".$nombre." ".$apellido."</p>
					   <p class='direccion'><strong>Direcci&oacute;n: </strong>".$direccion."</p>
					   <p class='telefono'><strong>Tel&eacute;fono: </strong>".$telefono."</p>
					   <p class='mail'><strong>Email: </strong><a href='mailto:".$mail."' target='_blank'>".$mail."</a></p>
					   <p class='cp'><strong>C&oacute;digo postal: </strong>".$cp."</p>
					   <p class='pais'><strong>Pa&iacute;s: </strong>".$pais."</p>
					   <p class='estado'><strong>Estado: </strong>".$estado."</p>
					   <h1>Datos de facturación</h1>
					   <p class='monto'><strong>Monto: </strong>".$simbolo.$tapi["monto"]."</p>
					   <p class='mediopago'><strong>Medio de pago: </strong>".$tapi["medioPago"]."</p>
					   <p class='cuotas'><strong>Cuotas: </strong>Contado</p>";
		}else{
			$order->update_status('cancelled', 'La orden fue rechazada');
			$texto = "<h1 class='rechazada'>Transacción rechazada</h1>";
		}
	}
	
	sanitize_text_field( $texto ); 
	return $texto;
}

add_shortcode('confirmacion_cobrosya', 'shortcode_confirmacion');

//Agregar campo de cuotas en el checkout
function campo_cuotas($fields){
	$fields['billing']['billing_phone']['label'] = "Celular";
    $fields['extra_fields']['cuotas'] = array(
		'id' => '_cuotas',
        'type' => 'select',
		'options' => array(
				'0' => __( 'Contado', 'cmb' ),
				'3'   => __( '3', 'cmb' ),
				'6'   => __( '6', 'cmb' ),
			), 
			'required' => false,
			'label' => __( 'Cantidad de cuotas')
    );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'campo_cuotas', 50 );

// Mostrar el campo en el checkout
function mostrar_campo_cuotas(){ 

    $checkout = WC()->checkout(); ?>

    <div class="extra-fields cuotas">
   
    <?php foreach ( $checkout->checkout_fields['extra_fields'] as $key => $field ) : ?>
			
            <?php echo("<div>"); woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); echo("</div>"); ?>
			
        <?php endforeach; ?>
    </div>

<?php }

add_action( 'woocommerce_after_checkout_billing_form' ,'mostrar_campo_cuotas' );

// save the extra field when checkout is processed
function guardar_campo_cuotas( $order_id, $posted ){
    if( isset( $posted['cuotas'] ) ) {
        update_post_meta( $order_id, '_cuotas', sanitize_text_field( $posted['cuotas'] ) );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'guardar_campo_cuotas', 10, 2 );

// display the extra data in the order admin panel
function mostrar_campo_cuotas_en_orden( $order ){  ?>
    <div class="order_data_column" style="width: 100%;">
        <h4><?php _e( 'Detalle de cuotas', 'woocommerce' ); ?></h4>
        <?php 
			$valor = get_post_meta( $order->id, '_cuotas', true );
            echo '<p style="color:red; font-size:16px;"><strong style="margin-right: 10px;">' . __( 'Cuotas' ) . ':</strong>' . $valor . '</p>'; ?>
    </div>
<?php }
add_action( 'woocommerce_admin_order_data_after_order_details', 'mostrar_campo_cuotas_en_orden' );

?>