<?php

function formatHarga($str = '')
{
    $insert = '.';
    $i = 1;
    while (($pos = strlen($str) - (3 * $i + ($i - 1))) > 0) {
        $str = substr($str, 0, $pos) . $insert . substr($str, $pos);

        $i++;
    }

    return $str;
}

function is_logged_in()
{
    $ci = get_instance();
    $email = $ci->session->userdata('email');
    if (!$email) {
        $menu = $ci->uri->segment(1);
        if (isset($menu)) {
            if ($menu != 'home') {
                redirect('auth');
            }
        }
    } else {
        $user = $ci->db->get_where('users', ['email' => $email]);
        if ($user->num_rows() < 1) {
            $ci->session->set_flashdata('message', '<div class="alert-danger">Email not found</div>
            ');
            redirect('auth');
        } else {
            $menu = $ci->uri->segment(1);
            $roleId = $ci->session->userdata('role_id');
            if ($roleId == 2 && $menu == 'admin') {
                redirect('auth/blocked');
            }
            return true;
        }
    }
}
