<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
class Nilai extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_api', 'api');
    }
    public function index_post()
    {
        $kd_ta = $this->post('kd_ta');
        $id_ta = $this->universal->getOneSelect('kode,id', ['kode' => $kd_ta], 'tahun_akademik');
        $data = [
            'username' => $this->post('username'),
            'prodi' => $this->post('prodi'),
            'kd_dosen' => $this->post('kd_dosen'),
            'makul' => $this->post('makul'),
            'thak' => $id_ta->id,
            'smt' => $this->post('semester'),
            'kelas' => $this->post('kelas'),
            'presensi' => $this->post('presensi'),
            'tugas' => $this->post('tugas'),
            'uts' =>  $this->post('uts'),
            'uas' => $this->post('uas'),
            'presensi_akhir' => $this->post('presensi'),
            'tugas_akhir' => $this->post('tugas'),
            'uts_akhir' => $this->post('uas'),
            'uas_akhir' => $this->post('uas')
        ];
        $insert = $this->universal->insert($data, 'nilai');
        if ($insert) {
            $response = [
                'status' => true,
                'message' => 'Berhasil input nilai'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal input nilai'
            ];
        }
        $this->response($response, 200);
    }
}
/* End of file Nilai.php */
