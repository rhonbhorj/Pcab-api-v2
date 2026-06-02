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
    public function get_paginated_transactions($from_date, $to_date, $limit, $offset)
    {
        $start_datetime = $from_date . ' 00:00:00';
        $end_datetime = $to_date . ' 23:59:59';

        // Base query conditions shared between counting and fetching
        $this->db->from('transactions');
        $this->db->where('status', 'SUCCESS');
        $this->db->where('date_created >=', $start_datetime);
        $this->db->where('date_created <=', $end_datetime);

        // 1. Get total record count matching conditions before limits are applied
        $total_records = $this->db->count_all_results('', false);

        if ($total_records === 0) {
            return false;
        }

        // 2. Fetch the chunk of rows for the current page
        $this->db->order_by('last_modified', 'ASC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return [
            'total_records' => $total_records,
            'records' => $query->result() // Returns an array of objects
        ];
    }

    public function get_search_transactions($limit, $offset, $search = null)
    {
        $this->db->from('transactions');

        // 🚀 Dynamic search block matching your exact database image schema properties
        if (!empty($search)) {
            $this->db->group_start();

            $this->db->like('reference_number', $search);
            $this->db->or_like('referenceNumber', $search);
            $this->db->or_like('name_of_payor', $search);
            $this->db->or_like('particulars', $search);
            $this->db->or_like('mobile_number', $search);
            $this->db->or_like('status', $search);  // Allows users to find records by searching "SUCCESS" or "FAILED"
            $this->db->or_like('ar_no', $search);   // Acknowledgement Receipt Number (Row 25)
            $this->db->or_like('report_no', $search); // Report Number (Row 24)

            $this->db->group_end();
        }

        // 1. Calculate the absolute total matching records before applying pagination limits
        // Passing 'false' prevents CodeIgniter from destroying the query context in memory
        $total_records = $this->db->count_all_results('', false);

        if ($total_records === 0) {
            return false;
        }

        // 2. Extract the specific subset window of matching rows
        // Always sorting cleanly by your table's explicit last_modified column (Row 18)
        $this->db->order_by('last_modified', 'ASC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return [
            'total_records' => $total_records,
            'records' => $query->result() // Returns an array of standard PHP objects
        ];
    }


}