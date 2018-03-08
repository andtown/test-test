<?php

/**
 * WP Admin Page Advanced Form class
 *
 */


class WP_Admin_Page_Advanced_Form extends WP_Admin_Page_Drag_Drop_Sort_Items_Two_Container_Form_Model {

    public function js() {
        $js = parent::js();
        $js[] = "test-js";
        return $js;
    }

    public function html_elements() {
        return apply_filters( $this->slug.'-page-settings-form-fields', [
                "non_field" => [
                    "type" => "advanced_form_items"
                ]
            ]
        );
    ?>
    <?php
    }

    public function form_fields() {
        return apply_filters( $this->slug.'-page-settings-form-fields', [
                "items" => [
                    "type" => [
                        "items1" => [
                            "type" => "advanced_form_checkbox",
                            "label" => "Items 1",
                            "options" => [
                                ["label" => "Option 1", "value" => "1"],
                                ["label" => "Option 2", "value" => "2"],
                                ["label" => "Option 3", "value" => "3"],
                                ["label" => "Option 4", "value" => "4"]
                            ],
                        ],   
                        "items2" => [
                            "label" => "Items 2",
                            "type" => "advanced_form_hidden"
                        ],
                        "items3" => [
                            "type" => "advanced_form_text",
                            "label" => "Items 3",
                            "options" => [
                                [ "label" => "Text", "value" => "" ]
                            ]
                        ]
                    ],
                    "required" => true
                ]
            ]
        );
    }    

}