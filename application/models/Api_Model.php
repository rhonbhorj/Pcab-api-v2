<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_transaction($from_date, $to_date)
    {
        $this->db->where('date >=', $from_date . ' 00:00:00');
        $this->db->where('date <=', $to_date . ' 23:59:59');
        $query = $this->db->get('transactions');
        return $query->result();
    }
}