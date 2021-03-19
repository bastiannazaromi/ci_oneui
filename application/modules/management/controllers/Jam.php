<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jam extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        management_init();
    }

    function index()
    {
        if ($this->u2 == 'jamkuliah') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nama_jam', 'Nama Jam', 'required');
                $this->form_validation->set_rules('mulai', 'Jam Mulai', 'required');
                $this->form_validation->set_rules('selesai', 'Jam Selesai', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/jamkuliah', 'refresh');
                } else {
                    $data = [
                        'nama_jam'      => $this->input->post('nama_jam'),
                        'mulai'         => $this->input->post('mulai'),
                        'selesai'       => $this->input->post('selesai')
                    ];

                    $insert = $this->universal->insert($data, 'jamkuliah');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('management/jamkuliah', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama_jam', 'Nama Jam', 'required');
                $this->form_validation->set_rules('mulai', 'Jam Mulai', 'required');
                $this->form_validation->set_rules('selesai', 'Jam Selesai', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/direktur', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));

                    $data = [
                        'nama_jam'      => $this->input->post('nama_jam'),
                        'mulai'         => $this->input->post('mulai'),
                        'selesai'       => $this->input->post('selesai'),
                        'updated_at'     => date('Y-m-d H:i:s')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'jamkuliah');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('management/jamkuliah', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'jamkuliah');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('management/jamkuliah', 'refresh');
            } else {
                $params = [
                    'title'     => 'Jam Kuliah',
                    'jam'       => $this->universal->getOrderBy('', 'jamkuliah', 'nama_jam', '', '')
                ];

                $this->load->view('jam', $params);
            }
        }
    }
}

/* End of file Jam.php */