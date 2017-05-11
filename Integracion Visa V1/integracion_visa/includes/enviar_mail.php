<?php
include_once ("wp-load.php");

function enviar_mail($datos){
	
	$from = get_bloginfo('admin_email');
	$nombre_sitio = get_bloginfo('name');
	
	if($datos['purchaseCurrencyCode']="858"){
		$moneda = "UYU";
	}else{
		$moneda = "USD";
	}
	
	$monto = (int)$datos['purchaseAmount']/100;
	
	$mensaje = '<table width="550" border="0" cellpadding="1" cellspacing="0">
			<tbody>
			<tr>
				<td height="30" valign="bottom" class="TextBlue"><strong><font color="#003399">Datos de Compra</font></strong></td>
			</tr>
			<tr>
				<td bgcolor="#B6B6B6">
					<table width="100%" cellspacing="0" cellpadding="1" border="0">
						<tbody>
							<tr>
								<td width="10" valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
								<td height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><strong>Comercio:<font size="3"> </font></strong></td>
								<td valign="middle" bgcolor="#FFFFFF" class="TextBlack"><font size="2">'.$nombre_sitio.'</font></td>
							</tr>
							<tr>
								<td valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
								<td height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><strong>Nro. de orden:</strong></td>
								<td valign="middle" bgcolor="#FFFFFF" class="TextBlack">'.$datos['purchaseOperationNumber'].'</td>
							</tr>

							<tr>
								<td width="10" valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
								<td width="128" height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nombre:</strong></font></td>
								<td width="404" valign="middle" bgcolor="#FFFFFF" class="textos">
								<span class="TextBlack"><font size="2" face="Arial, Helvetica, sans-serif">'.$datos['billingFirstName'].' '.$datos['billingLastName'].'</font></span></td>
							</tr>
							<tr>
								<td valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
								<td height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><strong>Monto:</strong></td>
								<td valign="middle" bgcolor="#FFFFFF" class="TextBlack">'.$moneda.' '.$monto.'</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
					
		<table width="550" border="0" cellpadding="1" cellspacing="0">
			<tbody>
				<tr>
					<td height="30" valign="bottom" class="TextBlue"><strong><font color="#003399">Datos de Tarjeta</font></strong></td>
				</tr>
				<tr>
					<td bgcolor="#B6B6B6">
						<table width="100%" cellspacing="0" cellpadding="1" border="0">
							<tbody>
								<tr>
									<td width="10" valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
									<td width="128" height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><strong>Tipo de Tarjeta:<font size="3"> </font></strong></td>
									<td width="404" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><font size="3">Visa</font></td>
								</tr>
								<tr>
									<td valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
									<td height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><strong>Número de Tarjeta:</strong></td>
									<td valign="middle" bgcolor="#FFFFFF" class="TextBlack">485951******0036</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<table width="550" border="0" cellpadding="1" cellspacing="0">
			<tbody>
				<tr>
					<td width="373" height="30" valign="bottom" class="TextBlue"><strong><font color="#003399">Plan de Pago</font></strong></td>
				</tr>
				<tr>
					<td bgcolor="#B6B6B6">
						<table width="100%" border="0" cellpadding="1" cellspacing="0">
							<tbody>
								<tr valign="bottom">
									<td width="10" valign="middle" bgcolor="#FFFFFF" class="TextBlack">&nbsp;</td>
									<td width="128" height="20" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><strong>Cuotas:<font size="3"> </font></strong></td>
									<td width="404" valign="middle" bgcolor="#FFFFFF" class="TextBlack"><font size="3">'.$datos['quotaName'].'</font></td>
								</tr>		
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>';

	$headers[] = 'From: '.$nombre_sitio.' <'.$from.'>';
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	wp_mail($datos['billingEMail'], "Pago VISA", $mensaje, $headers);
	
}

?>