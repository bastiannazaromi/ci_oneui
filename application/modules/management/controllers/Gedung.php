<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gedung extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        management_init();
    }

    function index()
    {
        if ($this->u2 == 'gedung') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nama', 'Nama Gedung', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/gedung', 'refresh');
                } else {
                    $data = [
                        'nama'          => $this->input->post('nama')
                    ];

                    $insert = $this->universal->insert($data, 'gedung');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('management/gedung', 'refresh');
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);

                $data = $this->universal->getOne(['id' => $id], 'gedung');

                echo json_encode($data);
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama', 'Nama Gedung', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/gedung', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'nama'         => $this->input->post('nama'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'gedung');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('management/gedung', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'gedung');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('management/gedung', 'refresh');
            } else {
                $params = [
                    'title'         => 'Gedung',
                    'gedung'        => $this->universal->getOrderBy('', 'gedung', 'nama', 'ASC', '')
                ];

                $this->load->view('gedung', $params);
            }
        } elseif ($this->u2 == 'ruang') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nama', 'Nama Ruang', 'required');
                $this->form_validation->set_rules('prodi', 'Kode Prodi', 'required');
                $this->form_validation->set_rules('gedung', 'gedung', 'required');
                $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('prodi')),
                        'id_gedung'     => dekrip($this->input->post('gedung')),
                        'nama_ruang'    => $this->input->post('nama'),
                        'kapasitas'     => $this->input->post('kapasitas')
                    ];

                    $insert = $this->universal->insert($data, 'ruang');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);

                $data = $this->universal->getOne(['id' => $id], 'ruang');

                echo json_encode($data);
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama', 'Nama Ruang', 'required');
                $this->form_validation->set_rules('prodi', 'Kode Prodi', 'required');
                $this->form_validation->set_rules('gedung', 'Gedung', 'required');
                $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required|numeric');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('prodi')),
                        'id_gedung'     => dekrip($this->input->post('gedung')),
                        'nama_ruang'    => $this->input->post('nama'),
                        'kapasitas'     => $this->input->post('kapasitas'),
                        'updated_at'     => date('Y-m-d H:i:s')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'ruang');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $delete = $this->universal->delete(['id' => $id], 'ruang');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect($_SERVER['HTTP_REFERER']);
            } else {
                if ($this->u3 != null) {
                    $ruang = $this->management->getRuang(['ruang.id_gedung' => dekrip($this->u3)]);
                } else {
                    $ruang = null;
                }

                $params = [
                    'title'         => 'Ruang',
                    'ruang'         => $ruang,
                    'prodi'         => $this->universal->getMulti('', 'prodi'),
                    'gedung'        => $this->universal->getOrderBy('', 'gedung', 'nama', 'asc', ''),
                    'id_gedung'     => dekrip($this->u3)
                ];

                $this->load->view('ruang', $params);
            }
        }
    }
}

/* End of file Gedung.php */