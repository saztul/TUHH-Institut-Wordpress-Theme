<?php
class TUHH_Settings {
    const SETTINGS_NAME = 'tuhh_institut_options';
    const OPTION_NAME = 'tuhh-institut';
    
    private static $instance;
    protected $option_name = self::OPTION_NAME;
    protected $data = array(
    	// Header
		'header_collapse_on_front_page' => '',
		'header_collapse_on_other_pages' => '',
		'header_background_color' => '',
    	'header_text_color' => '',
    	'header_institute_logo' => '',
    		
    	// Navigation
    	'navigation_by_megamenu' => '',
    	'breadcrumb_root_element_title' => '',
    	'breadcrumb_separator_color' => '',
    	'header_url_of_german_website' => '',
    	'header_url_of_english_website' => '',
    		
    	//Teaser
    	'teaser_show_on_front_page' => '',
    	'teaser_show_on_other_pages' => '',
    	'teaser_cycle_speed' => '',	
    	'teaser_default_image' => '',
    		
    	// Body
    	'body_link_color' => '',
    	'body_link_hover_color' => '',
    	
    	// Footer
    	'footer_address' => '',
    	'footer_contact' => '',
    	'footer_social_facebook_url' => '',
    	'footer_social_twitter_url' => '',
    	'footer_social_google_plus_url' => '',
    	'footer_social_flickr_url' => '',
    	'footer_social_youtube_url' => '',
    	'footer_feed_url' => '',
    	'footer_imprint_url' => '',
    	'footer_intranet_url' => ''
    );
    protected $options;
    
    public static function get_instance(){
        if(!self::$instance){
            self::$instance = new TUHH_Settings;
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
        	/* $page_title */ 'TUHH Theme Einstellungen', 
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
    	if (is_admin()){ //isset($_GET['page']) && $_GET['page'] == 'my_plugin_page'
    		wp_enqueue_media();
    		wp_register_style( 'tuhh-tab-css-style', get_template_directory_uri().'/vendor/TUHH-Tabs/tabs.css', array(), '2014-10-17-11-55');
    		wp_enqueue_style( 'tuhh-tab-css-style' );
    		wp_enqueue_script( 'tuhh-tab', get_template_directory_uri().'/vendor/TUHH-Tabs/tabs.js', array('jquery'), '2014-08-07-15-38', true);
    		wp_enqueue_script( 'tuhh-settings', get_template_directory_uri().'/js/wp-options.js', array('jquery'), '2014-08-07-15-38', true);
    	}
    	wp_enqueue_style( 'wp-color-picker' );          
        wp_enqueue_script( 'wp-color-picker' );    
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
    
    protected function sanitize_footer_contact($input){
        return $input;
    }
    
    protected function sanitize_footer_address($input){
        return $input;
    }
    
}
