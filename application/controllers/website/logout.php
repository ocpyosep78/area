<?php

class logout extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->User_model->del_session();
		header("Location: ".base_url());
		exit;
    }
}