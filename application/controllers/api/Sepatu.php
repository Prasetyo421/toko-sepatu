<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Sepatu extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Sepatu_model', 'sepatu');
        $this->methods['index_get']['limit'] = 2;
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $sepatu = $this->sepatu->getDataSepatu();
        } else {
            $sepatu = $this->sepatu->getDataSepatu($id);
        }

        if ($sepatu) {
            $this->response([
                'status' => true,
                'data'   => $sepatu
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status'  => false,
                'message' => 'id not found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status'  => false,
                'message' => 'please privide an id'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            if ($this->sepatu->deleteDataSepatu($id) > 0) {
                $this->response([
                    'status'  => true,
                    'message' => 'data sepatu has been deleted'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status'  => false,
                    'message' => 'id not found'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama'),
            'ukuran' => $this->post('ukuran'),
            'harga' => $this->post('harga'),
            'deskripsi' => $this->post('deskripsi'),
            'spesifikasi' => $this->post('spesifikasi'),
            'gambar' => $this->post('gambar')
        ];

        if ($data === null) {
            $this->response([
                'status'  => false,
                'message' => 'data not filled'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            if ($this->sepatu->insertSepatu($data) > 0) {
                $this->response([
                    'status'  => true,
                    'message' => 'data sepatu has been created'
                ], RestController::HTTP_CREATED);
            } else {
                $this->response([
                    'status'  => false,
                    'message' => 'failed to created data sepatu'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $data = [
            'nama' => $this->put('nama'),
            'ukuran' => $this->put('ukuran'),
            'harga' => $this->put('harga'),
            'deskripsi' => $this->put('deskripsi'),
            'spesifikasi' => $this->put('spesifikasi'),
            'gambar' => $this->put('gambar')
        ];

        $id = $this->put('id');

        if ($data === null) {
            $this->response([
                'status'  => false,
                'message' => 'data not filled'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            if ($this->sepatu->updateDataSepatu($data, $id) > 0) {
                $this->response([
                    'status'  => true,
                    'message' => 'data sepatu has been changed'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status'  => false,
                    'message' => 'failed to changed data sepatu'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }
}
