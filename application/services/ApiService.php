<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiService
{

    protected $CI;

    protected $secret_key;

    protected $endpoint_base_url;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();

        // Key for encryption ( must be the same on both ends )
        // $this->secret_key = $_ENV[ 'SECRET_KEY' ];
        $this->endpoint_base_url = $_ENV['ENDPOINT_BASE_URL'];
    }


    public function call_external_api($data, $access)
    {
        // $endpoint = $this->endpoint_base_url . '/pgw/api/v1/transactions/qr-codes/generate/';

             $endpoint = $this->endpoint_base_url . '/v1/cashin';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization:' . $access['Authorization'],
            'X-API-KEY: '.$access['X-API-KEY'],
            'X-API-USERNAME: '.$access['X-API-USERNAME'],
            'X-API-PASSWORD: '.$access['X-API-PASSWORD'],
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_PRESERVE_ZERO_FRACTION));

        $response = curl_exec($ch);
        $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // if ( curl_errno( $ch ) ) {
        // $error = curl_error( $ch );

        // http_response_code( 500 );

        // return [
        // 'status_code' => 500,
        // 'error' => $error
        // ];
        // }
        curl_close($ch);

        // expecting to be a json encoded response
        $resp['response'] = $response;
        $resp['status_code'] = $http_status_code;

        return $resp;
    }

    public function call_back($data, $endpoint)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $endpoint,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($data),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
       
       
        $resp['response'] =json_encode($data);
        $resp['status_code'] = $http_status_code;

        return $resp;
    }

 public function mw_token($access){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $this->endpoint_base_url.'/generate-token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-API-KEY: '.$access['X-API-KEY'],
    'X-API-USERNAME: '.$access['X-API-USERNAME'],
    'X-API-PASSWORD: '.$access['X-API-PASSWORD']
  ),
));

      $response = curl_exec($curl);
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
           $resp['response'] = $response;
        $resp['status_code'] = $http_status_code;

        return $resp;

    }

}