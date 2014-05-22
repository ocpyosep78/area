<?php

class icinema3satu {
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
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $array['link'] ));
			if (count($check) > 0) {
				continue;
			}
			
			$content_html = $this->get_content($array['link']);
			$desc = $this->get_desc($content_html);
			$thumbnail = $this->get_image($content_html);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $array['link'];
			$temp['link_source'] = $array['link'];
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
		
		// remove start offset
		$offset = '<div id="content">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<div id="loop-nav-numeric" class="nav-numeric">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		preg_match_all('/href="([^"]+)" title="[^"]+" rel="bookmark">([^<]+)<\/a><\/h2>/i', $content, $match);
		foreach ($match[0] as $key => $value) {
			if (!empty($match[1][$key]) && $match[2][$key]) {
				$array_temp = array( 'link' => $match[1][$key], 'title' => ucwords(strtolower($match[2][$key])) );
				$array_result[] = $array_temp;
			}
		}
		
		return $array_result;
	}
	
	function get_content($link_source) {
		$curl = new curl();
		$content = $curl->get($link_source);
		$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
		
		// remove start offset
		$offset = '<div id="content">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<div class="entry-meta-bottom">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		return $content;
	}
	
	function get_desc($content) {
		// remove start offset
		$offset = '<div class="entry-content clearfix">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// make nice format
		$content = trim(strip_tags($content));
		$array_temp = explode("\n", $content);
		foreach ($array_temp as $key => $line) {
			if (empty($line)) {
				unset($array_temp[$key]);
			}
		}
		$result = implode('<br />', $array_temp);
		
		// endfix
		if (!empty($result)) {
			$result .= '<br /><br /><div>Sumber : iCinema3satu</div>';
		}
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/ (style|alt|border|height|width)="[^"]*"/i', '', $content);
		
		// get link image
		preg_match('/class="entry-content clearfix">\s*<p><img src="([^"]+)"/i', $content, $match);
		$result = (isset($match[1]) && !empty($match[1])) ? $match[1] : '';
		
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