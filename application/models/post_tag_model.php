<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_Tag_model extends CI_Model {
    function __construct() {
        parent::__construct();
		
        $this->field = array( 'id', 'post_id', 'tag_id' );
    }

    function update($param) {
        $result = array();
       
        if (empty($param['id'])) {
            $insert_query  = GenerateInsertQuery($this->field, $param, POST_TAG);
            $insert_result = mysql_query($insert_query) or die(mysql_error());
           
            $result['id'] = mysql_insert_id();
            $result['status'] = '1';
            $result['message'] = 'Data berhasil disimpan.';
        } else {
            $update_query  = GenerateUpdateQuery($this->field, $param, POST_TAG);
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
            $select_query  = "SELECT * FROM ".POST_TAG." WHERE id = '".$param['id']."' LIMIT 1";
        } 
       
        $select_result = mysql_query($select_query) or die(mysql_error());
        if (false !== $row = mysql_fetch_assoc($select_result)) {
            $array = $this->sync($row);
        }
       
        return $array;
    }
	
    function get_array($param = array()) {
        $array = array();
		
		$string_tag = (!empty($param['tag_id'])) ? "AND PostTag.tag_id = '".$param['tag_id']."'" : '';
		$string_post = (!empty($param['post_id'])) ? "AND PostTag.post_id = '".$param['post_id']."'" : '';
		$string_not_draft = (isset($param['not_draft'])) ? "AND Post.post_type_id != '".POST_TYPE_DRAFT."'" : '';
		$string_publish_date = (!empty($param['publish_date'])) ? "AND Post.publish_date <= '".$param['publish_date']."'" : '';
		$string_filter = GetStringFilter($param, @$param['column']);
		$string_sorting = GetStringSorting($param, @$param['column'], 'Tag.name ASC');
		$string_limit = GetStringLimit($param);
		
		$select_query = "
			SELECT SQL_CALC_FOUND_ROWS PostTag.*,
				Tag.name tag_name, Tag.alias tag_alias,
				Post.alias post_alias, Post.name post_name, Post.desc post_desc, Post.create_date post_create_date, Post.thumbnail post_thumbnail
			FROM ".POST_TAG." PostTag
			LEFT JOIN ".TAG." Tag ON Tag.id = PostTag.tag_id
			LEFT JOIN ".POST." Post ON Post.id = PostTag.post_id
			LEFT JOIN ".POST_TYPE." PostType ON PostType.id = Post.post_type_id
			WHERE 1 $string_tag $string_post $string_not_draft $string_publish_date $string_filter
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
		if (isset($param['id'])) {
			$delete_query  = "DELETE FROM ".POST_TAG." WHERE id = '".$param['id']."' LIMIT 1";
			$delete_result = mysql_query($delete_query) or die(mysql_error());
		} else if (isset($param['post_id'])) {
			$delete_query  = "DELETE FROM ".POST_TAG." WHERE post_id = '".$param['post_id']."'";
			$delete_result = mysql_query($delete_query) or die(mysql_error());
		}
		
		$result['status'] = '1';
		$result['message'] = 'Data berhasil dihapus.';

        return $result;
    }
	
	function sync($row) {
		$row = StripArray($row, array( 'post_create_date' ));
		$row['tag_link'] = base_url('tag/'.$row['tag_alias']);
		
		// desc
		if (isset($row['post_desc'])) {
			$row['desc_limit'] = get_length_char(strip_tags($row['post_desc']), 250, ' ...');
		}
		
		// create date
		if (isset($row['post_create_date'])) {
			$date_temp = preg_replace('/-/i', '/', substr($row['post_create_date'], 0, 8));
			$row['post_link'] = base_url($date_temp.$row['post_alias']);
		}
		
		if (!empty($row['post_thumbnail'])) {
			$row['thumbnail_link'] = base_url('static/upload/'.$row['post_thumbnail']);
			$row['thumbnail_small_link'] = preg_replace('/\.(jpg|jpeg|png|gif)/i', '_s.$1', $row['thumbnail_link']);
		}
		
		return $row;
	}
}