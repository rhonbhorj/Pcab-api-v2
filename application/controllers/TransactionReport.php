<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class TransactionReport extends CI_Controller
 {

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'Dashboard_repo', 'repo' );
        // if ( $this->session->userdata( 'logged_in' ) === !TRUE ) {
        //     redirect( 'login' );
        // }

    }


  public  function round_half_up($number, $decimals) {
        return round($number, $decimals, PHP_ROUND_HALF_UP);
    }

    public function sumNgsiFee()
    {

      $data=  $this->repo->totalNgsifee();
   
       


        $sum = 0.0;


        foreach ($data as $item) {
            $fee = (float) $item['ngsi_fee'];
            $rounded_fee = $this->round_half_up($fee, 2);
            $sum += $rounded_fee;
        }

        return number_format($sum, 2, '.', ''); 

  
 
      

    }

      ////today
  public function   transactionToday()
  {
        $data = $this->repo->all_transaction_today();

        $ngsifee=  $this->repo->ngsi_fee_today();

        $sum = 0.0;

            if(  $ngsifee==false){
                $ngsi_fee_data=0;
                
            }else{
                foreach ($ngsifee as $item) {
                    $fee = (float) $item['ngsi_fee'];
                    $rounded_fee = $this->round_half_up($fee, 2);
                    
                    
                    $sum += $rounded_fee;
                }
                $ngsi_fee_data=number_format($sum, 2, '.', '');
            } 

            // $result = "SELECT  sum(fees_pcab) as pcab_fee,
            // sum(legal_research_fund) as lrf, 
            $to_number_format=$data[ 'lrf' ]+$data[ 'ds_tax' ]+$data[ 'pcab_fee' ]+$ngsi_fee_data;

            
                        $return_data = [
                            'total_txn_amount_today' => number_format( ( float )$to_number_format, 2, '.', ',' ),
                            'total_count_today' => number_format( ( float )$data[ 'total_count_today' ], 0, '.', ',' )
            ];
            return $return_data;
  }


////////                yesterday
  public function  transactionYesterday()
  {
    
    $all_transaction_yesterday = $this->repo->all_transaction_yesterday();
    $ngsifee=  $this->repo->ngsi_fee_yesterday();

    
     $sum = 0.0;

        if(  $ngsifee==false){
           $ngsi_fee_data=0;
                
            }else{
                foreach ($ngsifee as $item) {
                    $fee = (float) $item['ngsi_fee'];
                    $rounded_fee = $this->round_half_up($fee, 2);
                    
                    
                    $sum += $rounded_fee;
                }
                $ngsi_fee_data=number_format($sum, 2, '.', '');
            } 
    $to_number_format=$all_transaction_yesterday[ 'lrf' ]+$all_transaction_yesterday[ 'ds_tax' ]+$all_transaction_yesterday[ 'pcab_fee' ]+$ngsi_fee_data;
                     
    $return_data = [
                    'total_txn_amount_yesterday' =>number_format( ( float )$to_number_format, 2, '.', ',' ) ,
                    'total_count_transaction' => number_format( ( float )$all_transaction_yesterday[ 'total_count_transaction' ], 0, '.', ',' )
                 ];
            
            return $return_data;
    
  }
    
  
    public function dasboardReportData()
 {

        // if ( !$this->is_user_logged_in() ) {
        //     // Redirect to the login page
        //     redirect( 'login' );
        //     return;
        // }

            
        ///over all transaction 
        $alltransaction = $this->repo->all_transaction_data();
        $sunm_transaction =$alltransaction[ 'lrf' ]+$alltransaction[ 'ds_tax' ]+$alltransaction[ 'pcab_fee' ]+$this->sumNgsiFee();
        $data[ 'alltransaction' ] = [
            'total_txn_amount' => number_format( ( float )$sunm_transaction, 2, '.', ',' ),
            'total_count_success' => number_format( ( float )$alltransaction[ 'total_count' ], 0, '.', ',' )
        ];

        //       array of todays trtansaction 
        $data[ 'today_transaction' ] = $this->transactionToday();



        ///transaction yesterday
    

        $data[ 'yesterday_transaction' ] =  $this-> transactionYesterday();

        $data[ 'all_transaction_this_week' ] = $this->day_count();
        $data[ 'monthly_transaction' ] = $this->month_count();

        echo json_encode( $data );

        // $json_data = json_encode( $data );
        // $data[ 'json_data' ] = $json_data;

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

        return $this->repo->all_transaction_this_week( $yesterday, $i );

     

    }
    public function month_count()
    {
        $currentMonthNumber = date('m');  // Get the current month as a number (e.g., 09 for September)
        $currentYear = date('Y');         // Get the current year
        $months = [];                     // Initialize an array to store the month-year combinations
        
        // Loop through all months from 1 to the current month
        for ($i = 1; $i <= $currentMonthNumber; $i++) {
            // Ensure single-digit months have a leading zero using str_pad
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $months[] = "$currentYear-$month";  // Add each month to the array in the format YYYY-MM
        }
        
        // Call the repository method with the months array and current month number
        $result = $this->repo->monthly_transaction($months, $currentMonthNumber);
        
        return $result;
    }
    
    // public function month_count()
    // {
    //     $currentMonthName = date( 'm' );
    //     $today = date( 'Y-m-d' );


    

    //         if($currentMonthName  >=10){
    //             for ($i = 0; $i <  $currentMonthName; $i++) {
                    
    //                 $months[] = date('Y')."-".($i + 1);
    //             }
                
    //         }else{
    //             for ($i = 0; $i <  $currentMonthName; $i++) {
                    
    //                 $months[] = date('Y')."-0".($i + 1);
    //             }
    //         }
            
                
    //             $result =   $this->repo->monthly_transaction( $months, $currentMonthName );
            

    //                 return   $result;
                
                
    // }

    private function is_user_logged_in()
 {
        // Check if the 'logged_in' session variable exists and is set to TRUE
        return $this->session->userdata( 'logged_in' ) === TRUE;
    }
}