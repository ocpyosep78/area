<?php

class ganool {
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
			// link
			$link_temp = (string)$array->link;
			$array_link = explode('?', $link_temp, 2);
			$link_source = $array_link[0];
			
			// test purpose
			/*
			$title = trim((string)$array->title);
			if ($title != 'Naruto Shippuden Episode 322 Subtitle Indonesia') {
				continue;
			}
			/*	*/
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
			// make content clean
			$content_item = $curl->get($link_source);
			$content_item = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_item);
			
			// desc
			$desc = $this->get_desc($content_item);
			$download = $this->get_download($content_item);
			
			// set to array
			$temp = array();
			$temp['name'] = trim((string)$array->title);
			$temp['desc'] = $desc;
			$temp['download'] = $download;
			$temp['link_source'] = $link_source;
			$temp['category_id'] = $scrape['category_id'];
			$temp['post_type_id'] = $scrape['post_type_id'];
			$temp['scrape_master_id'] = $scrape['id'];
			$temp['scrape_time'] = $this->CI->config->item('current_datetime');
			$array_result[] = $temp;
			
			// add limit
			if (count($array_result) >= 10) {
				break;
			}
		}
		
		return $array_result;
	}
	
	function get_desc($content) {
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
		
		$result = '';
		$array_temp = explode("\n", $temp);
		foreach ($array_temp as $line) {
			$result .= '<div>'.$line.'</div>';
		}
		
		// endfix
		$result .= '<div>&nbsp;</div>';
		$result .= '<div>Sumber : Ganool</div>';
		
		return $result;
	}
	
	function get_download($content) {
		// remove start offset
		$offset = 'spoiler-body';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = 'crp_related';
		$pos_end = strpos($content, $offset);
		$content = '<div class=\''.substr($content, 0, $pos_end);
		
		// clean desc
		$content = trim(strip_tags($content));
		
		preg_match_all('/([\w\s]+)\s?:\s?(http:[\w\/\.]+)/i', $content, $match);
		if (count($match) > 0) {
			// remove single link text
			$offset = 'Single Link';
			$pos_end = strpos($content, $offset);
			$content = substr($content, 0, $pos_end);
			
			$content .= "Single Link\n";
			foreach ($match[0] as $key => $value) {
				$title = trim($match[1][$key]);
				$link = trim($match[2][$key]);
				$content .= "$link $title\n";
			}
		}
		
		return $content;
		
	}
}
