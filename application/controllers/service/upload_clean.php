<?php

class upload_clean extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		echo 'stop it';
		exit;
		$year_month = '2013/09';
		
		// clean each month
		$path_dir = $this->config->item('base_path').'/static/upload/'.$year_month;
		$path_array = $this->get_array_dir(array( 'dir' => $path_dir ));
		
		// get file per date
		$array_path_image = array();
		foreach ($path_array as $value) {
			$array_temp = $this->get_array_dir(array( 'dir' => $value ));
			$array_path_image = array_merge($array_path_image, $array_temp);
		}
		
		// get array format base name
		$array_image = array();
		foreach ($array_path_image as $base_path) {
			preg_match('/\d{4}\/\d{2}\/\d{2}\/[a-z0-9_\.]+$/i', $base_path, $match);
			if (!empty($match[0])) {
				$array_image[$match[0]]['path'] = $base_path;
			}
		}
		
		// get array db
		$array_db = $this->get_array_db(array( 'year_month' => $year_month ));
		
		// delete unused file
		foreach ($array_image as $key => $file) {
			// make basic on db
			$file_db_name = str_replace(array( '_s' ), '', $key);
			
			// filter it
			if (!isset($array_db[$file_db_name])) {
				echo $file['path'].'<br />';
				unlink($file['path']);
			}
		}
    }
	
	function get_array_dir($param) {
		$array_result = array();
		
		if ($handle = opendir($param['dir'])) {
			while (false !== ($entry = readdir($handle))) {
				if (in_array($entry, array('.', '..'))) {
					continue;
				}
				
				$array_result[] = $param['dir'].'/'.$entry;
			}
			closedir($handle);
		}
		
		// sort it
		asort($array_result);
		
		return $array_result;
	}
	
    function get_array_db($param = array()) {
        $array = array();
		
		$select_query = "
			SELECT thumbnail
			FROM ".POST." Post
			WHERE LEFT(thumbnail, 7) = '".$param['year_month']."'
			ORDER BY id ASC
			LIMIT 10000
		";
		$select_result = mysql_query($select_query) or die(mysql_error());
		while ( $row = mysql_fetch_assoc( $select_result ) ) {
			$array[$row['thumbnail']] = $row['thumbnail'];
		}
		
        return $array;
    }
}