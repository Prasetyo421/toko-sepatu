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
        $id_shoes = htmlspecialchars($this->input->post('id'), true);

        $this->form_validation->set_rules('kota-asal', 'kota-asal', 'required|trim');
        $this->form_validation->set_rules('kota-tujuan', 'kota-tujuan', 'required|trim');
        $this->form_validation->set_rules('amount', 'amount', 'required|trim');
        $this->form_validation->set_rules('size', 'size', 'required|trim');

        if (!$this->form_validation->run()) {
            $data['shoes'] = $this->sepatu->getDataShoesById($id_shoes);
            // var_dump($data['shoes']);
            // die;
            echo "false";
            $data['citys'] = json_decode(file_get_contents(base_url() . 'asset/json/citys.json'), true);
            $data['amount'] = htmlspecialchars($this->input->post('amount'), true);
            $data['size'] = htmlspecialchars($this->input->post('size'), true);
            $this->load->view('user/chart', $data);
        } else {

            echo "ok";
            $data['citys'] = json_decode(file_get_contents(base_url() . 'asset/json/citys.json'), true);

            $origin = htmlspecialchars($this->input->post('id-kota-asal'), true);
            $destination = htmlspecialchars($this->input->post('id-kota-tujuan'), true);
            $kotaAsal = htmlspecialchars($this->input->post('kota-asal'), true);
            $kotaTujuan = htmlspecialchars($this->input->post('kota-tujuan'), true);
            var_dump("ori" . $origin);
            echo "<br>";
            var_dump("des " . $destination);
            echo "<br>";

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
