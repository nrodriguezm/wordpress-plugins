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

	var $notify_url;

	/**
	 * Constructor for the gateway.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		$this->id                = 'cobrosya';
		$this->icon              = apply_filters( 'woocommerce_cobrosya_icon', get_site_url().'/wp-content/plugins/integracion_cobrosya/img/cobrosya.jpg');
		$this->has_fields        = false;
		$this->order_button_text = __( 'Ir a Cobrosya', 'woocommerce' );
		$this->liveurl           = 'https://api.cobrosya.com/v3/cobrar';
		$this->testurl           = 'http://api-sandbox.cobrosya.com/v3/cobrar';
		$this->method_title      = __( 'Cobrosya', 'woocommerce' );
		$this->notify_url        = WC()->api_request_url( 'WC_Gateway_Cobrosya' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
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
		$this->email 			 = '';
		$this->receiver_email    = '';
		$this->testmode			 = $this->get_option( 'testmode' );
		$this->send_shipping	 = 'no';
		$this->address_override	 = 'no';
		$this->debug			 = 'no';
		$this->form_submission_method = true;
		$this->page_style 		 = '';
		$this->invoice_prefix	 = '';
		$this->paymentaction     = $this->get_option( 'paymentaction', 'sale' );
		$this->identity_token    = $this->get_option( 'identity_token', '' );

		// Logs
		if ( 'yes' == $this->debug ) {
			$this->log = new WC_Logger();
		}

		// Actions
		add_action( 'valid-cobrosya-standard-request', array( $this, 'successful_request' ) );
		add_action( 'woocommerce_receipt_cobrosya', array( $this, 'receipt_page' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_thankyou_cobrosya', array( $this, 'pdt_return_handler' ) );

		// Payment listener/API hook
		add_action( 'woocommerce_api_wc_gateway_cobrosya', array( $this, 'check_cobrosya_response' ) );

		if ( ! $this->is_valid_for_use() ) {
			$this->enabled = false;
		}
	}

	/**
	 * Check if this gateway is enabled and available in the user's country
	 *
	 * @access public
	 * @return bool
	 */
	function is_valid_for_use() {
		if ( ! in_array( get_woocommerce_currency(), apply_filters( 'woocommerce_cobrosya_supported_currencies', array( 'AUD', 'BRL', 'CAD', 'MXN', 'NZD', 'HKD', 'SGD', 'USD', 'EUR', 'JPY', 'TRY', 'NOK', 'CZK', 'DKK', 'HUF', 'ILS', 'MYR', 'PHP', 'PLN', 'SEK', 'CHF', 'TWD', 'THB', 'GBP', 'RMB', 'RUB' ) ) ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 */
	public function admin_options() {

		?>
		<h3><?php _e( 'Cobrosya', 'woocommerce' ); ?></h3>
		<p><?php _e( 'CobrosYa funciona mandando al usuario a CobrosYa para introducir la información del pago.', 'woocommerce' ); ?></p>

		<?php if ( $this->is_valid_for_use() ) : ?>

			<table class="form-table">
			<?php
				// Generate the HTML For the settings form.
				$this->generate_settings_html();
			?>
			</table><!--/.form-table-->

		<?php else : ?>
			<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'woocommerce' ); ?></strong>: <?php _e( 'Cobrosya does not support your store currency.', 'woocommerce' ); ?></p></div>
		<?php
			endif;
	}

	/**
	 * Initialise Gateway Settings Form Fields
	 *
	 * @access public
	 * @return void
	 */
	function init_form_fields() {

		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar CobrosYa', 'woocommerce' ),
							'default' => 'yes'
						),
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
										'998'   => __( 'Dolares', 'cmb' ),
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
			'tarjetas' => array(
							'title' => __( 'Tarjetas de crédito', 'woocommerce' ),
							'type' => 'title',
							'description' => 'Opciones de pago para tarjetas. Requiere contrato con tarjetas',
						),
			'oca_monto_minimo' => array(
							'title' => __( 'Monto mínimo(OCA)', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Valor mínimo de la compra para aplicar cuotas', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'oca_1' => array(
							'title' => __( 'Tarjeta OCA', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Contado', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( '', 'woocommerce' ),
						),
			'oca_3' => array(
							'title' => __( '', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( '3 Cuotas', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( '', 'woocommerce' ),
						),
			'oca_6' => array(
							'title' => __( '', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( '6 Cuotas', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( '', 'woocommerce' ),
						),
			'master_monto_minimo' => array(
							'title' => __( 'Monto mínimo (Master)', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Valor mínimo de la compra para aplicar cuotas', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'master_1' => array(
							'title' => __( 'Tarjetas MASTERCARD/DINERS/DISCOVER/LIDER', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Contado', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( '', 'woocommerce' ),
						),
			'master_3' => array(
							'title' => __( '', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( '3 Cuotas', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( '', 'woocommerce' ),
						),
			'master_6' => array(
							'title' => __( '', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( '6 Cuotas', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( '', 'woocommerce' ),
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
	 * Limit the length of item names
	 * @param  string $item_name
	 * @return string
	 */
	public function cobrosya_item_name( $item_name ) {
		if ( strlen( $item_name ) > 127 ) {
			$item_name = substr( $item_name, 0, 124 ) . '...';
		}
		return html_entity_decode( $item_name, ENT_NOQUOTES, 'UTF-8' );
	}

	/**
	 * Get Cobrosya Args for passing to PP
	 *
	 * @access public
	 * @param mixed $order
	 * @return array
	 */
	function get_cobrosya_args( $order ) {

		$order_id = $order->id;

		if ( 'yes' == $this->debug ) {
			$this->log->add( 'cobrosya', 'Generating payment form for order ' . $order->get_order_number() . '. Notify URL: ' . $this->notify_url );
		}

		if ( in_array( $order->billing_country, array( 'US','CA' ) ) ) {
			$order->billing_phone = str_replace( array( '(', '-', ' ', ')', '.' ), '', $order->billing_phone );
			$phone_args = array(
				'night_phone_a' => substr( $order->billing_phone, 0, 3 ),
				'night_phone_b' => substr( $order->billing_phone, 3, 3 ),
				'night_phone_c' => substr( $order->billing_phone, 6, 4 ),
				'day_phone_a' 	=> substr( $order->billing_phone, 0, 3 ),
				'day_phone_b' 	=> substr( $order->billing_phone, 3, 3 ),
				'day_phone_c' 	=> substr( $order->billing_phone, 6, 4 )
			);
		} else {
			$phone_args = array(
				'night_phone_b' => $order->billing_phone,
				'day_phone_b' 	=> $order->billing_phone
			);
		}

		// Cobrosya Args
		$cobrosya_args = array_merge(
			array(
				'cmd'           => '_cart',
				'business'      => $this->email,
				'no_note'       => 1,
				'currency_code' => get_woocommerce_currency(),
				'charset'       => 'UTF-8',
				'rm'            => is_ssl() ? 2 : 1,
				'upload'        => 1,
				'return'        => urlencode( esc_url( add_query_arg( 'utm_nooverride', '1', $this->get_return_url( $order ) ) ) ),
				'cancel_return' => urlencode( esc_url( $order->get_cancel_order_url() ) ),
				'page_style'    => $this->page_style,
				'paymentaction' => $this->paymentaction,
				'bn'            => 'WooThemes_Cart',

				// Order key + ID
				'invoice'       => $this->invoice_prefix . ltrim( $order->get_order_number(), '#' ),
				'custom'        => serialize( array( $order_id, $order->order_key ) ),

				// IPN
				'notify_url'    => $this->notify_url,

				// Billing Address info
				'first_name'    => $order->billing_first_name,
				'last_name'     => $order->billing_last_name,
				'company'       => $order->billing_company,
				'address1'      => $order->billing_address_1,
				'address2'      => $order->billing_address_2,
				'city'          => $order->billing_city,
				'state'         => $this->get_cobrosya_state( $order->billing_country, $order->billing_state ),
				'zip'           => $order->billing_postcode,
				'country'       => $order->billing_country,
				'email'         => $order->billing_email
			),
			$phone_args
		);

		// Shipping
		if ( 'yes' == $this->send_shipping ) {
			$cobrosya_args['address_override'] = ( $this->address_override == 'yes' ) ? 1 : 0;

			$cobrosya_args['no_shipping'] = 0;

			// If we are sending shipping, send shipping address instead of billing
			$cobrosya_args['first_name']		= $order->shipping_first_name;
			$cobrosya_args['last_name']		= $order->shipping_last_name;
			$cobrosya_args['company']			= $order->shipping_company;
			$cobrosya_args['address1']		= $order->shipping_address_1;
			$cobrosya_args['address2']		= $order->shipping_address_2;
			$cobrosya_args['city']			= $order->shipping_city;
			$cobrosya_args['state']			= $this->get_cobrosya_state( $order->shipping_country, $order->shipping_state );
			$cobrosya_args['country']			= $order->shipping_country;
			$cobrosya_args['zip']				= $order->shipping_postcode;
		} else {
			$cobrosya_args['no_shipping'] = 1;
		}

		// If prices include tax or have order discounts, send the whole order as a single item
		if ( get_option( 'woocommerce_prices_include_tax' ) == 'yes' || $order->get_order_discount() > 0 || ( sizeof( $order->get_items() ) + sizeof( $order->get_fees() ) ) >= 9 ) {

			// Discount
			$cobrosya_args['discount_amount_cart'] = $order->get_order_discount();

			// Don't pass items - cobrosya borks tax due to prices including tax. Cobrosya has no option for tax inclusive pricing sadly. Pass 1 item for the order items overall
			$item_names = array();

			if ( sizeof( $order->get_items() ) > 0 ) {
				foreach ( $order->get_items() as $item ) {
					if ( $item['qty'] ) {
						$item_names[] = $item['name'] . ' x ' . $item['qty'];
					}
				}
			}

			$cobrosya_args['item_name_1'] 	= $this->cobrosya_item_name( sprintf( __( 'Order %s' , 'woocommerce'), $order->get_order_number() ) . " - " . implode( ', ', $item_names ) );
			$cobrosya_args['quantity_1'] 		= 1;
			$cobrosya_args['amount_1'] 		= number_format( $order->get_total() - round( $order->get_total_shipping() + $order->get_shipping_tax(), 2 ) + $order->get_order_discount(), 2, '.', '' );

			// Shipping Cost
			// No longer using shipping_1 because
			//		a) paypal ignore it if *any* shipping rules are within paypal
			//		b) paypal ignore anything over 5 digits, so 999.99 is the max
			if ( ( $order->get_total_shipping() + $order->get_shipping_tax() ) > 0 ) {
				$cobrosya_args['item_name_2'] = $this->cobrosya_item_name( __( 'Shipping via', 'woocommerce' ) . ' ' . ucwords( $order->get_shipping_method() ) );
				$cobrosya_args['quantity_2'] 	= '1';
				$cobrosya_args['amount_2'] 	= number_format( $order->get_total_shipping() + $order->get_shipping_tax(), 2, '.', '' );
			}

		} else {

			// Tax
			$cobrosya_args['tax_cart'] = $order->get_total_tax();

			// Cart Contents
			$item_loop = 0;
			if ( sizeof( $order->get_items() ) > 0 ) {
				foreach ( $order->get_items() as $item ) {
					if ( $item['qty'] ) {

						$item_loop++;

						$product = $order->get_product_from_item( $item );

						$item_name 	= $item['name'];

						$item_meta = new WC_Order_Item_Meta( $item['item_meta'] );
						if ( $meta = $item_meta->display( true, true ) ) {
							$item_name .= ' ( ' . $meta . ' )';
						}

						$cobrosya_args[ 'item_name_' . $item_loop ] 	= $this->cobrosya_item_name( $item_name );
						$cobrosya_args[ 'quantity_' . $item_loop ] 	= $item['qty'];
						$cobrosya_args[ 'amount_' . $item_loop ] 		= $order->get_item_subtotal( $item, false );

						if ( $product->get_sku() ) {
							$cobrosya_args[ 'item_number_' . $item_loop ] = $product->get_sku();
						}
					}
				}
			}

			// Discount
			if ( $order->get_cart_discount() > 0 ) {
				$cobrosya_args['discount_amount_cart'] = round( $order->get_cart_discount(), 2 );
			}

			// Fees
			if ( sizeof( $order->get_fees() ) > 0 ) {
				foreach ( $order->get_fees() as $item ) {
					$item_loop++;

					$cobrosya_args[ 'item_name_' . $item_loop ] 	= $this->cobrosya_item_name( $item['name'] );
					$cobrosya_args[ 'quantity_' . $item_loop ] 	= 1;
					$cobrosya_args[ 'amount_' . $item_loop ] 		= $item['line_total'];
				}
			}

			// Shipping Cost item - Cobrosya only allows shipping per item, we want to send shipping for the order
			if ( $order->get_total_shipping() > 0 ) {
				$item_loop++;
				$cobrosya_args[ 'item_name_' . $item_loop ] 	= $this->cobrosya_item_name( sprintf( __( 'Shipping via %s', 'woocommerce' ), $order->get_shipping_method() ) );
				$cobrosya_args[ 'quantity_' . $item_loop ] 	= '1';
				$cobrosya_args[ 'amount_' . $item_loop ] 		= number_format( $order->get_total_shipping(), 2, '.', '' );
			}

		}

		$cobrosya_args = apply_filters( 'woocommerce_cobrosya_args', $cobrosya_args );

		return $cobrosya_args;
	}

	/**
	 * Generate the cobrosya button link
	 *
	 * @access public
	 * @param mixed $order_id
	 * @return string
	 */
	function generate_cobrosya_form( $order_id ) {

		global $woocommerce;

		$order = new WC_Order( $order_id );
		$order->update_status('cancelled', 'El usuario no seleccionó método de pago.');
		if ( $this->testmode == 'yes' ):
			$cobrosya_adr = $this->testurl . '';
			$token = $this->token_sandbox;
		else :
			$cobrosya_adr = $this->liveurl . '';
			$token = $this->token_produccion;
		endif;

		$cobrosya_args = $this->get_cobrosya_args( $order );

		$cobrosya_args_array = array();
		
		$id_transaccion = $order->id;
		$nombre = $cobrosya_args["first_name"];
		$apellido = $cobrosya_args["last_name"];
		$email = $cobrosya_args["email"];
		$celular = $cobrosya_args["night_phone_b"];
		$monto = str_replace(".","",$order->get_total());
		$fecha_vencimiento = "";
		$url_respuesta = $this->url_respuesta;
		$direccion = $cobrosya_args["address1"];
		$ciudad = $cobrosya_args["city"];
		$departamento = $cobrosya_args["state"];
		$pais = $cobrosya_args["country"];
		$codigo_postal = $cobrosya_args["zip"];
		$telefono = substr($celular, 2);
		
		if ($this->fecha_vencimiento == 'yes') {
			//Calculo la fecha de vencimiento del pago
			//Obtengo la cantidad de minutos especificada para el vencimiento del pago
			$minutos = get_option( 'woocommerce_hold_stock_minutes' );
		
			//Lo paso a cantidad de dias
			$cant_dias = "+ ".(String)floor((int)$minutos / 1440)." days";
		
			//Obtengo la hora actual 
			$date = new DateTime(null, new DateTimeZone('America/Montevideo'));
			$date1 = $date->format('Y-m-d') . "\n";
		
			//Sumo los dias y obtengo la fecha de vencimiento
			$fecha_vencimiento = date('Y-m-d', strtotime($Date. $cant_dias));
		}
		
		//Cuotas oca
		$cuotas_oca = "";
		if ($monto >= $this->oca_monto_minimo){
			if ($this->oca_1 == 'yes') {
				$cuotas_oca .= "1";
			}
			
			if ($this->oca_3 == 'yes') {
				if ($this->oca_1 == 'yes') {
					$cuotas_oca .= ",3";
				} else {
					$cuotas_oca .= "3";
				}
			}
			
			if ($this->oca_6 == 'yes') {
				if (($this->oca_1 == 'yes') || ($this->oca_3 == 'yes')) {
					$cuotas_oca .= ",6";
				} else {
					$cuotas_oca .= "6";
				}
			}
		}
		
		//Cuotas master
		$cuotas_master = "";
		if ($monto >= $this->master_monto_minimo){
			if ($this->master_1 == 'yes') {
				$cuotas_master .= "1";
			}
			
			if ($this->master_3 == 'yes') {
				if ($this->master_1 == 'yes') {
					$cuotas_master .= ",3";
				} else {
					$cuotas_master .= "3";
				}
			}
			
			if ($this->master_6 == 'yes') {
				if (($this->master_1 == 'yes') || ($this->master_3 == 'yes')) {
					$cuotas_master .= ",6";
				} else {
					$cuotas_master .= "6";
				}
			}
		}
		
		$campo_monto_vencido = "";
		if ($this->monto_vencido != ""){
			$monto_vencido = $monto + round((($this->monto_vencido)*$monto)/100);
			$campo_monto_vencido = "<input type='hidden' name='monto_vencido' value='".$monto_vencido."'>";
		}
		
		$woocommerce->add_inline_js( '
			jQuery("body").block({
					message: "'.__( 'Espera mientras te dirigimos a la página de cobrosya...', 'woocommerce' ).'",
					overlayCSS:
					{
						background: "#fff",
						opacity: 0.6
					},
					css: {
				        padding:        20,
				        textAlign:      "center",
				        color:          "#555",
				        border:         "3px solid #aaa",
				        backgroundColor:"#fff",
				        cursor:         "wait",
				        lineHeight:		"32px"
				    }
				});
			jQuery("#formcobrosyasubmit").click();
		' );
		 
		return "<form action='".get_site_url()."/wp-content/plugins/integracion_cobrosya/archivos/comprar.php' method='post' id='formcobrosya'>
				<input type='hidden' name='token' value='".$token."'>
				<input type='hidden' name='id_transaccion' value='".$id_transaccion."'>
				<input type='hidden' name='nombre' value='".$nombre."'>
				<input type='hidden' name='apellido' value='".$apellido."'>
				<input type='hidden' name='email' value='".$email."'>
				<input type='hidden' name='concepto' value='".$this->concepto."'>
				<input type='hidden' name='moneda' value='".$this->moneda."'>
				<input type='hidden' name='monto' value='".$monto."'>
				<input type='hidden' name='fecha_vencimiento' value='".$fecha_vencimiento."'>
				".$campo_monto_vencido."
				<input type='hidden' name='url_respuesta' value='".$url_respuesta."/?id=". $id_transaccion."'>
				<input type='hidden' name='url_incorrecta' value='".$url_respuesta."/?id=-1'>
				<input type='hidden' name='url_api' value='".$cobrosya_adr."'>
				<input type='hidden' name='direccion' value='".$direccion."'>
				<input type='hidden' name='ciudad' value='".$ciudad."'>
				<input type='hidden' name='departamento' value='".$departamento."'>
				<input type='hidden' name='pais' value='".$pais."'>
				<input type='hidden' name='codigo_postal' value='".$codigo_postal."'>
				<input type='hidden' name='telefono' value='".$telefono."'>
				<input type='hidden' name='cuotas_oca' value='".$cuotas_oca."'>
				<input type='hidden' name='cuotas_master' value='".$cuotas_master."'>
				<input type='submit' value='Enviar' id='formcobrosyasubmit' style='display:none'></form>";
	}

	/**
	 * Process the payment and return the result
	 *
	 * @access public
	 * @param int $order_id
	 * @return array
	 */
	function process_payment( $order_id ) {

		$order = new WC_Order( $order_id );

		if ( ! $this->form_submission_method ) {

			$cobrosya_args = $this->get_cobrosya_args( $order );

			$cobrosya_args = http_build_query( $cobrosya_args, '', '&' );

			if ( 'yes' == $this->testmode ) {
				$cobrosya_adr = $this->testurl . '?test_ipn=1&';
			} else {
				$cobrosya_adr = $this->liveurl . '?';
			}

			return array(
				'result' 	=> 'success',
				'redirect'	=> $cobrosya_adr . $cobrosya_args
			);

		} else {

			return array(
				'result' 	=> 'success',
				'redirect'	=> $order->get_checkout_payment_url( true )
			);

		}

	}

	/**
	 * Output for the order received page.
	 *
	 * @access public
	 * @return void
	 */
	function receipt_page( $order ) {
		echo '<p>' . __( 'Gracias - su orden está pendiente de confirmación. Usted será redirigido a Cobrosya para realizar su pago.', 'woocommerce' ) . '</p>';

		echo $this->generate_cobrosya_form( $order );
	}

	/**
	 * Check Cobrosya IPN validity
	 **/
	function check_cobrosya_request_is_valid( $ipn_response ) {

		// Get url
		if ( 'yes' == $this->testmode ) {
			$cobrosya_adr = $this->testurl;
		} else {
			$cobrosya_adr = $this->liveurl;
		}

		if ( 'yes' == $this->debug ) {
			$this->log->add( 'cobrosya', 'Checking IPN response is valid via ' . $cobrosya_adr . '...' );
		}

		// Get received values from post data
		$validate_ipn = array( 'cmd' => '_notify-validate' );
		$validate_ipn += stripslashes_deep( $ipn_response );

		// Send back post vars to cobrosya
		$params = array(
			'body' 			=> $validate_ipn,
			'sslverify' 	=> false,
			'timeout' 		=> 60,
			'httpversion'   => '1.1',
			'compress'      => false,
			'decompress'    => false,
			'user-agent'	=> 'WooCommerce/' . WC()->version
		);

		if ( 'yes' == $this->debug ) {
			$this->log->add( 'cobrosya', 'IPN Request: ' . print_r( $params, true ) );
		}

		// Post back to get a response
		$response = wp_remote_post( $cobrosya_adr, $params );

		if ( 'yes' == $this->debug ) {
			$this->log->add( 'cobrosya', 'IPN Response: ' . print_r( $response, true ) );
		}

		// check to see if the request was valid
		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 && ( strcmp( $response['body'], "VERIFIED" ) == 0 ) ) {
			if ( 'yes' == $this->debug ) {
				$this->log->add( 'cobrosya', 'Received valid response from Cobrosya' );
			}

			return true;
		}

		if ( 'yes' == $this->debug ) {
			$this->log->add( 'cobrosya', 'Received invalid response from Cobrosya' );
			if ( is_wp_error( $response ) ) {
				$this->log->add( 'cobrosya', 'Error response: ' . $response->get_error_message() );
			}
		}

		return false;
	}

	/**
	 * Check for Cobrosya IPN Response
	 *
	 * @access public
	 * @return void
	 */
	function check_cobrosya_response() {
		global $woocommerce;
		global $wpdb;
		
		
		
		//Guardo datos en la base
		if (isset($_POST["id_secreto"])) {
			
			$sql = 'SELECT * FROM '. $wpdb->prefix . 'cobrosya WHERE idSecreto = "'.$_POST["id_secreto"].'" AND paga = 0';
			$tapi = $wpdb->get_row($sql, ARRAY_A);
			
			if (!(is_null($tapi))) {
				
				$order = new WC_Order( $tapi["transaccion"]);
				
				if ($_POST["accion"] == "cobro") {
					
					$sql = 'UPDATE '. $wpdb->prefix . 'cobrosya SET medioPagoId = '.$_POST["id_medio_pago"].', medioPago = "'.$_POST["medio_pago"].'", fechaHoraPago = "'.$_POST["fecha_hora_pago"].'", paga = 1 WHERE transaccion = "'.$tapi["transaccion"].'"';
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

	/**
	 * Successful Payment!
	 *
	 * @access public
	 * @param array $posted
	 * @return void
	 */
	function successful_request( $posted ) {

		$posted = stripslashes_deep( $posted );

		// Custom holds post ID
		if ( ! empty( $posted['invoice'] ) && ! empty( $posted['custom'] ) ) {

			$order = $this->get_cobrosya_order( $posted['custom'], $posted['invoice'] );

			if ( 'yes' == $this->debug ) {
				$this->log->add( 'cobrosya', 'Found order #' . $order->id );
			}

			// Lowercase returned variables
			$posted['payment_status'] 	= strtolower( $posted['payment_status'] );
			$posted['txn_type'] 		= strtolower( $posted['txn_type'] );

			// Sandbox fix
			if ( 1 == $posted['test_ipn'] && 'pending' == $posted['payment_status'] ) {
				$posted['payment_status'] = 'completed';
			}

			if ( 'yes' == $this->debug ) {
				$this->log->add( 'cobrosya', 'Payment status: ' . $posted['payment_status'] );
			}

			// We are here so lets check status and do actions
			switch ( $posted['payment_status'] ) {
				case 'completed' :
				case 'pending' :

					// Check order not already completed
					if ( $order->status == 'completed' ) {
						if ( 'yes' == $this->debug ) {
							$this->log->add( 'cobrosya', 'Aborting, Order #' . $order->id . ' is already complete.' );
						}
						exit;
					}

					// Check valid txn_type
					$accepted_types = array( 'cart', 'instant', 'express_checkout', 'web_accept', 'masspay', 'send_money' );

					if ( ! in_array( $posted['txn_type'], $accepted_types ) ) {
						if ( 'yes' == $this->debug ) {
							$this->log->add( 'cobrosya', 'Aborting, Invalid type:' . $posted['txn_type'] );
						}
						exit;
					}

					// Validate currency
					if ( $order->get_order_currency() != $posted['mc_currency'] ) {
						if ( 'yes' == $this->debug ) {
							$this->log->add( 'cobrosya', 'Payment error: Currencies do not match (sent "' . $order->get_order_currency() . '" | returned "' . $posted['mc_currency'] . '")' );
						}

						// Put this order on-hold for manual checking
						$order->update_status( 'on-hold', sprintf( __( 'Validation error: Cobrosya currencies do not match (code %s).', 'woocommerce' ), $posted['mc_currency'] ) );
						exit;
					}

					// Validate amount
					if ( $order->get_total() != $posted['mc_gross'] ) {
						if ( 'yes' == $this->debug ) {
							$this->log->add( 'cobrosya', 'Payment error: Amounts do not match (gross ' . $posted['mc_gross'] . ')' );
						}

						// Put this order on-hold for manual checking
						$order->update_status( 'on-hold', sprintf( __( 'Validation error: Cobrosya amounts do not match (gross %s).', 'woocommerce' ), $posted['mc_gross'] ) );
						exit;
					}

					// Validate Email Address
					if ( strcasecmp( trim( $posted['receiver_email'] ), trim( $this->receiver_email ) ) != 0 ) {
						if ( 'yes' == $this->debug ) {
							$this->log->add( 'cobrosya', "IPN Response is for another one: {$posted['receiver_email']} our email is {$this->receiver_email}" );
						}

						// Put this order on-hold for manual checking
						$order->update_status( 'on-hold', sprintf( __( 'Validation error: Cobrosya IPN response from a different email address (%s).', 'woocommerce' ), $posted['receiver_email'] ) );

						exit;
					}

					 // Store PP Details
					if ( ! empty( $posted['payer_email'] ) ) {
						update_post_meta( $order->id, 'Payer Cobrosya address', wc_clean( $posted['payer_email'] ) );
					}
					if ( ! empty( $posted['txn_id'] ) ) {
						update_post_meta( $order->id, 'Transaction ID', wc_clean( $posted['txn_id'] ) );
					}
					if ( ! empty( $posted['first_name'] ) ) {
						update_post_meta( $order->id, 'Payer first name', wc_clean( $posted['first_name'] ) );
					}
					if ( ! empty( $posted['last_name'] ) ) {
						update_post_meta( $order->id, 'Payer last name', wc_clean( $posted['last_name'] ) );
					}
					if ( ! empty( $posted['payment_type'] ) ) {
						update_post_meta( $order->id, 'Payment type', wc_clean( $posted['payment_type'] ) );
					}

					if ( $posted['payment_status'] == 'completed' ) {
						$order->add_order_note( __( 'IPN payment completed', 'woocommerce' ) );
						$order->payment_complete();
					} else {
						$order->update_status( 'on-hold', sprintf( __( 'Payment pending: %s', 'woocommerce' ), $posted['pending_reason'] ) );
					}

					if ( 'yes' == $this->debug ) {
						$this->log->add( 'cobrosya', 'Payment complete.' );
					}

				break;
				case 'denied' :
				case 'expired' :
				case 'failed' :
				case 'voided' :
					// Order failed
					$order->update_status( 'failed', sprintf( __( 'Payment %s via IPN.', 'woocommerce' ), strtolower( $posted['payment_status'] ) ) );
				break;
				case 'refunded' :

					// Only handle full refunds, not partial
					if ( $order->get_total() == ( $posted['mc_gross'] * -1 ) ) {

						// Mark order as refunded
						$order->update_status( 'refunded', sprintf( __( 'Payment %s via IPN.', 'woocommerce' ), strtolower( $posted['payment_status'] ) ) );

						$mailer = WC()->mailer();

						$message = $mailer->wrap_message(
							__( 'Order refunded/reversed', 'woocommerce' ),
							sprintf( __( 'Order %s has been marked as refunded - Cobrosya reason code: %s', 'woocommerce' ), $order->get_order_number(), $posted['reason_code'] )
						);

						$mailer->send( get_option( 'admin_email' ), sprintf( __( 'Payment for order %s refunded/reversed', 'woocommerce' ), $order->get_order_number() ), $message );

					}

				break;
				case 'reversed' :

					// Mark order as refunded
					$order->update_status( 'on-hold', sprintf( __( 'Payment %s via IPN.', 'woocommerce' ), strtolower( $posted['payment_status'] ) ) );

					$mailer = WC()->mailer();

					$message = $mailer->wrap_message(
						__( 'Order reversed', 'woocommerce' ),
						sprintf(__( 'Order %s has been marked on-hold due to a reversal - Cobrosya reason code: %s', 'woocommerce' ), $order->get_order_number(), $posted['reason_code'] )
					);

					$mailer->send( get_option( 'admin_email' ), sprintf( __( 'Payment for order %s reversed', 'woocommerce' ), $order->get_order_number() ), $message );

				break;
				case 'canceled_reversal' :

					$mailer = WC()->mailer();

					$message = $mailer->wrap_message(
						__( 'Reversal Cancelled', 'woocommerce' ),
						sprintf( __( 'Order %s has had a reversal cancelled. Please check the status of payment and update the order status accordingly.', 'woocommerce' ), $order->get_order_number() )
					);

					$mailer->send( get_option( 'admin_email' ), sprintf( __( 'Reversal cancelled for order %s', 'woocommerce' ), $order->get_order_number() ), $message );

				break;
				default :
					// No action
				break;
			}

			exit;
		}

	}

	/**
	 * Return handler
	 *
	 * Alternative to IPN
	 */
	public function pdt_return_handler() {
		$posted = stripslashes_deep( $_REQUEST );

		if ( ! empty( $this->identity_token ) && ! empty( $posted['cm'] ) ) {

			$order = $this->get_cobrosya_order( $posted['cm'] );

			if ( 'pending' != $order->status ) {
				return false;
			}

			$posted['st'] = strtolower( $posted['st'] );

			switch ( $posted['st'] ) {
				case 'completed' :

					// Validate transaction
					if ( 'yes' == $this->testmode ) {
						$cobrosya_adr = $this->testurl;
					} else {
						$cobrosya_adr = $this->liveurl;
					}

					$pdt = array(
						'body' 			=> array(
							'cmd' => '_notify-synch',
							'tx'  => $posted['tx'],
							'at'  => $this->identity_token
						),
						'sslverify' 	=> false,
						'timeout' 		=> 60,
						'httpversion'   => '1.1',
						'user-agent'	=> 'WooCommerce/' . WC_VERSION
					);

					// Post back to get a response
					$response = wp_remote_post( $cobrosya_adr, $pdt );

					if ( is_wp_error( $response ) ) {
						return false;
					}

					if ( ! strpos( $response['body'], "SUCCESS" ) === 0 ) {
						return false;
					}

					// Validate Amount
					if ( $order->get_total() != $posted['amt'] ) {

						if ( 'yes' == $this->debug ) {
							$this->log->add( 'cobrosya', 'Payment error: Amounts do not match (amt ' . $posted['amt'] . ')' );
						}

						// Put this order on-hold for manual checking
						$order->update_status( 'on-hold', sprintf( __( 'Validation error: Cobrosya amounts do not match (amt %s).', 'woocommerce' ), $posted['amt'] ) );
						return true;

					} else {

						// Store PP Details
						update_post_meta( $order->id, 'Transaction ID', wc_clean( $posted['tx'] ) );

						$order->add_order_note( __( 'PDT payment completed', 'woocommerce' ) );
						$order->payment_complete();
						return true;
					}

				break;
			}
		}

		return false;
	}

	/**
	 * get_cobrosya_order function.
	 *
	 * @param  string $custom
	 * @param  string $invoice
	 * @return WC_Order object
	 */
	private function get_cobrosya_order( $custom, $invoice = '' ) {
		$custom = maybe_unserialize( $custom );

		// Backwards comp for IPN requests
		if ( is_numeric( $custom ) ) {
			$order_id  = (int) $custom;
			$order_key = $invoice;
		} elseif( is_string( $custom ) ) {
			$order_id  = (int) str_replace( $this->invoice_prefix, '', $custom );
			$order_key = $custom;
		} else {
			list( $order_id, $order_key ) = $custom;
		}

		$order = new WC_Order( $order_id );

		if ( ! isset( $order->id ) ) {
			// We have an invalid $order_id, probably because invoice_prefix has changed
			$order_id 	= wc_get_order_id_by_order_key( $order_key );
			$order 		= new WC_Order( $order_id );
		}

		// Validate key
		if ( $order->order_key !== $order_key ) {
			if ( 'yes' == $this->debug ) {
				$this->log->add( 'cobrosya', 'Error: Order Key does not match invoice.' );
			}
			exit;
		}

		return $order;
	}

	/**
	 * Get the state to send to cobrosya
	 * @param  string $cc
	 * @param  string $state
	 * @return string
	 */
	public function get_cobrosya_state( $cc, $state ) {
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
