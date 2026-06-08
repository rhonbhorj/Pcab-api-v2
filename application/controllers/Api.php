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

    /**
     * Unserialize a single CodeIgniter session value
     * @param string $serialized The serialized value
     * @return mixed The unserialized value
     */
    private function unserialize_ci_value($serialized)
    {
        if (empty($serialized)) {
            return null;
        }

        // Integer: i:value
        if (strpos($serialized, 'i:') === 0) {
            return (int) substr($serialized, 2);
        }
        // Boolean: b:0 or b:1
        elseif (strpos($serialized, 'b:') === 0) {
            return (bool) (int) substr($serialized, 2);
        }
        // Null: N
        elseif ($serialized === 'N') {
            return null;
        }
        // String: s:length:"string"
        elseif (strpos($serialized, 's:') === 0) {
            preg_match('/s:(\d+):"(.*)"/', $serialized, $matches);
            return isset($matches[2]) ? $matches[2] : null;
        }

        return null;
    }

    /**
     * Parse CodeIgniter's custom session format
     * @param string $data The serialized session data
     * @return array The unserialized session array
     */
    private function unserialize_ci_session($data)
    {
        $result = [];

        // Split by semicolons to get individual key-value pairs
        $pairs = explode(';', $data);

        foreach ($pairs as $pair) {
            if (empty($pair)) {
                continue;
            }

            // Split by the first | to separate key from serialized value
            $pos = strpos($pair, '|');
            if ($pos === false) {
                continue;
            }

            $key = substr($pair, 0, $pos);
            $serialized = substr($pair, $pos + 1);

            // Parse the serialized value
            $value = $this->unserialize_ci_value($serialized);
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Validate session by session_id by checking if session file exists
     * @param string $session_id The session ID to validate
     * @return bool True if valid session exists, false otherwise
     */
    private function validate_session($session_id)
    {
        if (empty($session_id)) {
            return false;
        }

        // Get session save path and construct the session file path
        $sess_save_path = config_item('sess_save_path');
        $sess_driver = config_item('sess_driver');

        // Only support files driver
        if ($sess_driver !== 'files') {
            return false;
        }

        // Normalize the path to use forward slashes consistently
        $sess_save_path = str_replace('\\', '/', $sess_save_path);
        if (substr($sess_save_path, -1) !== '/') {
            $sess_save_path .= '/';
        }

        // Construct the session file path
        $session_file = $sess_save_path . 'ci_session' . $session_id;

        // Check if session file exists
        if (!file_exists($session_file)) {
            return false;
        }

        // Read session file with proper error handling
        $session_data = file_get_contents($session_file);
        if ($session_data === false || empty($session_data)) {
            return false;
        }

        // Parse CodeIgniter's custom session format
        $data = $this->unserialize_ci_session($session_data);

        if (empty($data) || !is_array($data)) {
            return false;
        }

        // Check if the session has logged_in flag set to TRUE
        if (!isset($data['logged_in']) || $data['logged_in'] !== TRUE) {
            return false;
        }

        return true;
    }


    public function get_all_transaction()
    {
        $stream = json_decode($this->input->raw_input_stream, true);

        $session_id = $stream['session_id'] ?? $this->input->post('session_id');
        $from_date = $this->input->get('from_date') ?? $stream['from_date'] ?? $this->input->post('from_date');
        $to_date = $this->input->get('to_date') ?? $stream['to_date'] ?? $this->input->post('to_date');

        // 1. VALIDATION: Verify session_id is valid and authenticated
        if (!$this->validate_session($session_id)) {
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

        // 1. VALIDATION: Verify session_id is valid and authenticated
        if (!$this->validate_session($session_id)) {
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

        // Added Date Filter Inputs
        $from_date = $this->input->get('from_date') ?? $stream['from_date'] ?? $this->input->post('from_date') ?? null;
        $to_date = $this->input->get('to_date') ?? $stream['to_date'] ?? $this->input->post('to_date') ?? null;

        // Read Pagination Parameters (Defaulting to Page 1, Limit 10)
        $page = (int) ($this->input->get('page') ?? $stream['page'] ?? $this->input->post('page') ?? 1);
        $limit = (int) ($this->input->get('limit') ?? $stream['limit'] ?? $this->input->post('limit') ?? 10);

        // Enforce minimum values for safe calculation
        if ($page < 1)
            $page = 1;
        if ($limit < 1)
            $limit = 10;

        // 1. VALIDATION: Verify session_id is valid and authenticated
        if (!$this->validate_session($session_id)) {
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

        // 🚀 2. EXECUTION: Pass search strings and date strings to the model
        $result = $this->Api->get_search_transactions($limit, $offset, $search, $from_date, $to_date);

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
