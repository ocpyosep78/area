<?php

class widget extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->ajax();
		}
    }
	
	function popular() {
		$this->load->view( 'website/widget/popular' );
	}
}