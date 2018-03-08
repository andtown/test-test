<?php

/**
 * The WP Admin Page Generic Form Model
 *
 */


abstract class WP_Admin_Page_Generic_Form_Model extends WP_Admin_Page {

    protected static $instance;

    protected $form_handler;  

    abstract protected function form_fields();

    protected function header() {
        global $page_hook;
    ?>
        <div class="wrap">
            <h1><?=$this->page_title?></h1>
            <?php if ($this->form_handler): ?>
            <?=$this->form_handler->begin_form_tag()?>            
                <?php wp_nonce_field( $page_hook, '_wpnonce' ); ?>
                <div class="form-table"> 
                    <div class="postbox">
                        <div class="inside">
            <?php endif; ?>                                                       
    <?php      
    }

    protected function body() {
        if ( $this->form_handler ) $this->form_handler->render($this->fields);        
    }

    protected function footer() {
    ?>
        <?php if ( $this->form_handler ): ?>
                        </div>
                    </div>
                </div>                      
                <p class="submit"><input id="submit" class="button button-primary" value="Save" type="submit"></p>
            <?=$this->form_handler->end_form_tag()?>
        <?php endif; ?>
        </div>  
    <?php
    }      

    public function render() {

        $this->header();
        $this->body();        
        $this->footer();

    }         

    private function rec_values( array &$fields = [], &$data = [] ) {

        foreach ( $fields as $key => &$val ) {

            if ( !isset($val['type']) ) continue;

            if ( !isset($data[$key]) ) continue;

            if ( is_array($val['type']) ) 
                self::rec_values($val['type'],$data[$key]);
            else
                $val['value'] = $data[$key];

        }

    }

    public function load_page() {
        global $page_hook;

        parent::load_page();

        do_action_ref_array( $this->slug.'-load-settings', array($this->slug, &$this->saved_data) );        

        $this->saved_data = array_merge( $this->saved_data, stripslashes_deep($_POST) );

        //TODO: array_intersect_key search for 1 level array only, later it should be able to handle multidimensional array but currently this codes works charm for generic form (2 depth array)
        if ($_POST) $this->saved_data = array_intersect_key($this->saved_data, $_POST);

        unset($this->saved_data['page'],$this->saved_data['_wpnonce'],$this->saved_data['_wp_http_referer']);

        self::rec_values($this->fields,$this->saved_data);

        if ( !( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], $page_hook ) ) ) return; 

        if ( $res = $this->form_handler->validate_form_input($this->fields, $_POST) ) {
            $res = apply_filters($this->slug.'-save-settings', false, $this->slug, $this->saved_data);            
        }

        if ( $res )
            $this->success_notices(__('Settings saved.','textdomain'));
        else if ( $res === false )
            $this->error_notices(__('There was a problem saving changes on this page. Some errors have been highlighted below.','textdomain'));

    }        

    public function init() {
        parent::init();
        $this->fields = $this->form_fields();
        $this->saved_data = [];        
    }

    public function __construct() {
        parent::__construct();
        $this->form_handler = Generic_Form_Handler::get_instance(); 
    }

}
