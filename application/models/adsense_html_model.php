<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adsense_Html_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array( 'id', 'adsense_owner_id', 'adsense_type_id', 'adsense_code', 'create_date', 'is_active' );
		
		// request area
		$this->request_more = true;
		$this->array_expire_id = array();
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, ADSENSE_HTML);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, ADSENSE_HTML);
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
            $select_query  = "SELECT * FROM ".ADSENSE_HTML." WHERE id = '".$param['id']."' LIMIT 1";
        } 
       
        $select_result = mysql_query($select_query) or die(mysql_error());
        if (false !== $row = mysql_fetch_assoc($select_result)) {
            $array = $this->sync($row);
        }
       
        return $array;
    }
	
    function get_array($param = array()) {
        $array = array();
		
		// replace
		$param['field_replace']['type_name'] = 'AdsenseType.name';
		$param['field_replace']['owner_name'] = 'AdsenseOwner.name';
		$param['field_replace']['owner_priority'] = 'AdsenseOwner.priority';
		
		$string_is_active = (isset($param['is_active'])) ? "AND AdsenseHtml.is_active = ".$param['is_active']."" : "";
		$string_id_expired = (isset($param['id_expired']) && count($param['id_expired']) > 0) ? "AND AdsenseHtml.id NOT IN (".implode(',',$param['id_expired']).")" : "";
		$string_adsense_type_alias = (!empty($param['adsense_type_alias'])) ? "AND AdsenseType.alias = '".$param['adsense_type_alias']."'" : "";
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'create_date ASC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS AdsenseHtml.*, AdsenseOwner.name owner_name, AdsenseOwner.priority owner_priority, AdsenseType.name type_name
			FROM ".ADSENSE_HTML." AdsenseHtml
			LEFT JOIN ".ADSENSE_OWNER." AdsenseOwner ON AdsenseOwner.id = AdsenseHtml.adsense_owner_id
			LEFT JOIN ".ADSENSE_TYPE." AdsenseType ON AdsenseType.id = AdsenseHtml.adsense_type_id
			WHERE 1 $string_is_active $string_id_expired $string_adsense_type_alias $string_filter
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
		$delete_query  = "DELETE FROM ".ADSENSE_HTML." WHERE id = '".$param['id']."' LIMIT 1";
		$delete_result = mysql_query($delete_query) or die(mysql_error());
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row, $column = array()) {
		$row = StripArray($row);
		
		return $row;
	}
	
	function get_code($param) {
		$result = '';
		
		// get data from cookie
		if ($this->request_more && !empty($_COOKIE['sue_adsense'])) {
			$this->array_expire_id = explode(',', $_COOKIE['sue_adsense']);
		}
		
		// no update expire adsense
		$this->request_more = false;
		
		$param_adsense['is_active'] = 1;
		$param_adsense['id_expired'] = $this->array_expire_id;
		$param_adsense['adsense_type_alias'] = $param['adsense_type_alias'];
		$param_adsense['sort'] = '[{"property":"AdsenseOwner.priority","direction":"DESC"}]';
		$param_adsense['limit'] = 1;
		$array_adsense = $this->get_array($param_adsense);
		
		// selected row
		$row = array();
		if (count($array_adsense) == 1) {
			$row = $array_adsense[0];
			$this->array_expire_id[] = $row['id'];
		} else {
			$this->array_expire_id = array();
			
			// reload adsense row
			$param_adsense['is_active'] = 1;
			$param_adsense['id_expired'] = $this->array_expire_id;
			$param_adsense['adsense_type_alias'] = $param['adsense_type_alias'];
			$param_adsense['sort'] = '[{"property":"AdsenseOwner.priority","direction":"DESC"}]';
			$param_adsense['limit'] = 1;
			$array_adsense = $this->get_array($param_adsense);
			
			// redefine data
			$row = $array_adsense[0];
			$this->array_expire_id[] = $row['id'];
		}
		
		// set cookie
		$string_implode = implode(',', $this->array_expire_id);
		setcookie("sue_adsense", $string_implode, time() + (60 * 60 * 5), '/');
		
		// set result
		$result = $row['adsense_code'];
		
		return $result;
	}
}