<?php 
function default_template ($args){ 
	
	$fields = $args['fields'];
	$logo	= $args['logo'];
	
	ob_start();
	?>
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
				

				.campo{
					border: solid 1px;
					height: 20px;
					padding-left: 5px; 
					font-family: Verdana, Arial, sans-serif;
					font-size: 14px;
					font-weight: normal;
				}
				
				.header{
					font-size: 16px;
					padding-bottom: 15px;
				}
				
				tr{
					padding: 0px;
				}
				
				.descripcion td{
					width: 700px;
					height: 100px;
					border: 1px solid black !important;
				}
				
				.header_descripcion{
					font-family: Verdana, Arial, sans-serif;
					font-size: 14px;
					font-weight: normal;
				}
				
				.tabla_descripcion td{
					padding: 10px;
					font-family: Verdana, Arial, sans-serif;
					font-size: 14px;
					font-weight: normal;
					width: 704px
				}
				
				.tabla_piezas{
					border: solid 1px;
				}
				.tabla_piezas td {
					font-family: Verdana, Arial, sans-serif;
					font-size: 14px;
					font-weight: normal;
				}
				
				.tabla_piezas .head td{
					font-weight: bold;
				}
				.tabla_piezas, .tabla_piezas tr, .tabla_piezas td{
					border: solid 1px;
					border-collapse: collapse;
					
				}
				
				.tabla_piezas td{
					padding: 5px 10px 5px 10px
				}
				
				.tabla_piezas .pieza{
					width: 230px;
				}
				
				.tabla_piezas .descripcion{
					width: 310px;
					text-align: center;
				}
				
				.tabla_piezas .cant, .tabla_piezas .fact{
					width: 50px;
				}
				
				.tabla_piezas .none{
					border: none; 
				}
				
				.tabla_piezas div{
					height: 8px;
				}
				
				.tabla_firmas{
					margin-top: 30px;
				}
				
				.tabla_firmas .col{
					width: 110px;
				}
				
				.tabla_firmas .firma{
					width: 200px;
					border-top: solid;
					text-align: center;
				}
				
				.tabla_firmas .foto_firma{
					text-align: center;
					font-family: Verdana, Arial, sans-serif;
					font-size: 14px;
					font-weight: normal;
				}
			
		</style>

		</head>
	<body>
		<table>
			<tr>
				<td width="280"> <img src="<?php echo $logo; ?>" width="240" height="55" ></td>
				<td width="120">
					<p>Fecha de Remito</p>
					<div class="campo"><?php if($fields['fecha_de_remito_1496408260630'] != ""){echo $fields['fecha_de_remito_1496408260630'];} ?></div>
				</td>
				<td width="120">
					<p>Nº</p>
					<div class="campo"><?php if($fields['no_1496408280986'] != ""){echo $fields['no_1496408280986'];} ?></div>
				</td>
			</tr>
		</table>

		<table cellspacing="0">
			<tr><td class="header" colspan="4">Remito de soporte Técnico<td></tr>
			<tr>
				<td >Cliente:</td>
				<td width="230"><div class="campo"><?php if($fields['cliente_1496414042449'] != ""){echo $fields['cliente_1496414042449'];} ?></div></td>
				<td style="padding-left: 30px;">Fecha y Hora de inicio:</td>
				<td width="100"><div class="campo"><?php if($fields['fecha_y_hora_de_inicio_1496409215028'] != ""){echo $fields['fecha_y_hora_de_inicio_1496409215028'];} ?></div></td>
			</tr>
			<tr>
				<td >Dirección:</td>
				<td width="230"><div class="campo"><?php if($fields['empresa_1496408300418'] != ""){echo $fields['empresa_1496408300418'];} ?></div></td>
				<td style="padding-left: 30px;">Fecha y Hora de fin:</td>
				<td width="100"><div class="campo"><?php if($fields['fecha_y_hora_de_fin_1496409225067'] != ""){ echo $fields['fecha_y_hora_de_fin_1496409225067'];} ?></div></td>
			</tr>
			<tr>
				<td >Email:</td>
				<td width="230"><div class="campo"><?php if($fields['direccion_1496408310609'] != ""){echo $fields['direccion_1496408310609'];} ?></div></td>
				<td style="padding-left: 30px;">Horas totales:</td>
				<td width="100"><div class="campo"><?php if($fields['horas_totales_1496409233552'] != ""){echo $fields['horas_totales_1496409233552'];} ?></div></td>
			</tr>
			<tr>
				<td >Departamento:</td>
				<td width="230"><div class="campo"><?php if($fields['departamento_1496408590047'] != ""){echo $fields['departamento_1496408590047'];} ?></div></td>
				<td style="padding-left: 30px;">Tipo de trabajo:</td>
				<td width="100"><div class="campo"><?php if($fields['tipo_de_trabajo_1496409242014'] != ""){echo $fields['tipo_de_trabajo_1496409242014'];} ?></div></td>
			</tr>
			<tr>
				<td >Teléfono:</td>
				<td width="230"><div class="campo"><?php if($fields['telefono_1496408341690'] != ""){echo $fields['telefono_1496408341690'];} ?></div></td>
				<td style="padding-left: 30px;"><td>
				<td width="100"></td>
			</tr>
		</table>
		
		<table class="tabla_descripcion">
			<tr><td class="header_descripcion">Descripción del trabajo:<td></tr>
			<tr class="descripcion"><td valign="top"><?php if($fields['descripcion_del_trabajo_1496409270160'] != ""){ echo $fields['descripcion_del_trabajo_1496409270160'];}?></td></tr>
		</table>
		<table class="tabla_descripcion">
			<tr><td class="header_descripcion">Observaciones:<td></tr>
			<tr class="descripcion"><td valign="top"><?php if($fields['observaciones_1496409312918'] != ""){ echo $fields['observaciones_1496409312918'];}?></td></tr>
		</table>
		<table class="tabla_piezas">
			<tr class="head none">
				<td colspan="4" class="descripcion none">Materiales</td>
			</tr>
			<tr class="head">
				<td class="pieza">Pieza</td>
				<td class="descripcion">Descripción</td>
				<td class="cant">Cant.</td>
				<td class="fact">Fact.</td>
			</tr>
			<tr>
				<td class="pieza"><div><?php if($fields['pieza_1_1496409355509'] != ""){echo $fields['pieza_1_1496409355509'];} ?></div></td>
				<td class="descripcion"><div><?php if($fields['descripcion_1_1496409362475'] != ""){echo $fields['descripcion_1_1496409362475'];} ?></div></td>
				<td class="cant"><div><?php if($fields['cant_1_1496409368568'] != ""){echo $fields['cant_1_1496409368568'];} ?></div></td>
				<td class="fact"><div><?php if($fields['fact_1_1496673144782'] != ""){echo $fields['fact_1_1496673144782'];}?></div></td>
			</tr>
			<tr>
				<td class="pieza"><div><?php if($fields['pieza_2_1496672844440'] != ""){echo $fields['pieza_2_1496672844440'];} ?></div></td>
				<td class="descripcion"><div><?php if($fields['descripcion_2_1496673005621'] != ""){echo $fields['descripcion_2_1496673005621'];} ?></div></td>
				<td class="cant"><div><?php if($fields['cant_2_1496673039339'] != ""){echo $fields['cant_2_1496673039339'];} ?></div></td>
				<td class="fact"><div><?php if($fields['fact_2_1496673142780'] != ""){echo $fields['fact_2_1496673142780'];}?></div></td>
			</tr>
			<tr>
				<td class="pieza"><div><?php if($fields['pieza_3_1496672838228'] != ""){echo $fields['pieza_3_1496672838228'];} ?></div></td>
				<td class="descripcion"><div><?php if($fields['descripcion_3_1496673008152'] != ""){echo $fields['descripcion_3_1496673008152'];} ?></div></td>
				<td class="cant"><div><?php if($fields['cant_3_1496673041176'] != ""){echo $fields['cant_3_1496673041176'];} ?></div></td>
				<td class="fact"><div><?php if($fields['fact_3_1496673138570'] != ""){echo $fields['fact_3_1496673138570'];}?></div></td>
			</tr>
			<tr>
				<td class="pieza"><div><?php if($fields['pieza_4_1496672852890'] != ""){echo $fields['pieza_4_1496672852890'];} ?></div></td>
				<td class="descripcion"><div><?php if($fields['descripcion_4_1496673010144'] != ""){echo $fields['descripcion_4_1496673010144'];} ?></div></td>
				<td class="cant"><div><?php if($fields['cant_4_1496673042713'] != ""){echo $fields['cant_4_1496673042713'];} ?></div></td>
				<td class="fact"><div><?php if($fields['fact_4_1496409382034'] != ""){echo $fields['fact_4_1496409382034'];}?></div></td>
			</tr>
			<tr>
				<td class="pieza"><div><?php if($fields['pieza_5_1496672855537'] != ""){echo $fields['pieza_5_1496672855537'];} ?></div></td>
				<td class="descripcion"><div><?php if($fields['descripcion_5_1496673013835'] != ""){echo $fields['descripcion_5_1496673013835'];} ?></div></td>
				<td class="cant"><div><?php if($fields['cant_5_1496673044260'] != ""){echo $fields['cant_5_1496673044260'];} ?></div></td>
				<td class="fact"><div><?php if($fields['fact_5_1496673133757'] != ""){echo $fields['fact_5_1496673133757'];}?></div></td>
			</tr>
			<tr>
				<td class="pieza"><div><?php if($fields['pieza_6_1496672857742'] != ""){echo $fields['pieza_6_1496672857742'];} ?></div></td>
				<td class="descripcion"><div><?php if($fields['descripcion_6_1496673016170'] != ""){echo $fields['descripcion_6_1496673016170'];} ?></div></td>
				<td class="cant"><div><?php if($fields['cant_6_1496673046000'] != ""){echo $fields['cant_6_1496673046000'];} ?></div></td>
				<td class="fact"><div><?php if($fields['fact_6_1496673147216'] != ""){echo $fields['fact_6_1496673147216'];}?></div></td>
			</tr>
		</table>
		<table class="tabla_firmas">
			<tr>
				<td class="col"> </td>
				<td class="foto_firma"><img width="200" height="50" src="<?php if($fields['firma_cliente_1506452139350'] != ""){echo $fields['firma_cliente_1506452139350'];}?>" ></td>
				<td class="col"> </td>
				<td class="foto_firma"><img width="200" height="50" src="<?php if($fields['firma_tecnico_1506452111056'] != ""){echo $fields['firma_tecnico_1506452111056'];}?>" ></td>
				<td class="col"> </td>
			</tr>
			<tr>
				<td class="col"> </td>
				<td class="firma">Firma Cliente</td>
				<td class="col"> </td>
				<td class="firma">Firma Técnico</td>
				<td class="col"> </td>
			</tr>
		</table>
		<table class="tabla_firmas">
			<tr>
				<td class="col"> </td>
				<td class="foto_firma"><?php if($fields['aclaracion_1496409435009'] != ""){echo $fields['aclaracion_1496409435009'];}?></td>
				<td class="col"> </td>
				<td class="foto_firma"><?php if($fields['aclaracion_1496409483359'] != ""){echo $fields['aclaracion_1496409483359'];}?></td>
				<td class="col"> </td>
			</tr>
			<tr>
				<td class="col"> </td>
				<td class="firma">Aclaración</td>
				<td class="col"> </td>
				<td class="firma">Aclaración</td>
				<td class="col"> </td>
			</tr>
		</table>
		
	</body>
	</html>
	<?php
	return ob_get_clean();
}

add_filter("ds_register_template_default", "default_template");