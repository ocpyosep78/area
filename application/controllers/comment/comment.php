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
		
		$result = array( 'status' => false );
		if ($action == 'update') {
			if (empty($_POST['id'])) {
				$_POST['is_publish'] = 1;
				$_POST['comment_time'] = $this->config->item('current_datetime');
			}
			
			$result = $this->Comment_model->update($_POST);
			$result['status'] = false;
		}
		
		echo json_encode($result);
    }
}