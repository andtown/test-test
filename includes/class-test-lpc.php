<?php

/**
 * Test Landing Page Controller class
 *
 */

class Test_LPC extends WP_Landing_Page_Controller {

    public static $page_post_type = 'landingpagectrl';
    public static $page_post_content = '[landing_page_controller]';
    public static $instance;

    public function reserved_pages() {
        return [
            'first-page',
            'second-page',
            'third-page',
        ];
    }

    public function rewrite_rules() {
        return apply_filters('landing_page_rewrite_rules', [
            "(first-page|second-page|third-page)(?:/([0-9]+))?/?$" => 'page=$matches[2]&template=$matches[1]',                       
            "((first-page)/([^/]+?(?:\-([0-9]+))?))(?:/([0-9]+))?/?$" => 'slug=$matches[3]&template=$matches[2]&id=$matches[4]&page=$matches[5]&is_first_page=1',
            "((second-page)/([^/]+?(?:\-([0-9]+))?))(?:/([0-9]+))?/?$" => 'slug=$matches[3]&template=$matches[2]&id=$matches[4]&page=$matches[5]&is_second_page=1',
            "((third-page)/([^/]+?(?:\-([0-9]+))?))(?:/([0-9]+))?/?$" => 'slug=$matches[3]&template=$matches[2]&id=$matches[4]&page=$matches[5]&is_third_page=1',
            "([0-9]+)(?:/([0-9]+))?/?$" => 'page=$matches[2]&slug=$matches[1]&property_id=$matches[1]&is_property_page=1',
            "([^/]+?(?:\-([0-9]+))?)(?:/([0-9]+))?/?$" => 'slug=$matches[1]&page=$matches[3]&property_id=$matches[2]&is_property_page=1'
        ]);
    }

}