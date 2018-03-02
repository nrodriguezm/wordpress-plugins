<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_Custom
 */
final class NinjaToDrive extends NF_Abstracts_Action{
    /**
     * @var string
     */
    protected $_name  = 'ninja-to-drive';

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var string
     */
    protected $_timing = 'normal';

    /**
     * @var int
     */
    protected $_priority = 10;
	
	protected $formID = '';

    /**
     * Constructor
     */
    public function __construct(){
   
		parent::__construct();

        $this->_nicename = __( 'Ninja To Drive', 'ninja-forms' );
		
		$this->formID = (int)$_GET['form_id'];
		
		$settings = $this->get_settings();
		
        $this->_settings = array_merge( $this->_settings, $settings );

    }

    public function process( $action_settings, $form_id, $data ){
        
	
		$strRequest = "";
		$i = 0;
		$len = count($array);
		foreach($data['fields'] as $field){
			
			if($field['type']!="submit" and $field['type']!="html"){
				//Field data
				$key = $field['settings']['key'];
				$value = $field['settings']['value'];
				
				if(is_array($value)){
					$value = implode(", ", $value);
				}
				
				$value = urlencode($value);
				
				//Action settings data
				if ($i == 0) {
					$strRequest .= $action_settings[$key]."=".$value;
				} else {
					$strRequest .= "&".$action_settings[$key]."=".$value;
				}
			}
		
			$i++;
			
		}
		
		//Send data to drive with curl
		$url = $action_settings['google_form_url']."/formResponse";
		
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
		
        return $data;
    }
	
	public function get_settings(){
		$settings = array();
		if($_GET['form_id']== 'new'){
			$fields = array();
		}else{
			$fields = Ninja_Forms()->form($this->formID)->get_fields();
		}
		
		foreach ($fields as $field){
			$type = $field->get_setting( 'type' );
			if($type != "submit" and $type != "html"){
				$key = $field->get_setting( 'key' );
				$label = $field->get_setting( 'label' );
				
				$field_settings = array(
					'name' => $key,
					'type' => 'textbox',
					'group' => 'primary',
					'label' => $label,
					'placeholder' => 'Google field id',
					'value' => '',
					'width' => 'one-half',
				);
				
				$settings[$key] = $field_settings;
			}
		}
		
		$settings['google_form_url'] = array(
			'name' => 'google_form_url',
			'type' => 'textbox',
			'group' => 'primary',
			'label' => 'Url form',
			'placeholder' => 'URL',
			'value' => '',
			'width' => 'full',
		);
		return $settings;
	}
}
