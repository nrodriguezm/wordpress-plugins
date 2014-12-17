<?php

require_once('../../../../wp-load.php');
global $wpdb;
$post = array(
    "token"             => $_POST["token"],
    "id_transaccion"    => $_POST["id_transaccion"],
    "nombre"            => $_POST["nombre"],
    "apellido"          => $_POST["apellido"],
	"email"				=> $_POST["email"],
    "concepto"          => $_POST["concepto"],
    "moneda"            => $_POST["moneda"],
    "monto"             => $_POST["monto"],
    "fecha_vencimiento" => $_POST["fecha_vencimiento"],
    "url_respuesta"     => $_POST["url_respuesta"],
	"url_incorrecta"	=> $_POST["url_incorrecta"],
	"direccion"			=> $_POST["direccion"],
	"ciudad"			=> $_POST["ciudad"],
	"departamento"		=> $_POST["departamento"],
	"pais"				=> $_POST["pais"],
	"codigo_postal"		=> $_POST["codigo_postal"],
	"telefono"			=> $_POST["telefono"],
	"cuotas_oca"		=> $_POST["cuotas_oca"],
	"cuotas_master"		=> $_POST["cuotas_master"]
);

if(isset($_POST["monto_vencido"])){
	$post["monto_vencido"] = $_POST["monto_vencido"];
}

$result = $wpdb->get_results ('SELECT transaccion FROM ' . $wpdb->prefix . 'cobrosya WHERE transaccion = '.$_POST["id_transaccion"]);

if (count ($result) > 0) {
	$query = 'UPDATE '. $wpdb->prefix .'cobrosya SET nombre = "'.$_POST["nombre"].'", apellido = "'.$_POST["apellido"].'", email = "'.$_POST["email"].'", concepto = "'.$_POST["concepto"].'", moneda = '.$_POST["moneda"].', monto = '.$_POST["monto"].' WHERE transaccion = '.$_POST["id_transaccion"];
} else {
	$query = 'INSERT INTO '. $wpdb->prefix .'cobrosya (transaccion, nombre, apellido, email, concepto, moneda, monto) VALUES ('.$_POST["id_transaccion"].', "'.$_POST["nombre"].'", "'.$_POST["apellido"].'", "'.$_POST["email"].'", "'.$_POST["concepto"].'", "'.$_POST["moneda"].'", '.$_POST["monto"].')';
}

$wpdb->query($query);

$ch = curl_init($_POST['url_api']);

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

if ($xml->error == 0) {
	$query = 'UPDATE '. $wpdb->prefix .'cobrosya SET nroTalon = '.$xml->nro_talon.', idSecreto = "'.$xml->id_secreto.'", urlMostrador = "'.$xml->url_mostrador.'" WHERE transaccion = '.$_POST["id_transaccion"];
	$wpdb->query($query);
	header("Location: ".$xml->url_mostrador);
}else{
	header("Location: ".$post["url_incorrecta"]);
}?>