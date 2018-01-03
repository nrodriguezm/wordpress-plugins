<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Cobrosya Standard Payment Gateway
 *
 * Provides a Cobrosya Standard Payment Gateway.
 *
 * @class 		WC_Cobrosya
 * @extends		WC_Gateway_Cobrosya
 * @version		2.0.0
 * @package		WooCommerce/Classes/Payment
 * @author 		WooThemes
 */
class WC_Gateway_Cobrosya extends WC_Payment_Gateway {

	public function __construct() {
		$this->id 		= 'cobrosya';
		$this->icon 	= get_site_url().'/wp-content/plugins/integracion_cobrosya/img/cobrosya.png';
		$this->has_fields = false;
		$this->method_title = 'CobrosYa';
		$this->liveurl           = 'https://api.cobrosya.com/v4/crear';
		$this->testurl           = 'http://api-sandbox.cobrosya.com/v4/crear';
		$this->notify_url        = WC()->api_request_url( 'WC_Gateway_Cobrosya' );
		$this->enabled = 'no';
		
		//Se definen y se cargan las opciones del panel.
		$this->init_form_fields();
		$this->init_settings();
		
		//Se cargan las opciones seteadas por el usuario
		$this->title 			 = $this->get_option( 'title' );
		$this->description 		 = $this->get_option( 'description' );
		$this->token_produccion  = $this->get_option( 'token_produccion' );
		$this->token_sandbox     = $this->get_option( 'token_sandbox' );
		$this->moneda 			 = $this->get_option( 'moneda' );
		$this->concepto			 = $this->get_option( 'concepto' );
		$this->fecha_vencimiento = $this->get_option( 'fecha_vencimiento' );
		$this->monto_vencido     = $this->get_option( 'monto_vencido' );
		$this->url_respuesta 	 = get_site_url().'/confirmacion-cobrosya';
		$this->oca_monto_minimo  = $this->get_option( 'oca_monto_minimo' );
		$this->oca_1 			 = $this->get_option( 'oca_1' );
		$this->oca_3 			 = $this->get_option( 'oca_3' );
		$this->oca_6 			 = $this->get_option( 'oca_6' );
		$this->master_monto_minimo  = $this->get_option( 'master_monto_minimo' );
		$this->master_1 		 = $this->get_option( 'master_1' );
		$this->master_3 		 = $this->get_option( 'master_3' );
		$this->master_6 		 = $this->get_option( 'master_6' );
		$this->testmode			 = $this->get_option( 'testmode' );
		$this->form_submission_method = true;
		
		//Accion para guardar las opciones del usuario.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
	}
	
	
	/**
	 * Método que define los campos del Gateway   
	 */
	function init_form_fields() {

		$this->form_fields = array(
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Cobrosya', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'description' => array(
							'title' => __( 'Description', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Pagar a través de CobrosYa, usted puede pagar con su tarjeta de crédito si no tiene una cuenta de CobrosYa', 'woocommerce' )
						),
			'token_produccion' => array(
							'title' => __( 'Token producción', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Token para producción', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'token_sandbox' => array(
							'title' => __( 'Token sandbox', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Token para sandbox', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'moneda' => array(
							'title' => __( 'Moneda', 'woocommerce' ),
							'type' => 'select',
							'options' => array(
										'858' => __( 'Pesos', 'cmb' ),
										'840'   => __( 'Dolares', 'cmb' ),
									), 
							'description' => __( 'Moneda en que se realizarán los pagos', 'woocommerce' ),
							'default' => __( 'pesos', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'concepto' => array(
							'title' => __( 'Concepto de compra', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Concepto de compra que aparece en la factura', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'fecha_vencimiento' => array(
							'title' => __( 'Fecha de vencimiento', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Fecha vencimiento', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( 'Activar si se desea ingresar una fecha de vencimiento a la factura. La fecha se indica en Productos->Inventario', 'woocommerce' ),
						),
			'monto_vencido' => array(
							'title' => __( 'Monto vencido', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Porcentaje adicional del monto a pagar en caso de vencimiento de la factura. Ej 10', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'testing' => array(
							'title' => __( 'Ambiente de prueba', 'woocommerce' ),
							'type' => 'title',
							'description' => '',
						),
			'testmode' => array(
							'title' => __( 'Habilitar CobrosYa sandbox', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar CobrosYa sandbox', 'woocommerce' ),
							'default' => 'yes',
							'description' =>  __( 'CobrosYa sandbox puede ser usado para probar pagos. Regístrate para obtener una cuenta de desarrollador', 'woocommerce' ),
						)
			);
	}
	
	/**
	 * Método que procesa el pago y retorna el resultado
	 */
	function process_payment( $order_id ) {
		
		$order = new WC_Order( $order_id );
		$order->update_status('processing', 'El usuario no seleccionó método de pago.');
		$cobrosya_args = $this->obtener_datos_pedido($order);
		include_once( 'envio_formulario_post.php' );
		
		return array(
			'result'   => 'success',
			'redirect' => $redireccionar
		);
		
	}
	
	/**
	 * Método para obtener los datos del pedido
	 */
	function obtener_datos_pedido( $order) {
		
		$datos = array(
			'first_name'    => $order->billing_first_name,
			'last_name'     => $order->billing_last_name,
			'email'         => $order->billing_email,
			'night_phone_b' => $order->billing_phone,
			'address1'      => $order->billing_address_1,
			'address2'      => $order->billing_address_2,
			'city'          => $order->billing_city,
			'state'         => $this->obtener_estado( $order->billing_country, $order->billing_state ),
			'country'       => $order->billing_country,
			'zip'           => $order->billing_postcode,
		);
		
		return $datos;
		
	}
	
	/**
	 * Check for Cobrosya IPN Response
	 *
	 * @access public
	 * @return void
	 */
	function respuesta_cobrosya() {
		
		global $woocommerce;
		global $wpdb;
		
		//Guardo datos en la base
		if (isset($_POST["id_secreto"])) {
			
			$sql = 'SELECT * FROM '. $wpdb->prefix . 'cobrosya WHERE idSecreto = "'.$_POST["id_secreto"].'" AND paga = 0';
			$tapi = $wpdb->get_row($sql, ARRAY_A);
			
			if (!(is_null($tapi))) {
				
				$order = new WC_Order( $tapi["transaccion"]);
				
				if ($_POST["accion"] == "cobro") {
					
					$sql = 'UPDATE '. $wpdb->prefix . 'cobrosya SET medioPagoId = '.$_POST["id_medio_pago"].', medioPago = "'.$_POST["medio_pago"].'", fechaHoraPago = "'.$_POST["fecha_hora_pago"].'", paga = 1, cuotas_codigo='.$_POST["cuotas_codigo"].', cuotas_texto="'.$_POST["cuotas_texto"].'", autorizacion="'.$_POST["autorizacion"].'"  WHERE transaccion = "'.$tapi["transaccion"].'"';
					$wpdb->query($sql);
					$order->update_status('completed', 'El usuario realizó un pago online.');
					echo "1";
					
				}elseif ($_POST["accion"] == "talon") {
				
					$sql = 'UPDATE '.$wpdb->prefix . 'cobrosya SET medioPagoId = '.$_POST["id_medio_pago"].', medioPago = "'.$_POST["medio_pago"].'", urlPDF = "'.$_POST["url_pdf"].'" WHERE transaccion = "'.$tapi["transaccion"].'"';
					$wpdb->query($sql);
					$order->update_status('pending', 'El usuario debe ir a Redpagos a realizar el pago.'); 
					echo "1";
					
				}

			}
		}
	}
	
	/*
	Método que obtiene los estados
	*/
	public function obtener_estado( $cc, $state ) {
		if ( 'US' === $cc ) {
			return $state;
		}

		$states = WC()->countries->get_states( $cc );

		if ( isset( $states[ $state ] ) ) {
			return $states[ $state ];
		}

		return $state;
	}
	
	
}
