<?php

class request extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		// check request
		$request = array();
		preg_match('/(\d{4}\/\d{2}\/\d{2})\/([\w\-]+)$/i', $_SERVER['REQUEST_URI'], $match);
		if (isset($match[2])) {
			$request = $this->Request_model->get_by_id(array( 'request_time' => $match[1], 'alias' => $match[2] ));
		}
		
		if (count($request) > 0) {
			$this->load->view( 'website/request_detail', array( 'request' => $request ) );
		} else if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->load->view( 'website/request' );
		}
    }
    
	function board() {
		$this->load->view( 'website/request_board' );
	}
	
    function action() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		// user
		$is_login = $this->User_model->is_login();
		$user = $this->User_model->get_session();
		$allow_request = ($is_login) ? $this->Request_model->allow_request(array( 'user_id' => $user['id'] )) : false;
		
		if (! $is_login) {
			$result = array( 'status' => false, 'message' => 'Session Anda sudah berakhir, silahkan login kembali.' );
			echo json_encode($result);
			exit;
		} else if (! $allow_request) {
			$result = array( 'status' => false, 'message' => 'Anda sudah mengirimkan request hari ini, harap mengirim request lagi besok.' );
			echo json_encode($result);
			exit;
		}
		
		$result = array( 'status' => false );
		if ($action == 'update') {
			$param = $_POST;
			$param['user_id'] = $user['id'];
			$param['alias'] = get_name($param['name']);
			$param['desc'] = nl2br(strip_tags($param['desc']));
			$param['request_time'] = $this->config->item('current_datetime');
			$param['status'] = 'Ongoing';
			$result = $this->Request_model->update($param);
			
			// post
			$request = $this->Request_model->get_by_id(array( 'id' => $result['id'] ));
			$result['redirect'] = $request['request_link'];
			
			$param_mail['to'] = 'info@suekarea.com';
			$param_mail['subject'] = '[Request] '.$param['name'];
			$param_mail['message'] = $_POST['desc'];
			sent_mail($param_mail);
		}
		
		echo json_encode($result);
    }
}