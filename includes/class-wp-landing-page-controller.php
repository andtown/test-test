<?php

/**
 * The WP Landing Page Controller class
 *
 */


abstract class WP_Landing_Page_Controller extends WP_Page_Controller implements IPage_Controller, IPage_Parser {
    // landing page controller class

    protected static $landing_page_id; 

    protected static $page_post_type;
    protected static $page_post_content;

    private $rewrite_rules = array();
    protected $is_landing_page = false;

    abstract protected function rewrite_rules();
    abstract protected function reserved_pages();

    public function init() {
        static::$landing_page_id = get_option('landing_page_id', null);       
        if (!static::$landing_page_id) return;
        $this->setup_rewrite_rules();
        $this->query_vars = [];
    }   

    public function parse_page( &$wp ) {
        global $wp_query;
        if ( ( is_page( (int) static::$landing_page_id ) || (int) static::$landing_page_id == $wp_query->post->ID ) && $wp_query->have_posts() ) {
            the_post();

            $wp_query->post->post_content = $this->set_page_the_content_hook( $wp_query->post->post_content );
            $wp_query->post->post_title = $this->set_page_the_title_hook( $wp_query->post->post_title );
            $wp_query->post->post_excerpt = $this->set_page_the_excerpt_hook( $wp_query->post->post_excerpt );
            $this->set_page_wp_title_hook( $wp_query->post->post_title, ' - ', false);
            $this->set_page_wp_head_hook();
            $this->set_page_wp_footer_hook();
            $this->set_page_the_template_include($this->query_vars['template']);
            
            $wp_query->rewind_posts();
        }
    }

    public function manage_hooks() {
        remove_action( 'template_redirect', 'wp_shortlink_header', 11 );     
        remove_action( 'template_redirect', 'redirect_canonical', 10 );
        remove_action( 'wp_head', 'wp_shortlink_wp_head' );            
        remove_action( 'wp_head', 'rel_canonical' );
        remove_action( 'embed_head', 'rel_canonical' );

        add_filter( 'is_landing_page', array( $this, 'is_landing_page' ) );

        add_action( 'wp', array($this, 'parse_page'), 12 );       

        parent::manage_hooks();
    }

    protected function prepare_page_query_vars() {
        global $wp;
        $wp->query_vars['post_type'] = static::$page_post_type;
        $wp->query_vars['page_id'] = static::$landing_page_id;
    }

    protected function setup_rewrite_rules() {
        $this->rewrite_rules = $this->rewrite_rules();
    }

    public static function activate_landing_page() {
        static::$landing_page_id = get_option('landing_page_id', null);       
        if ( !empty(static::$landing_page_id) && is_numeric(static::$landing_page_id) ) return;
        static::$landing_page_id = wp_insert_post(array( 
            'guid'=>get_site_url(), 
            'post_name' => static::$page_post_type, 
            'post_type' => static::$page_post_type,
            'post_content' => static::$page_post_content,
            'post_status' => 'publish', 
            'post_title' => static::$page_post_type));
        update_option('landing_page_id',static::$landing_page_id);
    }

    public static function deactivate_landing_page() {
        static::$landing_page_id = get_option('landing_page_id', null); 
        if ( !empty(static::$landing_page_id) && is_numeric(static::$landing_page_id) ) 
            wp_delete_post( (int) static::$landing_page_id, true );
        delete_option('landing_page_id');
        static::$landing_page_id = null;
    }    

    public function is_landing_page() {
        return $this->is_landing_page;
    }

    public function parse_request( $do, $wp, $extra_query_vars ) {

        if (empty(static::$landing_page_id)) return $do;

        if ( empty($this->rewrite_rules) ) return $do;

        $pathinfo = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
        list( $pathinfo ) = explode( '?', $pathinfo ); 
        $pathinfo = str_replace( "%", "%25", $pathinfo );

        list( $req_uri ) = explode( '?', $_SERVER['REQUEST_URI'] );
        $home_path = trim( parse_url( home_url(), PHP_URL_PATH ), '/' ); 
        $home_path_regex = sprintf( '|^%s|i', preg_quote( $home_path, '|' ) );

        $req_uri = str_replace($pathinfo, '', $req_uri);
        $req_uri = trim($req_uri, '/');
        $req_uri = preg_replace( $home_path_regex, '', $req_uri );
        $req_uri = trim($req_uri, '/');
        $pathinfo = trim($pathinfo, '/');
        $pathinfo = preg_replace( $home_path_regex, '', $pathinfo );
        $pathinfo = trim($pathinfo, '/');        

        if ( ! empty($pathinfo) && !preg_match('|^.*index.php$|', $pathinfo) ) {
            $requested_path = $pathinfo;
        } else {
            if ( $req_uri == 'index.php' )
                $req_uri = '';
            $requested_path = $req_uri;
        }

        $requested_file = $req_uri;

        $request_match = $requested_path;

        if ( empty( $request_match ) ) return $do;

        foreach ( (array) $this->rewrite_rules as $match => $query ) { 

            if ( ! empty($requested_file) && strpos($match, $requested_file) === 0 && $requested_file != $requested_path )
                $request_match = $requested_file . '/' . $requested_path;

            if ( preg_match("#^$match#", $request_match, $matches) || preg_match("#^$match#", urldecode($request_match), $matches) ) {

                $this->query_vars = addslashes(WP_MatchesMapRegex::apply($query, $matches));

                parse_str($this->query_vars,$this->query_vars); 
                
                //TODO: separate into public and private vars, priority low
                $this->query_vars = wp_parse_args($_REQUEST, $this->query_vars);

                if ( $this->is_landing_page = apply_filters_ref_array( 'landing_page_has_something', array(false, $this) ) ) {

                    do_action('it_is_landing_page');

                    $this->manage_hooks();

                    $this->prepare_page_query_vars();

                    return !$this->is_landing_page;

                }

            }
            
        }

        return $do;
    }

    public function __construct() {
        // add_action( 'init', array($this, 'init') );
        add_filter( 'do_parse_request', array($this, 'parse_request'), 99, 3 );      
        $this->init();
        parent::__construct();
    }

}