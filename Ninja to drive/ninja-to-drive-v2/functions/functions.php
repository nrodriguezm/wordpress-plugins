<?php
function print_forms_select($forms){
	
	if(count($forms) > 0){
		?>
		<select class="select_forms_nd">
			<option>Select form</option>
		<?php
		foreach($forms as $form){
			?><option value="<?php echo $form['id'];?>"><?php echo $form['name'];?></option><?php
		}
		?>
		</select>
		<?php
	}else{
		?>
		<h5>No forms created</h5>
		<?php
	}
	
}

function get_form_html_nd($fields, $id_form){
	$html = "";
	global $wpdb;
	$table_name = $wpdb->prefix . 'ninja_forms_drive_nd';
	$url_form = "";
	
	//Get form values
	$form_values = $wpdb->get_row("SELECT * FROM $table_name WHERE id_form = $id_form");
	
	if(!is_null($form_values)){
		$url_form = $form_values->url_form;
		$form_values = json_decode($form_values->values, true);
	}
	
	foreach ($fields as $field){
		if($field['type']!= "_submit"){
			$name = "nd-field_".$field['id'];
			$value = "";
			if(!is_null($form_values)){ $value = $form_values[$name];}
			?>
			<p>
				<label><?php echo $field['data']['label']; ?></label>
				<input type="text" name="<?php echo $name;?>" value="<?php echo $value; ?>">
			</p>
			<?php
		}
			
	}
	?>
	<label>Url form</label>
	<input type="text" name="url_form" value="<?php echo $url_form; ?>">
	<input type="hidden" name="id_form" value="<?php echo $id_form; ?>">	
	<?php
	
}

function get_form_nd_callback() {
	
	$form_id = intval( $_POST['form_id'] );
    $fields = ninja_forms_get_fields_by_form_id( $form_id );
	$html = get_form_html_nd($fields, $form_id);

	wp_die();
}

add_action( 'wp_ajax_get_form_nd', 'get_form_nd_callback' );

function save_form_values_nd($id_form){
	global $wpdb;
	$table_name = $wpdb->prefix . 'ninja_forms_drive_nd';
	
	//Generate array with new values
	$new_values = array();
	foreach($_POST as $key => $value){
		if($key != "id_form" and $key != "submit" and $key != "url_form"){
			$new_values[$key] = $value;
		}
	}
	
	$new_values = json_encode($new_values);

	//Get form values from database
	$values = $wpdb->get_row("SELECT * FROM $table_name WHERE id_form = $id_form");
	
	//If results found, then update else insert new row
	if(!is_null($values)){
		$wpdb->update($table_name, array('values' => $new_values, 'url_form' => $_POST['url_form']), array( 'id_form' => $id_form ));
	}else{
		$wpdb->insert($table_name, array('id_form' => $id_form, 'values' => $new_values, 'url_form' => $_POST['url_form'])); 
	}
}
?>
