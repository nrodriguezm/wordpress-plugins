<?php
require_once 'autoload.inc.php';

echo "hola";

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option( 'isRemoteEnabled', TRUE );

$html = <<<EOD
 <!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Aloha!</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
		font-size: 14px;
		font-weight: bold;
		margin:5px 7px; 
		padding:0;
    }
	
	
	.logo, .fecha{
		float: left;
		display: inline-block;
	}
	
	.logo{
		width: 50%;
	}
	
	.fecha{
		width: 20%
	}
	
	.campo{
		border: solid 1px;
		height: 20px;
	}
	
	.header{
		font-size: 16px;
		display: block;
		clear: both;
		margin: 90px 40px;
	}
   
</style>

</head>
<body>
	<div class="encabezado">
		<div class="logo">
			<img src="http://www.suresis.com.uy/Images/logo_suresis.png" width="240" height="55" >
		</div>
		<div class="fecha">
			<p>Fecha de Remito</p>
			<div class="campo"></div>
		</div>
		<div class="fecha">
			<p>Nº</p>
			<div class="campo"></div>
		</div>
	</div>
	<div class="datos">
		<p class="header">Remito de Soporte Técnico</p>
	</div>
	<div class="descripcion"></div>
	<div class="observaciones"></div>
	<div class="materiales"></div>
	<div class="firmas"></div>
</body>
</html>
EOD;


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>
