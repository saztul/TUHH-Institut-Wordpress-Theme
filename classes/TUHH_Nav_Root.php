<?php
/**
 * Root element of navigation
 */
class TUHH_Nav_Root extends TUHH_Nav_Item{
    
	/**
	 * Root constructor needs no data
	 */
    public function __construct(){
    }
    
    /**
     * Fake id for root node
     * @see TUHH_Nav_Item::get_id()
     */
    public function get_id(){
        return 0;
    }
    
    /**
     * Look for selected element in child nodes
     * @see TUHH_Nav_Item::query_selection()
     */
    public function query_selection(){
        foreach($this->children as $child){
            if($child->query_selection()) return true;
        }
    }

    /**
     * Set branch that contains the selected element
     * @see TUHH_Nav_Item::select_branch()
     * @param TUHH_Nav_Item $child
     */
    protected function select_branch(TUHH_Nav_Item $child){
        $this->contains_selected_in = $child;
    }
    
    /**
     * Render top navigation
     * @see TUHH_Nav_Item::render_top_nav()
     */
    public function render_top_nav(){
        $children = array_map(function($child){
            return $child->render_top_nav();
        }, $this->children);
        $list = $this->tag('ul', $children, array('data-delegate' => "sidebar-navigation"));
        return $this->tag('nav', array($list), array('id' => "top-navigation", "class" => "main-navigation"));
    }

    /**
     * Render side navigation
     * @see TUHH_Nav_Item::render_side_nav()
     */
    public function render_side_nav(){
        $children = array_map(function($child){
            return $child->render_side_nav();
        }, $this->children);
        return $this->tag('nav', $children, array('id' => "sidebar-navigation", "class" => "main-navigation"));
    }
    
    /**
     * Render breadcrumbs
     * @see TUHH_Nav_Item::render_breadcrumbs()
     * @return string
     */
    public function render_breadcrumbs(){
        $crumbs = array($this->render_self());
        if($this->contains_selected_in !== null){
            $crumbs = $this->contains_selected_in->render_breadcrumbs($crumbs);
        }
        return implode('<span class="path-sep"> &gt; </span>', $crumbs);
    }
    
    /**
     * Render root element
     * @return string
     */
    protected function render_self(){
        return sprintf(
            '<a href="%s">%s</a>',
            site_url(),
            TUHH_Institute::config()->breadcrumb_root_element_title()
        );
    }
    
    /**
     * Convert to string
     * @return string
     */
    public function __toString(){
        return $this->render_children();
    }
}
