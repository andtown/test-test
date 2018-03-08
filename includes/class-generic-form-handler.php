<?php

/**
 * The Generic Form Handler class
 *
 */

class Generic_Form_Handler extends HTML_Template_Handler {

    const ENCTYPE_A = 'application/x-www-form-urlencoded';
    const ENCTYPE_B = 'multipart/form-data';
    const ENCTYPE_C = 'text/plain';

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    protected static $instance;

    protected $method;
    protected $enctype;
    protected $name;
    protected $id;
    protected $action;
    protected $ajax;

    public function begin_form_tag() {
        printf('<form method="%s" action="%s" enctype="%s" id="%s" name="%s">',$this->method, $this->action, $this->enctype, $this->id, $this->name);
    }

    public function end_form_tag() {
        echo "</form>";
    }

    public function validate_form_fields() {
        //TODO: validate fields. 1. key index variable for html name attribute should be aplhanumeric
    }

    public function validate_form_input( array &$fields = [], array $request = [], bool &$valid = true ) {

        if ( !empty($fields) || (method_exists($this, 'form_fields') && ($fields = $this->form_fields()) && is_array($fields) && (count($fields) > 0)) ) {

            foreach ( $fields as $key => &$value ) {

                if ( !isset($value['type']) ) continue;

                if ( !isset($request[$key]) ) $request[$key] = array('');

                if ( is_array($value['type']) ) $valid = self::validate_form_input($value['type'], $request[$key], $valid);

                foreach ( (array) $request[$key] as $val ) {
                    if ( empty($val) && (isset($value['required']) && $value['required']) ) { $value['type_desc'] = "This field is required"; $valid = false; continue; }
                    if ( !empty($val) && isset($value['pattern']) && !preg_match($value['pattern'],$val) ) { $value['type_desc'] = 'This field does not match the pattern rule';  $valid = false; }
                }

            }

        }

        return $valid;
    }

    public function render( array $elements = [], string $id = null ) {

        if ( $elements || (method_exists($this, 'form_fields') && $elements = $this->form_fields()) ) {

            foreach ( (array) $elements as $key => $value ) {
                if ( !isset($value['type']) ) continue;
                if ( is_array($value['type'] ) ) {
                    $id = (!isset($id) || empty($id))?$key:$id.'['.$key.']';
                    self::render($value['type'], $id);
                } else {
                    parent::render( array($key=>$value), $id );
                }
            }
        }

    }

    public function __construct( string $method = self::METHOD_POST, string $action = "", string $enctype = self::ENCTYPE_A, string $id = 'myform',  string $name = 'myform', bool $ajax = false ) {

        parent::__construct();

        $this->method = $method;
        $this->action = $action;
        $this->enctype = $enctype;
        $this->id = $id;
        $this->name = $name;
        $this->ajax = $ajax;

    }

}