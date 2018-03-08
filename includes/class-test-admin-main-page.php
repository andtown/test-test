<?php

/**
 * Test Admin Main Page
 *
 */

class Test_Admin_Main_Page extends WP_Admin_Page_Generic_HTML_Model {

    protected static $instance;

    public $page_title = 'Test Admin Page';
    public $menu_title = 'Test Admin Page';
    public $parent_slug = null;
    public $slug = 'test-admin-page';

    public function js() {
        return [];
    }

    public function css() {
        return [];
    }  

    protected function html_elements() {
        return apply_filters( $this->slug.'-page-settings-form-fields', [
                "upper_heading_section" => [
                    "type" => "heading",
                    "label" => "List of Shortcodes"
                ],
                "upper_section" => [
                    "type" => "shortcodes_list"
                ]
            ]
        );
    }

}
