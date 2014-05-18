<?php

class ganool {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
		$curl = new curl();
		$array_item = array();
		$content = $curl->get($scrape['link']);
		$array_post = $this->get_array_clear($content);
		
		$array_result = array();
		foreach ($array_post as $array) {
			$array['title'] = trim($array['title']);
			
			// link
			$link_temp = $array['link'];
			$array_link = explode('?', $link_temp, 2);
			$link_source = $array_link[0];
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
			// make content clean
			$content_html = $curl->get($link_source);
			$content_html = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_html);
			
			// desc
			$desc = $this->get_desc($content_html);
			$thumbnail = $this->get_image($content_html);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $link_source;
			$temp['link_source'] = $link_source;
			$temp['thumbnail'] = $thumbnail;
			$temp['category_id'] = $scrape['category_id'];
			$temp['post_type_id'] = $scrape['post_type_id'];
			$temp['scrape_master_id'] = $scrape['id'];
			$temp['scrape_time'] = $this->CI->config->item('current_datetime');
			$array_result[] = $temp;
			
			// add limit
			if (count($array_result) >= 5) {
				break;
			}
		}
		
		return $array_result;
	}
	
	function get_array_clear($content) {
		$array_result = array();
		$array_content = new SimpleXmlElement($content);
		
		/*	
		// add link here
		$array_result[] = array('title' => 'Blame!', 'link' => 'http://ganool.com/blame');
		$array_result[] = array('title' => 'Biomega', 'link' => 'http://ganool.com/biomega');
		$array_result[] = array('title' => 'Blame Gakuen! And So On', 'link' => 'http://ganool.com/blame-gakuen-and-so-on');
		$array_result[] = array('title' => 'NOiSE', 'link' => 'http://ganool.com/noise');
		$array_result[] = array('title' => 'Bakuman', 'link' => 'http://ganool.com/bakuman');
		$array_result[] = array('title' => 'Astroboy', 'link' => 'http://ganool.com/astroboy');
		$array_result[] = array('title' => 'Age of Dinosaurs (2013) BluRay 1080p 5.1CH x264 Ganool', 'link' => 'http://ganool.com/age-of-dinosaurs-2013-bluray-1080p-5-1ch-x264-ganool');
		$array_result[] = array('title' => 'Ragin Cajun Redneck Gators (2013) TVRip 400MB Ganool', 'link' => 'http://ganool.com/ragin-cajun-redneck-gators-2013-tvrip-400mb-ganool');
		/*	*/
		
		foreach ($array_content->channel->item as $array_temp) {
			$array_temp = (array)$array_temp;
			unset($array_temp['category']);
			unset($array_temp['comments']);
			unset($array_temp['description']);
			
			$array_result[] = (array)$array_temp;
		}
		
		return $array_result;
	}
	
	function get_desc($content_raw) {
		$result = '';
		$content = $content_raw;
		
		// remove start offset
		$offset = '<!-- .entry-meta -->';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = 'Watch Trailer';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// clean desc
		$content = strip_tags($content);
		$temp = trim(preg_replace('/info: [\w\:\/\.]+/i', '', $content));
		
		// normal post
		if (!empty($temp)) {
			$array_temp = explode("\n", $temp);
			foreach ($array_temp as $line) {
				$result .= '<div>'.$line.'</div>';
			}
		}
		
		// anime condition
		if (empty($result)) {
			// retrive content
			$content = preg_replace('/src=/i', 'nosrc=', $content_raw);
			
			// remove start offset
			$offset = '<div class="entry-content">';
			$pos_first = strpos($content, $offset);
			$content = substr($content, $pos_first, strlen($content) - $pos_first);
			
			// remove end offset
			$offset = 'crp_related';
			$pos_end = strpos($content, $offset);
			$content = substr($content, 0, $pos_end);
			
			// remove download link
			$offset = 'spoiler-body';
			$pos_end = strpos($content, $offset);
			if ($pos_end === false) {
				$result = preg_replace('/ (class|alt|title|src|href|onclick)="[^\"]+"/i', '', $content);
			} else {
				$result = substr($content, 0, $pos_end);
			}
		}
		
		// endfix
		if (!empty($result)) {
			$result .= '<br /><div>Sumber : Ganool</div>';
		}
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/ (title|style|alt|border|height|width)="[^"]*"/i', '', $content);
		
		// get link image
		preg_match('/class="alignleft( wp-[a-z0-9\-]+)*" src="([^"]+)"/i', $content, $match);
		$result = (isset($match[2]) && !empty($match[2])) ? $match[2] : '';
		
		// write image
		if (!empty($result)) {
			$download_result = download_image($result);
			if ($download_result['status']) {
				$result = $download_result['dir_image_path'];
			}
		}
		
		return $result;
	}
}
