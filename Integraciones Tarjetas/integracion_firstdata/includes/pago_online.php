<?php
/*
Redireccion a web de pago online
*/
include("../../../../wp-load.php");
global $wpdb;

if(empty($_GET['ORDERNUMBER']) or $_GET['ORDERNUMBER'] == ""){ echo "Hubo un error al procesar el pedido"; die();}
if(empty($_GET['gateway']) or $_GET['gateway'] == ""){ echo "Hubo un error al procesar el pedido"; die();}

$order = new WC_Order((int)$_GET['ORDERNUMBER']);

switch ($_GET['gateway']) {
    case "000004":
		$gateway = new WC_Gateway_Diners();
        break;
    case "000005":
        $gateway = new WC_Gateway_Discover();
        break;
    case "000006":
		$gateway = new WC_Gateway_Lider();
        break;
	default:
		$gateway = new WC_Gateway_Master();
}


$nombre_tabla = $wpdb->prefix . 'firstdata_pedidos';

$datos_pedido = $wpdb->get_row( "SELECT * FROM $nombre_tabla WHERE ordernumber =".$_GET['ORDERNUMBER'] );


?>
<html>
<head>
<META content="text/html; charset=iso-8859-1">
<title>FirstData</title>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			$("#frm").submit();
		});
		</script>
</head>

<body bgcolor=#ffffff text=#000000 link=#333333 alink=#333333 vlink=#333333>
<font face="Arial, Helvetica, sans-serif" size="1">
<center>
<form method="post" action="http://t18.trepcom.com:8080/mbsapp-98025727/servlet/MerBuyServlet" id="frm">
<input name=MERCHANT          type=hidden value="<?php echo $gateway->fd_merchant; ?>">
<input name=CURRENCY          type=hidden value="<?php echo $gateway->fd_currency; ?>">
<input name=AMOUNTEXP10       type=hidden value="-2">
<input name=SUCCESSURL        type=hidden value="<?php echo $gateway->notify_url; ?>">
<input name=FAILUREURL        type=hidden value="<?php echo $gateway->notify_url; ?>">
<input name=CANCELURL         type=hidden value="<?php echo $gateway->notify_url; ?>&cancelado=1&ORDERNUMBER=<?php echo $_GET['ORDERNUMBER'];?>">

<p>
<h3><img src="../img/load-icon.gif"></h3>
<p>
  	<table cols=3 cellspacing=10 cellpadding=0 border=0>
  
		<tr>
			<td colspan=2><input name=ORDERNUMBER type=hidden size=4 value="<?php echo $order->id; ?>"></td>
		</tr>

		<tr>
			<td colspan=2><input name=AMOUNT type=hidden size=12 value="<?php echo $order->get_total(); ?>"></td>
		</tr>

		<tr>
			<td colspan=2><input name=INSTALLMENTS type=hidden size=2 value="<?php echo $datos_pedido->installments; ?>"></td>
		</tr>

		<tr>
			<td colspan=2><input name=EMAILTH type=hidden size=20 value="<?php echo $order->billing_email; ?>"></td>
		</tr>

		<tr>
			<td colspan=2><input name=BINCC type=hidden size=20 value="<?php echo $gateway->bincc; ?>"></td>
		</tr>

		<tr>
			<td colspan=2><input name=FINCC type=hidden size=20 value=""></td>
		</tr>

		<tr>
			<td colspan=2><input name=IFAPLICA type=hidden size=20 value="0"></td>
		</tr>

		<tr>
			<td colspan=2><input name=IFFAC type=hidden size=20 value=""></td>
		</tr>

		<tr>
			<td colspan=2><input name=IFIMP type=hidden size=20 value=""></td>
		</tr>

		<tr>
			<td colspan=2><input name=IFFIMP type=hidden size=20 value=""></td>
		</tr>
		
		<tr><td colspan=3 align=center>
			<BR>
			<BR>
			<BR>
			<input type="submit" value="  Pagar con e-Posnet  " style="display:none;">
			</td>
		</tr>
	</table>
</form>
</center>
</font>
</body>
</html>
