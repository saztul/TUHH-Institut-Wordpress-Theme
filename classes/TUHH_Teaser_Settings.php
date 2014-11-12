<?php
class TUHH_Teaser_Settings {
    const SETTINGS_NAME = 'tuhh_teaser_options';
    const OPTION_NAME = 'tuhh-teaser';
    
    private static $instance;
    protected $option_name = self::OPTION_NAME;
    protected $data = array(
	    	'teaser_slide_1_active' => '',
	   		'teaser_slide_1_title' => '',
	   		'teaser_slide_1_link' => '',
	  		'teaser_slide_1_text' => '',
	   		'teaser_slide_1_image' => '',
    		 
    		'teaser_slide_2_active' => '',
    		'teaser_slide_2_title' => '',
    		'teaser_slide_2_link' => '',
    		'teaser_slide_2_text' => '',
    		'teaser_slide_2_image' => '',
    		 
    		'teaser_slide_3_active' => '',
    		'teaser_slide_3_title' => '',
    		'teaser_slide_3_link' => '',
    		'teaser_slide_3_text' => '',
    		'teaser_slide_3_image' => '',
    		 
    		'teaser_slide_4_active' => '',
    		'teaser_slide_4_title' => '',
    		'teaser_slide_4_link' => '',
    		'teaser_slide_4_text' => '',
    		'teaser_slide_4_image' => '',
    		 
    		'teaser_slide_5_active' => '',
    		'teaser_slide_5_title' => '',
    		'teaser_slide_5_link' => '',
    		'teaser_slide_5_text' => '',
    		'teaser_slide_5_image' => '',
    		 
    		'teaser_slide_6_active' => '',
    		'teaser_slide_6_title' => '',
    		'teaser_slide_6_link' => '',
    		'teaser_slide_6_text' => '',
    		'teaser_slide_6_image' => ''
    );
    protected $options;
    
    public static function get_instance(){
        if(!self::$instance){
            self::$instance = new TUHH_Teaser_Settings;
        }
        return self::$instance;
    }
    
    public static function name($name){
        return self::SETTINGS_NAME."[".$name."]";
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
			/* $page_title */ 'TUHH Teaser Slides', 
        	/* $menu_title */ 'TUHH Teaser Slides', 
        	/* $capability */ 'edit_theme_options', 
        	/* $menu_slug  */ 'tuhh_teaser', 
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
        if (is_admin()){ //isset($_GET['page']) && $_GET['page'] == 'my_plugin_page'
    		wp_enqueue_media();
    		wp_register_style( 'tuhh-tab-css-style', get_template_directory_uri().'/vendor/TUHH-Tabs/tabs.css', array(), '2014-10-17-11-55');
    		wp_enqueue_style( 'tuhh-tab-css-style' );
    		wp_enqueue_script( 'tuhh-tab', get_template_directory_uri().'/vendor/TUHH-Tabs/tabs.js', array('jquery'), '2014-08-07-15-38', true);
    		wp_enqueue_script( 'tuhh-settings', get_template_directory_uri().'/js/wp-options.js', array('jquery'), '2014-08-07-15-38', true);
    	}
    	include(dirname(__FILE__).'/../views/tuhh_teaser_options.php');
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
    
    protected function sanitize_teaser_slide_text($input){
        return $input;
    }
    
    protected function sanitize_teaser_slide_1_text($input){
    	return $this->sanitize_teaser_slide_text($input);
    }
    protected function sanitize_teaser_slide_2_text($input){
    	return $this->sanitize_teaser_slide_text($input);
    }
    protected function sanitize_teaser_slide_3_text($input){
    	return $this->sanitize_teaser_slide_text($input);
    }
    protected function sanitize_teaser_slide_4_text($input){
    	return $this->sanitize_teaser_slide_text($input);
    }
    protected function sanitize_teaser_slide_5_text($input){
    	return $this->sanitize_teaser_slide_text($input);
    }
    protected function sanitize_teaser_slide_6_text($input){
    	return $this->sanitize_teaser_slide_text($input);
    }
}

