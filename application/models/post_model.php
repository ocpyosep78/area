<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array(
			'id', 'user_id', 'category_id', 'post_type_id', 'alias', 'name', 'desc', 'link_source', 'thumbnail', 'create_date', 'publish_date', 'view_count',
			'is_hot', 'is_popular'
		);
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, POST);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, POST);
            $update_result = mysql_query($update_query) or die(mysql_error());
           
            $result['id'] = $param['id'];
            $result['status'] = '1';
            $result['message'] = 'Data berhasil diperbaharui.';
        }
		
		$this->resize_image($param);
		
        return $result;
    }

    function get_by_id($param) {
        $array = array();
       
        if (isset($param['id'])) {
            $select_query  = "
				SELECT Post.*, User.fullname user_fullname
				FROM ".POST." Post
				LEFT JOIN ".USER." User ON User.id = Post.user_id
				WHERE Post.id = '".$param['id']."'
				LIMIT 1
			";
		} else if (isset($param['year']) && isset($param['month']) && isset($param['alias'])) {
			$select_query  = "SELECT * FROM ".POST." WHERE YEAR(create_date) = '".$param['year']."' AND MONTH(create_date) = '".$param['month']."' AND alias = '".$param['alias']."' LIMIT 1";
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
		$param['field_replace']['name'] = 'Post.name';
		$param['field_replace']['category_name'] = 'Category.name';
		
		$string_is_hot = (isset($param['is_hot'])) ? "AND Post.is_hot = '".$param['is_hot']."'" : '';
		$string_is_popular = (isset($param['is_popular'])) ? "AND Post.is_popular = '".$param['is_popular']."'" : '';
		$string_month = (isset($param['month'])) ? "AND MONTH(Post.create_date) = '".$param['month']."'" : '';
		$string_year = (isset($param['year'])) ? "AND YEAR(Post.create_date) = '".$param['year']."'" : '';
		$string_namelike = (!empty($param['namelike'])) ? "AND Post.name LIKE '%".$param['namelike']."%'" : '';
		$string_max_id = (!empty($param['max_id'])) ? "AND Post.id < '".$param['max_id']."'" : '';
		$string_category = (!empty($param['category_id'])) ? "AND Post.category_id = '".$param['category_id']."'" : '';
		$string_not_draft = (isset($param['not_draft'])) ? "AND Post.post_type_id != '".POST_TYPE_DRAFT."'" : '';
		$string_publish_date = (!empty($param['publish_date'])) ? "AND Post.publish_date <= '".$param['publish_date']."'" : '';
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'Post.name ASC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS Post.*, User.fullname user_fullname,
				Category.name category_name, PostType.name post_type_name
			FROM ".POST." Post
			LEFT JOIN ".USER." User ON User.id = Post.user_id
			LEFT JOIN ".CATEGORY." Category ON Category.id = Post.category_id
			LEFT JOIN ".POST_TYPE." PostType ON PostType.id = Post.post_type_id
			WHERE 1
				$string_is_hot $string_is_popular $string_month $string_year $string_namelike
				$string_category $string_max_id $string_not_draft $string_publish_date $string_filter
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
		$delete_query  = "DELETE FROM ".POST." WHERE id = '".$param['id']."' LIMIT 1";
		$delete_result = mysql_query($delete_query) or die(mysql_error());
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row, $column = array()) {
		$row = StripArray($row, array( 'create_date', 'publish_date' ));
		$row['desc_limit'] = get_length_char(strip_tags($row['desc']), 250, ' ...');
		
		$date_temp = preg_replace('/-/i', '/', substr($row['create_date'], 0, 8));
		$row['post_link'] = base_url($date_temp.$row['alias']);
		$row['thumbnail_link'] = base_url('static/upload/'.$row['thumbnail']);
		$row['thumbnail_small_link'] = preg_replace('/\.(jpg|jpeg|png|gif)/i', '_s.$1', $row['thumbnail_link']);
		
		$row['array_link_source'] = array();
		if (isset($row['link_source'])) {
			$array_temp = explode("\n", $row['link_source']);
			foreach ($array_temp as $link) {
				$array = explode(' ', $link, 2);
				$row['array_link_source'][] = array( 'link' => @$array[0], 'base_name' => @$array[1] );
			}
		}
		
		return $row;
	}
	
	function resize_image($param) {
		if (!empty($param['thumbnail'])) {
			$image_path = $this->config->item('base_path') . '/static/upload/';
			$image_source = $image_path . $param['thumbnail'];
			$image_result = $image_source;
			$image_small = preg_replace('/\.(jpg|jpeg|png|gif)/i', '_s.$1', $image_result);
			
			ImageResize($image_source, $image_small, 194, 123, 1);
			ImageResize($image_source, $image_result, 600, 374, 1);
		}
	}
	
	function get_link() {
		$post = array();
		
		preg_match('/(\d{4})\/(\d{2})\/([a-z0-9-]+)/i', $_SERVER['REQUEST_URI'], $match);
		if (count($match) >= 4) {
			$year = (!empty($match[1])) ? $match[1] : '';
			$month = (!empty($match[2])) ? $match[2] : '';
			$alias = (!empty($match[3])) ? $match[3] : '';
			
			$post = $this->get_by_id(array( 'year' => $year, 'month' => $month, 'alias' => $alias ));
		}
		
		return $post;
	}
}