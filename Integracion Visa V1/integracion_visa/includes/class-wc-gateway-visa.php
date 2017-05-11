<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Visa Standard Payment Gateway
 *
 * Provides a Visa Standard Payment Gateway.
 *
 * @class 		WC_Cobrosya
 * @extends		WC_Gateway_Visa
 * @version		2.0.0
 * @package		WooCommerce/Classes/Payment
 * @author 		WooThemes
 */
class WC_Gateway_Visa extends WC_Payment_Gateway {

	public function __construct() {
		$this->id 					= 'visa';
		$this->icon 				= get_site_url().'/wp-content/plugins/integracion_visa/img/visa.png';
		$this->has_fields			= false;
		$this->method_title 		= 'Visa';
		$this->liveurl      		= 'https://vpayment.verifika.com/VPOS/MM/transactionStart20.do';
		$this->testurl      		= 'https://integracion.alignetsac.com/VPOS/MM/transactionStart20.do';
		$this->notify_url       	= str_replace( 'https:', 'http:', add_query_arg( 'wc-api', 'WC_Gateway_Visa', home_url( '/' ) ) );
		$this->enabled 				= 'no';
		
		//Se definen y se cargan las opciones del panel.
		$this->init_form_fields();
		$this->init_settings();
		
		//Se cargan las opciones seteadas por el usuario
		$this->title 			 		= $this->get_option('title');
		$this->description 		 		= $this->get_option('description');
		$this->idacquirer 		 		= $this->get_option('idacquirer');
		$this->idcommerce 		 		= $this->get_option('idcommerce');
		$this->terminalcode 			= $this->get_option('terminalcode');
		$this->commercemallid 			= $this->get_option('commercemallid');
		$this->vi 		 				= $this->get_option('vi');
		$this->url_respuesta 	 		= get_site_url().'/confirmacion-visa';
		$this->testmode			 		= $this->get_option('testmode');
		$this->form_submission_method 	= true;
		$this->llave_firma_digital  	= $this->get_option('llave_firma_digital');
		$this->llave_cifrado  			= $this->get_option('llave_cifrado');
		$this->incluye_iva				= $this->get_option('incluye_iva');
		$this->valor_iva				= (int) $this->get_option('valor_iva');
		//Accion para guardar las opciones del usuario.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_api_wc_gateway_visa', array( $this, 'respuesta_visa' ) ); 
	}
	
	
	/**
	 * Método que define los campos del Gateway   
	 */
	function init_form_fields() {

		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar Visa', 'woocommerce' ),
							'default' => 'yes'
						),
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Visa', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'description' => array(
							'title' => __( 'Description', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Puede pagar con una tarjeta de crédito VISA con total seguridad.', 'woocommerce' )
						),
			'idacquirer' => array(
							'title' => __( 'IDACQUIRER', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Identificador fijo del Adquirente que permite al V-POS reconocer a la entidad adquirente del comercio. Este valor es generado por ALIGNET.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'idcommerce' => array(
							'title' => __( 'IDCOMMERCE', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Identificador fijo del comercio o tienda virtual que permite al V-POS reconocer enviando la solicitud de pago.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'terminalcode' => array(
							'title' => __( 'terminal Code', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Código de terminal de la compra.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'commercemallid' => array(
							'title' => __( 'Commerce Mall Id', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Valor del ID del Mall al cual pertenece el comercio.', 'woocommerce' ),
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
			'incluye_iva' => array(
							'title' => __( 'Precios incluyen IVA?', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Activar si los precios incluyen IVA', 'woocommerce' ),
							'description' =>  __( 'Este dato se utiliza para los calculos de la Ley de Inclusión financiera', 'woocommerce' ),
							'default' => 'yes'
						),
			'valor_iva' => array(
							'title' => __( 'Valor del IVA', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Si el valor del iva es de 22% ingresar el valor 22.', 'woocommerce' ),
							'default' => __( '22', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'produccion' => array(
							'title' => __( 'Ambiente de Producción', 'woocommerce' ),
							'type' => 'title',
							'description' => '',
						),
			'vi' => array(
							'title' => __( 'Vector de Inicialización', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Vector de Inicialización para ambiente de prueba.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_publica_request' => array(
							'title' => __( 'Llave pública de envio', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave publica de envio para ambiente de producción.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_privada_request' => array(
							'title' => __( 'Llave privada de envio', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave privada de envio para ambiente de produccion.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_publica_response' => array(
							'title' => __( 'Llave pública de respuesta', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave publica de respuesta para ambiente de producción.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_privada_response' => array(
							'title' => __( 'Llave privada de respuesta', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave privada de respuesta para ambiente de produccion.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'testing' => array(
							'title' => __( 'Ambiente de prueba', 'woocommerce' ),
							'type' => 'title',
							'description' => '',
						),
			'testmode' => array(
							'title' => __( 'Habilitar Visa sandbox', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar Visa sandbox', 'woocommerce' ),
							'default' => 'no',
							'description' =>  __( 'Visa sandbox puede ser usado para probar pagos.', 'woocommerce' ),
						),
			'idacquirer_testing' => array(
							'title' => __( 'IDACQUIRER', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Identificador de prueba, fijo del Adquirente que permite al V-POS reconocer a la entidad adquirente del comercio. Este valor es generado por ALIGNET.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'idcommerce_testing' => array(
							'title' => __( 'IDCOMMERCE', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Identificador de prueba, fijo del comercio o tienda virtual que permite al V-POS reconocer enviando la solicitud de pago.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'vi_testing' => array(
							'title' => __( 'Vector de Inicialización', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Vector de inicializacion de ambiente de prueba.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_publica_request_testing' => array(
							'title' => __( 'Llave pública de envio', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave pública de envio para ambiente de prueba.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_privada_request_testing' => array(
							'title' => __( 'Llave privada de envio', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave privada de envio  para ambiente de prueba.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_publica_response_testing' => array(
							'title' => __( 'Llave pública de respuesta', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave pública de respuesta para ambiente de prueba.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'llave_privada_response_testing' => array(
							'title' => __( 'Llave privada de respuesta', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Llave privada de respuesta para ambiente de prueba.', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			);
	}
	
	/**
	 * Método que procesa el pago y retorna el resultado
	 */
	function process_payment( $order_id ) {
		global $wpdb;
		
		$order = new WC_Order( $order_id );
		$order->update_status('processing', 'El usuario inició la compra con VISA.');
		
		$visa_args = $this->obtener_datos_compra($order);
		
		$respuesta = $this->enviar_datos_VPOS($visa_args);
		
		$nombre_tabla = $wpdb->prefix . 'visapedidos';
		
		//Registro del pedido
		$wpdb->query("INSERT INTO $nombre_tabla (id_pedido, fecha, nombre, apellido, direccion, telefono, ciudad, pais, email, importe, importe_gravado, detalle, IDACQUIRER, IDCOMMERCE, XMLREQ, DIGITALSIGN, SESSIONKEY) VALUES ('{$order->id}', NOW(), '{$visa_args['billingFirstName']}', '{$visa_args['billingLastName']}', '{$visa_args['billingAddress']}', '{$visa_args['billingPhone']}', '{$visa_args['billingCity']}', '{$visa_args['billingCountry']}', '{$visa_args['billingEMail']}', '{$visa_args['purchaseAmount']}', '{$visa_args['reserved12']}', 'Desde Woocommerce', '{$visa_args['acquirerId']}', '{$visa_args['commerceId']}', '{$respuesta['XMLREQ']}', '{$respuesta['DIGITALSIGN']}', '{$respuesta['SESSIONKEY']}')");                           
		$idpedido = $wpdb->insert_id;
		
		if(!empty($respuesta['XMLREQ']) and !empty($respuesta['DIGITALSIGN']) and !empty($respuesta['SESSIONKEY'])){
			$redireccionar = get_site_url().'/wp-content/plugins/integracion_visa/includes/pago_online.php?id_pedido='.$order_id;
		}else{
			$redireccionar = get_site_url().'/confirmacion-visa/?error=1';
		}
		
		return array(
			'result'   => 'success',
			'redirect' => $redireccionar
		);
		
	}
	
	/**
	 * Método para obtener el array con los datos de la compra para enviar al VPOS
	 */
	function obtener_datos_compra( $order) {
		
		//Obtengo datos de codigo de adquiriente y de comercio dependiendo del ambiente de prueba o produccion.
		if($this->testmode == 'yes'){
			$acquirerId = (int) $this->get_option('idacquirer_testing');
			$commerceId = (int) $this->get_option('idcommerce_testing');
		}else{
			$acquirerId = (int) $this->get_option('idacquirer');
			$commerceId = (int) $this->get_option('idcommerce');
		}
		
		//Transformo el total a pagar sin decimales
		$precio = $order->get_total();
		$precio = $precio;
		
		
		/****************************************
		Calculos de la ley de inclusion financiera
		******************************************/
		
		if($this->incluye_iva == 'yes'){
			//Al precio le quito el IVA
			$importe_gravado = intval($precio/(1.22));
		}else{
			$importe_gravado = $precio;
		}
		
		//Genero numero de factura de 7 digitos (Campo reserved11)
		$num_factura = (string)$order->id;
		$largo = strlen($num_factura);
		for($i=$largo; $i<7; $i++){
			$num_factura = "0".$num_factura;
		}
		
		//Se quitan caracteres especiales
		$nombre 	= trim(preg_replace('/[^\da-z ]/i', '', $order->billing_first_name));
		$apellido 	= trim(preg_replace('/[^\da-z ]/i', '', $order->billing_last_name));
		$email 		= trim(preg_replace('/[^\da-z\.\-_@]/i', '', $order->billing_email));
		$direccion 	= trim(preg_replace('/[^\da-z ]/i', '', $order->billing_address_1));
		
		$visa_args = array(
			'acquirerId'				=> 	$acquirerId,
			'commerceId'				=> 	$commerceId,
			'purchaseOperationNumber'	=>	$order->id,
			'purchaseAmount'			=>	$precio*100,
			'purchaseCurrencyCode'		=>	$this->get_option('moneda'),
			'commerceMallId'			=>	$this->get_option('commercemallid'),
			'language'					=>	'SP',
			'billingFirstName'			=>	$nombre,
			'billingLastName'			=>	$apellido,
			'billingEMail'				=>	$email,
			'billingAddress'			=>	$direccion,
			'billingZIP'				=>	$order->billing_postcode,
			'billingCity'				=>	$order->billing_city,
			'billingState'				=>	$order->billing_state,
			'billingCountry'			=>	$order->billing_country,
			'billingPhone'				=>	$order->billing_phone,
			'shippingAddress'			=>	$order->billing_address_1,
			'terminalCode'				=> 	$this->get_option('terminalcode'),
			'reserved10'				=>  '6',
			'reserved11'				=>  $num_factura,
			'reserved12'				=>  $importe_gravado*100,
		);
		
		//vector inicializacion
		return $visa_args;
		
	}
	
	/*Método que envia los datos de la compra al VPOS y retorna la respuesta*/
	function enviar_datos_VPOS($visa_args){
		
		include_once( 'vpos-plugin/vpos_plugin.php' );
		
		//Obtengo las llaves dependiendo si es ambiente de prueba o produccion
		if($this->testmode == 'yes'){
			$llavepublica = $this->get_option('llave_publica_request_testing');
			$llaveprivada  = $this->get_option('llave_privada_request_testing');
			$vi = $this->get_option('vi_testing');
		}else{
			$llavepublica = $this->get_option('llave_publica_request');
			$llaveprivada  = $this->get_option('llave_privada_request');
			$vi = $this->get_option('vi');
		}
		
		$respuesta['XMLREQ']="";
		$respuesta['DIGITALSIGN']="";
		$respuesta['SESSIONKEY']="";
		
		VPOSSend($visa_args, $respuesta, $llavepublica, $llaveprivada,$vi);
		
		return $respuesta;
	}
	
	
	
	/**
	 * Check for Cobrosya IPN Response
	 *
	 * @access public
	 * @return void
	 */
	function respuesta_visa() {
		
		include_once( 'vpos-plugin/vpos_plugin.php' );
		include_once( 'enviar_mail.php' );
		global $wpdb;
			
		//Se obtienen las llaves
		if($this->testmode == 'yes'){
			$llavepublica = $this->get_option('llave_publica_response_testing');
			$llaveprivada  = $this->get_option('llave_privada_response_testing');
			$vi = $this->get_option('vi_testing');
		}else{
			$llavepublica = $this->get_option('llave_publica_response');
			$llaveprivada  = $this->get_option('llave_privada_response');
			$vi = $this->get_option('vi');
		}
		
		//Se obtiene la respuesta de pago del VPOS
		$arrayIn['IDACQUIRER'] 	= 	$_POST['IDACQUIRER'];
		$arrayIn['IDCOMMERCE'] 	= 	$_POST['IDCOMMERCE'];
		$arrayIn['XMLRES'] 		= 	$_POST['XMLRES'];
		$arrayIn['DIGITALSIGN'] = 	$_POST['DIGITALSIGN'];
		$arrayIn['SESSIONKEY'] 	= 	$_POST['SESSIONKEY'];
		
		//Se descifran los datos enviados por el VPOS
		$arrayOut = '';
		$authresult = '';
		$respuesta = '';
		$id_pedido = '';
		
		// LOG
		if(VPOSResponse($arrayIn, $arrayOut,$llavepublica, $llaveprivada, $vi)) {
			
			$respuesta 	= json_encode($arrayOut);
			$id_pedido 	= $arrayOut['purchaseOperationNumber'];
			$authresult = $arrayOut['authorizationResult'];
			
		} else {
		
			$respuesta = 'Operación inválida';
			$authresult == 'Invalido';
		}
	
		$nombre_tabla = $wpdb->prefix . 'visarespuesta';
		$sql = "INSERT INTO $nombre_tabla (id_pedido, fecha, IDACQUIRER, IDCOMMERCE, XMLRES, DIGITALSIGN, SESSIONKEY, RESPUESTA) VALUES ('$id_pedido', NOW(),'".$arrayIn['IDACQUIRER']."','".$arrayIn['IDCOMMERCE']."', '".$arrayIn['XMLRES']."', '".$arrayIn['DIGITALSIGN']."', '".$arrayIn['SESSIONKEY']."', '$respuesta')";
		$wpdb->query($sql);
		
		//Url de redireccion 
		$pagina = get_page_by_title( 'Pago VISA cancelado' );
		$pedido = new WC_Order((int)$id_pedido);
		
		switch ($authresult) {
			case '00':
			
				$pedido->update_status('completed', "Pago completado con VISA.");
				//enviar_mail($arrayOut);
				$url = $pedido->get_checkout_order_received_url(); 
				break;
				
			case '01':
				
				$pedido->update_status('cancelled', "La transacción fue denegada por el banco emisor.");
				$url = $pagina->guid."/?status=01";
				break;
				
			case '05':
				
				if($arrayOut['errorCode'] == "2300"){
					$mensaje = "El usuario canceló la operacion al ingresar el número de tarjeta.";
				}elseif($arrayOut['errorCode'] == "2400"){
					$mensaje = "La operación no fue autorizada.";
				}else{
					$mensaje = "La operacion fue cancelada";
				}
				
				$pedido->update_status('cancelled', $mensaje);
				$url = $pagina->guid."/?status=05";
				break;
			default:
			$url = $pagina->guid."/?status=05";
				
		}
		
		wp_redirect($url);
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
