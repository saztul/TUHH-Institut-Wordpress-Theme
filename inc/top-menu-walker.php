<?php
class TUHH_Top_Menu_Walker extends TUHH_Walker {
    protected $selected = null;
    protected $page = null;
    
    protected function sort_elements($elements){
        return $elements;
    }
    
    protected function is_ancestor($id){
        return (
            $this->page && 
            isset($this->page->ancestors) && 
            is_array($this->page->ancestors) &&
            in_array( $id, $this->page->ancestors )
        );
    }
    
    protected function format_element($element){
        list($id, $link, $title) = $this->get_element_data($element);
	    $classes = $this->adapt_wp_classes($element);
		if ( $id == $this->selected || $this->is_ancestor($id) ){
            $classes[] = 'selected';
		}
        return sprintf(
            '<li><a data-submenu="menu-of-%d" href="%s" class="%s">%s</a></li>',
            $id,
            esc_url($link),
            join(' ', $classes),
            $title
        );
    }
    
    protected function format_elements_with_level(&$elements, $level){
        if(!isset($elements[$level])) return '';
        $sorted_elements = $this->sort_elements($elements[$level]);
        $out = '';
        foreach($sorted_elements as $element){
            $out .= $this->format_element($element);
        }
        return $out;
    }
    
    public function walk( $elements, $max_depth){
        $args = array_slice(func_get_args(), 2);
        $this->selected = null;
        $this->page = null;
        if(isset($args[1])){
            $this->selected = $args[1];
            $this->page = get_post($args[1]);
        }
        // var_dump($args);
        $map = $this->elements_by_parent($elements);
        return $this->format_elements_with_level($map, 0);
    }
    
}
?>