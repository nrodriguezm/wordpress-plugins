<?php

add_action( 'ninja_forms_process', 'add_to_spreadsheet' );
function add_to_spreadsheet(){

	global $ninja_forms_processing;
	global $wpdb;
	
	//Get form id
	$form_id = $ninja_forms_processing->get_form_ID();
	
	//Get google options
	$data_exists = $wpdb->get_row("SELECT * FROM ".NINJA_FORMS_GOOGLE_TABLE_NAME." WHERE form_id = $form_id");
	
	if(isset($data_exists)){
		//Get data
		$data = json_decode($data_exists->settings);
		
		//If drive is enabled then insert values into spreadsheet
		if($data->enable_drive == "1"){
			//Obtain all the form values in an array
			$fields_values = $ninja_forms_processing->get_all_fields();
			
			$strRequest ="";
			$length = count((array)$data->fields);
		
			$i=1;
			foreach ($data->fields as $field_id => $value) {
				if(!empty($value)){
					$val = urlencode($fields_values[$field_id]);
					$strRequest .= $value."=".$val;
					if($i < $length){
						$strRequest .= "&";
					}
				}
				$i++;
			}
			
			$url = $data->url_drive."/formResponse";
		
			$ch=curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1) ;
			curl_setopt($ch, CURLOPT_POSTFIELDS, $strRequest);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$result = curl_exec($ch);
			$num_error = curl_errno($ch);
			$type_error = strpos($result,'Moved Temporarily');
			if($type_error !== false) {
				$num_error = 1;
			}
		
			//Si falló envio mail
			if($num_error != 0 ){
				
				$site_name = get_bloginfo();			
				$subject = '['.$site_name.'] Error in registering submission in drive';
				$email_message = '<html><body style="font-size:13px;font-family:Verdana, Arial;"><span>Error in registering submission in drive.<br>';
				switch ($num_error) {
					case 6:
						$email_message .= 'Error with google form Url. The Url specified is: <br>'.$url;
						break;
					case 1:
						$email_message .= 'The error could be that "Allow only one answer per person (login required)" options is checked.';
						break;
				}
				$email_message .= '</span></body> </html>';
				
				wp_mail( $data->email_notify_error, $subject, $email_message, array('Content-Type: text/html; charset=UTF-8'));
			}
		
			curl_close($ch);
		}
			
	}
}