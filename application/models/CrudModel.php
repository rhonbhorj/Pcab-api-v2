<?php

defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class CrudModel extends CI_Model
 {

    public function __construct()
 {
        // Call the Model constructor
        parent::__construct();
    }

    public function display_record()
 {

        return $query = $this->db->select( '*' )
        ->from( 'payment_transaction' )
        ->get()->result_array();

        // $query-$this->db->get( 'payment_transaction' );
        // return $query();
    }

    public function last_data_deposit()
 {
        $result = 'SELECT * FROM pcab_db.tbl_deposit ORDER BY dep_id DESC LIMIT 1';

        $data = $this->db->query( $result );
        return $data->row_array() ? $data->row_array() : false;
    }

    public function get_all_data()
 {

        $sql = 'SELECT * FROM transactions where status = "SUCCESS" ORDER BY last_modified DESC';
        $Q = $this->db->query( $sql );
        return $Q->row_array() ? $Q->result_array() : false;
    }

    public function get_all_transaction_data()
 {

        $sql = 'SELECT * FROM transactions ORDER BY trans_id DESC ';
        $Q = $this->db->query( $sql );
        return $Q->row_array() ? $Q->result_array() : false;
    }

    public function all_deposit_data()
 {

        $sql = 'SELECT * FROM tbl_deposit   ORDER BY deposited_date DESC';
        $Q = $this->db->query( $sql );
        return $Q->row_array() ? $Q->result_array() : false;
    }

    public function get_deposit_transactions( $id )
 {
        $sql = 'SELECT * FROM tbl_depost_transaction Where deposit_id = ?';
        $Q = $this->db->query( $sql, $id );
        return $Q->row_array() ? $Q->result_array() : false;
    }
}