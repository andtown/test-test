<?php

/**
 * Test Admin Sub Page2 class
 *
 */

class Test_Admin_Sub_Page2 extends WP_Admin_Page_Generic_Form_Model {

    protected static $instance;

    public $page_title = 'Admin Sub Page 2';
    public $menu_title = 'Admin Sub Page 2';
    public $parent_slug = 'test-admin-page';
    public $slug = 'test-admin-sub-page2';

    public function js() {
        return [];
    }

    public function css() {
        return [];
    }

    public function form_fields() {
        return apply_filters( $this->slug.'-page-settings-form-fields', [
            "non_input_field" => [
                "type" => "available_tags",
                "label" => "Tags",
                "label_desc" => "Below are a list of available tags you can use."
            ],            
            "required_numeric_pattern_text" => [
                "type" => "text",
                "required" => true,
                "label" => "Required Text",
                "label_desc" => "(Put field description here..)",
                "wrapper_left_width" => "25%",
                "wrapper_right_width" => "75%",
                "pattern" => "/^[0-9]+$/i"
            ],                
            "required_textarea" => [
                "type" => "textarea",
                "required" => true,
                "label" => "Required Textarea",
                "wrapper_left_width" => "25%",
                "wrapper_right_width" => "75%",
                "rows" => 5                  
            ]
        ]      
        );
    }   

}