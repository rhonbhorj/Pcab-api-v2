<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function doLogin($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
}