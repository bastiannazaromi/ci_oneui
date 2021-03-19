<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
class Dosen extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_api', 'api');
    }
    public function addDosen_post()
    {
        $kode_dosen = $this->post('kode_dosen');
        $nama_lengkap = $this->post('nama_lengkap');
        $password = $this->post('password');
        $kode_prodi = $this->post('kode_prodi');
        $data = [
            'kode_dosen' => $kode_dosen,
            'nama_lengkap' => $nama_lengkap,
            'password' => $password,
            'kode_prodi' => $kode_prodi
        ];
        $insert = $this->universal->insert($data, 'table');
        if ($insert) {
            $response = [
                'status' => true,
                'messege' => 'Berhasil input dosen'
            ];
        }
        $this->response($response, 200);
    }
    public function cek_put() {
        $this->response('OK', 200);
    }
}

/* End of file Controllername.php */
