<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_Model', 'Api');
        header("Content-Type: application/json");

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Authorization, X-API-KEY");
    }


    public function get_all_transaction()
    {
        $stream = json_decode($this->input->raw_input_stream, true);

        $session_id = $stream['session_id'] ?? $this->input->post('session_id');
        $from_date = $this->input->get('from_date') ?? $stream['from_date'] ?? $this->input->post('from_date');
        $to_date = $this->input->get('to_date') ?? $stream['to_date'] ?? $this->input->post('to_date');

        if (!isset($this->session)) {
            $this->load->library('session');
        }

        if (empty($session_id) || $session_id !== $this->session->session_id) {
            $response = (object) [
                'status' => false,
                'message' => 'Unauthorized access. Invalid or expired session ID.',
                'data' => []
            ];

            $this->output
                ->set_status_header(401) // 401 Unauthorized Status Header
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }

        if (empty($from_date) || empty($to_date)) {
            $response = (object) [
                'status' => false,
                'message' => 'Both from_date and to_date are required parameters.',
                'data' => []
            ];

            $this->output
                ->set_status_header(400) // 400 Bad Request
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }

        $data = $this->Api->get_all_transaction($from_date, $to_date);

        $response = (object) [
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ];

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
}
