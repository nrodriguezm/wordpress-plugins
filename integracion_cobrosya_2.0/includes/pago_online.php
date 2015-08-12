<?php
/*
Redireccion a web de pago online
*/

if($_GET['sandbox'] == '1'){
	$url = 'http://api-sandbox.cobrosya.com/v4/cobrar';
} elseif($_GET['sandbox'] == '0'){
	$url = 'https://api.cobrosya.com/v4/cobrar';
} else {
	die();
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

	<form method="post" action="<?php echo $url; ?>" id="frm">

		<input type="hidden" name="nro_talon" value="<?php echo $_GET['nro_talon'];?>"/>
		<input type="hidden" name="id_medio_pago" value="<?php echo $_GET['mediopagoid'];?>"/>

		<?php if (isset($_GET['cuotas'])) { ?>
			<input type="hidden" name="cuotas" value="<?php echo $_GET['cuotas'];?>" />
		<?php } ?>

	</form>

	</body>
</html>