<?php

class shout extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'shout/shout' );
    }
    
    function action() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		/*
		// user
		$user = $this->User_model->get_cookies();
		if ($user['is_login']) {
			$user = $this->User_model->get_by_id(array( 'email' => $user['email'], 'auto_insert' => true ));
		} else {
			$user = array();
		}
		
		$result = array( 'status' => false );
		if ($action == 'update') {
			if (empty($_POST['id'])) {
				$_POST['is_publish'] = 1;
				$_POST['shout_time'] = $this->config->item('current_datetime');
			}
			
			if (count($user) > 0) {
				$_POST['user_id'] = $user['id'];
			}
			
			// validation
			$_POST['shout'] = strip_tags($_POST['shout']);
			
			$result = $this->Comment_model->update($_POST);
			$result['status'] = true;
		}
		/*	*/
		
		echo json_encode($result);
    }
}