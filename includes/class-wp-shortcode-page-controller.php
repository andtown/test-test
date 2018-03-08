<?php

/**
 * The WP Shortcode Page Controller class
 *
 */

abstract class WP_Shortcode_Page_Controller extends WP_Page_Controller implements IPage_Controller, IPage_Parser {

    protected static $instance;

    protected $is_shortcode;

    protected $is_shortcode_page;  

    protected $shortcode_tag;   

    public function init() {
        $this->is_shortcode_page = false;
        $this->is_shortcode = false;
    }

    public function parse_request( $do, $wp, $extra_query_vars ) {}

    public function parse_page( &$wp ) {
        global $wp_query, $post;
        if ( (is_single(array('post')) || is_page()) && $wp_query->have_posts() ) {
            the_post(); 
            if ( preg_match_all('/\[(\[?)('.$this->shortcode_tag.')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/i',$wp_query->post->post_content,$matches) ) {

                //TODO: for now query_vars will be filled with attributes taken from first shortcode only, later it should be able to handles multiple test_shortcode shortcodes on the same page
                //foreach( (array) $matches[3] as $match )
                $this->query_vars = shortcode_parse_atts( $matches[3][0] );

                $this->query_vars = wp_parse_args( $_REQUEST, $this->query_vars );

                if ( apply_filters_ref_array( 'shortcode_page_has_something', array(true, &$this) ) ) {

                    $this->manage_hooks();

                    $this->is_shortcode_page = true;   // we set this flag true before reaching template loader

                    do_action( 'it_is_shortcode_page' );

                }            

            }
            $wp_query->rewind_posts();
        }
    }

    public function manage_hooks() {
        parent::manage_hooks();
        add_shortcode( $this->shortcode_tag, array($this, 'render') );  
        add_filter('is_shortcode_page', array($this, 'is_shortcode_page'));
        add_filter('is_shortcode', array($this, 'is_shortcode'));
    }

    public function render( array $atts, string $content = null ) {

        $this->is_shortcode = true;

        $atts = wp_parse_args( $_REQUEST, $atts );

        do_action('it_is_shortcode');

        return apply_filters( "shortcode-page-controller", apply_filters( "{$this->shortcode_tag}-shortcode-page-controller", $content , $atts ), $atts );
      
    }

    public function is_shortcode() {
        return $this->is_shortcode;
    }

    public function is_shortcode_page() {
        return $this->is_shortcode_page;
    }

    public function __construct() {
        $this->init();        
        add_action( 'wp', array($this, 'parse_page'), 12 );
        parent::__construct();
    }

}