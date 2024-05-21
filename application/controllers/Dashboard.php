<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_repo', "repo");
    }

    public function index()
    {
        echo "pangit";
    }

    public function dasboardRepoertDdata()
    {
        $data['alltransaction'] = $this->repo->all_transaction_data();
        $data['today-transaction'] = $this->repo->all_transaction_today();

        $today = date('l');

        // Initialize the $yesterday array
        $yesterday = array();

        // Switch case to handle different days of the week
        switch ($today) {
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

        $data['all-transaction-this-week'] = $this->repo->all_transaction_this_week($yesterday, $i);

        echo json_encode($data);

        // dito pert
        // $this->load->view('<your dashbaord view', $data);
    }
}