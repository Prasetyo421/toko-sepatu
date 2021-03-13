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
            $namaSepatu = $this->input->post('name-sepatu');

            // jika ada gambar yang di upload
            if ($_FILES['image']['name']) {
                $tmpName = $_FILES['image']['tmp_name'];
                $data = list($width, $height, $type, $attr) = getimagesize($tmpName);

                $ekstensi = explode('/', $data['mime']);
                $ekstensi = $ekstensi[1];
                $config['file_name']         = $namaSepatu . '.' . $ekstensi;
                $config['upload_path']       = './asset/image/sepatu';
                $config['allowed_types']     = 'jpg|jpeg|png|gif';

                $this->load->library('upload', $config);

                // jika berhasil mengupload gambar
                if (!$this->upload->do_upload('image')) {
                    echo $this->upload->display_errors();
                    die;
                } else {
                    $data = $this->upload->data();

                    $this->load->library('image_lib');

                    $fileName = '';
                    // CROP
                    if ($height / 80 == 16 && $width / 80 == 9) {
                        // lakukan crop
                        $fileName = $this->crop('./asset/image/sepatu/' . $data['file_name']);
                    }
                    var_dump($fileName);
                    echo '<br>';
                    $fileNameThumb = $this->thumb('./asset/image/sepatu/crop/' . $fileName);
                    $this->image_lib->clear();

                    $ukuran = $this->input->post('size');
                    $ukuranJSON = json_encode($ukuran);
                    $gambar['image'] = [$fileName];
                    $gambar['thumb'] = [$fileNameThumb];
                    $data = [
                        'image' => $gambar['image'],
                        'thumb' => $gambar['thumb']
                    ];
                    $gambarJSON = json_encode($data);

                    $data = [
                        'nama' => htmlspecialchars($this->input->post('name-sepatu', true)),
                        'ukuran' => $ukuranJSON,
                        'harga' => htmlspecialchars($this->input->post('price', true)),
                        'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
                        'spesifikasi' => htmlspecialchars($this->input->post('spesifikasi', true)),
                        'gambar' => $gambarJSON
                    ];

                    if ($this->db->insert('sepatu', $data)) {
                        $this->session->set_flashdata('message', '<div class="alert-success">image uploaded successfully</div>
                    ');
                        redirect('admin/tambah_sepatu');
                    } else {
                        $this->db->display_error();
                    }
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert-danger">No image</div>
                ');
                redirect('admin/tambah_sepatu');
            }
        }
    }

    private function crop($sourceImage)
    {
        $fileName = explode('/', $sourceImage);
        $fileName = end($fileName);

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

    private function thumb($sourceImage)
    {
        $fileName = explode('/', $sourceImage);
        $fileName = end($fileName);
        var_dump($sourceImage);
        echo '<br>';
        var_dump($fileName);
        // die;

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
