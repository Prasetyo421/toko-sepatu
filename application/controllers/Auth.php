<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login.php');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $password = $this->input->post('password', true);
        $user = $this->db->get_where('users', ['email' => $this->input->post('email')])->row_array();

        if ($user) {
            // emailnya ada
            if ($user['is_active'] == 1) {
                // email telah active
                if (password_verify($password, $user['password'])) {
                    // password benar
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('user');
                    } else {
                        redirect('admin');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert-danger">Wrong Password</div>
                    ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert-danger">account not yet activate. Please activet!!</div>
                ');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert-danger">Email not ready</div>
            ');
            redirect('auth');
        }
    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont matches',
            'min_length' => 'password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


        if ($this->form_validation->run() == false) {
            $this->load->view('auth/registration');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash(htmlspecialchars($this->input->post('password1', true)), PASSWORD_DEFAULT),
                'image' => 'default.png',
                'role_id' => 1,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->session->set_flashdata('message', '<div class="alert-success">Congratulatio!! your account has been created. Please Login</div>
            ');
            $this->db->insert('users', $data);
            redirect('auth');
        }
    }

    public function logout()
    {
        unset($_SESSION['email']);
        unset($_SESSION['role_id']);

        $this->session->set_flashdata('message', '<div class="alert-success">You have been logged out</div>
        ');
        redirect('auth');
    }
}
