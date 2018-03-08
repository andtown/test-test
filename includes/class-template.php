<?php

/**
 * The Template class.
 *
 */

class Template {

    protected $Test_Query;

    protected static $instance;

    protected $is_ajax;

    protected $use_pagination;

    protected $templates = array();

    protected $template = '';     

    public function is_template( string $tmpl ) {
      
        if ( empty($tmpl) ) return null;

        return ( !apply_filters('in_the_loop',false) && isset($this->templates[$tmpl]) );

        return ( apply_filters('in_the_loop',false) && (strcasecmp($this->template, $tmpl) == 0) );

    }        

    protected function manage_actions_and_filters() {

    }

    public function render() {

    }

    public function init() {
        $Test_Query = null;
    }

    public static function get_instance() {
        if ( !isset(self::$instance) ) new static;
        return self::$instance;
    }

    public function __construct() {
        $this->init();
        self::$instance = $this;
    }

}

?>