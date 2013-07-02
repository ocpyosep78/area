<?php

class home extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->load->view( 'panel/home');
	}
	
	function check() {
		$ArrayMenu = array(
			0 => array( 'Link' => '/administrator/entry/jemaat', 'Title' => 'Jemaat' ),
			1 => array( 'Link' => '/administrator/entry/keluarga', 'Title' => 'Keluarga' ),
			2 => array( 'Link' => '/administrator/entry/gereja', 'Title' => 'Gereja' ),
			3 => array( 'Link' => '/administrator/entry/user', 'Title' => 'User' ),
			4 => array( 'Link' => '/administrator/entry/group', 'Title' => 'Group' )
		);
		echo json_encode( array( 'success' => true, 'menu' => $ArrayMenu ));
		exit;
		
		/*
		// cek apakah user login atau ga, kalau login, berikan menu dia, dalam format HTML
		if ( $UserAdmin = $this->session->userdata('UserAdmin') ) {
			$ArrayMenu = $this->M_User->GetArrayMenu();
			$ArrayMenu = array_values($ArrayMenu);
			
			echo json_encode( array( 'success' => true, 'menu' => $ArrayMenu ));
			return;
		}
		/* */
        
		show_error("Not logged in", 403);
	}
	
	function login() {
		$Data['message'] = '';
		
		$Admin = array( 'name' => 'sadasd' );
		
		$ArrayMenu = array(
			0 => array( 'Link' => '/administrator/entry/jemaat', 'Title' => 'Jemaat' ),
			1 => array( 'Link' => '/administrator/entry/keluarga', 'Title' => 'Keluarga' ),
			2 => array( 'Link' => '/administrator/entry/gereja', 'Title' => 'Gereja' ),
			3 => array( 'Link' => '/administrator/entry/user', 'Title' => 'User' ),
			4 => array( 'Link' => '/administrator/entry/group', 'Title' => 'Group' )
		);
		
		
		echo json_encode( array( 'success' => true, 'menu' => $ArrayMenu, 'UserAdmin' => $Admin ));
		exit;
		
		if (isset($_POST['username'])) {
//			$Admin = $this->M_User->GetByID(array('username' => $_POST['username']));
			$Admin = array( 'name' => 'sadasd' );
			
			if (count($Admin) == 0) {
				$Data['message'] = 'Maaf, user tidak ditemukan';
			} else {
				$password = (isset($_POST['password'])) ? $_POST['password'] : '';
				if ($Admin['password'] == md5($password)) {
					$this->session->set_userdata(array('UserAdmin' => $Admin));
					
					// Update Last Login
					$ParamAdmin = $Admin;
					$ParamAdmin['last_login'] = $this->config->item('current_time');
					$this->M_User->UpdateLogin($ParamAdmin);
					/* */
					
					// X-Requested-With
					if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
						unset($Admin['AdminPassWord']);
						$ArrayMenu = $this->M_User->GetArrayMenu();
						echo json_encode( array( 'success' => true, 'menu' => $ArrayMenu, 'UserAdmin' => $Admin ));
						return;
					}
					
					$LinkRedirect = $this->M_User->GetAdminRedirectPage($Admin);
					header("Location: " . $LinkRedirect); exit;
				}
			}
		}
                
		if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
			echo json_encode(array('success'=>false,'text'=>$Data['message']));
			return;
		}
		
		$this->load->view('administrator/home');
	}
	
	function dashboard() {
		echo 'asd';
	}
}