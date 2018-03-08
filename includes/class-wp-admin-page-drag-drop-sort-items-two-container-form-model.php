<?php

/**
 * The WP Admin Page Drag Drop Sort Items Two Container Form Model class
 *
 */


 abstract class WP_Admin_Page_Drag_Drop_Sort_Items_Two_Container_Form_Model extends WP_Admin_Page_Generic_Form_Model {

    abstract public function html_elements();

    public function js() {
        return [
            "jquery-ui-sortable",
            "jquery-ui-draggable",
            "jquery-ui-droppable"
        ];
    }

    public function css() {
        return [];
    }   
    
    private function reserved_rec( array &$fields = [], array $data = [], &$output, string $id = null ) {

        foreach ( $data as $key => $value ) {
            if ( isset($fields[$key]) ) {
                if ( isset($fields[$key]['type'])  ) {
                    if ( is_array($fields[$key]['type']) )  { 
                        $id = (!isset($id) || empty($id))?$key:$id.'['.$key.']';
                        self::reserved_rec($fields[$key]['type'], $data[$key], $output,$id);                             
                    } else {       
                        ob_start(); 
                            $this->form_handler->render( array($key=>$fields[$key]), $id );
                        $output .= ob_get_clean(); 
                        // fields reference will be used later when looping for available items and to have more speed while looping we do unset reserved key when we found the reserved one
                        unset($fields[$key]);
                    }
                }
            }
        }

    }

    private function available_rec( array &$fields = [], string &$output = '', string $id = null ) {

        foreach ( $fields as $key => $value ) {

            if (!isset($value['type'])) continue; 
            if ( is_array($value['type']) ) { $id = (!isset($id) || empty($id))?$key:$id.'['.$key.']'; self::available_rec($value['type'],$output,$id); continue; };

            ob_start();
                $this->form_handler->render( array($key=>$value), $id );
            $output .= ob_get_clean(); 

        }

    }

    public function load_page() {

        parent::load_page();

        $this->available = $this->reserved = '';

        $fields = $this->fields; 

        self::reserved_rec($fields, $this->saved_data, $this->reserved);

        self::available_rec($fields, $this->available);    

    }

    public function body() {
        global $page_hook;
    }  

    public function render() {
        global $page_hook;
        $this->form_handler->render( [ ["type" => "advanced_form_items", "reserved" => &$this->reserved, "available" => &$this->available, "type_desc" => isset($this->fields['items']['type_desc'])?$this->fields['items']['type_desc']:'', "page_title" => &$this->page_title ] ] );
    }

}