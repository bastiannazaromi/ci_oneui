<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Prodi extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        management_init();
    }

    function index()
    {
        if ($this->u2 == 'kaprodi') {
            if ($this->u3 == 'getPeg') {
                $peg = $this->management->likePeg($this->input->get('q'));
                $data = [];
                foreach ($peg as $hasil) {
                    array_push($data, [
                        "value"         => enkrip($hasil->id),
                        "text"          => $hasil->nama
                    ]);
                }

                $this->output->set_header('Content-Type: application/json');
                echo json_encode($data);
            } elseif ($this->u3 == 'add') {
                $this->form_validation->set_rules('id_peg', 'Nama Pegawai', 'required');
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/direktur', 'refresh');
                } else {
                    $data = [
                        'id_peg'          => dekrip($this->input->post('id_peg')),
                        'kd_prodi'        => dekrip($this->input->post('kd_prodi'))
                    ];

                    $insert = $this->universal->insert($data, 'ka_prodi');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('management/kaprodi', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/direktur', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'kd_prodi'        => dekrip($this->input->post('kd_prodi')),
                        'updated_at'       => date('Y-m-d H:i:s')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'ka_prodi');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('management/kaprodi', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'ka_prodi');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('management/kaprodi', 'refresh');
            } else {
                $params = [
                    'title'         => 'Ka. Prodi',
                    'kaprodi'       => $this->management->getKaProdi(),
                    'pegawai'       => $this->universal->getOrderBy('', 'pegawai', 'nama', '', ''),
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', '', '')
                ];

                $this->load->view('kaprodi', $params);
            }
        } elseif ($this->u2 == 'prodi') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('status', 'Status Akreditasi', 'required');

                $status = dekrip($this->input->post('status'));
                if ($status == 1) {
                    $this->form_validation->set_rules('no_sk', 'No SK Akreditasi', 'required');
                    $this->form_validation->set_rules('akreditasi', 'Akreditasi', 'required');

                    $no_sk = $this->input->post('no_sk');
                    $akreditasi = dekrip($this->input->post('akreditasi'));
                } else {
                    $no_sk = null;
                    $akreditasi = null;
                }

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/prodi', 'refresh');
                } else {
                    $data = [
                        'kd_prodi'        => dekrip($this->input->post('kd_prodi')),
                        'no_sk'           => $no_sk,
                        'status'          => $status,
                        'akreditasi'      => $akreditasi
                    ];
                    $insert = $this->universal->insert($data, 'prodi_akred');
                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }
                    redirect('management/prodi', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('status', 'Status Akreditasi', 'required');

                $status = dekrip($this->input->post('status'));
                if ($status == 1) {
                    $this->form_validation->set_rules('no_sk', 'No SK Akreditasi', 'required');
                    $this->form_validation->set_rules('akreditasi', 'Akreditasi', 'required');

                    $no_sk = $this->input->post('no_sk');
                    $akreditasi = dekrip($this->input->post('akreditasi'));
                } else {
                    $no_sk = null;
                    $akreditasi = null;
                }

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/direktur', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'kd_prodi'        => dekrip($this->input->post('kd_prodi')),
                        'no_sk'           => $no_sk,
                        'status'          => $status,
                        'akreditasi'      => $akreditasi,
                        'updated_at'       => date('Y-m-d H:i:s')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'prodi_akred');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('management/prodi', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'prodi_akred');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('management/prodi', 'refresh');
            } else {
                $params = [
                    'title'         => 'Program Studi',
                    'akreditasi'    => $this->management->getAkreditasi(),
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', '', '')
                ];
                $this->load->view('prodi', $params);
            }
        }
    }
}

/* End of file Prodi.php */