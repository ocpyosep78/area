<?php

class ajax extends CI_Controller {
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
	
    function view() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		if ($action == 'view_download') {
			$post = $this->Post_model->get_by_id(array( 'id' => $_POST['id'] ));
			$this->load->view( 'website/ajax/view_download', array( 'post' => $post ) );
		}
    }
}