<?php

/**
 * The WP Admin Page class
 *
 */


abstract class WP_Admin_Page extends Page_View implements IPage_View, INotices {

    protected static $instance;

    abstract protected function header();

    abstract protected function body();

    abstract protected function footer();

    public function success_notices($note) {
        add_action('admin_notices', function() use ($note) {
    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo $note; ?></p>
        </div>
    <?php
        });
    }

    public function error_notices($note) {
        add_action('admin_notices', function() use ($note) {
    ?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo $note; ?></p>
        </div>
    <?php
        });
    }      

    public function load_menu() {

        if ( empty ( $GLOBALS['admin_page_hooks'][$this->slug] ) && (!isset($this->parent_slug) || empty($this->parent_slug)) ) { 

            $page_hook = add_menu_page( $this->page_title, $this->menu_title, 'manage_options', $this->slug, array($this, 'render') );    
            add_action( 'load-'.$page_hook, array($this, 'load_page') );     

        } else if ( (isset($this->parent_slug) || !empty($this->parent_slug)) && !empty ( $GLOBALS['admin_page_hooks'][$this->parent_slug] ) ) { 

            $page_hook = add_submenu_page(
                 $this->parent_slug, 
                 $this->page_title, 
                 $this->menu_title, 
                'manage_options', 
                $this->parent_slug.'/'.$this->slug,
                array($this, 'render')
            );
            add_action( 'load-'.$page_hook, array($this, 'load_page') );

        }      
                
    }

    public function load_scripts() { 
        global $page_hook;

        do_action(sprintf("admin-page%s-load-scripts",(isset($this->parent_slug))?'-'.$this->parent_slug:'-'.$this->slug));

        do_action(sprintf("admin-page%s%s-load-scripts",(isset($this->parent_slug))?'-'.$this->parent_slug:'', (isset($this->slug))?'-'.$this->slug:''));        

        foreach ( (array) $this->css() as $key => $value ) { 
            if ( preg_match('/^https?:\/\/(?:[^\/]+\/)+(.+?)\.css\/?$/i',$value, $matches) )
                wp_enqueue_style( $matches[1], $value, array(), false, 'all' );
            else
                wp_enqueue_style( $value );
        }

        foreach ( (array) $this->js() as $key => $value ) { 
            if ( preg_match('/^https?:\/\/(?:[^\/]+\/)+(.+?)\.js\/?$/i',$value, $matches) )
                wp_enqueue_script( $matches[1], $value, array('jquery'), false, false );
            else
                wp_enqueue_script( $value );
        }

    }

    public function load_page() {
        add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) ); 
    }

    public function init() {
        
        $this->load_menu();
        //add_action('admin_menu', array($this, 'load_menu') );

    }

    public function __construct() {

        static::$instance = $this;

        $this->init();        

    }

    public static function get_instance() {

        if ( !isset(static::$instance) ) new static;

        return static::$instance;        

    }     

} 