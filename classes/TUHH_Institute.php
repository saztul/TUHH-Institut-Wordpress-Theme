<?php
class TUHH_Institute{
	
	protected static $instance;
	protected $options;
	
	public static function config(){
		if(!self::$instance){
			self::$instance = new TUHH_Institute();
		}
		return self::$instance;
	}
	
    public function __construct(){
        $this->options = get_option(TUHH_Settings::OPTION_NAME);
    }
    
    protected function option($name){
        return isset($this->options[$name]) ? $this->options[$name] : '';
    }
    
    protected function link($url, $title){
    	if(empty($url)){ return ''; }
    	if(!substr($url,0,1) == '#' && strpos($url, '://') === false){ $url = 'http://'.$url; }
    	return sprintf('<a href="%s" target="_blank">%s</a>', $url, $title);
    }
    
    
    //Header

	public function collapse_header_on_front_page(){
    	return $this->option('header_collapse_on_front_page');
    }
    
    public function collapse_header_on_other_pages(){
    	return $this->option('header_collapse_on_other_pages');
    }
    
    public function header_background_color(){
    	return $this->option('header_background_color');
    }
    
    public function header_text_color(){
    	return $this->option('header_text_color');
    }
    
    public function institute_logo(){
    	return $this->option('header_institute_logo');
    }
    
    // Teaser
    
	public function show_teaser_on_front_page(){
    	return $this->option('teaser_show_on_front_page');
    }
    
    public function show_teaser_on_other_pages(){
    	return $this->option('teaser_show_on_other_pages');
    }
    
    public function teaser_cycle_speed(){
    	return $this->option('teaser_cycle_speed');
    }
    
    public function teaser_default_image(){
    	return $this->option('teaser_default_image');
    }
    
    
    // Navigation
    
    public function url_of_german_website(){
    	return $this->option('header_url_of_german_website');
    }
    
    public function url_of_english_website(){
    	return $this->option('header_url_of_english_website');
    }
    
    public function language_switch(){
    	$de = $this->url_of_german_website();
    	$en = $this->url_of_english_website();
    	$out = '';
    	if(!empty($de) && !empty($en)){
    		$out .= "<span>";
    		$out .= '<a href="'.esc_attr($de).'" class=language-de>DE</a>';
    		$out .= " | ";
    		$out .= '<a href="'.esc_attr($en).'" class=language-en>EN</a>';
    		$out .= "</span>";
    	}
    	return $out;
    }
    
 	public function use_megamenu(){
    	return $this->option('navigation_by_megamenu');
 	}
    
    public function breadcrumb_root_element_title(){
    	return $this->option('breadcrumb_root_element_title');
    }
    
    public function breadcrumb_separator_color(){
    	return $this->option('breadcrumb_separator_color');
    }
    
    // Body
    
    public function link_color(){
    	return $this->option('body_link_color');
    }
    
    public function link_hover_color(){
    	return $this->option('body_link_hover_color');
    }
    
    // Footer
    
	public function address(){
    	return $this->option('footer_address');
    }
    
	public function contact(){
    	return $this->option('footer_contact');
    }
    
    public function facebook_url(){
    	return $this->option('footer_social_facebook_url');
    }
    
    public function twitter_url(){
    	return $this->option('footer_social_twitter_url');
    }
    
    public function google_plus_url(){
    	return $this->option('footer_social_google_plus_url');
    }
    
    public function flickr_url(){
    	return $this->option('footer_social_flickr_url');
    }
    
    public function youtube_url(){
    	return $this->option('footer_social_youtube_url');
    }
    
    public function feed_url(){
    	return $this->option('footer_feed_url');
    }
    
    public function imprint_url(){
    	return $this->option('footer_imprint_url');
    }
    
    public function intranet_url(){
    	return $this->option('footer_intranet_url');
    }

    public function facebook_link(){
    	return $this->link($this->facebook_url(), 'Facebook');
    }
    
    public function twitter_link(){
    	return $this->link($this->twitter_url(), 'Twitter');
    }
    
    public function google_plus_link(){
    	return $this->link($this->google_plus_url(), 'Google+');
    }
    
    public function flickr_link(){
    	return $this->link($this->flickr_url(), 'Flickr');
    }
    
    public function youtube_link(){
    	return $this->link($this->youtube_url(), 'Youtube');
    }
    
    public function feed_link(){
    	return $this->link($this->feed_url(), 'RSS Feed');
    }
    
    public function intranet_link(){
    	return $this->link($this->intranet_url(), 'Intranet');
    }
    
    public function imprint_link(){
    	return $this->link($this->imprint_url(), 'Impressum');
    }
    
}
?>