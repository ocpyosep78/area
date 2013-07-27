<?php

class cupux_movie {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
		$curl = new curl();
		$array_item = array();
		$content = $curl->get($scrape['link']);
		$array_content = new SimpleXmlElement($content);
		$array_source = $array_content->channel->item;
		
		$array_result = array();
		foreach ($array_source as $array) {
			// test purpose
			/*
			$title = trim((string)$array->title);
			if ($title != 'Strawberry Night (2013) BluRay 720p') {
				continue;
			}
			/*	*/
			
			$content_html = (string)$array->description;
			
			// desc
			$content_desc = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_html);
			$content_desc = str_replace('<br />', "\n", $content_desc);
			$content_desc = strip_tags($content_desc);
			
			// #1 condition
			$content_desc = str_replace(' Release', "\nRelease", $content_desc);
			preg_match('/(Release([a-z0-9\(\)\|\,\.\-\:\;\/\^\'\_\&\@\s]*))Download/i', $content_desc, $match);
			$string_temp = (isset($match[1])) ? $match[1] : '';
			
			// #2 condition
			if (empty($string_temp)) {
				$content_desc = str_replace(' Genre', "\nGenre", $content_desc);
				preg_match('/(Genre([a-z0-9\(\)\|\,\.\-\:\;\/\^\'\_\&\@\s]*))Download/i', $content_desc, $match);
				$string_temp = (isset($match[1])) ? $match[1] : '';
			}
			
			$string_temp = preg_replace('/(Direct|Download) Link[\x20-\x7E\s]+/i', '', $string_temp);
			$array_temp = explode("\n", $string_temp);
			$desc = '';
			foreach ($array_temp as $line) {
				$desc .= '<div>'.$line.'</div>';
			}
			
			// image_source
			preg_match('/class=\"item_thumb\" oncontextmenu=\"return false;\" src=\"([^\"]+)\"/i', $content_html, $match);
			$image_source = (isset($match[1])) ? $match[1] : '';
			
			// direct & download link
			$array_download = array();
			preg_match_all('/<a href="([^"]+)" target="_blank">(Direct|Download) Link/i', $content_html, $match);
			if (isset($match[1])) {
				foreach ($match[1] as $key => $link) {
					$link_temp = parse_url($link);
					$array_download[] = $link.' '.$match[2][$key].' Link : '.$link_temp['host'];
				}
			}
			$download = "Pilih 1 link aja gan\n".implode("\n", $array_download);
			
			// set to array
			$temp = array();
			$temp['name'] = trim((string)$array->title);
			$temp['desc'] = $desc;
			$temp['image_source'] = $image_source;
			$temp['download'] = $download;
			$temp['link_source'] = (string)$array->link;
			$temp['category_id'] = $scrape['category_id'];
			$temp['post_type_id'] = $scrape['post_type_id'];
			$temp['scrape_master_id'] = $scrape['id'];
			$temp['scrape_time'] = $this->CI->config->item('current_datetime');
			$array_result[] = $temp;
		}
		
		return $array_result;
	}
}
