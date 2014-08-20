<?php
class TUHH_Walker{
    protected function get_element_data($element){
        if(isset($element->xfn)){
            $id = $element->ID;
            $link = $element->url;
            $title = $element->title;
        }
        else{
            $id = $element->ID;
            $link = get_permalink($id);
            $title = $element->post_title;            
        }
        return array($id, $link, $title);
    }
    
    protected function elements_by_parent(&$elements){
        $map = array();
		foreach ( $elements as $e) {
            if(isset($e->menu_item_parent)){
                $parent = (int)$e->menu_item_parent;
            }
            else{
                $parent = (int)$e->post_parent;
            }
            if(!isset($map[$parent])) $map[$parent] = array();
            $map[$parent][] = $e;
		}
        $ordered = array_map(function($items){
            uasort($items, function($a, $b){
                if ($a->menu_order == $b->menu_order) {
                    return 0;
                }
                return ($a->menu_order < $b->menu_order) ? -1 : 1;
            });
            return $items;
        }, $map);
        return $ordered;
    }
    
    protected function adapt_wp_classes($e){
        if(isset($e->classes)){
            $classes = (array)$e->classes;
            if(in_array('current-menu-item', $classes)) $classes[] = 'selected';
            if(in_array('current-menu-ancestor', $classes)) $classes[] = 'parent-of-selected';
            
            return $this->element_classes[$e->ID] = $classes;
        }
        else{
            return array();
        }
    }
    
    
}
?>