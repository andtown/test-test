<?php

/**
 * The Page View class
 *
 */


abstract class Page_View {

    abstract public function js();

    abstract public function css();

    abstract public function render();

    abstract public function load_page(); 

    abstract public function load_scripts();   

    abstract public function load_menu();

    abstract public function error_notices($note);

    abstract public function success_notices($note);   

}