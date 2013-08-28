<?php

class alibaba {
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
			
			// test purpose
			/*	
			if ($array['title'] != 'Makai Ouji: Devils and Realist Episode 7 Subtitle Indonesia') {
				continue;
			}
			/*	*/
			
			// make content clean
			$content_item = $curl->get($link_source);
			$content_item = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_item);
			
			// collect data
			$desc = $this->get_desc($content_item);
			$download = $this->get_download($content_item);
			$image_source = $this->get_image($content_item);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $download;
			$temp['image_source'] = $image_source;
			$temp['link_source'] = $array['link'];
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
		$array_result[] = array('title' => 'Love Lab Episode 8 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/love-lab-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Gatchaman Crowds Episode 7 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/gatchaman-crowds-episode-7-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Kiniro Mosaic Episode 8 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/kiniro-mosaic-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Rozen Maiden (2013) Episode 8 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/rozen-maiden-2013-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Genei o Kakeru Taiyou Episode 8 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/genei-o-kakeru-taiyou-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Uchouten Kazoku Episode 8 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/uchouten-kazoku-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Toaru Kagaku no Railgun S Episode 19 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/toaru-kagaku-no-railgun-s-episode-19-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Blood Lad Episode 8 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/blood-lad-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Mushibugyou Episode 21 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/mushibugyou-episode-21-subtitle-indonesia.html');
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
		// remove start offset
		$offset = '<div class="single_post">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<div class="related-posts">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// remove string from website
		$content = str_replace(array('Sebagai downloader yang baik tentunya tahu apa yang harus dilakukan, dan jangan lupa untuk selalu meninggalkan jejak di blog ini!'), '', $content);
		$content = preg_replace('/Silahkan download [a-z0-9 ]+ di bawah ini:/i', '', $content);
		
		// additional start offset
		$offset = '</header>';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// additional end offset
		$offset = '<div class="bottomad">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// make it clean
		$temp = trim(strip_tags($content));
		$temp = preg_replace("/\n+/i", "\n", $temp);
		$array_temp = explode("\n", $temp);
		$result = implode("<br />", $array_temp);
		
		// endfix
		$result .= '<div>&nbsp;</div>';
		$result .= '<div>Sumber : Alibaba</div>';
		
		return $result;
	}
	
	function get_download($content) {
		// remove start offset
		$offset = '<div class="single_post">';
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = '<div class="related-posts">';
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// make it consistent
		$content = preg_replace('/<\/a>\s?\/\s?<a /i', '</a> / <a ', $content);
		$content = preg_replace('/(480|720)p?\s*[=:]\s*/i', "$1 ", $content);
		$content = preg_replace('/(title|class|rel|target)="[a-z0-9 \-\_]*"/i', '', $content);
		
		$result = '';
		preg_match_all('/(480|720) (<a href=\"([^\"]+)\" *>([a-z0-9 ]+)<\/a>( \/ )*)*/i', $content, $match);
		if (is_array($match[0]) && count($match[0]) > 0) {
			foreach ($match[0] as $key => $raw_value) {
				$label = $match[1][$key];
				preg_match_all('/<a href=\"([^\"]+)\" *>([a-z0-9 ]+)<\/a>/i', $raw_value, $raw_link);
				
				if (is_array($raw_link[0]) && count($raw_link[0]) > 0) {
					$result .= (empty($result)) ? $label."\n" : "\n".$label."\n";
					foreach ($raw_link[0] as $key => $raw) {
						$link = $raw_link[1][$key];
						$title = $raw_link[2][$key];
						$result .= $link.' '.$title."\n";
					}
				}
			}
		}
		
		// trim it
		$result = trim($result);
		
		return $result;
	}
	
	function get_image($content) {
		preg_match('/ width=\"\d+\" height=\"\d+\" src=\"([^\"]+)\"/i', $content, $match);
		$result = (isset($match[1]) && !empty($match[1])) ? $match[1] : '';
		
		return $result;
	}
}
