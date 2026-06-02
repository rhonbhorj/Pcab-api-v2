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

    public function acknowledgement_receipt()
    {
        // Read JSON payload inputs or fall back to standard GET/POST methods
        $stream = json_decode($this->input->raw_input_stream, true);

        $session_id = $stream['session_id'] ?? $this->input->post('session_id');
        $from_date = $this->input->get('from_date') ?? $stream['from_date'] ?? $this->input->post('from_date');
        $to_date = $this->input->get('to_date') ?? $stream['to_date'] ?? $this->input->post('to_date');

        // 🚀 Read Pagination Parameters (Defaulting to Page 1, Limit 10)
        $page = (int) ($this->input->get('page') ?? $stream['page'] ?? $this->input->post('page') ?? 1);
        $limit = (int) ($this->input->get('limit') ?? $stream['limit'] ?? $this->input->post('limit') ?? 10);

        // Enforce minimum values for safe calculation
        if ($page < 1)
            $page = 1;
        if ($limit < 1)
            $limit = 10;

        // Ensure CodeIgniter's Native Session library is fully initialized
        if (!isset($this->session)) {
            $this->load->library('session');
        }

        // 1. VALIDATION: Verify session_id matches active server session
        if (empty($session_id) || $session_id !== $this->session->session_id) {
            $response = (object) [
                'status' => false,
                'message' => 'Unauthorized access. Invalid or expired session ID.',
                'data' => []
            ];

            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }

        // 2. VALIDATION: Ensure datepicker values are provided
        if (empty($from_date) || empty($to_date)) {
            $response = (object) [
                'status' => false,
                'message' => 'Both from_date and to_date are required parameters.',
                'data' => []
            ];

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }

        // Calculate database query offset
        $offset = ($page - 1) * $limit;

        // 🚀 3. EXECUTION: Pass limit and offset to your updated model method
        $result = $this->Api->get_paginated_transactions($from_date, $to_date, $limit, $offset);

        if ($result !== false && !empty($result['records'])) {
            $total_pages = ceil($result['total_records'] / $limit);

            $response = (object) [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'pagination' => (object) [
                    'total_records' => (int) $result['total_records'],
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total_pages' => $total_pages
                ],
                'data' => $result['records']
            ];
            $status_code = 200;
        } else {
            $response = (object) [
                'status' => false,
                'message' => 'No transaction records found matching the selected criteria.',
                'pagination' => (object) [
                    'total_records' => 0,
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total_pages' => 0
                ],
                'data' => []
            ];
            $status_code = 404;
        }

        // Output clean JSON native response
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function acknowledgement_receipt_search()
    {
        // Read JSON payload inputs or fall back to standard GET/POST methods
        $stream = json_decode($this->input->raw_input_stream, true);

        $session_id = $stream['session_id'] ?? $this->input->post('session_id');
        $search = $this->input->get('search') ?? $stream['search'] ?? $this->input->post('search') ?? null;

        // Read Pagination Parameters (Defaulting to Page 1, Limit 10)
        $page = (int) ($this->input->get('page') ?? $stream['page'] ?? $this->input->post('page') ?? 1);
        $limit = (int) ($this->input->get('limit') ?? $stream['limit'] ?? $this->input->post('limit') ?? 10);

        // Enforce minimum values for safe calculation
        if ($page < 1)
            $page = 1;
        if ($limit < 1)
            $limit = 10;

        // Ensure CodeIgniter's Native Session library is fully initialized
        if (!isset($this->session)) {
            $this->load->library('session');
        }

        // 1. VALIDATION: Verify session_id matches active server session
        if (empty($session_id) || $session_id !== $this->session->session_id) {
            $response = (object) [
                'status' => false,
                'message' => 'Unauthorized access. Invalid or expired session ID.',
                'data' => []
            ];

            $this->output
                ->set_status_header(401) // 401 Unauthorized
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }

        // Calculate database query offset
        $offset = ($page - 1) * $limit;

        // 🚀 2. EXECUTION: Call the schema-matched search transaction model
        $result = $this->Api->get_search_transactions($limit, $offset, $search);

        if ($result !== false && !empty($result['records'])) {
            $total_pages = ceil($result['total_records'] / $limit);

            // Structuring the clean paginated API response
            $response = (object) [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'pagination' => (object) [
                    'total_records' => (int) $result['total_records'],
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total_pages' => $total_pages
                ],
                'data' => $result['records']
            ];
            $status_code = 200;
        } else {
            $response = (object) [
                'status' => false,
                'message' => 'No transaction records found matching the search criteria.',
                'pagination' => (object) [
                    'total_records' => 0,
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total_pages' => 0
                ],
                'data' => []
            ];
            $status_code = 404; // 404 Not Found
        }

        // Output clean JSON native response
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
}
