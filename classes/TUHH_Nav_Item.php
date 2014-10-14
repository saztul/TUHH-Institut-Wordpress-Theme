<?php 
/**
 * Single item in wordpress navigation
 */
class TUHH_Nav_Item{
	
	/**
	 * Data this item should display
	 * @var TUHH_Nav_WP_Data_Wrapper
	 */
    protected $wp_data;
    
    /**
     * Parent nav item
     * @var TUHH_Nav_Item
     */
    protected $parent;
    
    /**
     * Children of this navigation element
     * @var TUHH_Nav_Item[]
     */
    protected $children = array();
    
    /**
     * Is this the currently active page
     * @var boolean
     */
    protected $is_selected = false;
    
    /**
     * Child-branch containing the active page
     * @var TUHH_Nav_Item|null
     */
    protected $contains_selected_in = null;
    
    /**
     * Is the a direct descendant of the active page
     * @var boolean
     */
    protected $child_of_selected = false;
    
    /**
     * Construct with data from wp walker
     * @param array $wp_data
     */
    public function __construct($wp_data){
        $this->wp_data = new TUHH_Nav_WP_Data_Wrapper($wp_data);
    }
    
    /**
     * Get menu item id
     * @return number
     */
    public function get_id(){
        return $this->wp_data->get_id();
    }
    
    ////////////////////
    // manage selections
    ////////////////////
    
    /**
     * Mark item as selected element
     */
    public function propage_selection(){
        $this->is_selected = true;
        $this->parent->select_branch($this);
        foreach($this->children as $child){
            $child->parent_is_selected();
        }
    }
    
    /**
     * Crawl to navigation until we find the selected element
     * @return boolean
     */
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
    
    /**
     * Tell parent node a child is the selected element
     * @param TUHH_Nav_Item $child
     */
    protected function select_branch(TUHH_Nav_Item $child){
        $this->contains_selected_in = $child;
        $this->parent->select_branch($this);
        $this->wp_data->set_parent();
    }
    
    /**
     * Tell child the direct parent is selected
     */
    protected function parent_is_selected(){
        $this->child_of_selected = true;
    }
    
    ////////////////////
    // organize as tree
    ////////////////////
    
    /**
     * Add child node to this node
     * @param TUHH_Nav_Item $child
     */
    protected function append_child(TUHH_Nav_Item $child){
        $this->children[] = $child;
        $child->accept_parent($this);
    }
    
    /**
     * Set the parent for this node
     * @param TUHH_Nav_Item $parent
     */
    protected function accept_parent(TUHH_Nav_Item $parent){
        $this->parent = $parent;
    }
    
    /**
     * Build tree from flat array of items 
     * @param TUHH_Nav_Item[] $map
     */
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

    /**
     * CSS classes for this item
     * @return string
     */
    protected function list_classes(){
        $classes = [];
        if($this->contains_selected_in !== null || $this->is_selected) {
            $classes[] = 'contains-selected'; }
        return implode(' ', $classes);
    }

    /////////////////////
    // internal renderers
    /////////////////////

    /**
     * Render wp data
     * @return string
     */
    protected function render_self(){
        return strval($this->wp_data);
    }

    /**
     * Is this the selected element or a parent of the selected element
     * @return boolean
     */
    protected function contains_selected(){
        return $this->contains_selected_in !== null || $this->is_selected;
    }

    /**
     * Render a list containing all child nodes
     * @return string
     */
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

    /**
     * Render this node as a list element
     * @return string
     */
    protected function render_item(){       
        return $this->tag('li', array($this->render_self(), $this->render_children()));
    }
    
    /**
     * Helper function to build html tags
     * @param string $tag
     * @param array $children
     * @param array $attrs
     * @return string
     */
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
    
    /**
     * Render as top nav element
     * @return string
     */
    public function render_top_nav(){
        return $this->tag('li', array($this->render_self()));
    }
    
    /**
     * Render as side nav element
     * @return string
     */
    public function render_side_nav(){
        return $this->render_children();
    }
    
    /**
     * Build breadcrumbs 
     * @param array $upper_crumbs
     * @return array
     */
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
