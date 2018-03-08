<?php

/**
 * The Test Options class
 *
 */

class Test_Options extends WP_Options {

    protected static $instance;

    protected $id = 'test_settings';

    public static function is_empty_settings() {
        return empty(static::get_instance()->data);
    } 

    public static function setup_test_options_default_data() {
        //TODO: save default settings data in json format so it can be loaded from file.
        $data = [
            "test-admin-sub-page1" => [
                "required_numeric_pattern_input_tags" => 123,
                "numeric_pattern_input_tags" => 456,
                "required_checkbox" => [
                    "1", "2"
                ],
                "required_numeric_pattern_text" => 10,
                "required_text" => "Hello World!!",
                "email_pattern_text" => "someone@somewhere.something",
                "required_dropdown" => 1
            ],
            "test-admin-sub-page2" => [
                "required_numeric_pattern_text" => "123456",
                "required_textarea" => "%tag_10% %tag_5%, %tag_3% %tag_7% ,  %tag_4%, %tag_1% %tag_6%, %tag_2% %tag_8%",
            ],
            "test-admin-sub-page3" => [
                "items" => [
                    "items1" => [
                        "2", "3"
                    ],
                    "items2" => "selected_item",
                ]
            ],
            "test-admin-sub-page4" => [
                "items" => [
                    "items2" => [
                        "selected_item"
                    ],
                    "items3" => [ "Hello World", "selected_item" ],
                ]
            ]             
        ];

        static::get_instance()->add($data)->save();
    }

}