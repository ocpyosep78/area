<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array( 'id', 'user_id', 'name', 'alias', 'desc', 'imdb', 'reply', 'request_time', 'status' );
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, REQUEST);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, REQUEST);
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
            $select_query  = "SELECT * FROM ".REQUEST." WHERE id = '".$param['id']."' LIMIT 1";
        } else if (isset($param['user_id']) && isset($param['request_time'])) {
			$select_query  = "SELECT * FROM ".REQUEST." WHERE user_id = '".$param['user_id']."' AND DATE(request_time) = DATE('".$param['request_time']."') LIMIT 1";
        } else if (isset($param['alias']) && isset($param['request_time'])) {
			$select_query  = "SELECT * FROM ".REQUEST." WHERE alias = '".$param['alias']."' AND DATE(request_time) = DATE('".$param['request_time']."') LIMIT 1";
		}
		
        $select_result = mysql_query($select_query) or die(mysql_error());
        if (false !== $row = mysql_fetch_assoc($select_result)) {
            $array = $this->sync($row);
        }
       
        return $array;
    }
	
    function get_array($param = array()) {
        $array = array();
		
		$string_namelike = (!empty($param['namelike'])) ? "AND Request.name LIKE '%".$param['namelike']."%'" : '';
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'request_time ASC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS Request.*, User.fullname user_fullname
			FROM ".REQUEST." Request
			LEFT JOIN ".USER." User ON User.id = Request.user_id
			WHERE 1 $string_namelike $string_filter
			ORDER BY $string_sorting
			LIMIT $string_limit
		";
        $select_result = mysql_query($select_query) or die(mysql_error());
		while ( $row = mysql_fetch_assoc( $select_result ) ) {
			$array[] = $this->sync($row, @$param['column']);
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
		$delete_query  = "DELETE FROM ".REQUEST." WHERE id = '".$param['id']."' LIMIT 1";
		$delete_result = mysql_query($delete_query) or die(mysql_error());
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row, $column = array()) {
		$row = StripArray($row, array( 'request_time', 'user_id' ));
		
		// create link
		if (isset($row['request_time']) && isset($row['alias'])) {
			$request_time = preg_replace('/-/i', '/', substr($row['request_time'], 0, 10));
			$row['request_link'] = base_url('request/'.$request_time.'/'.$row['alias']);
		}
		
		return $row;
	}
	
	function allow_request($param) {
		$param_request['user_id'] = $param['user_id'];
		$param_request['request_time'] = date("Y-m-d");
		$request = $this->get_by_id($param_request);
		
		$result = (count($request) == 0) ? true : false;
		return $result;
	}
}