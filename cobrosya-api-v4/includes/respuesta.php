<?php
/*
* PASO 7: POST A URL DE NOTIFICACION EN CASO DE PAGO EXITOSO
*/

include('../../../../wp-load.php');
global $woocommerce;
global $wpdb;
		
//Guardo datos en la base
if (isset($_POST["id_secreto"])) {
	
	$sql = 'SELECT * FROM '. $wpdb->prefix . 'cobrosya WHERE idSecreto = "'.$_POST["id_secreto"].'"';
	$tapi = $wpdb->get_row($sql, ARRAY_A);
			
	if (!(is_null($tapi))) {
				
		$order = new WC_Order( $tapi["transaccion"]);
		
		//Caso transferencia bancaria
		if(in_array($_POST["id_medio_pago"], array('7','8','9','10','11','12'))){	
			$sql = 'UPDATE '. $wpdb->prefix . 'cobrosya SET medioPagoId = '.$_POST["id_medio_pago"].', medioPago = "'.$_POST["medio_pago"].'", fechaHoraPago = "'.$_POST["fecha_hora_pago"].'", paga = 1, cuotas_codigo='.$_POST["cuotas_codigo"].', cuotas_texto="'.$_POST["cuotas_texto"].'", autorizacion="'.$_POST["autorizacion"].'"  WHERE transaccion = "'.$tapi["transaccion"].'"';
			
		}else{
			$sql = 'UPDATE '. $wpdb->prefix . 'cobrosya SET medioPagoId = '.$_POST["id_medio_pago"].', medioPago = "'.$_POST["medio_pago"].'", fechaHoraPago = "'.$_POST["fecha_hora_pago"].'", paga = 1, autorizacion="'.$_POST["autorizacion"].'"  WHERE transaccion = "'.$tapi["transaccion"].'"';
		}
		
		$wpdb->query($sql);
		
		if(isset($_POST["cuotas_texto"])){
			$descripcion = 'El usuario pagó con '.$_POST["medio_pago"].' en '.$_POST["cuotas_texto"].'.';
		} else {
			$descripcion = 'El usuario pagó con '.$_POST["medio_pago"];
		}
		
		$order->update_status('completed', $descripcion);
		echo "1";
	}
} else {
		
}
?>