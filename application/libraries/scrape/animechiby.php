<?php

class animechiby {
    function __construct() {
        $this->CI =& get_instance();
		$this->is_index = true;
		$this->allow_duplicate = true;
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
			$temp['force_insert'] = true;
			$array_result[] = $temp;
			
			// add limit
			if (count($array_result) >= 5) {
				break;
			}
		}
		
		return $array_result;
	}
	
	function get_array_clear($content) {
		// result
		$array_result = $array_merge = array();
		
		// get latest post
		$array_post = $this->CI->Scrape_Content_model->get_array(array( 'scrape_master_id' => SCRAPE_CONTENT_ANIME_CHIBE_ID, 'limit' => 25 ));
		
		/*	
		// add link here
		$array_merge[] = array('title' => 'Little Busters! Refrain Episode 1 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/10/little-buster-refrain-episode-01.html');
		/*	*/
		
		$array_index = array();
		if (isset($this->is_index) && $this->is_index) {
			// remove start offset
			$offset = '<div class="lay1_wrap">';
			$pos_first = strpos($content, $offset);
			$content = substr($content, $pos_first, strlen($content) - $pos_first);
			
			// remove end offset
			$offset = '<div class="thn_paginate">';
			$pos_end = strpos($content, $offset);
			$content = substr($content, 0, $pos_end);
			
			preg_match_all('/<a href="([^\"]+)" title="([^\"]+)"/i', $content, $match);
			foreach ($match[0] as $key => $value) {
				$link = trim($match[1][$key]);
				$title = trim($match[2][$key]);
				$array_index[] = array('title' => $title, 'link' => $link);
			}
		} else {
			$array_content = new SimpleXmlElement($content);
			foreach ($array_content->channel->item as $array_temp) {
				$array_temp = (array)$array_temp;
				unset($array_temp['category']);
				unset($array_temp['description']);
				
				$array_index[] = (array)$array_temp;
			}
		}
		$array_index = array_reverse($array_index);
		
		// set result
		$array_merge = array_merge($array_merge, $array_index);
		
		// make sure only unindex page will be scrape
		foreach ($array_merge as $key => $row_index) {
			$is_duplicate = false;
			foreach ($array_post as $key => $row_db) {
				if ($row_db['link_source'] == $row_index['link']) {
					$is_duplicate = true;
					break;
				}
			}
			
			if (!$is_duplicate) {
				$array_result[] = $row_index;
			}
		}
		
		return $array_result;
	}
	
	function get_content($link_source) {
		$curl = new curl();
		$content = $curl->get($link_source);
		$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
		
		// remove start offset
		$offset = '<div class="single_post">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<div class="post_foot">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		return $content;
	}
	
	function get_desc($content) {
		$result = 'Sinopsis menyusul.';
		
		// endfix
		$result .= '<br /><div>Sumber : Anime Chibi</div>';
		
		return $result;
	}
	
	function get_download($content) {
		$result = '';
		
		// make it clean
		$content = str_replace('&nbsp;', ' ', $content);
		$content = preg_replace('/ (style)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/<\/?(p)([^\>]+)?>/i', '', $content);
		
		// get common link
		preg_match_all('/su-spoiler-icon"><\/span>([^\<]+)<\/div><div class="su-spoiler-content">((<span>[^<]+<\/span>)*(<h5>([^<]+)*<\/h5>)*(\s*<input class="button-auto" onclick="[^"]+" type="button" value="[^"]+" \/>)*)*/i', $content, $match);
		foreach ($match[0] as $key => $value) {
			$label_main = trim($match[1][$key]);
			
			$string_link = '';
			preg_match_all('/(<h5>([^<]+)*<\/h5>)*(\s*<input class="button-auto" onclick="[^"]+" type="button" value="[^"]+" \/>)*/i', $value, $array_sub_label);
			foreach ($array_sub_label[0] as $key => $raw_html_label) {
				if (empty($raw_html_label)) {
					continue;
				}
				
				// get label
				$sub_label = trim($array_sub_label[2][$key]);
				
				preg_match_all('/onclick="window.open\(\'([^\']+)\'\);return false;" type="button" value="([^"]+)"/i', $raw_html_label, $array_link);
				foreach ($array_link[0] as $key => $raw_html) {
					$link = $array_link[1][$key];
					$label = $array_link[2][$key];
					
					$string_link .= $link.' '.$label.' '.$sub_label."\n";
				}
			}
			
			// add space
			if (!empty($result)) {
				$result .= "\n";
			}
			
			$result .= $label_main."\n".$string_link;
		}
		
		// trim it
		$result = trim($result);
		
		return $result;
	}
	
	function get_image($content) {
		$content = preg_replace('/(border|height|width)\=\"\d+\"/i', '', $content);
		preg_match('/<img +src=\"([^\"]+)\"/i', $content, $match);
		$result = (isset($match[1]) && !empty($match[1])) ? $match[1] : '';
		
		return $result;
	}
}