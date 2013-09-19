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
		
		// user
		$user = $this->User_model->get_cookies();
		if ($user['is_login']) {
			$user = $this->User_model->get_by_id(array( 'email' => $user['email'] ));
		} else {
			$user = array();
		}
		
		// action
		$result = array( 'status' => false );
		if ($action == 'sent_shout') {
			if (empty($_POST['id'])) {
				$_POST['is_publish'] = 1;
				$_POST['shout_time'] = $this->config->item('current_datetime');
			}
			
			// override user name for login user
			if (count($user) > 0) {
				$_POST['user_name'] = $user['fullname'];
			}
			
			// validation & update
			$_POST['message'] = strip_tags($_POST['message']);
			$result = $this->Shout_Content_model->update($_POST);
			
			// get latest shout
			$result['status'] = true;
			$result['array_shout'] = $this->Shout_Content_model->get_array(array( 'last_id' => $_POST['last_id'] ));
		} else if ($action == 'refresh') {
			$result['status'] = true;
			$result['array_shout'] = $this->Shout_Content_model->get_array(array( 'last_id' => $_POST['last_id'] ));
		}
		
		echo json_encode($result);
    }
}