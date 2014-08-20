<?php
class TUHH_Navigation extends Walker{
    private $root;
    private $scope;

    // tuhh functions
    
    public function top_menu(){
        
    }
    
    public function side_menus(){
        
    }
    
    public function breadcrumbs(){
        
    }
    
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
        $this->root = new TUHH_Nav_Root;
        $this->last_added = $this->root;
        $this->scope = $this->root;
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
        echo "<script> DARP = ";
        echo json_encode($elements);
        echo "</script>";
        
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
}



class TUHH_Nav_Item{
    protected $wp_data;
    protected $parent;
    protected $children = array();
    protected $is_selected = false;
    protected $contains_selected_in = null;
    protected $child_of_selected = false;
    
    public function __construct($wp_data){
        $this->wp_data = $wp_data;
    }
    
    public function get_id(){
        return intval($this->wp_data->ID);
    }
    
    public function propage_selection(){
        $this->is_selected = true;
        $this->parent->select_branch($this);
        foreach($this->children as $child){
            $child->parent_is_selected();
        }
    }
        
    public function query_selection(){
        if($this->wp_data->current){
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
    }
    
    protected function parent_is_selected(){
        $this->child_of_selected = true;
    }
    
    protected function append_child(TUHH_Nav_Item $child){
        $this->children[] = $child;
        $child->accept_parent($this);
    }
    
    protected function accept_parent(TUHH_Nav_Item $parent){
        $this->parent = $parent;
    }
    
    public function assemble($map){
        if(isset($this->wp_data->menu_item_parent)){
            $parent_id = intval($this->wp_data->menu_item_parent);
            if(isset($map[$parent_id])){
                $map[$parent_id]->append_child($this);
            }
        }
    }

    protected function render_self(){
        $item = $this->wp_data;
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['class']   = $this->is_selected        ? 'selected'        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
        
		$item_output ='<a'. $attributes .'>';
		$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a>';
        return $item_output;
    }

    protected function render_children(){
        $out = '';
        if(count($this->children)){
            $sel = ($this->contains_selected_in !== null || $this->is_selected) ? ' class="contains-selected"' : '';
            $out .= "<ul".$sel.">";
            foreach($this->children as $child){
                $out .= strval($child);
            }
            $out .= "</ul>";
        }
        return $out;
    }

    public function __toString(){       
        $out = "<li>";
        $out .= $this->render_self();
        $out .= $this->render_children();
        $out .= "</li>";
        return $out;
    }
    
    public function render_top_nav(){
        return "<li>".$this->render_self()."</li>";
    }
    
    public function render_side_nav(){
        return $this->render_children();
    }
}

class TUHH_Nav_Root extends TUHH_Nav_Item{
    public function get_id(){
        return 0;
    }
    
    protected function select_branch(TUHH_Nav_Item $child){
        $this->contains_selected_in = $child;
    }
    
    public function render_top_nav(){
        $out = "<nav id=\"top-navigation\" class=\"main-navigation\"><ul data-delegate=\"sidebar-navigation\" class=\"contains-selected\">";
        foreach($this->children as $child){
            $out .= $child->render_top_nav();
        }
        $out .= "</ul></nav>";
        return $out;
    }

    public function render_side_nav(){
        $out = '<nav id="sidebar-navigation" class="main-navigation">';
        foreach($this->children as $child){
            $out .= $child->render_side_nav();
        }
        return $out.'</nav>';
    }
    
    public function __toString(){
        return $this->render_children();
    }
}




// class TUHH_Nav_Item{
//     protected $children = array();
//     protected $parent;
//     protected $is_child_of_selected = false;
//     protected $is_parent_of_selected = false;
//     protected $is_selected = false;
//
//     public function __construct($item, $args){
//
//     }
//
//     public function select(){
//         $this->parent->parent_of_selected($this, array($this));
//         $this->is_selected = true;
//         array_map($this->children, function($child){
//             $child->child_of_selected();
//         });
//     }
//
//     public function append_child(TUHH_Nav_Item $child){
//         $child->set_parent($this);
//         $this->children[] = $child;
//     }
//
//     public function last_child(){
//         if(count($this->children)){
//             return $this->children[count($this->children) - 1];
//         }
//         else return $this;
//     }
//
//     protected function set_parent(TUHH_Nav_Item $parent){
//         $this->parent = $parent;
//     }
//
//     // for menu walker
//     public function get_parent(){
//         return $this->parent;
//     }
//
//     protected function parent_of_selected(TUHH_Nav_Item $selected, array $branch){
//         $this->is_parent_of_selected = true;
//         $this->parent->parent_of_selected($selected, array_merge(array($this), $branch));
//     }
//
//     protected function child_of_selected(){
//         $this->is_child_of_selected = true;
//     }
//
//     public function get_selected_branch($ancestors = array()){
//         $ancestors[] = $this;
//         if($this->branch_with_selection){
//             $ancestors = $this->branch_with_selection->get_selected_branch($ancestors);
//         }
//         return $ancestors;
//     }
// }
//
// class TUHH_Nav_Root extends TUHH_Nav_Item{
//     protected $selected;
//     protected $selected_branch;
//
//     public function select(){
//     }
//
//     protected function set_parent(){
//     }
//
//     public function get_parent(){
//         return $this;
//     }
//
//     protected function parent_of_selected(TUHH_Nav_Item $selected, $selected_branch){
//         $this->selected_branch = $selected_branch;
//         $this->selected = $selected;
//     }
//
//     protected function child_of_selected(){
//     }
//
//     public function get_selected_branch(){
//         return $this->selected_branch;
//     }
//
//     public function get_selected(){
//         return $this->selected;
//     }
//
//
// }

?>