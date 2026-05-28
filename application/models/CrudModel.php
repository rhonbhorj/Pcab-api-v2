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

    private function build_all_data_query( $startDate = null, $endDate = null )
 {
        $this->db->from( 'transactions' );
        $this->db->where( 'status', 'SUCCESS' );

        $hasStart = ! empty( $startDate );
        $hasEnd = ! empty( $endDate );

        if ( $hasStart || $hasEnd ) {
            if ( $hasStart ) {
                $startDateTime = DateTime::createFromFormat( 'm/d/Y', $startDate );
                if ( $startDateTime ) {
                    $this->db->where( 'DATE(last_modified) >=', $startDateTime->format( 'Y-m-d' ) );
                }
            }
            if ( $hasEnd ) {
                $endDateTime = DateTime::createFromFormat( 'm/d/Y', $endDate );
                if ( $endDateTime ) {
                    $this->db->where( 'DATE(last_modified) <=', $endDateTime->format( 'Y-m-d' ) );
                }
            }
        } else {
            $today = date( 'Y-m-d' );
            $this->db->where( 'DATE(last_modified)', $today );
        }

        $this->db->order_by( 'last_modified', 'DESC' );
    }

    public function get_all_data( $startDate = null, $endDate = null, $limit = null, $offset = null )
 {
        $this->db->select( '*' );
        $this->build_all_data_query( $startDate, $endDate );

        if ( $limit !== null ) {
            $this->db->limit( $limit, $offset );
        }

        $Q = $this->db->get();
        return $Q->row_array() ? $Q->result_array() : false;
    }

    public function count_all_data( $startDate = null, $endDate = null )
 {
        $this->build_all_data_query( $startDate, $endDate );
        return (int) $this->db->count_all_results();
    }

    public function get_transaction_by_id( $trans_id )
 {
        $Q = $this->db->select( '*' )
            ->from( 'transactions' )
            ->where( 'trans_id', $trans_id )
            ->where( 'status', 'SUCCESS' )
            ->get();

        return $Q->row_array() ? $Q->row_array() : false;
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