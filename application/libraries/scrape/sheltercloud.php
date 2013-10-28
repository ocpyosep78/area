<?php

class sheltercloud {
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
			$link_source = $array['link'];
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
			$content_html = $this->get_content($link_source);
			$desc = $this->get_desc($content_html);
			$download = $this->get_download($content_html);
			$image_source = $this->get_image($content_html);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $download;
			$temp['link_source'] = $link_source;
			$temp['image_source'] = $image_source;
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
		$array_result[] = array('title' => 'Little Busters! Refrain Episode 1 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/10/little-buster-refrain-episode-01.html');
		/*	*/
		
		foreach ($array_content->entry as $array_temp) {
			$array_temp = (array)$array_temp;
			
			$link = '';
			foreach ($array_temp['link'] as $row) {
				$row = (array)$row;
				if ($row['@attributes']['rel'] == 'alternate') {
					$link = $row['@attributes']['href'];
					$title = $row['@attributes']['title'];
					break;
				}
			}
			
			$array_result[] = array( 'title' => $title, 'link' => $link );
		}
		
		return $array_result;
	}
	
	function get_content($link_source) {
		$curl = new curl();
		$content = $curl->get($link_source);
		$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
		
		// remove start offset
		$offset = "<div class='post-body entry-content'";
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = "<div class='post-footer'>";
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		return $content;
	}
	
	function get_desc($content) {
		$content = strip_tags($content);
		$content = preg_replace("/[\n]+/i", "\n", $content);
		$content = str_replace('&nbsp;', ' ', $content);
		$content = trim($content);
		
		$result = '';
		$array_temp = explode("\n", $content);
		foreach ($array_temp as $line) {
			$line = (empty($line)) ? '&nbsp;' : $line;
			$result .= '<div>'.$line.'</div>';
		}
		
		// endfix
		if (!empty($result)) {
			$result .= '<br /><div>Sumber : Sheltercloud</div>';
		}
		
		return $result;
	}
	
	function get_download($content) {
		$result = '';
		
		// make it clean
		$content = str_replace('&nbsp;', ' ', $content);
		$content = preg_replace('/ (style|target|rel)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/<\/?(b|i|span)([^\>]+)?>/i', '', $content);
		$content = preg_replace('/(<\/?div>\s)+/i', "\n", $content);
		
		// get common link
		preg_match_all('/\n([^<]+)<a class="Tombol" href="([^\"]+)">[^<]+<\/a>/i', $content, $match);
		foreach ($match[0] as $key => $value) {
			$label = trim($match[1][$key]);
			$link = trim($match[2][$key]);
			
			// make sure label only have one line
			$array_label = explode("\n", $label);
			$label = $array_label[count($array_label) - 1];
			
			$result .= (empty($result)) ? $link.' '.$label : "\n".$link.' '.$label;
		}
		
		// maybe link having password
		preg_match_all('/password[:= ]+([a-z0-9]+)/i', $content, $match);
		if (!empty($match[1][0])) {
			$password = trim($match[1][0]);
			$result .= "\n\nPassword : ".$password;
		}
		
		// trim it
		$result = trim($result);
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/ (border|height|width|alt)="[^"]+"/i', '', $content);
		preg_match('/<img +src=\"([^\"]+)\"/i', $content, $match);
		$result = (isset($match[1]) && !empty($match[1])) ? $match[1] : '';
		
		return $result;
	}
}