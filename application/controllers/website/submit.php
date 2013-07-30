<?php

class submit extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->load->view( 'website/submit' );
		}
    }
    
    function action() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		// user
		$is_login = $this->User_model->is_login();
		$user = $this->User_model->get_session();
		if (! $is_login) {
			$result = array( 'status' => false, 'message' => 'Session Anda sudah berakhir, silahkan login kembali.' );
			echo json_encode($result);
			exit;
		}
		
		$result = array( 'status' => false );
		if ($action == 'update') {
			$param = $_POST;
			$param['user_id'] = $user['id'];
			$param['post_type_id'] = POST_TYPE_SINGLE_LINK;
			$param['alias'] = $this->Post_model->get_name($param['name']);
			$param['create_date'] = $this->config->item('current_datetime');
			$param['publish_date'] = $this->config->item('current_datetime');
			$result = $this->Post_model->update($param);
			
			// post
			$post = $this->Post_model->get_by_id(array( 'id' => $result['id'] ));
			$result['redirect'] = $post['post_link'];
		}
		
		echo json_encode($result);
    }
}