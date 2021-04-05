<?php

class Sepatu_model extends CI_Model
{
    public function getAllDataSepatu()
    {
        return $this->db->get('sepatu')->result_array();
    }

    public function insertDataSepatu()
    {
        $data = [
            "nama" => htmlspecialchars($this->input->post('name', true)),
            "ukuran" => htmlspecialchars($this->input->post('ukuran', true)),
            "harga" => htmlspecialchars($this->input->post('harga', true)),
            "deskripsi" => htmlspecialchars($this->input->post('deskripsi', true)),

        ];

        $this->db->insert('sepatu', $data);
    }

    public function getDataSepatuByType($type)
    {
        $this->db->like('nama', $type);
        return $this->db->get('sepatu')->result_array();
    }

    public function getDataSepatuById($id)
    {
        $result = $this->db->get_where('sepatu', ['id' => $id])->row_array();
        $result['gambar'] = json_decode($result['gambar'], true);
        $result['ukuran'] = json_decode($result['ukuran'], true);
        $result['spesifikasi'] = json_decode($result['spesifikasi'], true);
        return $result;
    }

    private function getDataBySize($size)
    {
        $this->db->like('nama', $size);
        return $this->db->get('sepatu')->result_array();
    }

    public function getRelatedSepatu($sepatu)
    {
        $tipe = $this->getType($sepatu);
        $kesamaanTipe = $this->getDataSepatuByType($tipe);

        // kesamaan ukuran = low / high
        $ukuran = $this->getSize($sepatu);
        $kesamaanUkuran = $this->getDataBySize($ukuran);

        $warna = explode(' ', $sepatu);
        $warna = strtolower(end($warna));

        $kesamaanTipeUkuran = [];
        $kesamaanTipeWarna = [];
        $indexTipeWarna = 0;
        $indexTipeUkuran = 0;
        for ($i = 0; $i < count($kesamaanTipe); $i++) {
            $nama = $kesamaanTipe[$i]['nama'];
            if ($nama != $sepatu) {
                $nama = explode(' ', strtolower($nama));
                if (in_array($ukuran, $nama)) {
                    $kesamaanTipeUkuran[$indexTipeUkuran] = $kesamaanTipe[$i];
                    $indexTipeUkuran++;
                }
                if (in_array($warna, $nama)) {
                    $kesamaanTipeWarna[$indexTipeWarna] = $kesamaanTipe[$i];
                    $indexTipeWarna++;
                }
            }
        }

        $kesamaanUkuranWarna = [];
        $indexUkuranWarna = 0;
        for ($i = 0; $i < count($kesamaanUkuran); $i++) {
            $nama = $kesamaanUkuran[$i]['nama'];
            if ($nama != $sepatu) {
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
            return $this->db->get('sepatu', 10, 0)->result_array();
        }
    }

    private function getSize($namaSepatu)
    {
        $namaSepatu = explode(' ', strtolower($namaSepatu));
        $this->db->select('ukuran');
        $result = $this->db->get('type_ukuran')->result_array();
        for ($i = 0; $i < count($result); $i++) {
            $listTipeUkuran[$i] = $result[$i]['ukuran'];
        }

        for ($i = 0; $i < count($listTipeUkuran); $i++) {
            if (in_array($listTipeUkuran[$i], $namaSepatu)) {
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
            return $this->db->get('sepatu')->result_array();
        } else {
            return $this->db->get_where('sepatu', ['id' => $id])->result_array();
        }
    }

    public function deleteDataSepatu($id)
    {
        $this->db->delete('sepatu', ['id' => $id]);
        return $this->db->affected_rows();
    }


    public function insertSepatu($data)
    {
        $this->db->insert('sepatu', $data);
        return $this->db->affected_rows();
    }

    public function updateDataSepatu($data, $id)
    {
        $this->db->update('sepatu', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
