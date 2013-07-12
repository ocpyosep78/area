<?php
class mail extends SUEKAREA_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'panel/user/mail' );
    }
	
	function action() {
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array();
		if ($action == 'sent_mail') {
			sent_mail($_POST);
			@mail($param['to'], $param['title'], $param['message'], $headers);
			$result['status'] = true;
			$result['message'] = 'Email berhasil terkirim';
		}
		
		echo json_encode($result);
	}
}