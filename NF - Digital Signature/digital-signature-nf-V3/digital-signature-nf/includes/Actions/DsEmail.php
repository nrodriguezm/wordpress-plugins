<?php if ( ! defined( 'ABSPATH' ) ) exit;
use Dompdf\Dompdf;
/**
 * Class NF_Action_Email
 */
final class DS_Actions_Email extends NF_Abstracts_Action
{
    /**
    * @var string
    */
    protected $_name  = 'dsemail';

    /**
    * @var array
    */
    protected $_tags = array();

    /**
    * @var string
    */
    protected $_timing = 'late';

    /**
    * @var int
    */
    protected $_priority = 10;
	
	
	protected $form_values = array();
	
	protected $field_values;

    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Digital Signature Email', 'ninja-forms' );

        $settings = include( PLUGIN_DIR . 'includes/Config/DsActionEmailSettings.php');

        $this->_settings = array_merge( $this->_settings, $settings );

        $this->_backwards_compatibility();
    }

    /*
    * PUBLIC METHODS
    */

    public function process( $action_settings, $form_id, $data )
    {
        $errors = $this->check_for_errors( $action_settings );
		
        $headers = $this->_get_headers( $action_settings );
        
        if ( has_filter( 'ninja_forms_get_fields_sorted' ) ) {
            $fields_by_key = array();
            foreach( $data[ 'fields' ] as $field ){
                if( is_null( $field ) ) continue;
                if( is_array( $field ) ){
                    if( ! isset( $field[ 'key' ] ) ) continue;
                    $key = $field[ 'key' ];
                } else {
                    $key = $field->get_setting('key');
                }
                $fields_by_key[ $key ] = $field;
            }
			
			
            $data[ 'fields' ] = apply_filters( 'ninja_forms_get_fields_sorted', array(), $data[ 'fields' ], $fields_by_key, $form_id );
			
	   }
		
        $attachments = $this->_get_attachments( $action_settings, $data, $form_id );

        if( 'html' == $action_settings[ 'email_format' ] ) {
            $message = $action_settings['email_message'];
        } else {
            $message = $this->format_plain_text_message( $action_settings[ 'email_message_plain' ] );
        }

        $message = apply_filters( 'ninja_forms_action_email_message', $message, $data, $action_settings );

        try {
            $sent = wp_mail($action_settings['to'], $action_settings['email_subject'], $message, $headers, $attachments);
        } catch ( Exception $e ){
            $sent = false;
            $errors[ 'email_sent' ] = $e->getMessage();
        }

        $data[ 'actions' ][ 'email' ][ 'to' ] = $action_settings['to'];
        $data[ 'actions' ][ 'email' ][ 'sent' ] = $sent;
        $data[ 'actions' ][ 'email' ][ 'headers' ] = $headers;
        $data[ 'actions' ][ 'email' ][ 'attachments' ] = $attachments;

        if( $errors ){
            $data[ 'errors' ][ 'form' ] = $errors;
        }
        
		
        return $data;
    }

    protected function check_for_errors( $action_settings )
    {
        $errors = array();

        $email_address_settings = array( 'to', 'from_address', 'reply_to', 'cc', 'bcc' );

        foreach( $email_address_settings as $setting ){
            if( ! isset( $action_settings[ $setting ] ) ) continue;
            if( ! $action_settings[ $setting ] ) continue;


            $email_addresses = is_array( $action_settings[ $setting ] ) ? $action_settings[ $setting ] : explode( ',', $action_settings[ $setting ] );
            foreach( (array) $email_addresses as $email ){
                $email = trim( $email );
                if ( false !== strpos( $email, '<' ) && false !== strpos( $email, '>' ) ) {
                    preg_match('/(?<=<).*?(?=>)/', $email, $email);
                    $email = $email[ 0 ];
                }
                if( ! is_email( $email ) ) {
                    $errors[ 'email_' . $email ] = sprintf( __( 'Your email action "%s" has an invalid value for the "%s" setting. Please check this setting and try again.', 'ninja-forms'), $action_settings[ 'label' ], $setting );
                }
            }
        }

        return $errors;
    }

    private function _get_headers( $settings )
    {
        $headers = array();

        $headers[] = 'Content-Type: text/' . $settings[ 'email_format' ];
        $headers[] = 'charset=UTF-8';

        $headers[] = $this->_format_from( $settings );

        $headers = array_merge( $headers, $this->_format_recipients( $settings ) );

        return $headers;
    }

    private function _get_attachments( $settings, $data, $form_id )
    {
        $attachments = array();
		
		//Process submitions fields
		$this->_process_submition_fields($data[ 'fields' ]);
		
		//Create PDF
		$attachments[] = $this->_create_pdf( $data, $settings, $form_id );
        

        if( ! isset( $settings[ 'id' ] ) ) $settings[ 'id' ] = '';

        $attachments = apply_filters( 'ninja_forms_action_email_attachments', $attachments, $data, $settings );

        return $attachments;
    }

    private function _format_from( $settings )
    {
        $from_name = get_bloginfo( 'name', 'raw' );
        $from_name = apply_filters( 'ninja_forms_action_email_from_name', $from_name );
        $from_name = ( $settings[ 'from_name' ] ) ? $settings[ 'from_name' ] : $from_name;

        $from_address = get_bloginfo( 'admin_email' );
        $from_address = apply_filters( 'ninja_forms_action_email_from_address', $from_address );
        $from_address = ( $settings[ 'from_address' ] ) ? $settings[ 'from_address' ] : $from_address;

        return $this->_format_recipient( 'from', $from_address, $from_name );
    }

    private function _format_recipients( $settings )
    {
        $headers = array();

        $recipient_settings = array(
            'Cc' => $settings[ 'cc' ],
            'Bcc' => $settings[ 'bcc' ],
            'Reply-to' => $settings[ 'reply_to' ],
        );

        foreach( $recipient_settings as $type => $emails ){

            $emails = explode( ',', $emails );

            foreach( $emails as $email ) {

                if( ! $email ) continue;

                $matches = array();
                if (preg_match('/^"?(?<name>[^<"]+)"? <(?<email>[^>]+)>$/', $email, $matches)) {
                    $headers[] = $this->_format_recipient($type, $matches['email'], $matches['name']);
                } else {
                    $headers[] = $this->_format_recipient($type, $email);
                }
            }
        }

        return $headers;
    }

	
    private function _format_recipient( $type, $email, $name = '' )
    {
        $type = ucfirst( $type );

        if( ! $name ) $name = $email;

        $recipient = "$type: $name <$email>";

        return $recipient;
    }

	
    /*
     * Backwards Compatibility
     */
    private function _backwards_compatibility(){
        add_filter( 'ninja_forms_action_email_attachments', array( $this, 'ninja_forms_action_email_attachments' ), 10, 3 );
    }

    public function ninja_forms_action_email_attachments( $attachments, $form_data, $action_settings )
    {
        return apply_filters( 'nf_email_notification_attachments', $attachments, $action_settings[ 'id' ] );
    }

    private function format_plain_text_message( $message )
    {
        $message =  str_replace( array( '<table>', '</table>', '<tr><td>', '' ), '', $message );
        $message =  str_replace( '</td><td>', ' ', $message );
        $message =  str_replace( '</td></tr>', "\r\n", $message );
        return strip_tags( $message );
    }
	
	private function _create_pdf($data, $settings, $form_id){
		
		//The string request
		if(is_array( $data )){ 
			
			$file_path = $this->_generate_pdf_file($data, $settings, $form_id);
			
		}
		
		return $file_path;
	}
	
	private function _generate_pdf_file($data, $settings, $form_id){ 
		
		include_once(PLUGIN_DIR . "templates/pdf_templates/ds_template.php");
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->set_option( 'isRemoteEnabled', TRUE );
		$dompdf->set_option('isHtml5ParserEnabled', true);
		
		$field_values = array();
		
		foreach($data["fields"] as $field){
			$field_values[$field['key']] = $field['value'];
		}
		
		$this->field_values = $field_values;
		
		add_shortcode( "ds_field", array($this, "field_shortcode"));
		
		$args['fields'] = $field_values;
		$args['id_template'] = $settings['ds_pdf_template'];
		
		$args['autoincrement'] = $settings['ds_autoincrement'];
		$args['settings'] = $data; 
		
		$html = apply_filters( "ds_register_template", $args );
	
		$dompdf->loadHtml($html);

		//Setup the paper size and orientation
		$dompdf->setPaper('A4');

		//Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$file = $dompdf->output();
		
		$datetime = strtotime("now");
		$pdf_name = "digital_signature_nuevo_$datetime.pdf";
		
		file_put_contents(UPLOAD_DIR . "/$pdf_name", $file);
		
		return UPLOAD_DIR . "/$pdf_name"; 
	
	}
	
	private function _process_submition_fields($fields){
		$datetime = strtotime("now"); 
		
		foreach($fields as $field){
			
			//Create image if is digitalsignature field
			if($field['settings']['type'] == "digitalsignature"){
				
				$image_name = $field['settings']['id']."_".$datetime.".png";
				
				//Create url to image
				list($type, $field['settings']['value']) = explode(';', $field['settings']['value']);
				list(, $field['settings']['value'])      = explode(',', $field['settings']['value']);
				
				$value = base64_decode($field['settings']['value']);
				
				file_put_contents(UPLOAD_DIR . "/".$image_name, $value);
				$this->form_values[] = UPLOAD_DIR . "/".$image_name;
				
			}else{
				$this->form_values[$field['settings']['key']] = $field['settings']['value'];
			}
		}
	}
	
	public function field_shortcode($atts){
		$data = $this->field_values;
		if($atts['type']=="digitalsignature"){
			return '<img width="200" height="50" src="'.$data[$atts['key']].'" >';
		}
		$html = $data[$atts['key']];
		return $html;
	}

}
