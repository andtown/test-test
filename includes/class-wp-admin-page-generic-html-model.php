<?php

/**
 * The WP Admin Page Generic HTML Model class
 *
 */


abstract class WP_Admin_Page_Generic_HTML_Model extends WP_Admin_Page {

    protected static $instance;    

    abstract protected function html_elements();    

    protected function header() {
        global $page_hook;
    ?>
        <div class="wrap">
            <h1><?=$this->page_title?></h1>                                                    
    <?php      
    }

    protected function body() {
        if ( $elements = $this->html_elements() ) {
            foreach ( (array) $elements as $key => $value ) {           
                HTML_Template_Handler::get_instance()->render(array($elements[$key]));
            }
        }
    }

    protected function footer() {
    ?>        
        </div>  
    <?php
    }        

    public function render() {

        $this->header();
        $this->body();        
        $this->footer();     

    }   

    public function load_page() {
        parent::load_page();        
    }

    public function __construct() {
        parent::__construct();
    }    

}