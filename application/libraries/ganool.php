<?php

class ganool {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
//		$scrape['link'] = 'http://localhost/suekarea/trunk/temp.txt';
		
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
			
			// test purpose
			/*	
			if ($array['title'] != 'The Switch (2010) BluRay 720p 600MB Ganool') {
				continue;
			}
			/*	*/
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $link_source ));
			if (count($check) > 0) {
				continue;
			}
			
//			$link_source = 'http://localhost:8666/suekarea/trunk/post.html';
			
			// make content clean
			$content_item = $curl->get($link_source);
			$content_item = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_item);
			
			// desc
			$desc = $this->get_desc($content_item);
			$download = $this->get_download($content_item);
			
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
			
			// add limit
			if (count($array_result) >= 10) {
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
		$array_result[] = array('title' => 'The East (2013) 720p WEB-DL 800MB Ganool', 'link' => 'http://ganool.com/the-east-2013-720p-web-dl-800mb-ganool');
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
			$result .= '<div>&nbsp;</div>';
			$result .= '<div>Sumber : Ganool</div>';
		}
		
		return $result;
	}
	
	function get_download($content) {
		// clean image | js
		$content = preg_replace('/src=/i', 'nosrc=', $content);
		
		// remove start offset
		$offset = 'id="content"';
		$pos_first = strpos($content, $offset);
		$content = '<div '.substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = 'crp_related';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// clean desc
		$content = str_replace('http://www.imdb.com/', '', $content);
		$content = preg_replace('/ (onclick|target)=\"[^\"]+\"/i', '', $content);
		$content_clean = trim(strip_tags($content));
		
		// data
		$result = '';
		$is_write_single_link = false;
		
		// get from href
		$content_format = str_replace("<br />", "", $content);
		preg_match_all('/<strong>([a-z0-9 ]+)<\/strong>(\s*<a href=\"([^\"]+)\" onclick=\"[^\"]+\">([^\<]+)<\/a>)*/i', $content_format, $match);
		foreach ($match[0] as $key => $string_check) {
			$label = $match[1][$key];
			preg_match_all('/<a href=\"([^\"]+)\" onclick=\"[^\"]+\">([^\<]+)</i', $string_check, $array_link);
			if (count($array_link[0]) > 0) {
				$result .= (empty($result)) ? "" : "\n";
				$result .= $label."\n";
				foreach ($array_link[0] as $key => $value) {
					$result .= $array_link[1][$key].' '.$array_link[2][$key]."\n";
				}
			}
		}
		
		// get from label
		preg_match_all('/(Akafile|Mightyupload|UpAfile|Putlocker|UpToBox|PFU|Uploadscenter|Netload|Turbobit|Uploaded|FileClod|FileHostPro|Ezzyfile|Tubobit)[: ]+(full speed)?\s*((http:[\w\/\.]+\s?)+)/i', $content_clean, $match);
		if (count($match) > 0) {
			foreach ($match[0] as $value) {
				$value = trim($value);
				
				if (! $is_write_single_link) {
					$array_check = explode("\n", $value);
					$is_single_link = (count($array_check) == 1) ? true : false;
					if ($is_single_link) {
						$is_write_single_link = true;
						$result .= "\n\nSingle Link";
					}
				}
				
				if ($is_write_single_link) {
					$result .= (empty($result)) ? $value : "\n".$value;
				} else {
					$result .= (empty($result)) ? $value : "\n\n".$value;
				}
			}
		}
		
		// get from anime
		if (empty($result)) {
			preg_match_all('/([a-z0-9 ]+): \|( <a href="([^\"]+)">([a-z0-9 ]+)<\/a>\|)*/i', $content, $match);
			foreach ($match[0] as $key => $value) {
				$label = $match[1][$key];
				$result .= $label."\n";
				
				// get link
				preg_match_all('/<a href="([^\"]+)">([a-z0-9 ]+)<\/a>/i', $value, $array_link);
				foreach ($array_link[0] as $key_link => $link_value) {
					$result .= $array_link[1][$key_link].' '.$array_link[2][$key_link]."\n";
				}
				$result .= "\n";
			}
		}
		
		// get form p => ul
		if (empty($result)) {
			$content = preg_replace('/<\/?strong>/i', '', $content);
			preg_match_all('/([a-z0-9 ]+)<\/p>\n<ul>\n(<li><a href="[^\"]+">[a-z0-9 ]+<\/a><\/li>\n)*/i', $content, $match);
			foreach ($match[0] as $key => $value) {
				$label = $match[1][$key];
				preg_match_all('/href="([^\"]+)">([^>]+)</i', $value, $array_link);
				
				$result .= (empty($result)) ? $label : "\n\n".$label;
				foreach ($array_link[0] as $counter => $link_html) {
					$link_href = $array_link[1][$counter];
					$link_name = $array_link[2][$counter];
					$result .= "\n".$link_href.' '.$link_name;
				}
			}
		}
		
		return $result;
	}
}
