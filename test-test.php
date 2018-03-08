<?php
/**
* Plugin Name: Just Test
* Plugin URI: 
* Version: 0.0.1
* Author: Andtown
* Author URI: 
* Description: This is going to be something that is useful for serving content from external sources (non wp_posts table).
* License: GPL3
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// TODO: use php spl autoloader and namespace
require('includes/interfaces.php');
require('includes/class-utilities.php');
require('includes/class-template.php');;
require('includes/class-page-controller.php');
require('includes/class-wp-page-controller.php');
require('includes/class-wp-landing-page-controller.php');
require('includes/class-wp-shortcode-page-controller.php');
require('includes/class-test-spc.php');
require('includes/class-test-lpc.php');
require('includes/class-wp-options.php');
require('includes/class-test-options.php');
require('includes/class-html-template-handler.php');
require('includes/class-generic-form-handler.php');
require('includes/class-page-view.php');
require('includes/class-wp-admin-page.php');
require('includes/class-wp-admin-page-generic-html-model.php');
require('includes/class-wp-admin-page-generic-form-model.php');
require('includes/class-wp-admin-page-drag-drop-sort-items-two-container-form-model.php');
require('includes/class-test-admin-main-page.php');
require('includes/class-test-admin-sub-page1.php');
require('includes/class-test-admin-sub-page2.php');
require('includes/class-wp-admin-page-advanced-form.php');
require('includes/class-test-admin-sub-page3.php');
require('includes/class-test-admin-sub-page4.php');



register_activation_hook( __FILE__, array('Just_Test','activate_plugin') );
register_deactivation_hook( __FILE__, array('Just_Test','deactivate_plugin') );


class Just_Test {

    protected static $instance = null;
    protected $meta;
    protected $link;

    public $params;
    public $test_page;   

    public function __construct() {

        $this->init();

        //add_filter( 'do_parse_request', array(new Test_LPC, 'parse_request'), 99, 3 ); 
        new Test_LPC;
        //add_action( 'wp', array(new Test_SPC, 'parse_page'), 12 );
        new Test_SPC;

        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_init', array($this, 'admin_init') );        

        add_action( 'page_wp_head', array($this, 'page_wp_head'), 10, 2 );
        add_action( 'page_wp_footer', array($this, 'page_wp_footer'), 10, 2 );
        add_filter( 'page_the_content', array($this, 'page_the_content'), 10, 2);
        add_filter( 'page_the_title', array($this, 'page_the_title'), 10, 2);
        add_filter( 'page_the_excerpt', array($this, 'page_the_excerpt'), 10, 2);        
        add_filter( 'page_wp_title', array($this, 'page_wp_title'), 10, 4 );
        add_filter( 'page_template_include', array($this, 'page_template_include'), 10, 2);

        add_filter( 'landing_page_has_something', array($this, 'landing_page_has_something'), 10, 2 ); 
        add_filter( 'shortcode_page_has_something', array($this, 'shortcode_page_has_something'), 10, 2 ); 

        add_filter( 'test-admin-sub-page1-save-settings', array($this, 'admin_page_save_settings'), 10, 3 );           
        add_filter( 'test-admin-sub-page2-save-settings', array($this, 'admin_page_save_settings'), 10, 3 );  
        add_filter( 'test-admin-sub-page3-save-settings', array($this, 'admin_page_save_settings'), 10, 3 ); 
        add_filter( 'test-admin-sub-page4-save-settings', array($this, 'admin_page_save_settings'), 10, 3 ); 

        add_action( 'test-admin-sub-page1-load-settings', array($this, 'admin_page_load_settings'), 10, 2);
        add_action( 'test-admin-sub-page2-load-settings', array($this, 'admin_page_load_settings'), 10, 2);
        add_action( 'test-admin-sub-page3-load-settings', array($this, 'admin_page_load_settings'), 10, 2);
        add_action( 'test-admin-sub-page4-load-settings', array($this, 'admin_page_load_settings'), 10, 2);

        add_action( 'admin-page-load-scripts', array($this, 'admin_page_load_scripts') );
        add_action( 'admin-page-test-admin-page-load-scripts', array($this, 'admin_page_test_load_scripts') );   

        add_filter('is_test_page', array($this, 'is_test_page'), 10,1);        

        static::$instance = $this;

    }    

    public static function get_instance() {
        if ( !isset(static::$instance) ) new static;
        return static::$instance;
    }

    public static function activate_plugin() {
        Test_LPC::activate_landing_page();
        if (Test_Options::is_empty_settings())
            Test_Options::setup_test_options_default_data();
    }

    public static function deactivate_plugin() {
        Test_LPC::deactivate_landing_page();
    }


    public function admin_menu() { 

        if ( apply_filters( 'test_load_this_page_settings', true, 'Test_Admin_Main_Page' ) ) 
            new Test_Admin_Main_Page;

        if ( apply_filters( 'test_load_this_page_settings', true, 'Test_Admin_Sub_Page1' ) ) 
            new Test_Admin_Sub_Page1;

        if ( apply_filters( 'test_load_this_page_settings', true, 'Test_Admin_Sub_Page2' ) ) 
            new Test_Admin_Sub_Page2;  

        if ( apply_filters( 'test_load_this_page_settings', true, 'Test_Admin_Sub_Page3' ) ) 
            new Test_Admin_Sub_Page3; 

        if ( apply_filters( 'test_load_this_page_settings', true, 'Test_Admin_Sub_Page4' ) ) 
            new Test_Admin_Sub_Page4; 
      
    }

    public function admin_init() {

    }

    public function admin_page_load_scripts() {

    }

    public function admin_page_test_load_scripts() {

        wp_register_style( 'test', plugins_url( 'admin/css/test.css', __FILE__ ), array(), false, 'all' );
        wp_register_script( 'test-js', plugins_url( 'admin/js/test.js', __FILE__), array('jquery'), false, false ); 

        wp_register_style( 'jquery-tags-input', plugins_url( 'admin/plugins/jQuery-Tags-Input/src/jquery.tagsinput.css', __FILE__ ), array(), false, 'all' );
        wp_register_script( 'jquery-tags-input-js', plugins_url( 'admin/plugins/jQuery-Tags-Input/src/jquery.tagsinput.js', __FILE__), array('jquery'), false, false );            
    }

    public function admin_page_save_settings( $saved, $slug, $request ) {
        $request = stripslashes_deep($request);
        Test_Options::get_instance()->add(array($slug => $request))->save();   
        return true;
    }       

    public function admin_page_load_settings( $slug, &$data ) {
        $data = Test_Options::get_instance()->get($slug)->value();
        $data = empty($data)?array():$data;
    }


    public function landing_page_has_something( bool $has_something, Test_LPC $LPC ) {

        if ( $has_something = ( isset( $LPC->query_vars['template'] ) && in_array( $LPC->query_vars['template'], $LPC->reserved_pages()) ) ) {
            $LPC->query_vars['template'] = (isset($LPC->query_vars['template']))?urldecode(trim($LPC->query_vars['template'])):null;
            $LPC->query_vars['slug'] = (isset($LPC->query_vars['slug']))?urldecode(trim($LPC->query_vars['slug'])):'';
            $LPC->query_vars['page'] = (isset($LPC->query_vars['page']))?trim($LPC->query_vars['page']):1;   
        }

        return $has_something;

    }

    public function shortcode_page_has_something( bool $has_something, Test_SPC &$SPC ) {
        return $has_something;
    }

    public function page_the_content(string $content, array $query_vars) {
        return apply_filters('__the_content',$content, $query_vars);
    }

    public function page_the_title(string $title, array $query_vars) {
        return apply_filters('__the_title', $title, $query_vars);
    }

    public function page_the_excerpt(string $excerpt, array $query_vars) {
        return apply_filters('__the_excerpt', $excerpt, $query_vars);
    }

    public function page_template_include(string $template, array $query_vars) {
        return apply_filters('__template_include',$template, $query_vars);
    }

    public function page_wp_title(string $title, string $sep, string $seplocation, array $query_vars) {
        return apply_filters('__wp_title', $title, $sep, $seplocation, $query_vars);
    }

    public function page_wp_head( string $head , array $query_vars ) {
        $this->predefined_landing_page_meta($query_vars);
        $this->meta = apply_filters('test_meta',$this->meta);        
        $this->predefined_landing_page_link($query_vars);        
        $this->link = apply_filters('test_link',$this->link);
        ob_start();        
            $this->print_html_element('meta',$this->meta);
            $this->print_html_element('link',$this->link);       
        return apply_filters( '__wp_head', $head . ob_get_clean(), $query_vars );
    }

    public function page_wp_footer( string $footer, array $query_vars) {
        return apply_filters( '__wp_footer', $footer, $query_vars );
    }

    private function print_html_element(string $tag, array $atts) {
        foreach ( $atts as $att ) {
            if ( !is_array($att) ) continue;
            $c = '';
            foreach ( (array) $att as $key => $val ) {
                $c = !empty($c)?$c." ":"";
                $c .= $key ."=\"".esc_attr(stripslashes($val))."\"";
            }
            echo "<$tag $c>\n";
        }        
    }

    public function predefined_landing_page_meta(array $query_vars) {
        if ( !empty(get_option('blog_public',1)) )
            $this->meta['robots'] = ['name' => 'robots', 'content' => 'index, follow'];
        else
            $this->meta['robots'] = ['name' => 'robots', 'content' => 'noindex, follow'];            
    }

    public function predefined_landing_page_link( array $query_vars ) {
        $this->link[] = ['rel'=>'canonical', 'href' => esc_url(site_url())];
        $this->link[] = ['rel'=>'alternate', 'type'=>'application/rss+xml', 'title' => esc_attr(apply_filters('test_rss_title', get_bloginfo('blogname')." Test Feed")), 'href'=> apply_filters('test_rss_url', site_url($query_vars['template'].'/feed'))];
    }    

    public function init() {
        $this->meta = [];
        $this->link = [];
        $this->test_page = false;
        $this->params = [];
    } 

}

new Just_Test;