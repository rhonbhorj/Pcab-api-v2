<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Dashboard_repo extends CI_Model
 {

    public function all_transaction_data()
 {
        $result = "SELECT  SUM(txn_amount) AS total_txn_amount ,count(txn_amount) as total_count 
                    FROM transactions  where  status='SUCCESS'";

        $data = $this->db->query( $result );
        return $data->row_array() ? $data->row_array() : false;
    }

    public function all_transaction_today()
 {
        date_default_timezone_set( 'Asia/Manila' );
        $today = date( 'Y-m-d' );
        $result = "SELECT  SUM(txn_amount) AS total_txn_amount_today ,count(txn_amount) as total_count_today 
                  FROM transactions  where   last_modified like '%" . $today . "%'";

        $data = $this->db->query( $result );
        // $data->row_array() ? $data->row_array() : false;
        return $data->num_rows() > 0 ? $data->row_array() : false;
    }

    public function all_transaction_yesterday()
 {
        date_default_timezone_set( 'Asia/Manila' );
        $today = date( 'Y-m-d' );

        $yesterday = date( 'Y-m-d', strtotime( '-1 days', strtotime( $today ) ) );
        $result = "SELECT  SUM(txn_amount) AS total_txn_amount_yesterday ,count(txn_amount) as total_count_transaction 
        FROM transactions  where   last_modified like '%" . $yesterday . "%'";
        $data = $this->db->query( $result );
        return $data->row_array() ? $data->row_array() : false;
    }

    public function all_transaction_this_week( $datesArray, $count )
 {
        $today = date( 'Y-m-d' );

        $dates = array_values( $datesArray );

        $likePatterns = array_map( function ( $date ) {
            return " '%" . $date . "%'";
        }
        , $dates );

        for ( $i = 0; $i < $count; $i ++ ) {

            $sql = 'SELECT count(txn_amount) as total_count FROM transactions where  last_modified like ' . $likePatterns[ $i ] . " and status='SUCCESS'";

            $data = $this->db->query( $sql );

            $resultArray[ $i ] = $data->num_rows() > 0 ? $data->row_array() : false;
            $qry = 'SELECT count(txn_amount) as total_count_failed FROM transactions where  last_modified like ' . $likePatterns[ $i ] . " and status='FAILED'";

            $data2 = $this->db->query( $qry );
            $resultArray2[ $i ] = $data2->num_rows() > 0 ? $data2->row_array() : false;
        }

        $dayresult = [];

        foreach ( $datesArray as $date ) {
            $timestamp = strtotime( $date );
            $dayOfWeek = date( 'l', $timestamp );
            $dayresult[] = $dayOfWeek;
        }

        // $result = [];

        foreach ( $dayresult as $index => $day ) {
            $result[ $day ]  = $resultArray[ $index ]+ $resultArray2[ $index ];
            //   $resultArray2[ $index ];
            //     array_push( $result[ $day ], $resultArray2[ $index ] );
        }

        return $result;
    }

    public function  monthly_transaction( $months, $count )
 {

        $yearMonth = array_values( $months );

        $likePatterns = array_map( function ( $date ) {
            return " '%" . $date . "%'";
        }
        , $yearMonth );

        for ( $i = 0; $i < $count; $i ++ ) {

            $sql = 'SELECT count(txn_amount) as total_count FROM transactions where  last_modified like ' . $likePatterns[ $i ] . " and status='SUCCESS'";

            $data = $this->db->query( $sql );

            $resultArray[ $i ] = $data->num_rows() > 0 ? $data->row_array() : false;
            $qry = 'SELECT count(txn_amount) as total_count_failed FROM transactions where  last_modified like ' . $likePatterns[ $i ] . " and status='FAILED'";

            $data2 = $this->db->query( $qry );
            $resultArray2[ $i ] = $data2->num_rows() > 0 ? $data2->row_array() : false;
        }

        foreach ( $months as $date ) {
            $timestamp = strtotime( $date );
            $dayOfWeek = date( 'F', $timestamp );
            $dayresult[] = $dayOfWeek;
        }

        foreach ( $dayresult as $index => $day ) {
            $result[ $day ]  = $resultArray[ $index ]+$resultArray2[ $index ];
            ;
        }
        return $result;
    }
}