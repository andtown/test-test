<?php

/**
 * The WP Options class
 *
 */

class WP_Options {

    protected static $instance;

    protected $id = 'my_settings';

    protected $data;
    private $temp_data;

    public function load() {
        $this->data = get_option($this->id,array());
        //$this->data = (!empty($this->data))?json_decode($this->data, true):$this->data;
        $this->data = (!empty($this->data))?unserialize($this->data):array();
        $this->temp_data = $this->data;
    }

    public function get( string $key, $default = '' ) {
        $this->temp_data = ( isset($this->temp_data[$key]) )?$this->temp_data[$key]:$default;
        return $this;   
    }

    public function save() {
        //update_option( $this->id, json_encode($this->data) );
        update_option( $this->id, serialize($this->data) );
    }

    public function reset() {
        $this->temp_data = $this->data;
        return $this;
    }

    public function add( $data ) {
        if ( is_array($data) && is_array($this->data) ) {             
            $this->data = $data + $this->data;
        } else {
            $this->data .= $data;
        }
        return $this;
    }

    public function value() {
        return $this->temp_data;
    }

    public function init() { 
        $this->data = array();
        $this->temp_data = array();
        $this->load();
    }

    public static function get_instance() {

        if ( !isset(static::$instance) ) static::$instance = new static;
        return static::$instance;

    }

    public function __construct() {

        static::$instance = $this;

        $this->init();
 
    } 

}