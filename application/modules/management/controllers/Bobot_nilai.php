<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bobot_nilai extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        management_init();
    }

    function index()
    {
        if ($this->u2 == 'bobotnilai') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('huruf', 'Huruf', 'required');
                $this->form_validation->set_rules('angka_awal', 'Angka Awal', 'required');
                $this->form_validation->set_rules('angka_akhir', 'Angka Akhir', 'required');
                $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
                $this->form_validation->set_rules('th_akademik', 'Tahun Akademik', 'required');

                $huruf = dekrip($this->input->post('huruf'));
                $angka_awal = $this->input->post('angka_awal');
                $angka_akhir = $this->input->post('angka_akhir');
                $kd_prodi = dekrip($this->input->post('prodi'));
                $th_akademik = dekrip($this->input->post('th_akademik'));

                if ($huruf == 'A') {
                    $bobot = '4';
                } else if ($huruf == 'B') {
                    $bobot = '3';
                } else if ($huruf == 'C') {
                    $bobot = '2';
                } else if ($huruf == 'D') {
                    $bobot = '1';
                } else {
                    $bobot = '0';
                }

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'angka_awal'        => $angka_awal,
                        'angka_akhir'       => $angka_akhir,
                        'huruf'             => $huruf,
                        'bobot'             => $bobot,
                        'kd_prodi'          => $kd_prodi,
                        'tahun_akademik'    => $th_akademik
                    ];

                    $insert = $this->universal->insert($data, 'bobot_nilai');


                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('huruf', 'Huruf', 'required');
                $this->form_validation->set_rules('angka_awal', 'Angka Awal', 'required');
                $this->form_validation->set_rules('angka_akhir', 'Angka Akhir', 'required');
                $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
                $this->form_validation->set_rules('th_akademik', 'Tahun Akademik', 'required');

                $huruf = dekrip($this->input->post('huruf'));
                $angka_awal = $this->input->post('angka_awal');
                $angka_akhir = $this->input->post('angka_akhir');
                $kd_prodi = dekrip($this->input->post('prodi'));
                $th_akademik = dekrip($this->input->post('th$th_akademik'));

                if ($huruf == 'A') {
                    $bobot = '4';
                } else if ($huruf == 'B') {
                    $bobot = '3';
                } else if ($huruf == 'C') {
                    $bobot = '2';
                } else if ($huruf == 'D') {
                    $bobot = '1';
                } else {
                    $bobot = '0';
                }

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $id = dekrip($this->input->post('id'));

                    $data = [
                        'angka_awal'        => $angka_awal,
                        'angka_akhir'       => $angka_akhir,
                        'huruf'             => $huruf,
                        'bobot'             => $bobot,
                        'kd_prodi'          => $kd_prodi,
                        'tahun_akademik'    => $th_akademik
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'bobot_nilai');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'bobot_nilai');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $prodi = dekrip($this->u3);
                if (!$prodi) {
                    $prodi = $this->universal->getOneSelect('kd_prodi', '', 'prodi');
                    $prodi = $prodi->kd_prodi;
                }

                if ($this->u4 != '') {
                    $tahun = dekrip($this->u4);
                } else {
                    $tahun = $this->universal->getOneSelect('id', ['status' => 1], 'tahun_akademik');
                    $tahun = $tahun->id;
                }

                $bobot = $this->management->getBobotNilai(['bobot_nilai.kd_prodi' => $prodi, 'bobot_nilai.tahun_akademik' => $tahun]);

                $params = [
                    'title'         => 'Bobot Nilai',
                    'bobot'         => $bobot,
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', 'asc', ''),
                    'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                    'prodi_ini'     => $prodi,
                    'th_ini'        => $tahun
                ];

                $this->load->view('bobot_nilai', $params);
            }
        }
    }
}

/* End of file Bobot_nilai.php */
