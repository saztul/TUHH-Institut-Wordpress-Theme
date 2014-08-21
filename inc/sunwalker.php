<?php
class TUHH_Navigation extends Walker{
    private $root;
    private $scope;

    // singleton
    
    private static $instance;
    
    public static function get_instance(){
        if(!self::$instance){
            self::$instance = new TUHH_Navigation;
            self::$instance->import_wp_data();
        }
        return self::$instance;
    }
    
    protected function __construct(){
    }
    
    private function __clone(){
    }

    // wp walker functions
    
    protected function import_wp_data(){
        wp_nav_menu( array(
            'walker'         => $this,
            'theme_location' => 'primary'
        ));
    }
    
    public function walk($elements, $max_depth, $args = array()){
        $this->root = new TUHH_Nav_Root;
        $this->last_added = $this->root;
        $this->scope = $this->root;
    
        $wrapped = array();
        foreach($elements as $element){
            $wrapped[] = new TUHH_Nav_Item($element);
        }
        
        // make an id map
        $id_map = array();
        foreach($wrapped as $item){
            $id_map[$item->get_id()] = $item;
        }

        // build hierarchy with id map
        $id_map[0] = $this->root;
        foreach($wrapped as $item){
            $item->assemble($id_map);
        }

        $this->root->query_selection();
        
        return '';
    }
    
    public function top_navigation(){
        return $this->root->render_top_nav();
    }
    
    public function sidebar_navigation(){
        return $this->root->render_side_nav();
    }
    
    public function breadcrumbs(){
        return $this->root->render_breadcrumbs();
    }
}



class TUHH_Nav_Item{
    protected $wp_data;
    protected $parent;
    protected $children = array();
    protected $is_selected = false;
    protected $contains_selected_in = null;
    protected $child_of_selected = false;
    
    public function __construct($wp_data){
        $this->wp_data = new TUHH_WP_Data_Wrapper($wp_data);
    }
    
    public function get_id(){
        return $this->wp_data->get_id();
    }
    
    ////////////////////
    // manage selections
    ////////////////////
    
    public function propage_selection(){
        $this->is_selected = true;
        $this->parent->select_branch($this);
        foreach($this->children as $child){
            $child->parent_is_selected();
        }
    }
        
    public function query_selection(){
        if($this->wp_data->is_selected()){
            $this->propage_selection();
            return true;
        }
        else{
            foreach($this->children as $child){
                if($child->query_selection()) return true;
            }
            return false;
        }
    }
    
    protected function select_branch(TUHH_Nav_Item $child){
        $this->contains_selected_in = $child;
        $this->parent->select_branch($this);
        $this->wp_data->set_parent();
    }
    
    protected function parent_is_selected(){
        $this->child_of_selected = true;
    }
    
    ////////////////////
    // organize as tree
    ////////////////////
    
    protected function append_child(TUHH_Nav_Item $child){
        $this->children[] = $child;
        $child->accept_parent($this);
    }
    
    protected function accept_parent(TUHH_Nav_Item $parent){
        $this->parent = $parent;
    }
    
    public function assemble($map){
        $parent_id = $this->wp_data->parent_id();
        if(isset($map[$parent_id])){
            $map[$parent_id]->append_child($this);
        }
    }

    ////////////////////
    // render helpers
    ////////////////////
    // -> move to wp data?

    protected function list_classes(){
        $classes = [];
        if($this->contains_selected_in !== null || $this->is_selected) {
            $classes[] = 'contains-selected'; }
        return implode(' ', $classes);
    }

    /////////////////////
    // internal renderers
    /////////////////////

    protected function render_self(){
        return strval($this->wp_data);
    }

    protected function contains_selected(){
        return $this->contains_selected_in !== null || $this->is_selected;
    }

    protected function render_children(){
        $children = array_map(function($child){
            return $child->render_item();
        }, $this->children);
        return $this->tag(
            'ul', 
            $children,
            array('id' => "children-of-".$this->get_id(), 'class' => $this->list_classes())
        );
    }

    protected function render_item(){       
        return $this->tag('li', array($this->render_self(), $this->render_children()));
    }
    
    protected function tag($tag, $children, $attrs = array()){
        $attr_list = '';
        foreach($attrs as $name => $value){
            $attr_list .= sprintf(' %s="%s"', esc_attr($name), esc_attr($value));
        }
        return sprintf('<%s%s>%s</%s>', $tag, $attr_list, implode('', $children), $tag);
    }
    
    /////////////////////
    // external renderers
    /////////////////////
    
    public function render_top_nav(){
        return $this->tag('li', array($this->render_self()));
    }
    
    public function render_side_nav(){
        return $this->render_children();
    }
    
    public function render_breadcrumbs($upper_crumbs = array()){
        $upper_crumbs[] = $this->render_self();
        if($this->contains_selected_in !== null){
            return $this->contains_selected_in->render_breadcrumbs($upper_crumbs);
        }
        else{
            return $upper_crumbs;
        }
    }
}

class TUHH_Nav_Root extends TUHH_Nav_Item{
    
    public function __construct(){
    }
    
    public function get_id(){
        return 0;
    }
    
    public function query_selection(){
        foreach($this->children as $child){
            if($child->query_selection()) return true;
        }
    }

    protected function select_branch(TUHH_Nav_Item $child){
        $this->contains_selected_in = $child;
    }
    
    public function render_top_nav(){
        $children = array_map(function($child){
            return $child->render_top_nav();
        }, $this->children);
        $list = $this->tag('ul', $children, array('data-delegate' => "sidebar-navigation"));
        return $this->tag('nav', array($list), array('id' => "top-navigation", "class" => "main-navigation"));
    }

    public function render_side_nav(){
        $children = array_map(function($child){
            return $child->render_side_nav();
        }, $this->children);
        return $this->tag('nav', $children, array('id' => "sidebar-navigation", "class" => "main-navigation"));
    }
    
    public function render_breadcrumbs(){
        $crumbs = array();
        if($this->contains_selected_in !== null){
            $crumbs = $this->contains_selected_in->render_breadcrumbs();
        }
        return implode('<span class="path-sep"> &gt; </span>', $crumbs);
    }
    
    public function __toString(){
        return $this->render_children();
    }
}

class TUHH_WP_Data_Wrapper{
    protected $wp_data;
    protected $is_parent = false;
    
    public function __construct($wp_data){
        $this->wp_data = $wp_data;
    } 

    public function get_id(){
        return intval($this->wp_data->ID);
    }
    
    public function set_parent(){
        $this->is_parent = true;
    }
    
    public function is_selected(){
        return $this->wp_data->current;
    }
    
    public function parent_id(){
        if(isset($this->wp_data->menu_item_parent)){
            return intval($this->wp_data->menu_item_parent);
        }
        else return 0;
    }
    
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
