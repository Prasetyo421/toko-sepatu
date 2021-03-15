<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        if ($this->session->userdata['email']) {
            $data['sepatu'] = $this->db->get('sepatu')->result_array();
            $data['css'] = 'header-admin.css';

            $this->load->view('templates/header_admin', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/top_bar_admin');
            $this->load->view('templates/main_admin', $data);
            $this->load->view('templates/footer_admin');
        } else {
            $this->load->view('errors/html/error_404');
        }
    }

    public function tambah_sepatu()
    {
        $data['css'] = 'tambah-sepatu.css';
        $data['ukuran'] = $this->db->get('ukuran')->result_array();

        $this->form_validation->set_rules('name-sepatu', 'Nama-Sepatu', 'required|trim|is_unique[sepatu.nama]', [
            'is_uniqed' => 'nama sepatu sudah ada di databse'
        ]);
        $this->form_validation->set_rules('spesifikasi', 'Spesifikasi', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_admin', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/top_bar_admin');
            $this->load->view('admin/add_sepatu', $data);
            $this->load->view('templates/footer_admin');
        } else {
            $namaSepatu = time();

            $jumlahData = count($_FILES['image']['name']);

            $gambar = [];
            for ($i = 0; $i < $jumlahData; $i++) {
                $tmpName = $_FILES['image']['tmp_name'][$i];
                $data = list($width, $height, $type, $attr) = getimagesize($tmpName);
                $ekstensi = explode('/', $data['mime']);
                $ekstensi = $ekstensi[1];

                // Inisialisasi
                $_FILES['file']['name']     = $_FILES['image']['name'][$i];
                $_FILES['file']['type']     = $_FILES['image']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
                $_FILES['file']['size']     = $_FILES['image']['size'][$i];

                // config

                $config['file_name'] = $namaSepatu . '.' . $ekstensi;
                $config['upload_path'] = './asset/image/sepatu';
                $config['allowed_types'] = 'jpg|jpeg|png';

                // memanggil library 
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file') == false) {
                    var_dump($this->upload->display_errors());
                    die;
                } else {
                    $dataUpload = $this->upload->data();

                    $this->load->library('image_lib');

                    $sourceImage = './asset/image/sepatu/' . $dataUpload['file_name'];
                    $fileName    = $dataUpload['raw_name'] . '_crop' . $dataUpload['file_ext'];
                    // var_dump($fileName);
                    // echo '<br>';
                    $gambar['image'][$i] = $this->crop($sourceImage, $fileName);

                    $sourceImage = './asset/image/sepatu/crop/' . $gambar['image'][$i];
                    $fileName    = $dataUpload['raw_name'] . $dataUpload['file_ext'];
                    // var_dump($fileName);
                    // echo '<br>';
                    $gambar['thumb'][$i] = $this->thumb($sourceImage, $fileName);

                    // echo '<br>';
                    // var_dump($gambar['image']);
                    // echo '<br>';
                    // var_dump($gambar['thumb']);
                    // echo '<br>';
                }
            }

            $ukuran = $this->input->post('size');
            $ukuranJSON = json_encode($ukuran);
            $gambarJSON = json_encode($gambar);

            $data = [
                'nama' => htmlspecialchars($this->input->post('name-sepatu'), true),
                'ukuran' => $ukuranJSON,
                'harga' => htmlspecialchars($this->input->post('price'), true),
                'deskripsi' => htmlspecialchars($this->input->post('deskripsi'), true),
                'spesifikasi' => htmlspecialchars($this->input->post('spesifikasi'), true),
                'gambar' => $gambarJSON
            ];

            die;

            $query = $this->db->insert('sepatu', $data);
            if ($query == false) {
                var_dump($this->db->display_error());
                echo ('<br>');
            } else {
                $data['css'] = 'tambah-sepatu.css';
                $data['ukuran'] = $this->db->get('ukuran')->result_array();
                $this->session->set_flashdata('message', '<div class="alert-success">Data berhasil di tambahkan</div>');
                $this->load->view('templates/header_admin', $data);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/top_bar_admin');
                $this->load->view('admin/add_sepatu', $data);
                $this->load->view('templates/footer_admin');
                // $allData = $this->db->get('sepatu')->result_array();
                // var_dump($allData);
            }
        }
    }

    private function crop($sourceImage, $fileName)
    {
        // var_dump($fileName);
        // echo '<br>';

        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourceImage;
        $config['maintain_ratio'] = FALSE;
        $config['x_axis'] = 0;
        $config['y_axis'] = 280;
        $config['width'] = 720;
        $config['height'] = 720;
        $config['new_image'] = './asset/image/sepatu/crop/' . $fileName;

        $this->image_lib->initialize($config);

        //$this->image_lib->crop();

        if (!$this->image_lib->crop()) {
            echo $this->image_lib->display_errors();
        } else {
            $this->image_lib->clear();
            return $fileName;
        }
    }

    private function thumb($sourceImage, $fileName)
    {
        echo 'parameter filename thumb: ' . $fileName;
        echo '<br>';

        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourceImage;
        $config['create_thumb'] = TRUE;
        $config['width'] = 100;
        $config['new_image'] = './asset/image/sepatu/thumb/' . $fileName;

        $this->image_lib->initialize($config);

        //$this->image_lib->crop();

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        } else {
            $this->image_lib->clear();
            echo 'filename thumb: ' . $fileName;
            echo '<br>';
            return $fileName;
        }
    }

    private function checkDataExist($table, $column, $key)
    {
        $query = $this->db->get_where($table, [$column => $key]);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
