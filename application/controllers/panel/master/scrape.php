<?php
class scrape extends SUEKAREA_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'panel/master/scrape' );
    }
	
	function grid() {
		$result['rows'] = $this->Scrape_Master_model->get_array($_POST);
		$result['count'] = $this->Scrape_Master_model->get_count();
		
		echo json_encode($result);
	}
	
	function action() {
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array();
		if ($action == 'update') {
			$result = $this->Scrape_Master_model->update($_POST);
		} else if ($action == 'get_by_id') {
			$result = $this->Scrape_Master_model->get_by_id(array( 'id' => $_POST['id'] ));
		} else if ($action == 'delete') {
			$result = $this->Scrape_Master_model->delete($_POST);
		}
		
		echo json_encode($result);
	}
	
	function view() {
		$this->load->view( 'panel/master/popup/scrape' );
	}
}