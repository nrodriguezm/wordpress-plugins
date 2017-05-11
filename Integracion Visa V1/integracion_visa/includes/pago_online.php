<?php
/*
Redireccion a web de pago online
*/
include("../../../../wp-load.php");
global $wpdb;

if(empty($_GET['id_pedido']) or $_GET['id_pedido'] == ""){ echo "error"; die();}

$order = new WC_Order( (int)$_GET['id_pedido'] );
$opciones_visa = new WC_Gateway_Visa();

$nombre_tabla = $wpdb->prefix . 'visapedidos';
$datos_pedido = $wpdb->get_row( "SELECT * FROM $nombre_tabla WHERE id_pedido =".$_GET['id_pedido'] );

if($opciones_visa->testmode == 'yes'){
	$url = $opciones_visa->testurl;
}else{
	$url = $opciones_visa->liveurl;
}

?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>API Test</title>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			$("#frm").submit();
		});
		</script>
	</head>

	<body>

	<form name="frmSolicitudPago" method="post" action="<?php echo $url; ?>" id="frm">
		<input type="hidden" name="IDACQUIRER" 	value="<?php echo $datos_pedido->IDACQUIRER;?>"/>
		<input type="hidden" name="IDCOMMERCE" 	value="<?php echo $datos_pedido->IDCOMMERCE;?>"/>
		<input type="hidden" name="XMLREQ" 		value="<?php echo $datos_pedido->XMLREQ;?>"/>
		<input type="hidden" name="DIGITALSIGN" value="<?php echo $datos_pedido->DIGITALSIGN;?>"/>
		<input type="hidden" name="SESSIONKEY" 	value="<?php echo $datos_pedido->SESSIONKEY;?>"/>
		<input type="submit" value="Enviar" id="formvisasubmit" style="display:none">

	</form>

	</body>
</html>