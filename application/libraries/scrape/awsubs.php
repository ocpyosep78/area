<?php

class awsubs {
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
		$array_result[] = array('title' => 'Free! Episode 9 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/09/free-episode-9-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Brothers Conflict Episode 10 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/09/brothers-conflict-episode-10-subtitle.html');
		$array_result[] = array('title' => 'Busou Shinki Episode 13 OVA Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/09/busou-shinki-episode-13-ova-subtitle.html');
		$array_result[] = array('title' => 'Watamote Episode 9 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/09/watamote-episode-9-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Watamote Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/watamote-episode-8-subtitle-indonesia.html');
		$array_result[] = array('title' => 'Monogatari Series: Second Season Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/monogatari-S2-08.html');
		$array_result[] = array('title' => 'Kimi no Iru Machi Episode 7 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/kimi-no-iru-machi-episode-7-subtitle.html');
		$array_result[] = array('title' => 'Genei wo Kakeru Taiyou Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/genei-wo-kakeru-taiyou-episode-8.html');
		$array_result[] = array('title' => 'Senki Zesshou Symphogear G Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/senki-zesshou-symphogear-g-episode-8.html');
		$array_result[] = array('title' => 'To Aru Kagaku no Railgun S Episode 19 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/to-aru-kagaku-no-railgun-s-episode-19.html');
		$array_result[] = array('title' => 'Kamisama no Inai Nichiyoubi Episode 8 Subtitle Indonesia', 'link' => 'http://www.wardhanime.net/2013/08/kamisama-no-inai-nichiyoubi-episode-8.html');
		/*	*/
		
		foreach ($array_content->channel->item as $array_temp) {
			$array_temp = (array)$array_temp;
			unset($array_temp['category']);
			unset($array_temp['description']);
			
			$array_result[] = (array)$array_temp;
		}
		
		return $array_result;
	}
	
	function get_content($link_source) {
		$curl = new curl();
		$content = $curl->get($link_source);
		$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
		
		// remove start offset
		$offset = "<div class='post-body entry-content'>";
		$pos_first = strpos($content, $offset);
		$content = substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = "<div id='area-bawah'>";
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		return $content;
	}
	
	function get_desc($content) {
		$content = strip_tags($content);
		$content = preg_replace('/(480|720).+/i', '', $content);
		$content = preg_replace("/[\n]+/i", "\n", $content);
		$content = str_replace('&nbsp;', ' ', $content);
		$content = trim($content);
		
		$result = '';
		$array_temp = explode("\n", $content);
		foreach ($array_temp as $line) {
			$line = (empty($line)) ? '&nbsp;' : $line;
			$result .= '<div>'.$line.'</div>';
		}
		
		// endfix
		$result .= '<div></div>';
		$result .= '<div>Sumber : AWSubs</div>';
		
		return $result;
	}
	
	function get_download($content) {
		$result = '';
		
		// make it clean
		$content = str_replace('&nbsp;', ' ', $content);
		$content = preg_replace('/ (style|class|target|rel)\=\"[^\"]+\"/i', '', $content);
		$content = preg_replace('/<\/?(b|span)([^\>]+)?>/i', '', $content);
		
		// remove start offset
		$offset = '<div dir="ltr" trbidi="on">';
		$pos_first = strpos($content, $offset);
		$content = '<div '.substr($content, $pos_first, strlen($content) - $pos_first);
		
		// remove end offset
		$offset = "<center>";
		$pos_end = strpos($content, $offset);
		$content = substr($content, 0, $pos_end);
		
		// remove empty link
		$content = preg_replace('/\| <strike>[^\<]+<\/strike>/i', '', $content);
		$content = preg_replace('/<strike>[^\<]+<\/strike> \|/i', '', $content);
		
		// get link
		preg_match_all('/div>([^\<]+)<\/div>\s<div>\s(<a href="[^"]+"\>[a-z]+<\/a>[ \|]*)+/i', $content, $match);
		foreach ($match[0] as $key => $value) {
			$label = trim($match[1][$key]);
			preg_match_all('/<a href="([^"]+)"\>([a-z]+)<\/a>/i', $value, $array_link);
			
			// validation
			if (count($array_link[0]) == 0) {
				continue;
			}
			
			$result .= (empty($result)) ? "$label\n" : "\n$label\n";
			foreach ($array_link[0] as $counter => $temp) {
				$link_href = $array_link[1][$counter];
				$link_title = $array_link[2][$counter];
				
				$result .= $link_href.' '.$link_title."\n";
			}
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