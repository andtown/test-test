<?php

/**
 * The WP Page Controller class
 *
 */

abstract class WP_Page_Controller extends Page_Controller {

    public function set_page_the_content_hook( string $content ) {
        return apply_filters('page_the_content', $content, $this->query_vars );    
    }

    public function set_page_the_title_hook( string $title ) {
        return apply_filters('page_the_title', $title, $this->query_vars );   
    }    

    public function set_page_the_excerpt_hook( string $excerpt ) {
        return apply_filters('page_the_excerpt', $excerpt, $this->query_vars);
    }

    public function set_page_wp_head_hook() {
        $wp_head = apply_filters( 'page_wp_head', '', $this->query_vars );
        add_action('wp_head', function() use($wp_head) {
            echo $wp_head;
        },10,1);        
    }

    public function set_page_wp_footer_hook() {
        $wp_footer = apply_filters( 'page_wp_footer', '', $this->query_vars );
        add_action('wp_footer', function() use($wp_footer) {
            echo $wp_footer;
        },10,1);        
    }

    public function set_page_wp_title_hook( string $title, string $sep, string $seplocation) {
        $wp_title = apply_filters('page_wp_title', $title, $sep, $seplocation, $this->query_vars );
        add_filter('wp_title', function($title, $sep, $seplocation) use($wp_title) {
            return $wp_title;
        },10,3);
    }

    public function set_page_the_template_include( string $template = '') {
        $template_include = apply_filters('page_template_include', $template, $this->query_vars);   
        add_filter('template_include', function($tmpl) use($template_include) {            
            return ( is_readable( $template_include ) )?$template_include:$tmpl;
        },10,1);
    }

    public function manage_hooks() {
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'wp_generator' ); 
        remove_action( 'wp_head', 'feed_links_extra', 3 ); 
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'rsd_link' ); 
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'index_rel_link' );
        remove_action( 'wp_head', 'parent_post_rel_link' ); 
        remove_action( 'wp_head', 'start_post_rel_link' ); 
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
    }

    public static function instance() {
        if ( !isset(static::$instance) ) new static;
        return static::$instance;
    }

    public function __construct() {
        if ( isset(static::$instance) ) wp_die('multiple instance '.get_class($this));
        static::$instance = $this;
    }       

}