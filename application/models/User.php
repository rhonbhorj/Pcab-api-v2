<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{

	public function get_user($username) {
        
        $this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('UserName', $username);
		$query = $this->db->get();
        return $query->row_array();
	}

	
}