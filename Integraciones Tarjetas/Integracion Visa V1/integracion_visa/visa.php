<?php
/**
* Plugin Name: Integracion Visa a Woocommerce
* Plugin URI: ''
* Description: Integracion de la pasarela de pagos Visa a Woocommerce.
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
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$nombre_tabla = $wpdb->prefix . 'visarespuesta';
			if( !($wpdb->get_var("SHOW TABLES LIKE '" . $nombre_tabla . "'") === $nombre_tabla )) {
				$sql ="CREATE TABLE IF NOT EXISTS `".$nombre_tabla."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `id_pedido` int(50) NOT NULL,
				  `fecha` datetime NOT NULL,
				  `IDACQUIRER` varchar(512) NOT NULL,
				  `IDCOMMERCE` varchar(512) NOT NULL,
				  `XMLRES` text NOT NULL,
				  `DIGITALSIGN` varchar(512) NOT NULL,
				  `SESSIONKEY` varchar(512) NOT NULL,
				  `RESPUESTA` text NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
				
				dbDelta( $sql );
				
				
			}
			
			$nombre_tabla = $wpdb->prefix . 'visapedidos';
			if( !($wpdb->get_var("SHOW TABLES LIKE '" . $nombre_tabla . "'") === $nombre_tabla )) {
				
			$sql="CREATE TABLE IF NOT EXISTS `".$nombre_tabla."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`id_pedido` int(50) NOT NULL,
			`fecha` datetime NOT NULL,
			`nombre` varchar(50) NOT NULL,
			`apellido` varchar(50) NOT NULL,
			`direccion` varchar(50) NOT NULL,
			`telefono` varchar(50) NOT NULL,
			`ciudad` varchar(30) NOT NULL,
			`pais` varchar(30) NOT NULL,
			`email` varchar(30) NOT NULL,
			`importe` varchar(30) NOT NULL,
			`importe_gravado` varchar(50) NOT NULL,
			`detalle` text NOT NULL,
			`IDACQUIRER` varchar(512) NOT NULL,
			`IDCOMMERCE` varchar(512) NOT NULL,
			`XMLREQ` text NOT NULL,
			`DIGITALSIGN` varchar(512) NOT NULL,
			`SESSIONKEY` varchar(512) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";
				
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
	$titulo_pagina = 'Pago VISA cancelado';
	
	//Obtengo id de la pagina
	$pagina = get_page_by_title( $titulo_pagina );
	//Verifico que la pagina este creada
	if( !(null == $pagina->ID)) {
		//Elimino la pagina
		wp_delete_post( $pagina->ID, true );
	}
	
	//Eliminar tablas de la base de datos
	$nombre_tabla = $wpdb->prefix . 'visalog';
	$sql = 'DROP TABLE '. $nombre_tabla;
	$wpdb->query($sql);
	
	$nombre_tabla = $wpdb->prefix . 'visapedidos';
	$sql = 'DROP TABLE '. $nombre_tabla;
	$wpdb->query($sql);
	
}

// Crear página
function crear_pagina() {
	$titulo_pagina = 'Pago VISA cancelado';
	
	// Si la página no existe, se crea
	if( null == get_page_by_title( $titulo_pagina )) {
		$pagina = array(
		  'post_title'    => $titulo_pagina,
		  'post_content'  => '[confirmacion_visa]',
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
			 
	include 'includes/class-wc-gateway-visa.php';
	
	function woocommerce_agregar_visa($methods) {
		$methods[] = 'WC_Gateway_Visa';
		return $methods;
	}
			 
	add_filter('woocommerce_payment_gateways', 'woocommerce_agregar_visa' );
}

function shortcode_confirmacion() {
	
	global $woocommerce;
	global $wpdb;
	
	$pedido = new WC_Order((int)$_GET['id_pedido']);
	
	if(!isset($_GET['status'])){
		get_template_part( 404 ); exit();
	}
	
	switch ($_GET['status']) {
		case '01':
		echo "<h3 style='text-align: center;'>La transacción ha sido denegada por el Banco Emisor</h3>";
		break;
		case '05':
		echo "<h3 style='text-align: center;'>La transacción ha sido rechazada</h3>";
		break;
	}
}

add_shortcode('confirmacion_visa', 'shortcode_confirmacion');

/*
//Agregar campo de cuotas en el checkout
function campo_cuotas($fields){
	
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
*/
?>