<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Sepatu_model', 'sepatu');
        is_logged_in();
    }
    public function index()
    {
        if ($this->session->userdata['email']) {
            $data['shoes'] = $this->db->get('shoes')->result_array();
            $data['css'] = ['index-admin.css'];
            $data['js'] = 'template admin.js';

            $this->load->view('templates/header_admin', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/top_bar_admin');
            $this->load->view('templates/main_admin', $data);
            $this->load->view('templates/footer_admin', $data);
        } else {
            $this->load->view('errors/html/error_404');
        }
    }

    public function detail($id)
    {
        $data['css'] = ['detail-sepatu-admin.css'];
        $data['js'] = 'detail sepatu admin.js';
        $data['shoes'] = $this->sepatu->getDataShoesById($id);

        $this->load->view('templates/header_admin', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/top_bar_admin');
        $this->load->view('admin/detail_sepatu', $data);
        $this->load->view('templates/footer_admin', $data);
    }

    public function update_sepatu($id)
    {
        $data['judul'] = 'Halaman Update Sepatu';
        $data['css'] = ['update-sepatu.css'];
        $data['js'] = 'update sepatu.js';

        $this->db->select('size');
        $getSizes = $this->db->get('ukuran')->result_array();
        for ($i = 0; $i < count($getSizes); $i++) {
            $data['sizes'][$i] = $getSizes[$i]['size'];
        }
        $data['shoes'] = $this->sepatu->getDataShoesById($id);
        for ($i = 0; $i < count($data['shoes']['sizes']); $i++) {
            $data['shoes']['sizes'][$i] = $data['shoes']['sizes'][$i]['size'];
        }

        $this->form_validation->set_rules('name-sepatu', 'Nama-Sepatu', 'required|trim', [
            'is_uniqed' => 'nama sepatu sudah ada di databse'
        ]);
        $this->form_validation->set_rules('spesifikasi[]', 'Spesifikasi', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim');

        if ($this->form_validation->run() === false) {
            $this->load->view('templates/header_admin', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/top_bar_admin');
            $this->load->view('admin/update_sepatu', $data);
            $this->load->view('templates/footer_admin');
        } else {
            $gambar = [];
            if ($_FILES['image']['error'][0] === 4) {
                // tidak ada gambar yang di upload,
                // menggunakan file lama

                $shoes_name = htmlspecialchars($this->input->post('name-sepatu'), true);
                $shoes_price = htmlspecialchars($this->input->post('price'), true);
                $shoes_desc = htmlspecialchars($this->input->post('deskripsi'), true);
                $shoes_data = [
                    'shoes_name' => $shoes_name,
                    'price' => $shoes_price,
                    'description' => $shoes_desc
                ];

                $this->db->update('shoes', $shoes_data, ['id' => $id]);

                // Update SIZES
                $ukuran = $this->input->post('size');

                for ($i = 0; $i < count($data['shoes']['sizes']); $i++) {
                    if (!$this->db->delete('sizes', ['id' => $data['shoes']['sizes'][$i]['id']])) {
                        var_dump($this->db->display_error());
                    }
                }

                $sizeDataInsert = [];
                for ($i = 0; $i < count($ukuran); $i++) {
                    $sizeDataInsert[$i] = [
                        'size' => $ukuran[$i],
                        'id_shoes' => $id
                    ];
                }

                if (!$this->db->insert_batch('sizes', $sizeDataInsert)) {
                    var_dump($this->db->display_error());
                }

                // Akhir Update Sizes

                // Update Spec
                $spesifikasi = $this->input->post('spesifikasi');

                for ($i = 0; $i < count($data['shoes']['specifications']); $i++) {
                    if (!$this->db->delete('specifications', ['id' => $data['shoes']['specifications'][$i]['id']])) {
                        var_dump($this->db->display_error());
                    }
                }

                $specDataInsert = [];
                for ($i = 0; $i < count($spesifikasi); $i++) {
                    $specDataInsert[$i] = [
                        'spec' => $spesifikasi[$i],
                        'id_shoes' => $id
                    ];
                }

                if (!$this->db->insert_batch('specifications', $specDataInsert)) {
                    var_dump($this->db->display_error());
                }

                // Akhir Update spec

                $this->session->set_flashdata('message', '<div class="alert-success">Berhasil <strong>mengubah</strong> data sepatu</div>');
                redirect('admin');
            } else {

                $jmlhGambarHps = count($data['shoes']['images']);
                for ($i = 0; $i < $jmlhGambarHps; $i++) {
                    $fileNameHps = $data['shoes']['images'][$i]['image_name'];
                    $fileNameHpsThumb = $data['shoes']['thumb'][$i]['thumb_name'];
                    if (!unlink('./asset/image/sepatu/' . $fileNameHps)) {
                        echo 'You have an error';
                    }
                    if (!unlink('./asset/image/sepatu/thumb/' . $fileNameHpsThumb)) {
                        echo 'You have an error, thumb';
                    }
                }

                $jumlahData = count($_FILES['image']['name']);
                $namaSepatu = time();

                $gambar = [];
                for ($i = 0; $i < $jumlahData; $i++) {
                    $tmpName = $_FILES['image']['tmp_name'][$i];
                    $info = list($width, $height, $type, $attr) = getimagesize($tmpName);
                    $ekstensi = explode('/', $info['mime']);
                    $ekstensi = $ekstensi[1];

                    // Inisialisasi
                    $_FILES['file']['name']     = $_FILES['image']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['image']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
                    $_FILES['file']['size']     = $_FILES['image']['size'][$i];

                    // config

                    $config['file_name'] = $namaSepatu + $i . '.' . $ekstensi;
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
                        if (($height / $width) > 1.5) {
                            $fileName    = $dataUpload['raw_name'] . '_crop' . $dataUpload['file_ext'];
                            $gambar['image'][$i] = $this->crop($sourceImage, $fileName);

                            if (!unlink($sourceImage)) {
                                echo "You have an error";
                            }

                            $sourceImage2 = './asset/image/sepatu/' . $gambar['image'][$i];
                            $fileName    = $dataUpload['raw_name'] . $dataUpload['file_ext'];
                            $gambar['thumb'][$i] = $this->thumb($sourceImage2, $fileName);
                        } else {
                            $sourceImage2 = $sourceImage;
                            $fileName    = $dataUpload['raw_name'] . $dataUpload['file_ext'];
                            $gambar['thumb'][$i] = $this->thumb($sourceImage2, $fileName);

                            $gambar['image'][$i] = $dataUpload['file_name'];
                        }
                    }
                }

                // Update SIZES
                $ukuran = $this->input->post('size');

                // var_dump($data);
                for ($i = 0; $i < count($data['shoes']['sizes']); $i++) {
                    if (!$this->db->delete('sizes', ['id' => $data['shoes']['sizes'][$i]['id']])) {
                        var_dump($this->db->display_error());
                    }
                }

                $sizeDataInsert = [];
                for ($i = 0; $i < count($ukuran); $i++) {
                    $sizeDataInsert[$i] = [
                        'size' => $ukuran[$i],
                        'id_shoes' => $id
                    ];
                }

                if (!$this->db->insert_batch('sizes', $sizeDataInsert)) {
                    var_dump($this->db->display_error());
                }

                // Akhir Update Sizes

                // Update Spec
                $spesifikasi = $this->input->post('spesifikasi');

                for ($i = 0; $i < count($data['shoes']['specifications']); $i++) {
                    if (!$this->db->delete('specifications', ['id' => $data['shoes']['specifications'][$i]['id']])) {
                        var_dump($this->db->display_error());
                    }
                }

                $specDataInsert = [];
                for ($i = 0; $i < count($spesifikasi); $i++) {
                    $specDataInsert[$i] = [
                        'spec' => $spesifikasi[$i],
                        'id_shoes' => $id
                    ];
                }

                if (!$this->db->insert_batch('specifications', $specDataInsert)) {
                    var_dump($this->db->display_error());
                }
                // Akhir Update spec

                // Update Image
                $images = $gambar['image'];

                for ($i = 0; $i < count($data['shoes']['images']); $i++) {
                    if (!$this->db->delete('images', ['id' => $data['shoes']['images'][$i]['id']])) {
                        var_dump($this->db->display_error());
                    }
                }

                $imagescDataInsert = [];
                for ($i = 0; $i < count($images); $i++) {
                    $imagescDataInsert[$i] = [
                        'image_name' => $images[$i],
                        'id_shoes' => $id
                    ];
                }

                if (!$this->db->insert_batch('images', $imagescDataInsert)) {
                    var_dump($this->db->display_error());
                }
                // Akhir Update Images

                // Update Thumb
                $thumb = $gambar['thumb'];

                for ($i = 0; $i < count($data['shoes']['thumb']); $i++) {
                    if (!$this->db->delete('thumb', ['id' => $data['shoes']['thumb'][$i]['id']])) {
                        var_dump($this->db->display_error());
                    }
                }

                $thumbDataInsert = [];
                for ($i = 0; $i < count($thumb); $i++) {
                    $thumbDataInsert[$i] = [
                        'thumb_name' => $thumb[$i],
                        'id_shoes' => $id
                    ];
                }

                if (!$this->db->insert_batch('thumb', $thumbDataInsert)) {
                    var_dump($this->db->display_error());
                }
                // Akhir Update thumb

                $this->session->set_flashdata('message', '<div class="alert-success">Berhasil <strong>mengubah</strong> data sepatu</div>');
                redirect('admin');
            }
        }
    }

    public function delete($id)
    {
        $shoes = $this->sepatu->getDataShoesById($id);
        for ($i = 0; $i < count($shoes['images']); $i++) {
            if (!unlink('./asset/image/sepatu/' . $shoes['images'][$i]['image_name'])) {
                echo "You have an error";
            }

            if (!unlink('./asset/image/sepatu/thumb/' . $shoes['thumb'][$i]['thumb_name'])) {
                echo "You have an error, thumb";
            }
        }
        if ($this->sepatu->deleteDataSepatu($id)) {
            $this->session->set_flashdata('message', '<div class="alert-success">Berhasil menghapus data sepatu</div>');
            redirect('admin');
        } else {
            $this->session->set_flashdata('message', '<div class="alert-danger">Gagal menghapus data sepatu</div>');
            redirect('admin');
        }
    }


    public function tambah_sepatu()
    {
        $data['css'] = ['tambah-sepatu.css'];
        $data['js'] = 'tambah sepatu.js';
        $data['ukuran'] = $this->db->get('ukuran')->result_array();

        $this->form_validation->set_rules('name-sepatu', 'Nama-Sepatu', 'required|trim|is_unique[sepatu.nama]', [
            'is_uniqed' => 'nama sepatu sudah ada di databse'
        ]);
        $this->form_validation->set_rules('spesifikasi[]', 'Spesifikasi', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header_admin', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/top_bar_admin');
            $this->load->view('admin/add_sepatu', $data);
            $this->load->view('templates/footer_admin');
        } else {

            $jumlahData = count($_FILES['image']['name']);
            if ($_FILES['image']['error'][0] === 4) {
                $this->load->view('templates/header_admin', $data);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/top_bar_admin');
                $this->load->view('admin/add_sepatu', $data);
                $this->load->view('templates/footer_admin');
            } else {

                $namaSepatu = time();
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
                    $config['file_name'] = $namaSepatu + $i . '.' . $ekstensi;
                    $config['upload_path'] = './asset/image/sepatu';
                    $config['allowed_types'] = 'jpg|jpeg|png';

                    // memanggil library 
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('file')) {
                        var_dump($this->upload->display_errors());
                        // die;
                    } else {
                        $dataUpload = $this->upload->data();

                        $this->load->library('image_lib');

                        $sourceImage = './asset/image/sepatu/' . $dataUpload['file_name'];
                        if (($height / $width) > 1.5) {
                            $fileName    = $dataUpload['raw_name'] . '_crop' . $dataUpload['file_ext'];
                            $gambar['image'][$i] = $this->crop($sourceImage, $fileName);

                            if (!unlink($sourceImage)) {
                                echo "You have an error";
                            }

                            $sourceImage2 = './asset/image/sepatu/' . $gambar['image'][$i];
                            $fileName    = $dataUpload['raw_name'] . $dataUpload['file_ext'];
                            $gambar['thumb'][$i] = $this->thumb($sourceImage2, $fileName);
                        } else {
                            $sourceImage2 = $sourceImage;
                            $fileName    = $dataUpload['raw_name'] . $dataUpload['file_ext'];
                            $gambar['thumb'][$i] = $this->thumb($sourceImage2, $fileName);
                            $gambar['image'][$i] = $dataUpload['file_name'];
                        }
                    }
                }

                $ukuran = $this->input->post('size');
                $spesifikasi = $this->input->post('spesifikasi');

                $shoes_name = htmlspecialchars($this->input->post('name-sepatu'), true);
                $shoes_data = [
                    'shoes_name' => $shoes_name,
                    'description' => htmlspecialchars($this->input->post('deskripsi'), true),
                    'price' => htmlspecialchars($this->input->post('price'), true)
                ];
                $insertShoes = $this->db->insert('shoes', $shoes_data);

                $this->db->select('id');
                $id_shoes = $this->db->get_where('shoes', ['shoes_name' => $shoes_name])->result_array()[0]['id'];

                $sizes = [];
                for ($i = 0; $i < count($ukuran); $i++) {
                    $sizes[$i] = [
                        'size' => $ukuran[$i],
                        'id_shoes' => $id_shoes
                    ];
                }

                $specifications = [];
                for ($i = 0; $i < count($spesifikasi); $i++) {
                    $specifications[$i] = [
                        'spec' => $spesifikasi[$i],
                        'id_shoes' => $id_shoes
                    ];
                }

                $images = [];
                $thumb = [];
                for ($i = 0; $i < count($gambar['image']); $i++) {
                    $images[$i] = [
                        'image_name' => $gambar['image'][$i],
                        'id_shoes' => $id_shoes
                    ];
                    $thumb[$i] = [
                        'thumb_name' => $gambar['thumb'][$i],
                        'id_shoes' => $id_shoes
                    ];
                }

                $insertSizes = $this->db->insert_batch('sizes', $sizes);
                $insertSpec = $this->db->insert_batch('specifications', $specifications);
                $insertImages = $this->db->insert_batch('images', $images);
                $insertThumb = $this->db->insert_batch('thumb', $thumb);

                if ($insertShoes == false) {
                    var_dump($this->db->display_error());
                    echo ('<br>');
                } elseif ($insertSizes == false) {
                    var_dump($this->db->display_error());
                    echo ('<br>');
                } elseif ($insertSpec == false) {
                    var_dump($this->db->display_error());
                    echo ('<br>');
                } elseif ($insertImages == false) {
                    var_dump($this->db->display_error());
                    echo ('<br>');
                } elseif ($insertThumb == false) {
                    var_dump($this->db->display_error());
                    echo ('<br>');
                } else {
                    $data['css'] = ['tambah-sepatu.css'];
                    $data['ukuran'] = $this->db->get('ukuran')->result_array();
                    $this->session->set_flashdata('message', '<div class="alert-success">Data berhasil di tambahkan</div>');
                    $this->load->view('templates/header_admin', $data);
                    $this->load->view('templates/sidebar');
                    $this->load->view('templates/top_bar_admin');
                    $this->load->view('admin/add_sepatu', $data);
                    $this->load->view('templates/footer_admin');
                }
            }
        }
    }

    private function crop($sourceImage, $fileName)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourceImage;
        $config['maintain_ratio'] = FALSE;
        $config['x_axis'] = 0;
        $config['y_axis'] = 280;
        $config['width'] = 720;
        $config['height'] = 720;
        $config['new_image'] = './asset/image/sepatu/' . $fileName;

        $this->image_lib->initialize($config);


        if (!$this->image_lib->crop()) {
            echo 'error crop' . $this->image_lib->display_errors();
        } else {
            $this->image_lib->clear();
            return $fileName;
        }
    }

    private function thumb($sourceImage, $fileName)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourceImage;
        $config['create_thumb'] = TRUE;
        $config['width'] = 100;
        $config['new_image'] = './asset/image/sepatu/thumb/' . $fileName;

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo 'error thumb' . $this->image_lib->display_errors();
        } else {
            $this->image_lib->clear();
            $fileName = explode('.', $fileName);
            $fileName = $fileName[0] . '_thumb.' . end($fileName);
            return $fileName;
        }
    }
}
