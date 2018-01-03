<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Pasarela Master Card
 *
 */
class WC_Gateway_Master extends WC_Payment_Gateway {

	public function __construct() {
		$this->id 					= 'first_data_master';
		$this->campo_cuotas 		= 'installments-'.$this->id;
		$this->icon 				= get_site_url().'/wp-content/plugins/integracion_firstdata/img/master.png';
		$this->has_fields			= true;
		$this->method_title 		= 'Master Card';
		$this->notify_url       	= add_query_arg( 'wc-api', 'WC_Gateway_Master', home_url( '/' ));
		$this->enabled 				= 'no';
		$this->bincc 				= '000001';
		
		
		//Se definen y se cargan las opciones del panel.
		$this->init_form_fields();
		
		//Se cargan las opciones seteadas por el usuario
		$this->title 			 		= $this->get_option('title');
		$this->description 		 		= $this->get_option('description');
		$this->fd_merchant 		 		= $this->get_option('fd_merchant');
		$this->fd_currency 		 		= $this->get_option('fd_currency');
		$this->fd_installments 		 	= $this->get_option('fd_installments');
		$this->fd_cancelurl 			= $this->get_option('fd_cancelurl');
		$this->fd_failureurl 		 	= $this->get_option('fd_failureurl');
		$this->form_submission_method 	= true;
		
		//Accion para guardar las opciones del usuario.
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_api_wc_gateway_master', array( $this, 'respuesta_firstdata' ) ); 
	}
	
	
	/**
	 * Método que define los campos del Gateway   
	 */
	function init_form_fields() {
		
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
		);
		
		$query = new WP_Query( $args );
		
		$paginas = array("-" => "Seleccionar");
		foreach ($query->posts as $pagina){
			$paginas[$pagina->ID] = $pagina->post_title;
			
		}
		
		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar Master Card', 'woocommerce' ),
							'default' => 'no'
						),
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Master Card', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'description' => array(
							'title' => __( 'Description', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Puede pagar con una tarjeta de crédito Master Card con total seguridad.', 'woocommerce' )
						),
			'fd_merchant' => array(
							'title' => __( 'Número de comercio', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'Identificador MERCHANT enviado por firstdata con la integracion', 'woocommerce' ),
							'default' => __( '', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'fd_currency' => array(
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
						
			'fd_installments' => array(
							'title' => __( 'Cuotas', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Habilitar Cuotas?', 'woocommerce' ),
							'default' => 'no'
						),
						
			'fd_ifaplica' => array(
							'title' => __( 'Aplica descuento (6-Aplica-Ley 19210 / 1-Aplica-Ley 17934 / 0-No Aplica):', 'woocommerce' ),
							'type' => 'select',
							'options' => array(
										'0' => __( 'No aplica', 'cmb' ),
										'1'   => __( 'Aplica ley 17.934', 'cmb' ),
										'6'   => __( 'Aplica ley 19.210', 'cmb' ),
									), 
							'description' => __( 'Campo incorporado al manejo de la Inclusión financiera Ley 19.210', 'woocommerce' ),
							'default' => __( '0', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'fd_cancelurl' => array(
							'title' => __( 'Página de cancelacion', 'woocommerce' ),
							'type' => 'select',
							'options' => $paginas,
							'description' => __( 'Url de la página de cancelación', 'woocommerce' ),
							'default' => __( '-', 'woocommerce' ),
							'desc_tip'      => true,
			),
			
			'fd_failureurl' => array(
							'title' => __( 'Página de error', 'woocommerce' ),
							'type' => 'select',
							'options' => $paginas,
							'description' => __( 'Url de la página de rechazo', 'woocommerce' ),
							'default' => __( '-', 'woocommerce' ),
							'desc_tip'      => true,
			),
		);
	}
	
	public function payment_fields(){
		
		$campo_cuotas = $this->campo_cuotas;
		
		if($this->fd_installments == "yes"){
			echo "<label>Cantidad de cuotas</label><select name='$campo_cuotas'><option value=''>Seleccionar</option><option value='01'>Contado</option><option value='02'>2 cuotas</option><option value='03'>3 cuotas</option></select><br><br>";
		}else{
			echo "<input type='hidden' name='$campo_cuotas' value='01'>";
		}
		
		echo $this->description;
	}
	
	/**
	 * Método que procesa el pago y retorna el resultado
	 */
	function process_payment( $order_id ) {
		global $wpdb;
		
		$order = new WC_Order( $order_id );
		$order->update_status('processing', 'El usuario inició la compra con Master Card.');
		
		$nombre_tabla = $wpdb->prefix . 'firstdata_pedidos';
		
		$campo_cuotas = $this->campo_cuotas;
		$installments = $_POST["$campo_cuotas"];
		
		//Registro del pedido
		$wpdb->query("INSERT INTO $nombre_tabla (ordernumber, fecha, nombre, apellido, direccion, telefono, ciudad, pais, email, amount, installments, merchant, currency, bincc, fincc, ifaplica, iffac, ifimp, iffimp) VALUES ('{$order->id}', NOW(), '{$order->billing_first_name}', '{$order->billing_last_name}', '{$order->billing_address_1}', '{$order->billing_phone}', '{$order->billing_city}', '{$order->billing_country}', '{$order->billing_email}', '{$order->get_total()}', '$installments', '{$this->get_option('fd_merchant')}', '{$this->get_option('fd_currency')}', '{$this->bincc}', '', '{$this->get_option('fd_ifaplica')}', '', '', '')");                           
		$idpedido = $wpdb->insert_id;
		
		
		$redireccionar = get_site_url().'/wp-content/plugins/integracion_firstdata/includes/pago_online.php?ORDERNUMBER='.$order_id.'&gateway='.$this->bincc;

		return array(
			'result'   => 'success',
			'redirect' => $redireccionar
		);
	}
	
	public function validate_fields(){
		
		if($this->fd_installments == "yes"){
			$campo_cuotas = $this->campo_cuotas;
			
			if($_POST["$campo_cuotas"] ==""){
				wc_add_notice("Seleccione la cantidad de cuotas", "error");
				return false;
			}
		}
		
		return true;
	
	}
	
	/**
	 * Procesar Respuesta
	 *
	 * @access public
	 * @return void
	 */
	function respuesta_firstdata() {
	
		global $wpdb;
		
		//Por defecto la url de retorno es la de fallido
		$url_retorno = get_permalink((int)$this->fd_failureurl);
		
		//Pago cancelado
		if(isset($_GET['cancelado'])){
			
			$ordernumber = $_GET['ORDERNUMBER'];
			$pedido = new WC_Order((int)$ordernumber);
			
			if($pedido->get_status() == "processing"){
				
				$responsetext = "Cancelado";
			
				//Inserto en BD la respuesta
				$nombre_tabla = $wpdb->prefix . 'firstdata_respuesta';
				$sql = "INSERT INTO $nombre_tabla (ordernumber, fecha, responsetext ) VALUES ('$ordernumber', NOW(), '$responsetext')";
				$wpdb->query($sql);
				
				//Actualizo estado del pedido a cancelado
				$pedido->update_status('cancelled', "El pago ha sido cancelado.");
				
				//Retorno a la pagina de cancelacion
				$url_retorno = get_permalink((int)$this->fd_cancelurl);
			
			}
		}else{
			
			//Se obtiene la respuesta de pago de firstdata
			$ordernumber 	= $_GET['ORDERNUMBER'];
			$merchant 		= $_GET['MERCHANT'];
			$approvalcode	= $_GET['APPROVALCODE'];
			$amount 		= $_GET['AMOUNT'];
			$currency 		= $_GET['CURRENCY'];
			$responsecode 	= $_GET['ResponseCode'];
			$responsetext 	= $_GET['ResponseText'];
			$iftiptar 		= $_GET['IFTIPTAR'];
			$ifaplicaley 	= $_GET['IFAPLICALEY'];
			$ifdecreto 		= $_GET['IFDECRETO'];
			$ifimpiva 		= $_GET['IFIMPIVA'];
			$signeddata1 	= $_GET['SignedData1'];
			$signeddata2 	= $_GET['SignedData2'];
			
			$pedido = new WC_Order((int)$ordernumber);
			
			$nombre_tabla = $wpdb->prefix . 'firstdata_respuesta';
			$sql = "INSERT INTO $nombre_tabla (ordernumber, fecha, merchant, approvalcode, ammount, currency, responsecode, responsetext, iftiptar, ifaplicaley, ifdecreto, ifimpiva, signeddata1, signeddata2 ) VALUES ('$ordernumber', NOW(),'$merchant','$approvalcode', '$amount', '$currency', '$responsecode', '$responsetext', '$iftiptar', '$ifaplicaley', '$ifdecreto', '$ifimpiva', '$signeddata1', '$signeddata2')";
			$wpdb->query($sql);
			
			//Pago completado con exito
			if($responsecode == "0"){
				$pedido->update_status('completed', "Pago completado con exito.");
				$url_retorno = $pedido->get_checkout_order_received_url();
			}else{
				$pedido->update_status('failed', "El pago ha sido rechazado por firstdata");
			}
		}
		
		wp_redirect($url_retorno);
	
	}

}
