<?php

interface IAttributes {
    public function get(string $key);
    public function set(string $key, $val);
    public function get_static(string $key);
    public function set_static(string $key, $val);
}

Interface IShortcode_Query {
    public function the_shortcode( array $query, string $content = null );
}

interface IPage_Controller {
    public function parse_request( $reserved1, $reserved2, $reserved3 ); 
    public function manage_hooks();    
}

Interface IPage_Parser {
    public function parse_page( &$reserved );
}

Interface IPage_View {
    public function js();
    public function css();
    public function render();
    public function load_page();
    public function load_menu();
    public function load_scripts();                
}

Interface INotices {
    public function error_notices($note);
    public function success_notices($note); 
}



?>