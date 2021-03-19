<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_api', 'api');
    }
    public function index_post()
    {
        $data = [
            'nim'               => $this->post('nim'),
            'kd_prodi'          => $this->post('kd_prodi'),
            'kd_mp'             => $this->post('kd_mp'),
            'nominal'           => $this->post('nominal'),
            'status'            => $this->post('status'),
            'nama_rbp'          => $this->post('nama_rbp'),
            'norek'             => $this->post('norek'),
            'id_tahun_akademik' => $this->post('id_tahun_akademik'),
            'semester'          => $this->post('semester'),
            'jalur'             => $this->post('jalur'),
            'tahun_angkatan'    => $this->post('tahun_angkatan'),
            'tanggal_ta'        => $this->post('tanggal_ta'),
            'id_nilaiguna'      => $this->post('id_nilaiguna')
        ];
        $insert = $this->universal->insert($data, 'tagihan');
        if ($insert) {
            $response = [
                'status' => true,
                'message' => 'Berhasil input'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal input'
            ];
        }
        $this->response($response, 200);
    }
}

/* End of file Tagihan.php */
