<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('Sepatu_model', 'sepatu');
    }
    public function index()
    {
        $user = $this->db->get_where('users', ['email' => $this->session->userdata['email']])->row_array();

        $data['name'] = $user['name'];
        $this->load->view('user/index', $data);
    }

    public function chart()
    {
        $data['css'] = 'chart.css';
        $data['js'] = 'chart.js';
        $userEmail = $this->session->userdata('email');
        $userData = $this->db->get_where('users', ['email' => $userEmail])->result_array()[0];
        $id_chart = $userData['id'];


        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('size', 'size', 'required|trim');

        $amount = htmlspecialchars($this->input->post('amount'), true);
        $variant = htmlspecialchars($this->input->post('size'), true);

        if (!$this->form_validation->run()) {
            // echo 'form_validation1 gagal';
            $products_in_chart = $this->sepatu->getDataChart($id_chart);
            $data['products'] = $products_in_chart;

            $this->load->view('templates/sepatu_header', $data);
            $this->load->view('user/chart', $data);
            $this->load->view('templates/sepatu_footer');
        } else {
            // echo 'form_validation2 gagal';
            $id_shoes = htmlspecialchars($this->input->post('id'), true);
            $data['shoes'] = $this->sepatu->getDataShoesById($id_shoes);

            $dataForChart = [
                'id_chart' => $id_chart,
                'id_product' => $id_shoes,
                'amount' => $amount,
                'variant' => $variant,
            ];

            $this->sepatu->insertDataChart($dataForChart);
            $products_in_chart = $this->sepatu->getDataChart($id_chart);
            $data['products'] = $products_in_chart;

            $this->load->view('templates/sepatu_header', $data);
            $this->load->view('user/chart', $data);
            $this->load->view('templates/sepatu_footer');
        }
    }

    public function hapusProductChart($id_chart, $id_product)
    {
        $this->sepatu->deleteDataChart($id_chart, $id_product);
        redirect('user/chart');
    }

    public function cekOngkir()
    {

        $id_shoes = htmlspecialchars($this->input->post('id'), true);
        $data['shoes'] = $this->sepatu->getDataShoesById($id_shoes);


        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('size', 'size', 'required|trim');

        $amount = htmlspecialchars($this->input->post('amount'), true);
        $variant = htmlspecialchars($this->input->post('size'), true);


        $this->form_validation->set_rules('id-kota-asal', 'id-kota-asal', 'required|trim');
        $this->form_validation->set_rules('id-kota-tujuan', 'id-kota-tujuan', 'required|trim');
        $this->form_validation->set_rules('kota-asal', 'kota-asal', 'required|trim');
        $this->form_validation->set_rules('kota-tujuan', 'kota-tujuan', 'required|trim');

        if (!$this->form_validation->run()) {
            // echo 'form_validation2 gagal';
            $userEmail = $this->session->userdata('email');
            $userData = $this->db->get_where('users', ['email' => $userEmail])->result_array()[0];

            $id_chart = $userData['id'];
            $dataForChart = [
                'id_chart' => $id_chart,
                'id_product' => $id_shoes,
                'amount' => $amount,
                'variant' => $variant,
            ];

            $this->sepatu->insertDataChart($dataForChart);

            $products_in_chart = $this->sepatu->getDataChart($id_chart);

            $data['products'] = $products_in_chart;

            $this->load->view('templates/sepatu_header', $data);
            $this->load->view('user/chart', $data);
            $this->load->view('templates/sepatu_footer');
        } else {
            echo "ok";
            $data['citys'] = json_decode(file_get_contents(base_url() . 'asset/json/citys.json'), true);

            $data['citys'] = json_decode(file_get_contents(base_url() . 'asset/json/citys.json'), true);
            $data['amount'] = $amount;
            $data['size'] = $variant;

            $origin = htmlspecialchars($this->input->post('id-kota-asal'), true);
            $destination = htmlspecialchars($this->input->post('id-kota-tujuan'), true);
            $kotaAsal = htmlspecialchars($this->input->post('kota-asal'), true);
            $kotaTujuan = htmlspecialchars($this->input->post('kota-tujuan'), true);

            $weight = 1000;
            $couries = ['jne', 'tiki', 'pos'];
            $costs = [];
            for ($i = 0; $i < 3; $i++) {
                $cost_calculation_data = [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $couries[$i]
                ];
                $result = $this->calculateCost($cost_calculation_data);

                $result = $result['rajaongkir']['results'][0];
                array_push($costs, $result);
            }

            $data['costs'] = $costs;
            $data['namaKotaAsal'] = $kotaAsal;
            $data['namaKotaTujuan'] = $kotaTujuan;
            $this->load->view('user/chart', $data);
        }
    }

    private function getProvinceList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . KEY_API_RAJAONGKIR
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response) {
            return json_decode($response, true);
        } else {
            return $err;
        }
    }

    private function getCitysList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . KEY_API_RAJAONGKIR
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return json_decode($response, true);
        }
    }

    private function calculateCost($data)
    {
        $origin = $data['origin'];
        $destination = $data['destination'];
        $weight = $data['weight'];
        $courier = $data['courier'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . KEY_API_RAJAONGKIR
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return json_decode($response, true);
        }
    }
}
