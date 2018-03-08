<?php

/**
 * Test Admin Sub Page1 Class
 *
 */

class Test_Admin_Sub_Page1 extends WP_Admin_Page_Generic_Form_Model {

    protected static $instance;

    public $page_title = 'Admin Sub Page 1';
    public $menu_title = 'Admin Sub Page 1';
    public $parent_slug = 'test-admin-page';
    public $slug = 'test-admin-sub-page1';

    public function js() {
        return [
            "jquery-tags-input-js",        
            "test-js"
        ];
    }

    public function css() {
        return [
            "jquery-tags-input",        
            "test"
        ];
    }

    public function form_fields() {
        return apply_filters( $this->slug.'-page-settings-form-fields', [
                "required_numeric_pattern_input_tags" => [
                    "type" => "text",
                    "required" => true,
                    "pattern" => '/^(?:[0-9]+,?)+$/i',
                     "label" => "Required Numeric Pattern Input Tags",
                     "class" => "input-tags"
                ],
                "numeric_pattern_input_tags" => [
                    "type" => "text",
                    "pattern" => '/^(?:[0-9]+,?)+$/i',
                    "label" => "Numeric Pattern Input Tags",
                    "class" => "input-tags"
                ],                
                "required_checkbox" => [
                    "type" => "checkbox",
                    "options" => [
                        [ "label"=> "One", "value"=> 1 ],
                        [ "label"=> "Two", "value"=> 2 ],  
                    ],
                    "required" => true,
                    "label" => "Required Checkbox"                    
                ],              
                "required_numeric_pattern_text" => [
                    "type" => "text",
                    "pattern" => '/^[0-9]+$/i',
                    "required" => true,
                    "label" => "Required Numeric Pattern Text"
                ], 
                "required_text" => [
                    "type" => "text",
                    "required" => true,
                    "label" => "Required Text"
                ], 
                "email_pattern_text" => [
                    "type" => "text",
                    "pattern" => &Utilities::$email_regex_pattern,
                    "label" => "Email Pattern Text"
                ],  
                "required_dropdown" => [
                    "type" => "select",
                    "options" => [
                        [ "label" => "Select", "value" => "" ],
                        [ "label"=> "One", "value"=> "1" ],
                        [ "label"=> "Two", "value"=> "2" ],
                        [ "label"=> "Three", "value"=> "3" ],                        
                    ],
                    "required" => true,
                    "label" => "Required dropdown type"
                ]            
            ]
        );
    }

}