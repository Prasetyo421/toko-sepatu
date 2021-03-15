<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sepatu_model', 'sepatu');
    }


    public function index()
    {
        $data['judul'] = 'Halaman Home';
        $data['css'] = 'home-sepatu.css';

        $this->db->select('type');
        $tipe = $this->db->get('type_sepatu')->result_array();
        for ($i = 0; $i < count($tipe); $i++) {
            $tipe[$i] = $tipe[$i]['type'];
        }

        for ($i = 0; $i < count($tipe); $i++) {
            // var_dump($tipe[$i]);
            $data['dataSepatu'][$tipe[$i]] = $this->sepatu->getDataSepatuByType($tipe[$i]);


            for ($j = 0; $j < count($data['dataSepatu'][$tipe[$i]]); $j++) {
                $data['dataSepatu'][$tipe[$i]][$j]['ukuran'] = json_decode($data['dataSepatu'][$tipe[$i]][$j]['ukuran']);
                $data['dataSepatu'][$tipe[$i]][$j]['gambar'] = json_decode($data['dataSepatu'][$tipe[$i]][$j]['gambar']);
            }
        }

        $data['type'] = $tipe;

        // var_dump($data['dataSepatu']);

        $this->load->view('templates/sepatu_header', $data);
        $this->load->view('sepatu/home', $data);
        $this->load->view('templates/sepatu_footer');
    }

    public function detailSepatu($id)
    {
        $data['judul'] = 'Halaman Detail Sepatu';
        $data['css'] = 'detail-sepatu.css';
        $data['sepatu'] = $this->sepatu->getDataSepatuById($id);
        $data['sepatu']['ukuran'] = json_decode($data['sepatu']['ukuran']);
        $data['sepatu']['gambar'] = json_decode($data['sepatu']['gambar']);
        // $data['sepatu']['jumlahGambar'] = count($data['sepatu']['gambar']->thumb);
        // var_dump($data['sepatu']);
        // die;

        $this->load->view('templates/sepatu_header', $data);
        $this->load->view('sepatu/detail', $data);
        $this->load->view('templates/sepatu_footer');
    }
}
