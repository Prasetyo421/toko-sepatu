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
                        redirect('admin');
                    } else {
                        redirect('user');
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

    public function login_google()
    {
        require_once APPPATH . "libraries/vendor/autoload.php";

        $google_client = new $Google_Client();
        $google_client->setClientId('1073361218611-ngc6dv9868f2eodnigrjm5nm9u23tllv.apps.googleusercontent.com');
        $google_client->setClientSecret('dauEkR89TUmp7Vb-bHvwUtCZ');
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
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => htmlspecialchars($this->input->post('email'), true),
                'token' => $token,
                'date_created' => time()
            ];

            $this->_sendEmail($token, 'verify');

            $this->db->insert('user_token', $user_token);
            $this->db->insert('users', $data);


            $this->session->set_flashdata('message', '<div class="alert-success">Congratulatio!! your account has been created. Please Login</div>');
            redirect('auth');
        }
    }

    public function forgetPassowrd()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('message', '<div class="alert-danger">isi email terlebih dahulu! </div>');
            redirect('auth');
        } else {
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => htmlspecialchars($this->input->post('email'), true),
                'token' => $token,
                'date_created' => time()
            ];

            $email = htmlspecialchars($this->input->post('email'), true);

            $this->db->delete('user_token', ['email' => $email]);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'forgot password');

            $this->session->set_flashdata('message', '<div class="alert-success">email lupa sandi telah dikirim </div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'akunujicoba1999@gmail.com',
            'smtp_pass' => 'Rahasiabanget',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('akunujicoba1999@gmail.com', 'Toko Sepatu');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('verify');
            $this->email->message('click this link to verify your eccount: ' . '<a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> active </a>');
        } else if ($type == 'forgot password') {
            $this->email->subject('forgot password');
            $this->email->message('click this link to change your password: ' . '<a href="' . base_url() . 'auth/forget?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> change password </a>');
        }

        if (!$this->email->send()) {
            echo $this->email->print_debugger();
            die;
        } else {
            return true;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if (!$user) {
            $this->session->set_flashdata('message', '<div class="alert-danger">Email yang anda masukan salah</div>');
            redirect('auth/registration');
        } else {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if (!$user_token) {
                $this->session->set_flashdata('message', '<div class="alert-danger">Token yang anda masukan salah</div>');
                redirect('auth/registration');
            } else {
                if ($user_token['date_created'] - time() > 60) {
                    $this->session->set_flashdata('message', '<div class="alert-danger">Token expired</div>');
                    redirect('auth/registration');
                } else {
                    $this->db->delete('user_token', ['token' => $token]);
                    $this->db->update('users', ['is_active' => 1], ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert-succes">Email telah active</div>');
                    redirect('auth');
                }
            }
        }
    }

    public function forget()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        if (!$user) {
            $this->session->set_flashdata('message', '<div class="alert-danger">Email salah</div>');
            redirect('auth/registration');
        } else {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if (!$user_token) {
                $this->session->set_flashdata('message', '<div class="alert-danger">Token Salah</div>');
                redirect('auth/registration');
            } else {
                if ((time() - $user_token['date_created']) > (60)) {
                    $this->db->delete('user_token', ['id' => $user_token['id']]);
                    $this->session->set_flashdata('message', '<div class="alert-danger"> Token Expired!</div>');
                    redirect('auth/registration');
                } else {
                    $this->load->view('auth');
                }
            }
        }
    }

    public function changePassword()
    {
        $email = htmlspecialchars($this->input->post('email'), true);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]|min_length[3]', [
            'matches' => 'password dont matches',
            'min_length' => 'password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password2', 'required|trim|matches[password1]');

        if (!$this->form_validation->run()) {
            $this->load->view('auth');
        } else {
            $password = htmlspecialchars($this->input->post('password1'), true);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'password' => $password
            ];
            $this->db->update('users', $data, ['email' => $email]);
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

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
