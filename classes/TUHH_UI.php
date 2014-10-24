<?php
class TUHH_UI{
    private $settings;
    private $option;
    
    public function __construct($settings){
    	$this->settings = $settings;//TUHH_Settings::get_instance();
    	$this->option = $this->settings->option_name();
    }
    
	public function color_field($name){
		echo '<input type="text" '.
				'class="tuhh-color-field" '.
				'id="tuhh_'.$name.'" '.
				'name="'.$this->option.'['.$name.']" '.
				'value="'.esc_attr( $this->settings->option($name) ).'" />';
	}
	
	public function text_field($name){
		echo '<input type="text" '.
				'name="'.$this->option.'['.$name.']" '.
				'id="tuhh_'.$name.'" '.
				'value="'.esc_attr( $this->settings->option($name) ).'" />';
	}
	
	public function number_field($name, $step = 1, $min = 1){
		echo '<input type="number" '.
				'step="'.esc_attr( $step ).'" '.
				'min="'.esc_attr( $min ).'" '.
				'name="'.$this->option.'['.$name.']" '.
				'id="tuhh_'.$name.'" '.
				'value="'.esc_attr( $this->settings->option($name) ).'" />';
	}
	
	public function text_area($name){
		echo '<textarea class="wp-editor-area" rows="14" '.
				'name="'.$this->option.'['.$name.']" '.
				'id="tuhh_'.$name.'" '.
				'>'.esc_attr( $this->settings->option($name) ).'</textarea>';
	}
	
	public function checkbox($name){
		$fname = $this->option.'['.$name.']';
		echo '<input type="hidden" name="'.$fname.'" value="0">';
		echo '<input type="checkbox" '.
				'name="'.$fname.'" '.
				'id="tuhh_'.$name.'" '.
				($this->settings->option($name) == '1' ? 'checked="checked" ' : '').
				'value="1" />';
	}
	
	public function upload($name){
		$fname = $this->option.'['.$name.']';
		echo '<label for="upload_image">'.
				'<input class="tuhh_upload" type="text" size="36" name="'.$this->option.'['.$name.']" '.
				'value="'.esc_attr( $this->settings->option($name) ).'" />'.
				'<input class="tuhh_upload_button button" type="button" value="Upload Image" />'.
				'<br />Geben Sie eine URL ein oder laden Sie ein Bild hoch'.
				'</label>';
	}
	
	
}