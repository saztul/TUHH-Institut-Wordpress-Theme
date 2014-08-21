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