<?php

class comment extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'comment/comment' );
    }
    
    function action() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
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
				$_POST['comment_time'] = $this->config->item('current_datetime');
			}
			
			if (count($user) > 0) {
				$_POST['user_id'] = $user['id'];
			}
			
			// validation
			$_POST['comment'] = strip_tags($_POST['comment']);
			
			$result = $this->Comment_model->update($_POST);
			$result['status'] = true;
		}
		
		echo json_encode($result);
    }
}