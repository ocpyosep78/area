<?php

class narutobleachlover {
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
			
			// content already exist
			$check = $this->CI->Scrape_Content_model->get_by_id(array( 'link_source' => $array['link'] ));
			if (count($check) > 0) {
				continue;
			}
			
			// make content clean
			$content_item = $curl->get($array['link']);
			$content_item = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content_item);
			
			// collect data
			$desc = $this->get_desc($content_item);
			$download = $this->get_download($content_item);
			
			// set to array
			$temp = array();
			$temp['name'] = $array['title'];
			$temp['desc'] = $desc;
			$temp['download'] = $download;
			$temp['link_source'] = $array['link'];
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
		$array_result[] = array('title' => 'Gatchaman Crowds Episode 10 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/09/gatcha10.html');
		$array_result[] = array('title' => 'Fate/Kaleid Liner PrismaIlya Episode 10 Subtitle Indonesia(FINAL)', 'link' => 'http://www.alibabasub.net/2013/09/fatekaleid-liner-prisma%e2%98%86ilya-episode-10-subtitle-indonesiafinal.html');
		$array_result[] = array('title' => 'Jigoku Sensei Nube Episode 4 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/jigoku-sensei-nube-episode-4-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Jigoku Sensei Nube Episode 3 Subtitle Indonesia', 'link' => 'http://www.alibabasub.net/2013/08/jigoku-sensei-nube-episode-3-subtitle-indonesia.html');
		/*	*/
		
		foreach ($array_content->channel->item as $array_temp) {
			$array_temp = (array)$array_temp;
			unset($array_temp['category']);
			unset($array_temp['description']);
			
			$array_result[] = (array)$array_temp;
		}
		
		return $array_result;
	}
	
	function get_desc($content, $param = array()) {
		$result = '';
		
		// remove start offset
		$offset = "<div class='post-body entry-content'>";
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = "<div id='post-bottom-ads'>";
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// get result
		$result = nl2br(trim(strip_tags($content)));
		
		// endfix
		$result .= '<div></div>';
		$result .= '<div>Sumber : Naruto Bleach Lover</div>';
		
		return $result;
	}
	
	function get_download($content) {
		$result = '';
		
		// remove start offset
		$offset = "<div class='post-body entry-content'>";
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = "<div id='post-bottom-ads'>";
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// clean content
		$content = preg_replace('/(rel|style|target)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/ +\>/i', '>', $content);
		preg_match_all('/\<a href\=\"([^\"]+)\"\>\[?([\w\s]+)\]?\<\/a\>/i', $content, $match);
		
		if (isset($match[1])) {
			foreach ($match[1] as $key => $value) {
				$link = $match[1][$key];
				$label = $match[2][$key];
				
				// check link
				$array_link = parse_url($link);
				if (isset($array_link['host']) && $array_link['host'] == 'www.narutobleachlover.net') {
					continue;
				}
				
				$result .= $link.' '.$label."\n";
			}
		}
		
		// trim it
		$result = trim($result);
		
		return $result;
	}
}
