<?php
/**
 * Custom handler for wordpress navigations
 */
class TUHH_Navigation extends Walker{
    
    /**
     * Root of navigation
     * @var TUHH_Nav_Root
     */
    private $root;
    
 	/**
 	 * Singleton instance
 	 * @var TUHH_Navigation
 	 */   
    private static $instance;
    
    /**
     * Get access to singleton instance
     * @return TUHH_Navigation
     */
    public static function get_instance(){
        if(!self::$instance){
            self::$instance = new TUHH_Navigation;
            self::$instance->import_wp_data();
        }
        return self::$instance;
    }
    
    /**
     * Prevent constrcution outside of singleton accessor
     */
    protected function __construct(){
    }
    
    /**
     * Prevent duplication
     */
    private function __clone(){
    }

    // wp walker functions
    
    /**
     * Import data from wordpress
     */
    protected function import_wp_data(){
        wp_nav_menu( array(
            'walker'         => $this,
            'theme_location' => 'primary'
        ));
    }
    
    /**
     * Implement wordpress walker method to import the nav data
     * @param array $elements
     * @param integer $max_depth
     * @param array $args
     * @return string
     */
    public function walk($elements, $max_depth, $args = array()){
        $this->root = new TUHH_Nav_Root;
        $this->last_added = $this->root;
        
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
    
    /**
     * Render top navigation
     * @return string
     */
    public function top_navigation(){
        return $this->root->render_top_nav();
    }
    
    /**
     * Render side navigation
     * @return string
     */
    public function sidebar_navigation(){
        return $this->root->render_side_nav();
    }
    
    /**
     * Render breadcrumbs
     */
    public function breadcrumbs(){
        return $this->root->render_breadcrumbs();
    }
}