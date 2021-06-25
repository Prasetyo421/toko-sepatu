<?php

use Composer\InstalledVersions;

class Sepatu_model extends CI_Model
{
    public function getAllDataSepatu()
    {
        return $this->db->get('sepatu')->result_array();
    }

    private function getDataShoesBySize($size)
    {
        $this->db->like('shoes_name', $size);
        $shoes_data = $this->db->get('shoes')->result_array();

        for ($i = 0; $i < count($shoes_data); $i++) {
            $id_shoes = $shoes_data[$i]['id'];
            $this->db->select('size');
            $shoes_data[$i]['sizes'] = $this->db->get_where('sizes', ['id_shoes' => $id_shoes])->result_array();
            $this->db->select('spec');
            $shoes_data[$i]['specifications'] = $this->db->get_where('specifications', ['id_shoes' => $id_shoes])->result_array();
            $this->db->select('id, image_name');
            $shoes_data[$i]['images'] = $this->db->get_where('images', ['id_shoes' => $id_shoes])->result_array();
            $this->db->select('thumb_name');
            $shoes_data[$i]['thumb'] = $this->db->get_where('thumb', ['id_shoes' => $id_shoes])->result_array();
        }

        return $shoes_data;
    }

    public function getRelatedSepatu($shoes_name)
    {
        $type = $this->getType($shoes_name);
        $relatedType = $this->getDataShoesByType($type);

        // kesamaan ukuran = low / high
        $size = $this->getSize($shoes_name);
        $kesamaanUkuran = $this->getDataShoesBySize($size);

        $warna = explode(' ', $shoes_name);
        $warna = strtolower(end($warna));

        $kesamaanTipeUkuran = [];
        $kesamaanTipeWarna = [];
        $indexTipeWarna = 0;
        $indexTipeUkuran = 0;
        for ($i = 0; $i < count($relatedType); $i++) {
            $nama = $relatedType[$i]['shoes_name'];
            if ($nama != $shoes_name) {
                $nama = explode(' ', strtolower($nama));
                if (in_array($size, $nama)) {
                    $kesamaanTipeUkuran[$indexTipeUkuran] = $relatedType[$i];
                    $indexTipeUkuran++;
                }
                if (in_array($warna, $nama)) {
                    $kesamaanTipeWarna[$indexTipeWarna] = $relatedType[$i];
                    $indexTipeWarna++;
                }
            }
        }

        $kesamaanUkuranWarna = [];
        $indexUkuranWarna = 0;
        for ($i = 0; $i < count($kesamaanUkuran); $i++) {
            $nama = $kesamaanUkuran[$i]['shoes_name'];
            if ($nama != $shoes_name) {
                $nama = explode(' ', strtolower($nama));
                if (in_array($warna, $nama)) {
                    $kesamaanUkuranWarna[$indexUkuranWarna] = $kesamaanUkuran[$i];
                }
            }
        }

        $related = array_merge($kesamaanTipeUkuran, $kesamaanTipeWarna, $kesamaanUkuranWarna);

        if (count($related) > 5) {
            return $related;
        } else {
            $related_shoes = $this->db->get('shoes', 10, 0)->result_array();
            for ($i = 0; $i < count($related_shoes); $i++) {
                $id_shoes = $related_shoes[$i]['id'];
                $this->db->select('size');
                $related_shoes[$i]['sizes'] = $this->db->get_where('sizes', ['id_shoes' => $id_shoes])->result_array();
                $this->db->select('spec');
                $related_shoes[$i]['specifications'] = $this->db->get_where('specifications', ['id_shoes' => $id_shoes])->result_array();
                $this->db->select('id, image_name');
                $related_shoes[$i]['images'] = $this->db->get_where('images', ['id_shoes' => $id_shoes])->result_array();
                $this->db->select('thumb_name');
                $related_shoes[$i]['thumb'] = $this->db->get_where('thumb', ['id_shoes' => $id_shoes])->result_array();
            }

            return $related_shoes;
        }
    }

    private function getSize($shoes_name)
    {
        $shoes_name = explode(' ', strtolower($shoes_name));
        $this->db->select('ukuran');
        $result = $this->db->get('type_ukuran')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $listTipeUkuran[$i] = $result[$i]['ukuran'];
        }

        for ($i = 0; $i < count($listTipeUkuran); $i++) {
            if (in_array($listTipeUkuran[$i], $shoes_name)) {
                return $listTipeUkuran[$i];
            }
        }
    }

    private function getType($namaSepatu)
    {
        $namaSepatu = explode(' ', strtolower($namaSepatu));
        $this->db->select('type');
        $result = $this->db->get('type_sepatu')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $listTipeSepatu[$i] = $result[$i]['type'];
        }

        for ($i = 0; $i < count($listTipeSepatu); $i++) {

            if (in_array($listTipeSepatu[$i], $namaSepatu)) {
                return $listTipeSepatu[$i];
            }
        }
    }

    // API

    public function getDataSepatu($id = null)
    {
        if ($id === null) {
            return $this->getAllDataSepatu();
        } else {
            return $this->getDataShoesById($id);
        }
    }

    public function deleteDataSepatu($id)
    {
        $this->db->delete('sizes', ['id_shoes' => $id]);
        $this->db->delete('specifications', ['id_shoes' => $id]);
        $this->db->delete('images', ['id_shoes' => $id]);
        $this->db->delete('thumb', ['id_shoes' => $id]);
        $this->db->delete('shoes', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function updateDataSepatu($data, $id)
    {
        return $this->db->affected_rows();
    }

    // END API

    public function insertShoesData($data)
    {
        $shoesData['shoes_name'] = $data['shoes_name'];
        $shoesData['description'] = $data['description'];
        $shoesData['price'] = $data['price'];

        $this->db->insert('shoes', $shoesData);
        $this->db->select('id');
        $id_shoes = $this->db->get_where('shoes', ['shoes_name' => $shoesData['shoes_name']])->result_array()[0]['id'];

        var_dump($id_shoes);
        echo $id_shoes . '</>';

        for ($i = 0; $i < count($data['thumb']); $i++) {

            echo $data['images'][$i] . '</br>';

            $dataImage = [
                'id_shoes' => $id_shoes,
                'image_name' => $data['images'][$i]
            ];
            $this->db->insert('images', $dataImage);
            $this->db->select('id');
            $id_image = $this->db->get_where('images', ['image_name' => $data['images'][$i]])->result_array()[0]['id'];

            $dataThumb = [
                'id_image' => $id_image,
                'thumb_name' => $data['thumb'][$i]
            ];
            $this->db->insert('thumb', $dataThumb);
            $this->db->select('id');
        }

        for ($i = 0; $i < count($data['specifications']); $i++) {
            $dataSpec = [
                'spec' => $data['specifications'][$i],
                'id_shoes' => $id_shoes
            ];

            $this->db->insert('specifications', $dataSpec);
        }

        for ($i = 0; $i < count($data['sizes']); $i++) {
            $dataSizes = [
                'size' => $data['sizes'][$i],
                'id_shoes' => $id_shoes
            ];

            $this->db->insert('sizes', $dataSizes);
        }
    }

    public function getDataShoesByType($type)
    {
        $this->db->like('shoes_name', $type);
        $shoes_data = $this->db->get('shoes')->result_array();

        for ($i = 0; $i < count($shoes_data); $i++) {
            $id_shoes = $shoes_data[$i]['id'];
            $this->db->select('size');
            $shoes_data[$i]['sizes'] = $this->db->get_where('sizes', ['id_shoes' => $id_shoes])->result_array();
            $this->db->select('spec');
            $shoes_data[$i]['specifications'] = $this->db->get_where('specifications', ['id_shoes' => $id_shoes])->result_array();
            $this->db->select('id, image_name');
            $shoes_data[$i]['images'] = $this->db->get_where('images', ['id_shoes' => $id_shoes])->result_array();
            $this->db->select('thumb_name');
            $shoes_data[$i]['thumb'] = $this->db->get_where('thumb', ['id_shoes' => $id_shoes])->result_array();
        }

        return $shoes_data;
    }

    public function getAllDataShoes()
    {
        $shoes_data = $this->db->get('shoes')->result_array();
        for ($i = 0; $i < count($shoes_data); $i++) {
            $id_shoes = $shoes_data[$i]['id'];
            $shoes_data[$i]['sizes'] = $this->db->get_where('sizes', ['id_shoes' => $id_shoes])->result_array();
            $shoes_data[$i]['specifications'] = $this->db->get_where('specifications', $id_shoes)->result_array();
            $shoes_data[$i]['images'] = $this->db->get_where('images', ['id_shoes' => $id_shoes])->result_array();
            $shoes_data[$i]['thumb'] = $this->db->get_where('thumb', ['id_shoes' => $id_shoes])->result_array();
        }

        return $shoes_data;
    }

    public function getDataShoesById($id)
    {
        $shoes_data = $this->db->get_where('shoes', ['id' => $id])->result_array()[0];
        // $this->db->select('size');
        $shoes_data['sizes'] = $this->db->get_where('sizes', ['id_shoes' => $id])->result_array();
        // $this->db->select('spec');
        $shoes_data['specifications'] = $this->db->get_where('specifications', ['id_shoes' => $id])->result_array();
        $this->db->select('id, image_name');
        $shoes_data['images'] = $this->db->get_where('images', ['id_shoes' => $id])->result_array();
        $this->db->select('id, thumb_name');
        $shoes_data['thumb'] = $this->db->get_where('thumb', ['id_shoes' => $id])->result_array();

        return $shoes_data;
    }

    public function insertDataChart($data)
    {
        $result = $this->db->insert('detail_chart', $data);
        return $result;
    }

    public function getDataChart($id_chart)
    {
        $query = "SELECT * FROM detail_chart JOIN shoes ON (detail_chart.id_product = shoes.id) WHERE detail_chart.id_chart = " . $id_chart;
        $result = $this->db->query($query)->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $id_product = $result[$i]['id_product'];
            $images = $this->db->get_where('images', ['id_shoes' => $id_product])->result_array();
            $thumb = $this->db->get_where('thumb', ['id_shoes' => $id_product])->result_array();
            $result[$i]['sizes'] = $this->db->get_where('sizes', ['id_shoes' => $id_product])->result_array();
            $result[$i]['images'] = $images;
            $result[$i]['thumb'] = $thumb;
        }
        return $result;
    }

    public function deleteDataChart($id_chart, $id_product)
    {
        $result = $this->db->delete('detail_chart', ['id_chart' => $id_chart, 'id_product' => $id_product]);
    }

    public function cekProductInChart($kondisi)
    {
        $product = $this->db->get_where('detail_chart', $kondisi);
        if ($product->num_rows() < 1) {
            return false;
        } else {
            return $product->result_array()[0];
        }
    }

    public function updateAmountProductInChart()
    {
        $email = $this->session->userdata['email'];
        $operation = $this->input->post('operation', true);
        $id_product = $this->input->post('idProduct', true);
        $id_chart = $this->db->get_where('users', ['email' => $email])->result_array()[0]['id'];
        $kondisi = [
            'id_chart' => $id_chart,
            'id_product' => $id_product
        ];
        $this->db->select('amount');
        if ($operation == 'plus') {
            $amount = (int)$this->db->get_where('detail_chart', $kondisi)->result_array()[0]['amount'] + 1;
        } else if ($operation == 'minus') {
            $amount = (int)$this->db->get_where('detail_chart', $kondisi)->result_array()[0]['amount'] - 1;
        }

        $data = [
            'amount' => $amount
        ];
        if ($this->db->update('detail_chart', $data, $kondisi)) {
            return $amount;
        } else {
            $this->db->display_error();
        }
    }
}
