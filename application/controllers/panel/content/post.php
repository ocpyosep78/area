<?php
class post extends SUEKAREA_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'panel/content/post' );
    }
	
	function grid() {
		$result['rows'] = $this->Post_model->get_array($_POST);
		$result['count'] = $this->Post_model->get_count();
		
		echo json_encode($result);
	}
	
	function action() {
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		// user
		$user = $this->User_model->get_session();
		
		$result = array();
		if ($action == 'update') {
			if (empty($_POST['id'])) {
				$_POST['user_id'] = $user['id'];
				$_POST['create_date'] = $this->config->item('current_datetime');
			}
			
			$result = $this->Post_model->update($_POST);
		} else if ($action == 'get_by_id') {
			$result = $this->Post_model->get_by_id(array( 'id' => $_POST['id'] ));
		} else if ($action == 'delete') {
			$result = $this->Post_model->delete($_POST);
		}
		
		echo json_encode($result);
	}
	
	function view() {
		$this->load->view( 'panel/content/popup/post' );
	}
}