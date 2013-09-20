<?php

class cupux_movie {
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
			$desc = $this->get_desc($content_html);
			$download = $this->get_download($content_html);
			$image_source = $this->get_image($content_html);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $download;
			$temp['link_source'] = $array['link'];
			$temp['image_source'] = $image_source;
			$temp['category_id'] = $scrape['category_id'];
			$temp['post_type_id'] = $scrape['post_type_id'];
			$temp['scrape_master_id'] = $scrape['id'];
			$temp['scrape_time'] = $this->CI->config->item('current_datetime');
			$array_result[] = $temp;
			
			// add limit
			if (count($array_result) >= 4) {
				break;
			}
		}
		
		return $array_result;
	}
	
	function get_array_clear($content) {
		$array_result = array();
		$array_content = new SimpleXmlElement($content);
		
		/*	*/
		// add link here
		$array_result[] = array('title' => 'Rockin\' on Heaven\'s Door (2013) HDRip [korea]', 'link' => 'http://www.cupux-movie.com/2013/09/rockin-on-heavens-door-2013-hdrip-korea.html');
		$array_result[] = array('title' => 'An Ordinary Love Story (2012) DVDRip [Thailand]', 'link' => 'http://www.cupux-movie.com/2013/09/an-ordinary-love-story-2012-dvdrip.html');
		$array_result[] = array('title' => 'Sorry Saranghaeyo (2010) DVDRip [thailand]', 'link' => 'http://www.cupux-movie.com/2013/09/sorry-saranghaeyo-2010-dvdrip-thailand.html');
		$array_result[] = array('title' => 'Pai In Love (2012) DVDRip [thailnad]', 'link' => 'http://www.cupux-movie.com/2013/09/pai-in-love-2012-dvdrip-thailnad.html');
		/*	*/
		
		foreach ($array_content->channel->item as $array_temp) {
			$array_temp = (array)$array_temp;
			unset($array_temp['category']);
			unset($array_temp['description']);
			
			$array_result[] = (array)$array_temp;
		}
		
		return $array_result;
	}
	
	function get_content($link_source) {
		// get html content
		$curl = new curl();
		$content_html = $curl->get($link_source);
		$content_html = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_html);
		
		// remove start offset
		$offset = 'post-body-';
		$pos_first = strpos($content_html, $offset);
		$content_html = "<div class='".substr($content_html, $pos_first, strlen($content_html) - $pos_first);
		
		// remove end offset
		$offset = "<div class='post-footer'>";
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
		$content = substr($content, 0, $pos_end);
		
		// set display
		$content = str_replace(array('&nbsp;'), array(''), $content);
		$result = nl2br(trim(strip_tags($content)));
		
		// generate endfix
		if (!empty($result)) {
			$result .= '<div></div>';
			$result .= '<div>Sumber : Cupux Movie</div>';
		}
		
		return $result;
	}
	
	function get_download($content) {
		$result = '';
		
		// default link
		preg_match_all('/<a href="([^"]+)" target="_blank">(Direct|Download|Part[^\<]+)/i', $content, $match);
		if (isset($match[1])) {
			$array_download = array();
			foreach ($match[1] as $key => $link) {
				$link_temp = parse_url($link);
				$array_download[] = $link.' '.$match[2][$key].' Link : '.$link_temp['host'];
			}
			$result = implode("\n", $array_download);
		}
		
		return $result;
	}
	
	function get_image($content) {
		preg_match('/class=\"item_thumb\" oncontextmenu=\"return false;\" src=\"([^\"]+)\"/i', $content, $match);
		$result = (isset($match[1])) ? $match[1] : '';
		
		return $result;
	}
}
