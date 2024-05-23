<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class TransactionReport extends CI_Controller
 {

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'Dashboard_repo', 'repo' );
    }

    public function dasboardReportData()
 {

        $alltransaction = $this->repo->all_transaction_data();
        $data[ 'alltransaction' ] = [
            'total_txn_amount' => number_format( ( float )$alltransaction[ 'total_txn_amount' ], 2, '.', ',' ),
            'total_count' => number_format( ( float )$alltransaction[ 'total_count' ], 0, '.', ',' )
        ];

        $allTransactionToday = $this->repo->all_transaction_today();
        $data[ 'today_transaction' ] = [
            'total_txn_amount_today' => number_format( ( float )$allTransactionToday[ 'total_txn_amount_today' ], 2, '.', ',' ),
            'total_count_today' => number_format( ( float )$allTransactionToday[ 'total_count_today' ], 0, '.', ',' )
        ];

        $all_transaction_yesterday = $this->repo->all_transaction_yesterday();

        $data[ 'yesterday_transaction' ] =  [
            'total_txn_amount_yesterday' => number_format( ( float )$all_transaction_yesterday[ 'total_txn_amount_yesterday' ], 2, '.', ',' ),
            'total_count_transaction' => number_format( ( float )$all_transaction_yesterday[ 'total_count_transaction' ], 0, '.', ',' )
        ];

        $data[ 'all_transaction_this_week' ] = $this->day_count();
        $data[ 'monthly_transaction' ] = $this->month_count();
        // echo json_encode( $data );
        // $this->load->view( 'modules/dashboard', $data );
    }

    public function day_count()
 {

        $today = date( 'l' );

        // Initialize the $yesterday array
        $yesterday = array();

        // Switch case to handle different days of the week
        switch ( $today ) {
            case 'Monday':
            // Only today's date
            // $i = 0;
            // $yesterday[] = date('Y-m-d', strtotime("days", strtotime($today)));

            for ($i = 0; $i < 1; $i ++) {
                $yesterday[] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        case 'Tuesday':

            for ($i = 0; $i < 2; $i ++) {
                $yesterday['data' . ($i + 1)] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        case 'Wednesday':
            for ($i = 0; $i < 3; $i ++) {
                $yesterday['data' . ($i + 1)] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        case 'Thursday':

            for ($i = 0; $i < 4; $i ++) {
                $yesterday['data' . ($i + 1)] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        case 'Friday':

            for ($i = 0; $i < 5; $i ++) {
                $yesterday['data' . ($i + 1)] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        case 'Saturday':

            for ($i = 0; $i < 6; $i ++) {
                $yesterday['data' . ($i + 1)] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        case 'Sunday':

            for ($i = 0; $i < 7; $i ++) {
                $yesterday['data' . ($i + 1)] = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            }
            break;

        default:
            // Default case to handle any unexpected input
            $yesterday['data'] = $today;
            break;
    }

        $data[ 'all_transaction_this_week' ] = $this->repo->all_transaction_this_week( $yesterday, $i );

        $data['monthly_transaction']= $this->month_count();

        // echo json_encode($data);

        $json_data = json_encode($data);
        $data['json_data'] = $json_data;
        // echo '<pre>'; print_r($data); echo '</pre>';        
        $this->load->view('modules/dashboard.php', $data);

    }

    
    public function month_count()
    {
        $currentMonthName = date( 'F' );
        $today = date( 'Y-m-d' );


        switch ($currentMonthName) {
            case 'January':
                // Only today's date
            // $i = 0;
            // $yesterday[] = date( 'Y-m-d', strtotime( 'days', strtotime( $today ) ) );

            for ( $i = 0; $i < 1; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'February':

            for ( $i = 0; $i < 2; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'March':
            for ( $i = 0; $i < 3; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'April':

            for ( $i = 0; $i < 4; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'May':

            for ( $i = 0; $i < 5; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'June':

            for ( $i = 0; $i < 6; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'July':

            for ( $i = 0; $i < 7; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;
            case 'August':

            for ( $i = 0; $i < 8; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;
            case 'September':

            for ( $i = 0; $i < 9; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;
            case 'October':

            for ( $i = 0; $i < 10; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'November':

            for ( $i = 0; $i < 11; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            case 'December':

            for ( $i = 0; $i < 12; $i ++ ) {
                $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            }
            break;

            default:
            $months[] = date( 'Y-m', strtotime( "-$i month", strtotime( $today ) ) );
            break;
        }

        $result =   $this->repo->monthly_transaction( $months, $i );

        return  $result ;
        // echo $today;
    }
}