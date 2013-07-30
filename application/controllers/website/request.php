<?php

class request extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->load->view( 'website/request' );
		}
    }
    
    function action() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array( 'status' => false );
		if ($action == 'update') {
			
		}
		
		echo json_encode($result);
    }
}