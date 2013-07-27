<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scrape_Content_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array(
			'id', 'post_id', 'category_id', 'post_type_id', 'scrape_master_id', 'name', 'desc', 'link_source', 'image_source', 'thumbnail', 'scrape_time', 'download'
		);
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, SCRAPE_CONTENT);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, SCRAPE_CONTENT);
            $update_result = mysql_query($update_query) or die(mysql_error());
           
            $result['id'] = $param['id'];
            $result['status'] = '1';
            $result['message'] = 'Data berhasil diperbaharui.';
        }
       
        return $result;
    }

    function get_by_id($param) {
        $array = array();
       
        if (isset($param['id'])) {
            $select_query  = "SELECT * FROM ".SCRAPE_CONTENT." WHERE id = '".$param['id']."' LIMIT 1";
        } else if (isset($param['link_source'])) {
            $select_query  = "SELECT * FROM ".SCRAPE_CONTENT." WHERE link_source = '".$param['link_source']."' LIMIT 1";
        } 
		
        $select_result = mysql_query($select_query) or die(mysql_error());
        if (false !== $row = mysql_fetch_assoc($select_result)) {
            $array = $this->sync($row);
        }
       
        return $array;
    }
	
    function get_array($param = array()) {
        $array = array();
		
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'scrape_time DESC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS ScrapeContent.*, Post.create_date, Post.alias,
				Category.name category_name, PostType.name post_type_name, ScrapeMaster.name scrape_master_name
			FROM ".SCRAPE_CONTENT." ScrapeContent
			LEFT JOIN ".SCRAPE_MASTER." ScrapeMaster ON ScrapeMaster.id = ScrapeContent.scrape_master_id
			LEFT JOIN ".POST." Post ON Post.id = ScrapeContent.post_id
			LEFT JOIN ".CATEGORY." Category ON Category.id = ScrapeContent.category_id
			LEFT JOIN ".POST_TYPE." PostType ON PostType.id = ScrapeContent.post_type_id
			WHERE 1 $string_filter
			ORDER BY $string_sorting
			LIMIT $string_limit
		";
        $select_result = mysql_query($select_query) or die(mysql_error());
		while ( $row = mysql_fetch_assoc( $select_result ) ) {
			$array[] = $this->sync($row);
		}
		
        return $array;
    }

    function get_count($param = array()) {
		$select_query = "SELECT FOUND_ROWS() TotalRecord";
		$select_result = mysql_query($select_query) or die(mysql_error());
		$row = mysql_fetch_assoc($select_result);
		$TotalRecord = $row['TotalRecord'];
		
		return $TotalRecord;
    }
	
    function delete($param) {
		$delete_query  = "DELETE FROM ".SCRAPE_CONTENT." WHERE id = '".$param['id']."' LIMIT 1";
		$delete_result = mysql_query($delete_query) or die(mysql_error());
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row) {
		$row = StripArray($row);
		
		if (isset($row['create_date']) && isset($row['alias'])) {
			$date_temp = preg_replace('/-/i', '/', substr($row['create_date'], 0, 8));
			$row['post_link'] = base_url($date_temp.$row['alias']);
		}
		
		return $row;
	}
}