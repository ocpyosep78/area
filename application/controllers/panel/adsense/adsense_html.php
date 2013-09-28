<?php
class adsense_html extends SUEKAREA_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'panel/adsense/adsense_html' );
    }
	
	function grid() {
		$result['rows'] = $this->Adsense_Html_model->get_array($_POST);
		$result['count'] = $this->Adsense_Html_model->get_count();
		
		echo json_encode($result);
	}
	
	function action() {
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array();
		if ($action == 'update') {
			if (empty($_POST['id'])) {
				$_POST['create_date'] = $this->config->item('current_datetime');
			}
			
			$result = $this->Adsense_Html_model->update($_POST);
		} else if ($action == 'get_by_id') {
			$result = $this->Adsense_Html_model->get_by_id(array( 'id' => $_POST['id'] ));
		} else if ($action == 'delete') {
			$result = $this->Adsense_Html_model->delete($_POST);
		}
		
		echo json_encode($result);
	}
	
	function view() {
		$this->load->view( 'panel/adsense/popup/adsense_html' );
	}
}