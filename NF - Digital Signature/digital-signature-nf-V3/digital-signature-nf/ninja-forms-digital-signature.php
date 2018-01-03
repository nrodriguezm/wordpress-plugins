<?php
/*
Plugin Name: Ninja Forms Digital Signature
Plugin URI:  https://trepcom.com
Description: Add digital signature functionality to a Ninja Form
Version:     1.0
Author:      Andrés Beraldo
Author URI:  https://trepcom.com
*/


$upload = wp_upload_dir();
$upload_dir = $upload['basedir'];
$upload_dir = $upload_dir . '/ds_uploads';
define("UPLOAD_DIR", $upload_dir);
define("PLUGIN_DIR", plugin_dir_path( __FILE__ ));


include( PLUGIN_DIR . 'includes/dompdf/autoload.inc.php');
include( PLUGIN_DIR . 'includes/css_composer/css_composer.php');
include( PLUGIN_DIR . 'templates/template_post_type.php');

add_filter('ninja_forms_register_fields', 'ds_register_signature_field');
function ds_register_signature_field($fields){
        
	class DigitalSignature extends NF_Abstracts_Input{
		
		protected $_name = 'digitalsignature';
		
		protected $_section = 'userinfo';
		
		protected $_icon = 'pencil';
		
		protected $_aliases = array( 'input' );
		
		protected $_type = 'digitalsignature';
		
		protected $_templates = 'digitalsignature';
		
		public function __construct(){
			
			$this->_nicename = __( 'Digital Signature', 'ninja-forms' );
			
			add_filter('ninja_forms_field_template_file_paths', array( $this, 'add_custom_template_path' ));
			
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		 
			parent::__construct();
		}
		 
		public function add_custom_template_path($templates){
			$templates[] = PLUGIN_DIR . '/templates/';
			return $templates;
		}
		
		public function enqueue_scripts(){
			wp_enqueue_script( 'signature-pad', plugin_dir_url( __FILE__ ) . 'assets/js/signature_pad.js', array('jquery'), '1.0.0', false );
			wp_enqueue_script( 'digitalsignature', plugin_dir_url( __FILE__ ) . 'assets/js/app.js', array( 'nf-front-end', 'jquery' ), '1.0.0', false );
        }
		
	}
	
 
	$fields['digitalsignature'] = new DigitalSignature;

	return $fields;
}


add_filter( 'ninja_forms_register_actions', 'add_email_action', 10, 1 );
function add_email_action($actions){
	
	include( PLUGIN_DIR . 'includes/Actions/DsEmail.php');
	$actions['dsemail'] = new DS_Actions_Email();
	return $actions;
	
}

//Activation function
function ds_activation_hook() {
 
    if(class_exists("Ninja_Forms")){
		
		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/ds_uploads';
		if (! is_dir(UPLOAD_DIR)) {
		   mkdir( UPLOAD_DIR, 0700 );
		}
		
		apply_filters('ninja_forms_register_fields', '');
		
		//Import default form
		$data = file_get_contents( PLUGIN_DIR .'assets/default_form/default_form.nff' );
		
		$import_form = true;
		$forms = Ninja_Forms()->form()->get_forms();
		foreach ($forms as $form){
			$import_form = !($form->get_setting( 'title' ) == "Remito");
			if(!$import_form){ break;}
		}
		
		if($import_form){
			$import = Ninja_Forms()->form()->import_form( $data );
		} 
		
	}else{
	
		deactivate_plugins(  __FILE__ );
		die('<div class="error"><p>Ninja Forms is not installed or activated</p></div>');
	}
}
 
register_activation_hook( __FILE__, 'ds_activation_hook' );


?>