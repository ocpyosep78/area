<?php

class widget extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		$this->$method();
    }
	
	function popular() {
		$this->load->view( 'website/widget/popular' );
	}
	
	function submit() {
		$this->load->view( 'website/widget/submit' );
	}
}