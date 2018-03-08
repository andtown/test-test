<?php

/**
 *
 * The Page Controller class
 *
 */

abstract class Page_Controller {

    abstract public function manage_hooks();

    abstract public function parse_request( $reserved1, $reserved2, $reserved3 ); 

    abstract public function parse_page( &$reserved );
}