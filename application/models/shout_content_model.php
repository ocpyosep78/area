<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shout_Content_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array( 'id', 'shout_master_id', 'user_name', 'message', 'shout_time' );
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, SHOUT_CONTENT);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, SHOUT_CONTENT);
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
            $select_query  = "SELECT * FROM ".SHOUT_CONTENT." WHERE id = '".$param['id']."' LIMIT 1";
        } 
       
        $select_result = mysql_query($select_query) or die(mysql_error());
        if (false !== $row = mysql_fetch_assoc($select_result)) {
            $array = $this->sync($row);
        }
       
        return $array;
    }
	
    function get_array($param = array()) {
        $array = array();
		
		$string_last_id = (!empty($param['last_id'])) ? "AND ShoutContent.id > '".$param['last_id']."'" : '';
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'shout_time ASC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS ShoutContent.*
			FROM ".SHOUT_CONTENT." ShoutContent
			WHERE 1 $string_last_id $string_filter
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
	
	function get_latest_shout($param) {
        $array = array();
		
		$string_shout_master_id = (!empty($param['shout_master_id'])) ? "AND ShoutContent.shout_master_id = '".$param['shout_master_id']."'" : '';
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT *
			FROM (
				SELECT *
				FROM ".SHOUT_CONTENT." ShoutContent
				WHERE 1 $string_shout_master_id
				ORDER BY shout_time DESC
				LIMIT $string_limit
			) shout
			ORDER BY shout_time ASC
		";
        $select_result = mysql_query($select_query) or die(mysql_error());
		while ( $row = mysql_fetch_assoc( $select_result ) ) {
			$array[] = $this->sync($row, @$param['column']);
		}
		
        return $array;
	}
	
    function delete($param) {
		$delete_query  = "DELETE FROM ".SHOUT_CONTENT." WHERE id = '".$param['id']."' LIMIT 1";
		$delete_result = mysql_query($delete_query) or die(mysql_error());
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row, $column = array()) {
		$row = StripArray($row, array( 'shout_time' ));
		
		$array_time = explode(' ', $row['shout_time']);
		$row['shout_time_only'] = $array_time[1];
		
		return $row;
	}
}