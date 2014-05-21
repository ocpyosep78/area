<?php

class update_post extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		// get scrape master
		$scrape_master = $this->Scrape_Master_model->get_by_id(array( 'order_by_latest' => true ));
		$this->load->library('scrape/'.$scrape_master['library']);
		
		// update scrape master
		$param_update['id'] = $scrape_master['id'];
		$param_update['last_update'] = $this->config->item('current_datetime');
		$this->Scrape_Master_model->update($param_update);
		
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
		
		// show result
		echo $scrape_master['name'].' : New post : '.$insert_post.' from '.count($array_post).' total post';
    }
}