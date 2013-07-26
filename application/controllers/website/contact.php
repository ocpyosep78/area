<?php

class contact extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$method = (isset($this->uri->segments[2])) ? $this->uri->segments[2] : '';
		
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->load->view( 'website/contact' );
		}
    }
    
    function action() {
		$action = (!empty($_POST['action'])) ? $_POST['action'] : '';
		unset($_POST['action']);
		
		$result = array( 'status' => false );
		if ($action == 'update') {
			if (empty($_POST['id'])) {
				$_POST['message_time'] = $this->config->item('current_datetime');
			}
			
			// validation
			$_POST['message'] = strip_tags($_POST['message']);
			
			$result = $this->Contact_model->update($_POST);
			$result['status'] = true;
			
			$param_mail['to'] = 'info@suekarea.com';
			$param_mail['subject']  = 'Contact us';
			$param_mail['message']  = 'Name : '.$_POST['name'].'<br />';
			$param_mail['message'] .= 'Email : '.$_POST['email'].'<br />';
			$param_mail['message'] .= 'Website : '.$_POST['website'].'<br />';
			$param_mail['message'] .= 'Message : '.$_POST['message'].'<br />';
			$param_mail['message'] .= 'Time : '.$_POST['message_time'];
			sent_mail($param_mail);
		}
		
		echo json_encode($result);
    }
}