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
        return $this->db->get_where('sepatu', ['id' => $id])->row_array();
    }
}
