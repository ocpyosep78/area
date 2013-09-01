<?php

class awsubs {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
		$curl = new curl();
		$array_item = array();
		$content = $curl->get($scrape['link']);
		$array_content = new SimpleXmlElement($content);
		
		$array_result = array();
		foreach ($array_content->channel->item as $temp) {
			$array = (array)$temp;
			$array['title'] = trim($array['title']);
			$link_source = $array['link'];
			
			// test purpose
			/*
			if ($array['title'] != 'Persona: Trinity Soul Episode 3 Subtitle Indonesia') {
				continue;
			}
			/*	*/
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
			// desc
			$desc = $this->get_desc($array['description']);
			$download = $this->get_download($array['description']);
			$image_source = $this->get_image($array['description']);
			
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
		}
		
		return $array_result;
	}
	
	function get_array_clear($content) {
		$array_result = array();
		$array_content = new SimpleXmlElement($content);
		
		/*
		// add link here
		$array_result[] = array('title' => 'Gin no Saji Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/watamote-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Gin no Saji Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/monogatari-S2-08.html');
		$array_result[] = array('title' => 'Gin no Saji Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/kimi-no-iru-machi-episode-7-subtitle.html');
		/*	*/
		
		foreach ($array_content->channel->item as $array_temp) {
			$array_temp = (array)$array_temp;
			unset($array_temp['category']);
			unset($array_temp['description']);
			
			$array_result[] = (array)$array_temp;
		}
		
		return $array_result;
	}
	
	function get_desc($content) {
		$content = str_replace('&nbsp;', '', $content);
		$content = preg_replace('/<\/?(b|span)([^\>]+)?>/i', '', $content);
		$content = preg_replace('/\[\<strike\>[\w]+\<\/strike\>\]/i', '', $content);
		$content = preg_replace('/(style|class)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/\s+\>/i', '>', $content);
		$content = preg_replace('/\:/i', ': ', $content);
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
		$content = str_replace('&nbsp;', '', $content);
		$content = preg_replace('/<\/?(b|span)([^\>]+)?>/i', '', $content);
		$content = preg_replace('/\[\<strike\>[\w]+\<\/strike\>\]/i', '', $content);
		$content = preg_replace('/(style|class|rel|target)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/\s+\>/i', '>', $content);
		preg_match_all('/(480p|576p|720p)([\w\s\=\&\;]+)?(<\/?(span|b)([^>]+)?>)*((\[<a href\=\"[^\"]+\">\w+\<\/a\>\])*)/i', $content, $match);
		
		// condition #1
		$result = '';
		if (isset($match[1])) {
			foreach ($match[1] as $key => $value) {
				if (!empty($result)) {
					$result .= "\n";
				}
				
				// write title
				$result .= $value."\n";
				
				// write link
				preg_match_all('/href=\"([^\"]+)\">([^\<]+)</i', $match[6][$key], $array_link);
				foreach ($array_link[1] as $key => $link) {
					$result .= $array_link[1][$key].' '.$array_link[2][$key]."\n";
				}
			}
		}
		
		// condition #2
		if (empty($result)) {
			preg_match_all('/href=\"([^\"]+)\">([^\<]+)</i', $content, $match);
			foreach ($match[1] as $key => $link) {
				$check = preg_match('/wardhanime/i', $link, $check);
				if ($check) {
					continue;
				}
				
				$result .= $match[1][$key].' '.$match[2][$key]."\n";
			}
		}
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/(border|height|width)\=\"\d+\"/i', '', $content);
		preg_match('/<img +src=\"([^\"]+)\"/i', $content, $match);
		$result = (isset($match[1]) && !empty($match[1])) ? $match[1] : '';
		
		return $result;
	}
}