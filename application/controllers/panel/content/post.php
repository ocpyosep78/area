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
		
		foreach ($result['rows'] as $key => $array) {
			unset($result['rows'][$key]['alias']);
			unset($result['rows'][$key]['desc']);
			unset($result['rows'][$key]['download']);
			unset($result['rows'][$key]['desc_limit']);
			unset($result['rows'][$key]['array_download']);
			unset($result['rows'][$key]['thumbnail_link']);
			unset($result['rows'][$key]['thumbnail_small_link']);
		}
		
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
			if (isset($_POST['desc'])) {
				$_POST['desc'] = clean_html_style($_POST['desc']);
			}
			
			$result = $this->Post_model->update($_POST);
		} else if ($action == 'get_by_id') {
			$result = $this->Post_model->get_by_id(array( 'id' => $_POST['id'], 'tag_include' => true ));
		} else if ($action == 'delete') {
			$result = $this->Post_model->delete($_POST);
		}
		
		echo json_encode($result);
	}
	
	function view() {
		$this->load->view( 'panel/content/popup/post' );
	}
}