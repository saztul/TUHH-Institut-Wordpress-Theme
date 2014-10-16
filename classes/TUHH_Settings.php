<?php
class TUHH_Settings {
    const SETTINGS_NAME = 'tuhh_institut_options';
    const OPTION_NAME = 'tuhh-institut';
    
    private static $instance;
    protected $option_name = self::OPTION_NAME;
    protected $data = array(
        'api_key' => 'abc',
        'client_id' => '1',
        'site_id' => '2',
        'param_name' => 'event',
        'cache' => '0',
        'list_template' => '',
        'detail_template' => '',
        'calendar_template' => ''
    );
    protected $options;
    
    public static function get_instance(){
        if(!self::$instance){
            self::$instance = new TUHH_Settings;
        }
        return self::$instance;
    }
    
    public function __construct(){
    	if (is_admin()){
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'add_page'));
        }
        $this->options = get_option($this->option_name);
    }
    
    public function option_name(){
        return $this->option_name;
    }
    
    public function option($name){
        return isset($this->options[$name]) ? $this->options[$name] : '';
    }
    
    /////////////
    // WP Hooks
    /////////////
    
     public function admin_init(){
        register_setting(self::SETTINGS_NAME, $this->option_name, array($this, 'validate'));
    }
    
    public function add_page() {
        add_theme_page( 
        	/* $page_title */ 'TUHH Theme Settings', 
        	/* $menu_title */ 'TUHH Theme', 
        	/* $capability */ 'edit_theme_options', 
        	/* $menu_slug  */ 'tuhh_options', 
        	/* $function   */ array($this, 'render_options_page') 
        );
    }
    
    public function activate() {
        update_option($this->option_name, $this->data);
    }
    
    public function deactivate() {
        delete_option($this->option_name);
    }
    
    ////////////
    // renderers
    ////////////
    
    public function render_options_page(){
        include(dirname(__FILE__).'/../views/tuhh_options.php');
    }
    
    /////////////
    // Validators
    /////////////
    
    public function validate($inputs){
        $valid = array();
        foreach($this->data as $key => $old_value){
            if(method_exists($this, 'sanitize_'.$key)){
                $valid[$key] = $this->{'sanitize_'.$key}($inputs[$key]);
            }
            else{
                $valid[$key] = $this->sanitize($inputs[$key]);
            }
            if(method_exists($this, 'validate_'.$key)){
                $valid[$key] = $this->{'validate_'.$key}($valid[$key], $this->data[$key]);
            }
        }
        return $valid;
    }
    
    protected function sanitize($input){
        return sanitize_text_field($input);
    }
    
    protected function sanitize_list_template($input){
        return $input;
    }
    
    protected function sanitize_detail_template($input){
        return $input;
    }
    
    protected function validate_api_key($new_value, $old_value){
        if(empty($new_value) || !preg_match('/^[a-z0-9]+$/i', $new_value)){
            add_settings_error(
                'api_key',                     // Setting title
                'apikey_texterror',            // Error ID
                'Please enter a valid API-Key',// Error message
                'error'                         // Type of message
            );
            return $old_value;
        }
        else return $new_value;
    }
}
