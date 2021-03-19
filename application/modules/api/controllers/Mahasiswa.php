<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_api', 'api');
    }
    public function addMahasiswa_post()
    {
        $nim = $this->post('nim');
        $data = [
            'nim' => $nim,
            'password' => $nim,
            'nama_lengkap' =>  $this->post('nama'),
            'jk' =>  $this->post('jk'),
            'nik' => $this->post('nik'),
            'tempat_lahir' => $this->post('tempat_lahir'),
            'tanggal_lahir' => $this->post('tanggal_lahir'),
            'email' => $this->post('email'),
            'asal_sekolah' => $this->post('asal_sekolah'),
            'semester_masuk' => $this->post('semester_masuk'),
            'tahun_masuk' => $this->post('tahun_masuk'),
            'semester' => $this->post('semester'),
            'status_kelas' => 0,
            'jalur' => $this->post('jalur'),
            'prodi' => $this->post('prodi'),
            'agama' => $this->post('agama')
        ];
        $insert = $this->universal->insert($data, 'mahasiswa');
        if ($insert) {
            $response = [
                'status' => true,
                'message' => 'Berhasil input data mahasiswa'
            ];
            $this->response($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal input data mahasiswa'
            ];
            $this->response($response, 502);
        }
    }
    public function tahun_akademik_get()
    {
        $status = $this->get('status');
        if ($status) {
            $data = $this->universal->getMulti(['status' => $status], 'tahun_akademik');
        } else {
            $data = $this->universal->getMulti('', 'tahun_akademik');
        }
        $this->response($data, 200);
    }
    public function semester_get()
    {
        $semester = $this->get('semester');
        if ($semester) {
            $cek = $this->api->getSemester(['semester' => $semester]);
            if ($cek) {
                $data = $cek;
            } else {
                $data = [
                    'status' => false,
                    'message' => 'Semester tidak ditemukan'
                ];
            }
        } else {
            $data = $this->api->getSemester();
        }
        $this->response($data, 200);
    }
    public function tahun_angkatan_get()
    {
        $data = $this->api->getTahunAngkatan();
        $this->response($data, 200);
    }
    public function mahasiswa_get()
    {
        $thn_angkatan = $this->get('ta');
        $prodi = $this->get('prodi');
        $smt = $this->get('semester');
        $akademik = $this->get('akademik');
        $jalur = $this->get('jalur');
        $nim = $this->get('nim');

        $data = $this->api->getMhs($nim, $akademik, $prodi, $thn_angkatan, $smt, $jalur);
        $this->response($data, 200);
    }
    public function getMhsByJalur_get()
    {
        $jalur = $this->get('jalur');
        if ($jalur) {
            $data = $this->api->getMhsBy(['mahasiswa.jalur' => $jalur]);
            if ($data) {
                $this->response($data, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ];
                $this->response($response, 502);
            }
        } else {
            $this->response(['status' => false], 502);
        }
    }
    public function getJalur_get()
    {
        $jalur = $this->get('jalur');
        if ($jalur) {
            $cek = $this->universal->getMulti(['mahasiswa.jalur' => $jalur], 'jalur');
            if ($cek) {
                $data = $cek;
            } else {
                $data = [
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ];
                $this->response($data, 502);
            }
        } else {
            $data = $this->universal->getMulti('', 'jalur');
        }
        $this->response($data, 200);
    }
    public function getProdi_get()
    {
        $kode = $this->get('kode_prodi');
        if ($kode) {
            $data = $this->universal->getMulti(['kode_prodi' => $kode], 'prodi');
            if ($data) {
                $this->response($data, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Data tidakditemukan'
                ];
                $this->response($response, 502);
            }
        } else {
            $data = $this->universal->getMulti('', 'prodi');
            $this->response($data, 200);
        }
    }

    public function getMhsByNIMEPT_get()
    {
        $nim = $this->get('nim');
        $data = $this->api->getMhsByNIM_EPT($nim);
        if ($data) {
            $this->response($data, 200);
        }
    }
}
/* End of file Mahasiswa.php */
