<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        management_init();
    }
    public function index()
    {
        if ($this->u2 == 'kelas') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kelas', 'Nama Kelas', 'required|trim|alpha|max_length[1]');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/kelas', 'refresh');
                } else {
                    $data = [
                        'kelas'     => $this->input->post('kelas')
                    ];

                    $insert = $this->universal->insert($data, 'kelas');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('management/kelas', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'kelas');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('management/kelas', 'refresh');
            } else {

                $params = [
                    'title'         => 'Master Kelas',
                    'kelas'         => $this->universal->getOrderBy('', 'kelas', 'kelas', 'asc', ''),
                    'alpha'         => range('A', 'Z')
                ];

                $this->load->view('kelas', $params);
            }
        } else if ($this->u2 == 'bagikelas') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kelas', 'Nama Kelas', 'required|trim|alpha|max_length[1]');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/kelas', 'refresh');
                } else {
                    $data = [
                        'prodi'     => $this->user[0]->kd_prodi,
                        'kelas'     => $this->input->post('kelas'),
                        'tahun'     => $this->_tahun()
                    ];

                    $insert = $this->universal->insert($data, 'kelas');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('prodi/kelas', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kelas', 'kelas', 'required|trim|alpha|max_length[1]');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/kelas', 'refresh');
                } else {

                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'prodi'     => $this->user[0]->kd_prodi,
                        'kelas'     => $this->input->post('kelas')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'kelas');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('prodi/kelas', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'direktur');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('prodi/kelas', 'refresh');
            } else {
                $tahun = dekrip($this->u3);
                $semester = dekrip($this->u4);
                if (!$semester) {
                    $semester = $this->_semester();
                }
                if (!$tahun) {
                    $tahun = $this->_tahun();
                }
                $status_tahun = $this->universal->getOneSelect('status', ['id' => $tahun], 'tahun_akademik');
                $params = [
                    'title'         => 'Pembagian Kelas',
                    'kelas'         => $this->universal->getOrderBy(['prodi' => $this->user[0]->kd_prodi, 'tahun' => $tahun], 'kelas', 'kelas', 'asc', ''),
                    'bagikelas'     => $this->prodi->getBagiKelas(['prodi' => $this->user[0]->kd_prodi, 'tahun' => $tahun, 'semester' => $semester]),
                    'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                    'th_ini'        => $tahun,
                    'status_th'     => $status_tahun->status
                ];

                $this->load->view('bagikelas', $params);
            }
        }
    }

    private function _tahun()
    {
        $tahun = $this->universal->getOneSelect('id', ['status' => 1], 'tahun_akademik');

        return $tahun->id;
    }

    private function _semester()
    {
        $semester = $this->universal->getOneSelect('MAX(semester) as semester', '', 'bagikelas');

        return $semester->id;
    }
}

/* End of file Kelas.php */