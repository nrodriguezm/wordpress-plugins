<?php
function ninja_forms_register_tab_google_drive(){
	$all_forms_link = esc_url(remove_query_arg(array('form_id', 'tab')));
	$args = array(
		'name' => __( 'Google Drive', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'display_function' => 'ninja_forms_display_google_drive',
		'save_function' => 'ninja_forms_save_google_drive_settings',
		'tab_reload' => true,
		//'title' => '<h2>Forms <a href="'.$all_forms_link.'" class="add-new-h2">'.__('View All Forms', 'ninja-forms').'</a></h2>',
	);
	ninja_forms_register_tab('google_drive', $args);
}

add_action( 'admin_init', 'ninja_forms_register_tab_google_drive' );

function ninja_forms_display_google_drive($form_id, $data){
	//Silence is golden
}

function ninja_forms_register_google_drive_settings_basic_metabox(){

	global $wpdb;
	
	if( isset( $_REQUEST['form_id'] ) ){
		$form_id = absint( $_REQUEST['form_id'] );
		$form_row = ninja_forms_get_form_by_id( $form_id );
		$form_data = $form_row['data'];
	}else{
		$form_id = '';
		$form_row = '';
		$form_data = '';
	}

	$all_fields = ninja_forms_get_fields_by_form_id($form_id);

	//Get field values
	$data_exists = $wpdb->get_row("SELECT * FROM wp_ninja_forms_drive WHERE form_id = $form_id");
	
	if(isset($data_exists)){
		$data = $data_exists->settings;
		$data = json_decode($data);
	}
	
	$settings = array(	
		array(
				'name' => 'enable_drive',
				'type' => 'checkbox',
				'desc' => '',
				'label' => __( 'Enable Google drive submition', 'ninja-forms' ),
				'display_function' => '',
				'help' => '',
				'default_value' => $data->enable_drive,
			),
		array(
			'name' => 'url_drive',
			'type' => 'text',
			'label' => __( 'Url form drive', 'ninja-forms' ),
			'desc' => __( 'Url of google form. Format: https://docs.google.com/forms/d/xxxxxxxxxx', 'ninja-forms' ),
			'default_value' => $data->url_drive,
		),
		array(
			'name' => 'fields',
			'type' => 'title',
			'label' => __( '<label style="font-size:15px;">Fields ID</label>', 'ninja-forms' ),
		),
	);
	foreach ($all_fields as $one_field){
		if ($one_field["type"] <> "_submit"){
			$label = $one_field['data']['label'];
			$name = preg_replace('/\s+/', '_', strtolower($label));
			$values = $data->fields;
			$field = array(
				'name' => $name,
				'type' => 'text',
				'label' => __( $label, 'ninja-forms' ),
				'default_value' => $data->fields->{$one_field["id"]},
			);
			array_push($settings, $field);
		}
	}
	
	array_push($settings, 
		array(
			'name' => 'fields_entry',
			'type' => 'title',
			'label' => __( '<label style="font-size:15px;">Error options</label>', 'ninja-forms' ),
		),
		array(
			'name' => 'email_notify_error',
			'type' => 'text',
			'label' => __( 'Email', 'ninja-forms' ),
			'desc' => __( 'Enter an email address to report errors', 'ninja-forms' ),
			'default_value' => $data->email_notify_error,
		)
	);
	$args = apply_filters( 'ninja_forms_google_drive_basic', array(
		'page' => 'ninja-forms',
		'tab' => 'google_drive',
		'slug' => 'basic_settings',
		'title' => __( 'Register form to Google spreadsheet settings', 'ninja-forms' ),
		'state' => 'closed',
		'settings' => $settings,
	));
	ninja_forms_register_tab_metabox($args);
}

add_action( 'admin_init', 'ninja_forms_register_google_drive_settings_basic_metabox' );

function ninja_forms_save_google_drive_settings( $form_id, $data ){
	global $wpdb, $ninja_forms_admin_update_message;
	$form_row = ninja_forms_get_form_by_id( $form_id );
	$form_data = $form_row['data'];
	
	$data_exists = $wpdb->get_row("SELECT * FROM ".NINJA_FORMS_GOOGLE_TABLE_NAME." WHERE form_id = $form_id");
	
	$settings = array();
	$settings["enable_drive"] = $data["enable_drive"]; 
	$settings["url_drive"] = $data["url_drive"]; 
	$settings["fields"] = array();
		
	$all_fields = ninja_forms_get_fields_by_form_id($form_id);
	foreach ($all_fields as $one_field){
		if ($one_field["type"] <> "_submit"){
			$label = $one_field['data']['label'];
			$name = preg_replace('/\s+/', '_', strtolower($label));
			$settings["fields"][$one_field["id"]] = $data[$name];
		}
	}
		
	$settings["email_notify_error"] = $data["email_notify_error"];
	$settings = json_encode($settings);
	
	$data_array = array( 'form_id' => $form_id, 'settings' => $settings );
	
	if(!isset($data_exists)){
		//Insert new row
		$wpdb->insert( NINJA_FORMS_GOOGLE_TABLE_NAME, $data_array );
	}else{
		//Update row
		$wpdb->update( NINJA_FORMS_GOOGLE_TABLE_NAME, $data_array, array('form_id' => $form_id) );
	}
	
	$update_msg = __( 'Google Drive Settings Saved', 'ninja-forms' );
	return $update_msg;
}
