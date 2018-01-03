<?php
/*
Generacion del formulario POST a CobrosYa
*/

/*
* PASO 3: Armo el array $post para enviar a cobrosya
*/

$post = array();

$opciones_cobrosya = new WC_Gateway_Cobrosya();
if($opciones_cobrosya->get_option('testmode') == 'yes'){
	$sandbox = '1';
	$post['url_cobrosya'] = $opciones_cobrosya->testurl;
	$post['token'] = $opciones_cobrosya->get_option('token_sandbox');
}else{
	$sandbox = '0';
	$post['url_cobrosya'] = $opciones_cobrosya->liveurl;
	$post['token'] = $opciones_cobrosya->get_option('token_produccion');
}

$order = new WC_Order( $order_id );
$order->update_status('processing', 'Inicio transacción.');

$post['id_transaccion'] = $order->id;

$post['nombre'] = $order->billing_first_name;
$post['apellido'] = $order->billing_last_name;
$post['email'] = $order->billing_email;
$post['celular'] = $order->billing_phone;
$post['concepto'] = $opciones_cobrosya->get_option('concepto');
$post['moneda'] = $opciones_cobrosya->get_option('moneda');
$post['monto'] = $order->get_total();
$vencimiento = $opciones_cobrosya->get_option('fecha_vencimiento');
if ($vencimiento == 'yes') {
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
	$post['fecha_vencimiento'] = $fecha_vencimiento;
}

$post['url_respuesta'] = get_site_url().'/confirmacion-cobrosya/?id='.$post['id_transaccion'];
$post['consumo_final'] = 0;
$post['direccion'] = $order->billing_address_1;
$post['ciudad'] = $order->billing_city;
$post['departamento'] = $order->billing_state;
$post['pais'] = $order->billing_country;
$post['codigo_postal'] = $order->billing_postcode;
$post['telefono'] = substr($post['celular'], 2);

$cuotas = get_post_meta( $order->id, '_cuotas', true );
global $wpdb;

$query = 'INSERT INTO '. $wpdb->prefix .'cobrosya (transaccion, nombre, apellido, email, concepto, moneda, monto, fecha) VALUES ('.$post["id_transaccion"].', "'.$post["nombre"].'", "'.$post["apellido"].'", "'.$post["email"].'", "'.$post["concepto"].'", "'.$post["moneda"].'", '.$post["monto"].', "'.date("Y-m-d").'")';

$wpdb->query($query);

//Envio mensaje post
$ch = curl_init($post['url_cobrosya']);

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "");
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($post));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$res = curl_exec($ch);

curl_close($ch);

$xml = simplexml_load_string($res);


/*
* PASO 4: Si no hubo errores voy al paso 5. Sino FIN 
*/

if ($xml->error == 0) {
	$query = 'UPDATE '. $wpdb->prefix .'cobrosya SET nroTalon = '.$xml->nro_talon.', idSecreto = "'.$xml->id_secreto.'", urlPDF = "'.$xml->url_pdf.'", mediosdepago = "'.$xml->mediosdepago.'" WHERE transaccion = '.$post["id_transaccion"];
	$wpdb->query($query);
	
	/*
	* PASO 5: Medio de pago elegido dentro de la lista de medios de pago autorizados? 
	*/
	if (in_array($this->medioPago, explode(",", $xml->mediosdepago))) {
		
		/*
		* PASO 6: El medio de pago es online? (Banco o tarjetas) 
		* Si es offline (Red pagos, paganza) muestro resultados y pdf.
		* Si es online redirecciono a la web.
		*/
		
		if(in_array($this->medioPago, array(2,3,4,7,8,9,10,11,12,13))){
			//Pago online
			$redireccionar = get_site_url().'/wp-content/plugins/integracion_cobrosya/includes/pago_online.php?sandbox='.$sandbox.'&mediopagoid='.$this->medioPago.'&cuotas='.$cuotas.'&nro_talon='.$xml->nro_talon;
		} elseif(in_array($this->medioPago, array(5,6))){
			//Pago offline
			if($this->medioPago == 5){
				$mediopago = 'Paganza'; 
			} else {
				$mediopago = 'Redpagos';
			}
			
			$sql = 'UPDATE '. $wpdb->prefix . 'cobrosya SET medioPagoId = '.$this->medioPago.', medioPago = "'.$mediopago.'", paga = 0  WHERE transaccion = "'.$post["id_transaccion"].'"';
			$wpdb->query($sql);
			
			$order->update_status('on-hold', 'El usuario debe ir a '.$mediopago.' a realizar el pago.');
			
			$redireccionar = get_site_url().'/confirmacion-cobrosya/?id='.$post["id_transaccion"];
		}
		
	} else {
		//Mensaje de medio de pago fuera de servicio o no habilitado para la transaccion.
		$mensaje = "Medio de pago no habilitado";
		$query = 'UPDATE '. $wpdb->prefix .'cobrosya SET medioPagoId = '.$this->medioPago.', medioPago = "'.$mensaje.'" WHERE transaccion = '.$post["id_transaccion"];
		$wpdb->query($query);
		$redireccionar = get_site_url().'/confirmacion-cobrosya/?err=-1';
	}
}else{
	//Error en la transaccion.
	$query = 'UPDATE '. $wpdb->prefix .'cobrosya SET error = '.$xml->error.' WHERE transaccion = '.$post["id_transaccion"];
	$wpdb->query($query);
	$redireccionar = get_site_url().'/confirmacion-cobrosya/?err='.$xml->error;
}

?>