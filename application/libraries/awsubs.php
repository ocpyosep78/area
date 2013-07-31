<?php

class awsubs {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
		$scrape['link'] = 'http://localhost:8666/suekarea/trunk/raw.xml';
		
		$curl = new curl();
		$array_item = array();
		$content = $curl->get($scrape['link']);
		$array_content = new SimpleXmlElement($content);
		
		$array_result = array();
		foreach ($array_content->channel->item as $array) {
			// test purpose
			/*
			$title = trim((string)$array->title);
			if ($title != 'Naruto Shippuden Episode 322 Subtitle Indonesia') {
				continue;
			}
			/*	*/
			
			// link
			$link_source = (string)$array->link;
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
			// desc
			$desc = $this->get_desc((string)$array->description);
			$download = $this->get_download((string)$array->description);
			
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
		}
		print_r($array_result); exit;
		return $array_result;
	}
	
	function get_desc($content) {
		preg_match('/<img [^>]+>(.+)<a[^>]+>Download/i', $content, $match);
		$temp = (isset($match[1])) ? $match[1] : '';
		$temp = str_replace('</div>', "\n", $temp);
		$temp = str_replace('<br />', "\n", $temp);
		$temp = str_replace('&nbsp;', ' ', $temp);
		$temp = preg_replace('/\n+/i', "\n", $temp);
		$temp = trim(strip_tags($temp));
		
		$result = '';
		$array_temp = explode("\n", $temp);
		foreach ($array_temp as $line) {
			$line = (empty($line)) ? '&nbsp;' : $line;
			$result .= '<div>'.$line.'</div>';
		}
		
		// endfix
		$result .= '<div>&nbsp;</div>';
		$result .= '<div>Sumber : AWSubs</div>';
		
		return $result;
	}
	
	function get_download($content) {
		$content = preg_replace('/\[\<strike\>[\w]+\<\/strike\>\]/i', '', $content);
		preg_match_all('/(480p|720p)([\w\s\=\&\;]+)?(<\/?(span|b)([^>]+)?>)*((\[<a href\=\"[\w\:\/\.]+\">\w+<\/a>\])*)/i', $content, $match);
		
		$content = '';
		if (isset($match[1])) {
			foreach ($match[1] as $key => $value) {
				if (!empty($content)) {
					$content .= "\n";
				}
				
				// write title
				$content .= $value."\n";
				
				// write link
				preg_match_all('/href=\"([^\"]+)\">([^\<]+)</i', $match[6][$key], $array_link);
				foreach ($array_link[1] as $key => $link) {
					$content .= $array_link[1][$key].' '.$array_link[2][$key]."\n";
				}
			}
		}
		
		return $content;
	}
}
