<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array( 'id', 'user_type_id', 'email', 'fullname', 'passwd', 'address', 'register_date', 'is_active' );
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, USER);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, USER);
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
            $select_query  = "SELECT * FROM ".USER." WHERE id = '".$param['id']."' LIMIT 1";
        } else if (isset($param['email'])) {
            $select_query  = "SELECT * FROM ".USER." WHERE email = '".$param['email']."' LIMIT 1";
        } 
       
        $select_result = mysql_query($select_query) or die(mysql_error());
        if (false !== $row = mysql_fetch_assoc($select_result)) {
            $array = $this->sync($row);
        }
       
        return $array;
    }
	
    function get_array($param = array()) {
        $array = array();
		
		$string_namelike = (!empty($_POST['namelike'])) ? "AND User.email LIKE '%".$_POST['namelike']."%'" : '';
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'name ASC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS User.*, UserType.name user_type_name
			FROM ".USER." User
			LEFT JOIN ".USER_TYPE." UserType ON UserType.id = User.user_type_id
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
		$delete_query  = "DELETE FROM ".USER." WHERE id = '".$param['id']."' LIMIT 1";
		$delete_result = mysql_query($delete_query) or die(mysql_error());
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row, $column = array()) {
		$row = StripArray($row);
		
		return $row;
	}
	
	function get_menu() {
		$menu = array(
			array(
				'Title' => 'Content Management',
				'Child' => array(
					array( 'Title' => 'Post', 'Link' => base_url('panel/content/post') ),
					array( 'Title' => 'Comment', 'Link' => base_url('panel/content/comment') ),
					array( 'Title' => 'Request', 'Link' => base_url('panel/content/request') )
				)
			),
			array(
				'Title' => 'User Management',
				'Child' => array(
					array( 'Title' => 'User', 'Link' => base_url('panel/user/user') ),
					array( 'Title' => 'Mail', 'Link' => base_url('panel/user/mail') )
				)
			),
			array(
				'Title' => 'Master',
				'Child' => array(
					array( 'Title' => 'Category', 'Link' => base_url('panel/master/category') ),
					array( 'Title' => 'Config', 'Link' => base_url('panel/master/config') )
				)
			)
		);
		
		return $menu;
	}
	
	/*	Region Session */
	
	function is_login($admin_level = false) {
		$user = $this->get_session();
		$result = (count($user) > 0) ? true : false;
		
		if ($result && $admin_level) {
			if ($user['user_type_id'] != USER_TYPE_ADMINISTRATOR) {
				$result = false;
			}
		}
		
		return $result;
	}
	
	function required_login($admin_level = false) {
		$is_login = $this->is_login($admin_level);
		if (!$is_login) {
			header("Location: ".base_url('panel'));
			exit;
		}
	}
	
	function set_session($user) {
		$_SESSION['user_login'] = $user;
	}
	
	function get_session() {
		$user = (isset($_SESSION['user_login'])) ? $_SESSION['user_login'] : array();
		if (! is_array($user)) {
			$user = array();
		}
		
		return $user;
	}
	
	function del_session() {
		if (isset($_SESSION['user_login'])) {
			unset($_SESSION['user_login']);
		}
	}
	
	/*	End Region Session */
}