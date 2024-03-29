<?php
class scrape extends SUEKAREA_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$this->load->view( 'panel/content/scrape' );
    }
	
	function grid() {
		$result['rows'] = $this->Scrape_Content_model->get_array($_POST);
		$result['count'] = $this->Scrape_Content_model->get_count();
		
		foreach ($result['rows'] as $key => $array) {
			unset($result['rows'][$key]['desc']);
			unset($result['rows'][$key]['download']);
			unset($result['rows'][$key]['link_source']);
			unset($result['rows'][$key]['image_source']);
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
			if (isset($_POST['desc']))
				$_POST['desc'] = clean_html_style($_POST['desc']);
			if (isset($_POST['download']))
				$_POST['download'] = trim($_POST['download']);
			
			$result = $this->Scrape_Content_model->update($_POST);
		}
		else if ($action == 'get_by_id') {
			$result = $this->Scrape_Content_model->get_by_id(array( 'id' => $_POST['id'] ));
		}
		else if ($action == 'delete') {
			$result = $this->Scrape_Content_model->delete($_POST);
		}
		else if ($action == 'do_scrape') {
			$scrape_master = $this->Scrape_Master_model->get_by_id(array( 'id' => $_POST['id'] ));
			$this->load->library('scrape/'.$scrape_master['library']);
			
			$insert_post = 0;
			$result['status'] = true;
			$array_post = $this->$scrape_master['library']->get_array($scrape_master);
			foreach ($array_post as $post) {
				$post_db = $this->Scrape_Content_model->get_by_id(array( 'link_source' => $post['link_source'] ));
				
				// checking
				if (isset($post['force_insert']) && $post['force_insert']) {
					$insert_record = true;
				} else if (count($post_db) > 0) {
					$insert_record = false;
				} else {
					$insert_record = true;
				}
				
				if ($insert_record) {
					$insert_post++;
					$result = $this->Scrape_Content_model->update($post);
				}
			}
			$result['message'] = 'New post : '.$insert_post.' from '.count($array_post).' total post';
		}
		else if ($action == 'publish') {
			$result['status'] = true;
			$scrape = $this->Scrape_Content_model->get_by_id(array( 'id' => $_POST['id'] ));
			if ($scrape['post_id'] == 0) {
				$param_post = $scrape;
				$param_post['id'] = 0;
				$param_post['user_id'] = $user['id'];
				$param_post['alias'] = $this->Post_model->get_name($param_post['name']);
				$param_post['create_date'] = $this->config->item('current_datetime');
				$param_post['publish_date'] = $this->config->item('current_datetime');
				$result = $this->Post_model->update($param_post);
				
				$param_scrape['id'] = $scrape['id'];
				$param_scrape['post_id'] = $result['id'];
				$this->Scrape_Content_model->update($param_scrape);
			}
		}
		else if ($action == 'unpublish') {
			$param_update['id'] = $_POST['id'];
			$param_update['post_id'] = -1;
			$result = $this->Scrape_Content_model->update($param_update);
		}
		
		echo json_encode($result);
	}
	
	function view() {
		$this->load->view( 'panel/content/popup/scrape' );
	}
}