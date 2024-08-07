<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_repo extends CI_Model
{

    public function totalNgsifee()
    {
        $result = "SELECT ngsi_convenience_fee AS ngsi_fee 
                   FROM transactions  where  status='SUCCESS'";

        $data = $this->db->query($result);
        return $data->result_array() ? $data->result_array() : false;
    }

    public function all_transaction_data()
    {
        $result = "SELECT 
            sum(fees_pcab) as pcab_fee,
            sum(legal_research_fund) as lrf,
            sum(document_stamp_tax) as ds_tax
            ,count(txn_amount) as total_count 
            FROM transactions  where  status='SUCCESS'";

        $data = $this->db->query($result);
        return $data->row_array() ? $data->row_array() : false;
    }



    ///today
    public function all_transaction_today()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $result = "SELECT  sum(fees_pcab) as pcab_fee,
         sum(legal_research_fund) as lrf,  sum(document_stamp_tax) as ds_tax,
        count(txn_amount) as total_count_today 
                  FROM transactions  where   last_modified like '%" . $today . "%' and  status='SUCCESS'";

        $data = $this->db->query($result);
        // $data->row_array() ? $data->row_array() : false;
        return $data->num_rows() > 0 ? $data->row_array() : false;
    }
    
    public function ngsi_fee_today()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $result = "SELECT ngsi_convenience_fee AS ngsi_fee 
                     FROM transactions  where   last_modified like '%" . $today . "%' and  status='SUCCESS'";

        $data = $this->db->query($result);
        // $data->row_array() ? $data->row_array() : false;
        return $data->num_rows() > 0 ? $data->result_array() : false;
    }


    ////yesterday


    public function ngsi_fee_yesterday()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');

        $yesterday = date('Y-m-d', strtotime('-1 days', strtotime($today)));
        $result = "SELECT ngsi_convenience_fee AS ngsi_fee 
                     FROM transactions  where   last_modified like '%" . $yesterday . "%' and  status='SUCCESS'";

        $data = $this->db->query($result);

        return $data->num_rows() > 0 ? $data->result_array() : false;
    }

    public function all_transaction_yesterday()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');

        $yesterday = date('Y-m-d', strtotime('-1 days', strtotime($today)));
        $result = "SELECT  
           sum(fees_pcab) as pcab_fee,
            sum(legal_research_fund) as lrf,
            sum(document_stamp_tax) as ds_tax,
        
            count(txn_amount) as total_count_transaction 
        FROM transactions  where   last_modified like '%" . $yesterday . "%'  and  status='SUCCESS'";
        $data = $this->db->query($result);
        return $data->row_array() ? $data->row_array() : false;
    }



    public  function round_half_up($number, $decimals)
    {
        return round($number, $decimals, PHP_ROUND_HALF_UP);
    }



    public function all_transaction_this_week($datesArray, $count)
    {
        $today = date('Y-m-d');

        $dates = array_values($datesArray);

        $likePatterns = array_map(
            function ($date) {
                return " '%" . $date . "%'";
            },
            $dates
        );
        $likePatterns1 = array_map(
            function ($date) {
                return  $date;
            },
            $dates
        );
        for ($i = 0; $i < $count; $i++) {



            $qry_select = "SELECT ngsi_convenience_fee AS ngsi_fee 
            FROM transactions  where   last_modified like " .  $likePatterns[$i] . " and  status='SUCCESS'";

            $qry_result = $this->db->query($qry_select);

            $ngsi_fee = $qry_result->num_rows() > 0 ? $qry_result->result_array() : false;

            $sum = 0.0;

            if ($ngsi_fee == false) {
                $ngsi_fee_data = number_format((float)0, 2, '.', ',');
            } else {
                foreach ($ngsi_fee as $item) {
                    $fee = (float) $item['ngsi_fee'];
                    $rounded_fee = $this->round_half_up($fee, 2);

                    $sum += $rounded_fee;
                }
                $ngsi_fee_data = number_format($sum, 2, '.', '');
            }

            $sum_ngsi_fee =      $ngsi_fee_data;

            $sql = 'SELECT count(txn_amount) as total_count,
            sum(txn_amount)  as total_txn_amount,
            sum(fees_pcab) as pcab_fee,
            sum(legal_research_fund) as lrf,
            sum(ngsi_convenience_fee) as ngsi_convenience_fee,
            sum(document_stamp_tax) as ds_tax
            
            
             FROM transactions where  last_modified like ' . $likePatterns[$i] . " and status='SUCCESS'";

            $data = $this->db->query($sql);

            $ngsi_data_sum = $data->num_rows() > 0 ? $data->row_array() : false;
            $resultArray[$i]['total_count_success'] =  $data->num_rows() > 0 ? (int) $data->row()->total_count : false;
            $resultArray[$i]['ds_tax'] = $data->num_rows() > 0 ? number_format((float)$data->row()->ds_tax, 2, '.', ',') : false;
            // $resultArray[ $i ] = $data->num_rows() > 0 ? $data->row_array() : false;



            $resultArray[$i]['pcab_fee'] = $data->num_rows() > 0 ? number_format((float)$data->row()->pcab_fee, 2, '.', ',') : false;
            $resultArray[$i]['lrf'] = $data->num_rows() > 0 ? number_format((float)$data->row()->lrf, 2, '.', ',') : false;
            $txn_amount = $ngsi_data_sum['pcab_fee'] + $ngsi_data_sum['ds_tax'] + $ngsi_data_sum['lrf'] + $sum_ngsi_fee;
            $resultArray[$i]['ngsi_convenience_fee'] = $sum_ngsi_fee;


            $resultArray[$i]['total_txn_amount'] = number_format((float)$txn_amount, 2, '.', ',');





            $qry = 'SELECT count(txn_amount) as total_count_failed FROM transactions where  last_modified like ' . $likePatterns[$i] . " and status='FAILED'";
            $data2 = $this->db->query($qry);

            $resultArray2[$i]['total_count_failed'] = $data2->num_rows() > 0 ? (int) $data2->row()->total_count_failed : false;


            $qry1 = 'SELECT count(txn_amount) as total_count_created FROM transactions where  last_modified like ' . $likePatterns[$i] . " and status='STARTED'";
            $data3 = $this->db->query($qry1);
            $resultArray3[$i]['total_count_created'] = $data3->num_rows() > 0 ? (int) $data3->row()->total_count_created : false;



            $qry4 = 'SELECT count(txn_amount) as total_count FROM transactions where  last_modified like  ' . $likePatterns[$i] . " ";
            $data4 = $this->db->query($qry4);
            $resultArray4[$i]['total_count'] = $data4->num_rows() > 0 ? (int) $data4->row()->total_count : false;

            $get_date[$i]['date'] = $likePatterns1[$i];
        }

        $dayresult = [];

        foreach ($datesArray as $date) {
            $timestamp = strtotime($date);
            $dayOfWeek = date('l', $timestamp);
            $dayresult[] = $dayOfWeek;
        }

        // $result = [];

        foreach ($dayresult as $index => $day) {
            $result[$day]  = $resultArray[$index] + $resultArray2[$index] + $resultArray3[$index] + $resultArray4[$index] + $get_date[$index];
            //   $resultArray2[ $index ];
            //     array_push( $result[ $day ], $resultArray2[ $index ] );
        }

        return $result;
    }

    public function  monthly_transaction($months, $count)
    {


        $yearMonth = array_values($months);

        $likePatterns = array_map(
            function ($date) {
                return " '%" . $date . "%'";
            },
            $yearMonth
        );
        $likePatterns1 = array_map(
            function ($date) {
                return  $date;
            },
            $yearMonth
        );


        for ($i = 0; $i < $count; $i++) {



            $qry_select = "SELECT ngsi_convenience_fee AS ngsi_fee 
            FROM transactions  where   last_modified like " .  $likePatterns[$i] . " and  status='SUCCESS'";

            $qry_result = $this->db->query($qry_select);

            $ngsi_fee = $qry_result->num_rows() > 0 ? $qry_result->result_array() : false;

            $sum = 0.0;

            if ($ngsi_fee == false) {
                $ngsi_fee_data = number_format((float)0, 2, '.', ',');
            } else {
                foreach ($ngsi_fee as $item) {
                    $fee = (float) $item['ngsi_fee'];
                    $rounded_fee = $this->round_half_up($fee, 2);

                    $sum += $rounded_fee;
                }
                $ngsi_fee_data = number_format($sum, 2, '.', '');
            }

            $sum_ngsi_fee = $ngsi_fee_data + 1;

            $sql = 'SELECT count(txn_amount) as total_count,
            sum(txn_amount)  as total_txn_amount,
            sum(fees_pcab) as pcab_fee,
            sum(legal_research_fund) as lrf,
            sum(ngsi_convenience_fee) as ngsi_convenience_fee,
            sum(document_stamp_tax) as ds_tax
            
            
             FROM transactions where  last_modified like ' . $likePatterns[$i] . " and status='SUCCESS'";

            $data = $this->db->query($sql);

            $ngsi_data_sum = $data->num_rows() > 0 ? $data->row_array() : false;
            $resultArray[$i]['total_count_success'] =  $data->num_rows() > 0 ? (int) $data->row()->total_count : false;
            $resultArray[$i]['ds_tax'] = $data->num_rows() > 0 ? number_format((float)$data->row()->ds_tax, 2, '.', ',') : false;
            // $resultArray[ $i ] = $data->num_rows() > 0 ? $data->row_array() : false;



            $resultArray[$i]['pcab_fee'] = $data->num_rows() > 0 ? number_format((float)$data->row()->pcab_fee, 2, '.', ',') : false;
            $resultArray[$i]['lrf'] = $data->num_rows() > 0 ? number_format((float)$data->row()->lrf, 2, '.', ',') : false;
            $txn_amount = $ngsi_data_sum['pcab_fee'] + $ngsi_data_sum['ds_tax'] + $ngsi_data_sum['lrf'] + $sum_ngsi_fee;
            $resultArray[$i]['ngsi_convenience_fee'] = $sum_ngsi_fee;


            $resultArray[$i]['total_txn_amount'] = number_format((float)$txn_amount, 2, '.', ',');





            $qry = 'SELECT count(txn_amount) as total_count_failed FROM transactions where  last_modified like ' . $likePatterns[$i] . " and status='FAILED'";
            $data2 = $this->db->query($qry);

            $resultArray2[$i]['total_count_failed'] = $data2->num_rows() > 0 ? (int) $data2->row()->total_count_failed : false;


            $qry1 = 'SELECT count(txn_amount) as total_count_created FROM transactions where  last_modified like ' . $likePatterns[$i] . " and status='STARTED'";
            $data3 = $this->db->query($qry1);
            $resultArray3[$i]['total_count_created'] = $data3->num_rows() > 0 ? (int) $data3->row()->total_count_created : false;



            $qry4 = 'SELECT count(txn_amount) as total_count FROM transactions where  last_modified like  ' . $likePatterns[$i] . " ";
            $data4 = $this->db->query($qry4);
            $resultArray4[$i]['total_count'] = $data4->num_rows() > 0 ? (int) $data4->row()->total_count : false;

            $get_date[$i]['date'] = $likePatterns1[$i];
        }



        foreach ($months as $date) {
            $timestamp = strtotime($date);
            $dayOfWeek = date('F', $timestamp);
            $dayresult[] = $dayOfWeek;
        }

        foreach ($dayresult as $index => $day) {
            $result[$day]  = $resultArray[$index] + $resultArray2[$index] + $resultArray3[$index] + $resultArray4[$index];
        }
        return $result;

        
    }
}