<?php 
class TUHH_Teaser{
    
    public static function run(){
        $teaser = new TUHH_Teaser();
        return $teaser->build_teaser();
    }
    
    public function __construct(){
        $this->options = get_option(TUHH_Teaser_Settings::OPTION_NAME);
    }
    
    public function option($name){
        return isset($this->options[$name]) ? $this->options[$name] : '';
    }
    
    protected function build_teaser_slide($nr){
        if($this->option("teaser_slide_${nr}_active")){
            $image = $this->option("teaser_slide_${nr}_image");
            if(!empty($image)){
                $image = sprintf(' data-background="%s"', esc_attr($image));
            }
            return sprintf(
                '<article%s><h1><a href="%s" tabindex="-1">%s</a></h1><p>%s</p></article>',
                $image,
                esc_url($this->option("teaser_slide_${nr}_link")),
                esc_html($this->option("teaser_slide_${nr}_title")),
                esc_html($this->option("teaser_slide_${nr}_text"))
            );
        }
        else return '';
    }
    
    protected function build_teaser(){
        $duration = TUHH_Institute::config()->teaser_cycle_speed();
        $slides = array_map(array($this, 'build_teaser_slide'), array(1,2,3,4,5,6));
        return ''. 
        '<section id="teaser-bar">'.
            '<nav id="teaser" data-duration="'.esc_attr($duration).'">'.
                '<section id="slider">'.
                    implode($slides).
                '</section>'.
            '</nav>'.
        '</section>';
    }
    
}