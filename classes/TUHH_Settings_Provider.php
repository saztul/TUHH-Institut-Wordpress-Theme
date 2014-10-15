<?php
class TUHH_Settings_Provider{
    public function __construct(){
        $this->options = get_option(TUHH_Settings::OPTION_NAME);
    }
    
    public function server_url(){
        return 'https://events.tutech.eu';
    }
    
    public function client_id(){
        return $this->option('client_id');
    }
    
    public function site_id(){
        return $this->option('site_id');
    }
    
    public function api_key(){
        return $this->option('api_key');
    }

    public function cache_time(){
        return $this->option('cache');
    }

    public function param_name(){
        return $this->option('param_name');
    }

    protected function option($name){
        return isset($this->options[$name]) ? $this->options[$name] : '';
    }
    
}
?>