<?php
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
