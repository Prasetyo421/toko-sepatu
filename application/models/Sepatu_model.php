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
