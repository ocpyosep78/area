<?php

class ajax extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->ajax();
		}
    }
	
    function view() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		if ($action == 'view_download') {
			$post = $this->Post_model->get_by_id(array( 'id' => $_POST['id'] ));
			$this->load->view( 'website/ajax/view_download', array( 'post' => $post ) );
		} else if ($action == 'view_login') {
			$this->load->view( 'website/ajax/view_login' );
		} else if ($action == 'view_registration') {
			$this->load->view( 'website/ajax/view_registration' );
		}
    }
	
	function user() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array( 'status' => false );
		if ($action == 'register') {
			$user = $this->User_model->get_by_id(array( 'email' => $_POST['email'] ));
			if (count($user) > 0) {
				$result['message'] = 'Email Anda sudah terdaftar, silahkan login.';
				echo json_encode($result);
				exit;
			}
			
			$param = $_POST;
			$param['is_active'] = 1;
			$param['user_type_id'] = USER_TYPE_MEMBER;
			$param['register_date'] = $this->config->item('current_datetime');
			$param['passwd'] = EncriptPassword($param['passwd']);
			$result = $this->User_model->update($param);
			
			// set user
			$result['status'] = true;
			$user = $this->User_model->get_by_id(array( 'id' => $result['id'] ));
			$this->User_model->set_session($user);
		}
		else if ($action == 'login') {
			$user = $this->User_model->get_by_id(array( 'email' => $_POST['email'] ));
			if (count($user) == 0) {
				$result['message'] = 'Email Anda tidak terdaftar, silahkan register.';
			} else if (empty($user['is_active'])) {
				$result['message'] = 'Maaf, user Anda tidak aktif, mohon menghubungi Admin untuk pengaktifan kembali.';
			} else if ($user['passwd'] != EncriptPassword($_POST['passwd'])) {
				$result['message'] = 'Password Anda tidak sama, harap isikan password yang benar.';
			} else {
				$result['status'] = true;
				$this->User_model->set_session($user);
			}
		}
		
		echo json_encode($result);
	}
}