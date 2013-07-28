<?php

class alibaba {
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
			// test purpose
			/*
			$title = trim((string)$array->title);
			if ($title != 'Naruto Shippuden Episode 322 Subtitle Indonesia') {
				continue;
			}
			/*	*/
			
			$content_html = (string)$array->description;
			
			// desc
			$content_desc = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_html);
			$content_desc = str_replace('</div>', "\n", $content_desc);
			$content_desc = str_replace('<br />', "\n", $content_desc);
			$content_desc = str_replace('&nbsp;', "", $content_desc);
			$content_desc = preg_replace("/\n+/i", "\n", $content_desc);
			$content_desc = trim(strip_tags($content_desc));
			
			$content_desc = preg_replace('/Sebagai downloader[\x20-\x7E\s]+/i', "", $content_desc);
			$array_temp = explode("\n", $content_desc);
			$desc = '';
			foreach ($array_temp as $line) {
				$desc .= '<div>'.$line.'</div>';
			}
			
			// image_source
			preg_match('/border=\"0\" (height=\"\d+\" )?src=\"([^\"]+)\"/i', $content_html, $match);
			$image_source = (isset($match[2])) ? $match[2] : '';
			
			// direct & download link
			$array_download = array();
			preg_match_all('/(([\w\d]+)\s*:\s*\|*\s*(<span style="color: black;">)?)?<a href=\"([^\"]+)\"( target=\"_blank\")?>([^<]+)<\/a>/i', $content_html, $match);
			if (isset($match[1])) {
				foreach ($match[1] as $key => $link) {
					if (!empty($match[2][$key])) {
						if (count($array_download) > 0) {
							$array_download[] = '&nbsp;';
						}
						
						$array_download[] = trim($match[2][$key]);
					}
					
					$array_download[] = trim($match[4][$key]).' '.trim($match[6][$key]);
				}
			}
			$download = "Jangan lupa like yaa gan\n".implode("\n", $array_download);
			
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
