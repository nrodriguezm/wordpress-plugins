<?php

function add_to_spreadsheet_nd($form_data){
	
	global $wpdb;
	//global $ninja_forms_processing;
	$table_name = $wpdb->prefix . 'ninja_forms_drive_nd';
	
	//Get the fields.
	$fields =  $form_data[ 'fields' ];

	//Get form id
	$id_form =  $form_data[ 'form_id' ];
	
	
	
	//Get form values, array in which the key is the id of the field
	$form_values = $wpdb->get_row("SELECT * FROM $table_name WHERE id_form = $id_form");
	
	$google_values = json_decode($form_values->values, true);
	
	//The string request
	if( is_array( $fields ) and !is_null($form_values) ){ 
		
		$strRequest = "";
		$first = true;
		
		foreach($fields as $field){
			$id_field = $field[ 'id' ];
			$value = $field[ 'value' ];
			$exist_key = array_key_exists("nd-field_$id_field", $google_values);
			if(!is_null($value) and !empty($value) and $exist_key){
				if(!$first){
					$strRequest .="&";
				}else{
					$first = false;
				}
				
				if(is_array($value)){
					$value = implode(",", $value);
				}
				$strRequest .= $google_values["nd-field_$id_field"]."=".urlencode($value);
			}
		}
		
		//Send data to drive with curl
		$url = $form_values->url_form."/formResponse";
		
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1) ;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $strRequest);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$result = curl_exec($ch);
		$num_error = curl_errno($ch);

		curl_close($ch);
	}
	
}
add_action( 'register_submit_drive_nd', 'add_to_spreadsheet_nd' );
?>
