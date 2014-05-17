<?php

class cupux_movie {
    function __construct() {
        $this->CI =& get_instance();
		$this->is_index = true;
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
		
		/*	
		// add link here
		$array_result[] = array('title' => 'Amy (2013) DVDRip', 'link' => 'http://www.cupux-movie.com/2013/10/amy-2013-dvdrip.html');
		/*	*/
		
		if (isset($this->is_index) && $this->is_index) {
			// remove start offset
			$offset = "<div class='main section' id='main'><div class='widget Blog' id='Blog1'>";
			$pos_first = strpos($content, $offset);
			$content = substr($content, $pos_first, strlen($content) - $pos_first);
			
			// remove end offset
			$offset = "<!--Page Navigation Starts-->";
			$pos_end = strpos($content, $offset);
			$content = substr($content, 0, $pos_end);
			
			preg_match_all('/h3 (class)=\'[^\']+\'>\s*<a href=\'([^\']+)\'>([^\<]+)<\/a>/i', $content, $match);
			foreach ($match[0] as $key => $value) {
				$link = trim($match[2][$key]);
				$title = trim($match[3][$key]);
				$array_result[] = array('title' => $title, 'link' => $link);
			}
		} else {
			$array_content = new SimpleXmlElement($content);
			foreach ($array_content->channel->item as $array_temp) {
				$array_temp = (array)$array_temp;
				unset($array_temp['category']);
				unset($array_temp['description']);
				
				$array_result[] = (array)$array_temp;
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
		$offset = "<div class='post-body entry-content'>";
		$pos_first = strpos($content_html, $offset);
		$content_html = substr($content_html, $pos_first, strlen($content_html) - $pos_first);
		
		// remove end offset
		$offset = "<div style='float:right;padding-right:10px;'>";
		$pos_end = strpos($content_html, $offset);
		$content_html = substr($content_html, 0, $pos_end);
		
		return $content_html;
	}
	
	function get_desc($content) {
		$result = '';
		
		// remove start offset
		$offset = '<div class="product_describe">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<iframe allowfullscreen=""';
		$pos_end = strpos($content, $offset);
		if ($pos_end === false) {
			$offset = "<a class='addthis_button_tweet'>";
			$pos_end = strpos($content, $offset);
			$content = substr($content, 0, $pos_end);
		} else {
			$content = substr($content, 0, $pos_end);
		}
		
		// set display
		$content = str_replace(array('&nbsp;'), array(''), $content);
		$result = nl2br(trim(strip_tags($content)));
		$result = preg_replace('/(<br \/>\s){2,}/i', "<br /><br />\n", $result);
		
		// remove 'Watch Trailer'
		$result = str_replace(':: Watch Trailer ::', '', $result);
		
		// generate endfix
		if (!empty($result)) {
			$result .= '<div></div>';
			$result .= '<div>Sumber : Cupux Movie</div>';
		}
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/ (style|alt|border|height|width)="[^"]*"/i', '', $content);
		
		// get image link
		preg_match('/"item_thumb" src="([^"]+)"/i', $content, $match);
		$result = (isset($match[1])) ? $match[1] : '';
		
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
