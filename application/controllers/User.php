<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $user = $this->db->get_where('users', ['email' => $this->session->userdata['email']])->row_array();

        $data['name'] = $user['name'];
        $this->load->view('user/index', $data);
    }
}
