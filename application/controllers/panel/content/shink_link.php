<?php
class shink_link extends SUEKAREA_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'panel/content/shink_link' );
    }
	
	function action() {
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array();
		if ($action == 'convert') {
			// load library
			$link_short = $this->Link_Short_model->get_by_id(array( 'id' => $_POST['id'] ));
			$this->load->library($link_short['library']);
			
			$array_result = array();
			$array_link = explode("\n", $_POST['link_from']);
			foreach ($array_link as $line) {
				$line = trim($line);
				
				if (is_valid_link($line)) {
					$array_result[] = $this->$link_short['library_name']->convert($link_short, $line);
				} else {
					$array_result[] = $line;
				}
			}
			
			$result['status'] = true;
			$result['message'] = implode("\n", $array_result);
		}
		
		echo json_encode($result);
	}
	
	/*
	function grid() {
		$result['rows'] = $this->Contact_model->get_array($_POST);
		$result['count'] = $this->Contact_model->get_count();
		
		echo json_encode($result);
	}
	
	function view() {
		$this->load->view( 'panel/content/popup/shink_link' );
	}
	/*	*/
}