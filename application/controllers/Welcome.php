<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Welcome extends CI_Controller
 {
    public function __construct()
    {
        parent::__construct();

        $this->load->model( 'CrudModel', 'crud' );
        // $this->class->yourfnc();

    }




    public function index()
    {

        if ( $this->is_user_logged_in() ) {

            $result[ 'route' ] = $this->uri->segment( 1 );

            if ( $result[ 'route' ] == 'dashboard' ) {
                redirect( '/transaction-dashboard' );
                return;
            }

            if ( $result[ 'route' ] == 'acknowledgement-receipt' ) {
                $latest_deposit = $this->crud->last_data_deposit();
                $result[ 'data' ] = $this->crud->get_all_data();
                $result[ 'last_deposit' ] = $latest_deposit ? $this->crud->get_deposit_transactions( [ $latest_deposit[ 'dep_id' ] ] )[ 0 ] : null;
                $result[ 'last_deposit_date' ] = $latest_deposit ? $latest_deposit[ 'deposited_date' ] : null;
            }

            if ( $result[ 'route' ] == 'deposit' ) {

                $deposits = $this->crud->all_deposit_data();
                if ( $deposits ) {

                    $deposit_transations_added = array_map( function ( $data ) {
                        $transactions = $this->crud->get_deposit_transactions( $data[ 'dep_id' ] );
                        $last_transactions = $this->crud->get_deposit_transactions( $data[ 'last_deposit_trans_id' ] );
                        $data[ 'transactions' ] = $transactions[ 0 ] ?? null;
                        $data[ 'last_deposit_transactions' ] = $last_transactions[ 0 ] ?? null;
                        return $data;
                    }
                    , $deposits ? $deposits : [] );



                    $latest_deposit = $this->crud->last_data_deposit();
                    $result[ 'last_deposit' ] = $latest_deposit ? $this->crud->get_deposit_transactions( [ $latest_deposit[ 'dep_id' ] ] )[ 0 ] : null;
                    $result[ 'last_deposit_date' ] = $latest_deposit ? $latest_deposit[ 'deposited_date' ] : null;

                    $result[ 'data' ] = $deposit_transations_added;
                } else {
                    $result[ 'data' ] = false;
                }
            }

            if ( $result[ 'route' ] == 'transaction-table' ) {
                if ( $_SESSION[ 'usertype' ] == 'SUPERADMIN' ) {
                    $result[ 'data' ] = $this->crud->get_all_transaction_data();
                } else {
                    redirect( 'login' );
                }
            }

			if ( $result[ 'route' ] == 'transaction-dashboard' ) {

			}

            $this->load->view( 'index', $result );
        } else {
            redirect( 'login' );
        }
    }

    public function validate_route( $route )
    {
        if ( isset( $route ) ) {
            $this->load->view( './modules/admin_dashboard' );
            return;
        }
        if ( $route == 'crud' ) {
            $this->load->view( './modules/admin_dashboard' );
        }
    }



    public function redirect()
    {

        // ## With Model ####
        // $result[ 'data' ] = $this->CrudModel->display_record();

        // ## Without Model ####
        $route = $this->uri->segment( 1 );
        $result[ 'data' ] = $this->db->select( '*' )
        ->from( 'payment_transaction' )
        ->get()->result_array();
        $result[ 'route' ] = $route;
        $this->load->view( 'index', $result );
    }

    public function test_api()
    {

        $query = $this->db->query( 'SELECT * FROM payment_transaction' );
        echo json_encode( $query->result_array() );
    }


    private function is_user_logged_in()
    {
        // Check if the 'logged_in' session variable exists and is set to TRUE
        return $this->session->userdata( 'logged_in' ) === TRUE;
    }

    public function test_data()
    {
        $result[ 'data' ] = $this->crud->get_all_transaction_data();
        echo json_encode( $result );
    }

	public function faq_page(){
		$this->load->view('webpage/faq-page');
	}
    public function maintenance(){
		$this->load->view('maintenance/maintenance');
	}
}