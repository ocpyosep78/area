<?php

class oplovers {
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
			
			// collect
			$content_html = $this->get_content($array['link']);
			$desc = $this->get_desc($content_html, $array['title']);
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
		$offset = "<div class='post-outer'>";
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<script type="text/javascript">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		preg_match_all("/<h3><a href='([^']+)'>([^<]+)<\/a>/i", $content, $match);
		foreach ($match[0] as $key => $value) {
			if (!empty($match[1][$key]) && $match[2][$key]) {
				$array_temp = array( 'link' => $match[1][$key], 'title' => $match[2][$key] );
				if ($array_temp['link'] == 'http://www.oploverz.net/ps03-polo-heart-pirates-ready-stock/') {
					continue;
				}
				
				$array_result[] = $array_temp;
			}
		}
		
		return $array_result;
	}
	
	function get_content($link_source) {
		// get html content
		$curl = new curl();
		$content_html = $curl->get($link_source);
		$content_html = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_html);
		
		// remove start offset
		$offset = '<div class="post-body">';
		$pos_first = strpos($content_html, $offset);
		$content_html = substr($content_html, $pos_first, strlen($content_html) - $pos_first);
		
		// remove end offset
		$offset = "http://www.oploverz.net/2012/11/frequently-asked-questions.html";
		$pos_end = strpos($content_html, $offset);
		$content_html = substr($content_html, 0, $pos_end);
		
		return $content_html;
	}
	
	function get_desc($content, $title = '') {
		$content = preg_replace('/\<blink[\x20-\x7E|\x0A]+/i', '', $content);
		$content = preg_replace('/\Jadwal Rilis OPLOVERZ bisa dilihat di[\x20-\x7E|\x0A]+/i', '', $content);
		$content = strip_tags($content);
		$content = str_replace('&nbsp;', ' ', $content);
		$content = trim(preg_replace('/[\n]+/i', "\n", $content));
		
		$result = '';
		$array_temp = explode("\n", $content);
		foreach ($array_temp as $line) {
			$line = (empty($line)) ? '&nbsp;' : trim($line);
			
			// remove symbol
			if ($line == '//') {
				continue;
			}
			
			// append result
			if (!empty($line)) {
				$result .= '<div>'.$line.'</div>';
			}
		}
		
		// check default title
		if (empty($result) && !empty($title)) {
			$result .= "<div>$title</div>";
		}
		
		// endfix
		if (!empty($result)) {
			$result .= '<br /><div>Sumber : Oplovers</div>';
		}
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/ (style|alt|border|height|width)="[^"]*"/i', '', $content);
		
		// get link image
		preg_match('/image-thumb">\s*<img src="([^"]+)"/i', $content, $match);
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
