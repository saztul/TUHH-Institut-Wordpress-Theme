<?php
class TUHH_Side_Menu_Walker extends TUHH_Walker{
    protected $selected = null;
    protected $page = null;
    protected $elements_by_parent;
    protected $element_classes;
    
    public function walk($elements, $max_depth){
        $args = array_slice(func_get_args(), 2);
        $this->selected = null;
        $this->page = null;
        // var_dump($args);
        // echo '---';
        if(isset($args[1])){
            $this->selected = $args[1];
            $this->page = get_post($args[1]);
        }
        $this->elements_by_parent = $this->elements_by_parent($elements);
        // var_dump($this->elements_by_parent);
        $this->element_classes($elements);
        return $this->build_root_elements();
    }
        
    protected function element_classes(&$elements){
        $this->element_classes = array();
        foreach ( $elements as $e) {
            $this->element_classes[$e->ID] = $this->adapt_wp_classes($e);
        }
        $this->element_classes[$this->selected][] = 'selected';
        if($this->page && isset($this->page->ancestors) && is_array($this->page->ancestors)){
            foreach($this->page->ancestors as $a){
                $this->element_classes[$a][] = 'parent-of-selected';
            }
        }
    }
    
    protected function get_elements_with_parent($parent){
        if(isset($this->elements_by_parent[$parent])){
            return $this->elements_by_parent[$parent];
        }
        else return array();
    }
    
    protected function build_root_elements(){
        return $this->build_elements_with_parent(0, 'format_root_element', false);
    }
    
    protected function build_elements_with_parent($parent, $formatter = 'format_element', $wrap = true){
        $elements = $this->get_elements_with_parent($parent);
        if(count($elements) == 0) return '';
        else{ 
            $children = implode('', array_map(array($this, $formatter), $elements));
            if($wrap){
                $classes = $this->menu_classes($parent);
                $children = "<ul class=\"".join(' ', $classes)."\">$children</ul>"; 
            }
            return $children;
        }
    }
    
    public function format_root_element($element){
        list($id, $link, $title) = $this->get_element_data($element);
        $classes = $this->menu_classes($id);
        if(count($classes) > 0){
            $classes[] = 'navigation-visible';
        }
        return sprintf(
            "<ul id=\"menu-of-%d\" class=\"%s\">%s</ul>",
            $id,
            join(' ', $classes),
            $this->build_elements_with_parent($id, 'format_element', false)
        );
    }
    
    protected function menu_classes($id){
        $link_classes = $this->element_classes[$id];
        $classes = array();
        if(in_array('selected', $link_classes)){
            $classes[] = 'children-of-selected';
        }
        if(in_array('parent-of-selected', $link_classes)){
            $classes[] = 'contains-selected';
        }
        return $classes;
    }
    
    public function format_element($element){
        list($id, $link, $title) = $this->get_element_data($element);
        return sprintf(
            "<li><a href=\"%s\" class=\"%s\">%s</a>%s</li>",
            esc_url($link),
            join(' ', $this->element_classes[$id]),
            apply_filters( 'the_title', $title, $id ),
            $this->build_elements_with_parent($id)
        );
    }
    
}
?>