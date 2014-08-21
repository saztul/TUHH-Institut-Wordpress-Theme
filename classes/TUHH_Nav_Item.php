<?php 
class TUHH_Nav_Item{
    protected $wp_data;
    protected $parent;
    protected $children = array();
    protected $is_selected = false;
    protected $contains_selected_in = null;
    protected $child_of_selected = false;
    
    public function __construct($wp_data){
        $this->wp_data = new TUHH_Nav_WP_Data_Wrapper($wp_data);
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
