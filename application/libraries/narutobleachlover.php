<?php

class narutobleachlover {
    function __construct() {
        $this->CI =& get_instance();
    }
    
	function get_array($scrape) {
		$scrape['link'] = 'http://localhost/suekarea/trunk/temp.xml';
		
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
			
			// test purpose
			/*	*/
			$title = $array['title'];
			if ($title != 'Baca Komik One Piece 716 Bahasa Indonesia') {
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
		print_r($array_result); exit;
		
		return $array_result;
	}
	
	function get_desc($content) {
		$content = str_replace('&nbsp;', '', $content);
		$content = str_replace('<br />', "\n", $content);
		$content = preg_replace('/<\/?(b|span)([^\>]+)?>/i', '', $content);
		$content = preg_replace('/\[\<strike\>[\w]+\<\/strike\>\]/i', '', $content);
		$content = preg_replace('/(style|class)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/\s+\>/i', '>', $content);
		$content = preg_replace('/\:/i', ': ', $content);
		echo $content; exit;
		preg_match('/\<\/table\>(\<\/?div\>)*([\w\s\:\<\>\/\-\~\.\,\"\'\=]+)\[?Download/i', $content, $match);
		
		$temp = (isset($match[2])) ? $match[2] : '';
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
		$result .= '<div>Sumber : Naruto Bleach Lover</div>';
		
		return $result;
	}
	
	function get_download($content) {
		return '';
		
		$content = str_replace('&nbsp;', '', $content);
		$content = preg_replace('/<\/?(b|span)([^\>]+)?>/i', '', $content);
		$content = preg_replace('/\[\<strike\>[\w]+\<\/strike\>\]/i', '', $content);
		$content = preg_replace('/(style|class)\=\"[^\"]+\"/i', '', $content);
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
}
