<?php

class rss extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$is_popular = get_popular();
		
		// post
		$param_post['not_draft'] = true;
		$param_post['is_popular'] = get_popular();
		$param_post['publish_date'] = $this->config->item('current_datetime');
		$param_post['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
		$param_post['limit'] = 20;
		$array_post = $this->Post_model->get_array($param_post);
		
		$rss_param['link'] = ($is_popular) ? base_url('rss') : base_url('rss/latest');
		$rss_param['title'] = ($is_popular) ? 'Suekarea - Popular Post' : 'Suekarea - Latest Post';
		$rss_param['array_item'] = $array_post;
		$rss_param['description'] = $rss_param['title'];
		$this->load->view( 'website/common/rss', $rss_param );
    }
}