<?php

class unduhfilm21 {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
		$curl = new curl();
		$array_item = array();
		$content = $curl->get($scrape['link']);
		$array_content = new SimpleXmlElement($content);
		
		$array_result = array();
		foreach ($array_content->channel->item as $array) {
			$array = (array)$array;
			$link_source = $array['link'];
			$array['title'] = trim($array['title']);
			$array['description'] = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $array['description']);
			
			$array['category'] = (is_string($array['category'])) ? trim($array['category']) : '';
			if (strtoupper($array['category']) == 'STREAMING') {
				continue;
			}
			
			// test purpose
			/*	
			$title = $array['title'];
			if ($title != 'The Sigil (2012) DVDRip') {
				continue;
			}
			/*	*/
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
			// desc
			$desc = $this->get_desc($array['description'], array( 'title' => $array['title'] ));
			$download = $this->get_download($array['description']);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $download;
			$temp['link_source'] = $link_source;
			$temp['category_id'] = $scrape['category_id'];
			$temp['post_type_id'] = $scrape['post_type_id'];
			$temp['scrape_master_id'] = $scrape['id'];
			$temp['scrape_time'] = $this->CI->config->item('current_datetime');
			$array_result[] = $temp;
		}
		
		return $array_result;
	}
	
	function get_desc($content, $param = array()) {
		$content = preg_replace('/\<(br \/|\/div)\>/i', "\n", $content);
		$content = str_replace('&nbsp;', ' ', $content);
		$content = strip_tags($content);
		$content = preg_replace('/DOWNLOAD[\w ]+/i', "", $content);
		$content = trim(preg_replace('/[\n]+/i', "\n", $content));
		
		$result = '';
		$array_temp = explode("\n", $content);
		foreach ($array_temp as $line) {
			$line = (empty($line)) ? '&nbsp;' : $line;
			$result .= '<div>'.trim($line).'</div>';
		}
		
		// endfix
		$result .= '<div>&nbsp;</div>';
		$result .= '<div>Sumber : Unduh Film 21</div>';
		
		return $result;
	}
	
	function get_download($content) {
		// clean content
		$content = preg_replace('/(rel|style|target)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/ +\>/i', '>', $content);
		$content = preg_replace('/\<\/?(b|span)\>/i', '', $content);
		preg_match_all('/\<a href\=\"([^\"]+)\"\>\[?([^\<]+)\]?\<\/a\>/i', $content, $match);
		
		$result = '';
		if (isset($match[1])) {
			foreach ($match[1] as $key => $value) {
				$link = $match[1][$key];
				$label = $match[2][$key];
				$result .= $link.' '.$label."\n";
			}
		}
		
		// trim it
		$result = trim($result);
		
		return $result;
	}
}
