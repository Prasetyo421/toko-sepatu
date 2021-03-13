<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function index()
    {
        $user = $this->db->get_where('users', ['email' => $this->session->userdata['email']])->row_array();

        $data['name'] = $user['name'];
        $this->load->view('user/index', $data);
    }
}
