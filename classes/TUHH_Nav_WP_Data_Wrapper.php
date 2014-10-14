<?php
/**
 * Abstraction for wordpress navigation element data
 */
class TUHH_Nav_WP_Data_Wrapper{
	/**
	 * Data th walker provided
	 * @var array
	 */
    protected $wp_data;
    
    /**
     * Is the a parent of the selected page
     * @var boolean
     */
    protected $is_parent = false;
    
    /**
     * Constructor
     * @param array $wp_data
     */
    public function __construct($wp_data){
        $this->wp_data = $wp_data;
    } 

    /**
     * Id of menu item
     * @return number
     */
    public function get_id(){
        return intval($this->wp_data->ID);
    }
    
    /**
     * Mark this as parent
     */
    public function set_parent(){
        $this->is_parent = true;
    }
    
    /**
     * Is this the selected element
     * @param boolean
     */
    public function is_selected(){
        return $this->wp_data->current;
    }
    
    /**
     * Get the menu id of the parent element
     * @return number
     */
    public function parent_id(){
        if(isset($this->wp_data->menu_item_parent)){
            return intval($this->wp_data->menu_item_parent);
        }
        else return 0;
    }
    
    /**
     * Convert wp-data into a link-tag
     * @return string
     */
    public function __toString(){
        $item = $this->wp_data;
        
        $classes = array();
        if($this->is_selected()){
            $classes[] = 'selected'; }
        if($this->is_parent){
            $classes[] = 'parent-of-selected'; }
        
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['class']  = implode(' ', $classes);

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
        return '<a'.$attributes." data-submenu=\"children-of-".$this->get_id()."\">".apply_filters( 'the_title', $item->title, $item->ID ).'</a>';
    }
}
