<?php

use Restserver\Libraries\REST_Controller;

defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );
require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php';
require_once( APPPATH . 'services/ApiService.php' );

class Api extends REST_Controller
 {

    public $apiService;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set( 'Asia/Manila' );
        $this->apiService = new ApiService();
        $this->load->model( 'Model_repo', 'model' );

        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE' );
        header( 'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With' );
    }



    public function generate_token_get()
    {
           $this->output->set_content_type( 'application/json' );

        
        $header = apache_request_headers();



 if (array_key_exists('X-API-KEY', $header) != true || array_key_exists('X-API-USERNAME', $header) != true || array_key_exists('X-API-PASSWORD', $header) != true) {
            // if (array_key_exists('X-API-KEY', $header) != true ) {
            $resp['status'] = FALSE;
            $resp['message'] = 'Api parameters is invalid';


            $this->response(  $resp,Rest_Controller::HTTP_UNAUTHORIZED);
        } else {
         
  $response =$this->apiService->mw_token($header);

   $this->response( json_decode( $response[ 'response' ], true ), $response[ 'status_code' ] );
        }





       
    }



    public function trans_status_post()
    {
           $this->output->set_content_type( 'application/json' );
              $header = apache_request_headers();
          $data[ 'data' ] = json_decode( file_get_contents( 'php://input' ), true );
      
        $response =$this->apiService->transaction_status($data[ 'data' ] ,$header);

       $this->response( json_decode( $response[ 'response' ], true ), $response[ 'status_code' ] );
       
    }



 }