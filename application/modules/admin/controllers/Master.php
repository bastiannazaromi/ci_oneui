<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        admin_init();
    }

    function index()
    {
        if ($this->u2 == 'agama') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('agama', 'Nama Agama', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/agama', 'refresh');
                } else {
                    $data = [
                        'agama'      => $this->input->post('agama')
                    ];

                    $insert = $this->universal->insert($data, 'agama');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/agama', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('agama', 'Nama Agama', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/prodi', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'agama'          => $this->input->post('agama')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'agama');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('admin/agama', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'agama');
                if ($delete) {
                    $this->notifikasi->success('toastr-sukses', 'Data berhasil dihapus');
                }

                redirect('admin/agama', 'refresh');
            } else {
                $params = [
                    'title'         => 'Agama',
                    'agama'         => $this->universal->getMulti('', 'agama')
                ];

                $this->load->view('agama', $params);
            }
        } elseif ($this->u2 == 'jalur') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('jalur', 'Nama Jalur', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/jalur', 'refresh');
                } else {
                    $data = [
                        'nama_jalur'      => $this->input->post('jalur')
                    ];

                    $insert = $this->universal->insert($data, 'jalur');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/jalur', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('jalur', 'Nama Jalur', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/jalur', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'nama_jalur'          => $this->input->post('jalur')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'jalur');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('admin/jalur', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'jalur');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('admin/jalur', 'refresh');
            } else {
                $params = [
                    'title'         => 'Jalur Pendaftaran',
                    'jalur'         => $this->universal->getMulti('', 'jalur')
                ];

                $this->load->view('jalur', $params);
            }
        } elseif ($this->u2 == 'statuspeg') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kode', 'Kode Status', 'required|trim');
                $this->form_validation->set_rules('nama_status', 'Nama Status', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/statuspeg', 'refresh');
                } else {
                    $data = [
                        'kode'              => $this->input->post('kode'),
                        'nama_status'       => $this->input->post('nama_status')
                    ];

                    $insert = $this->universal->insert($data, 'status_pegawai');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/statuspeg', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kode', 'Kode Status', 'required|trim');
                $this->form_validation->set_rules('nama_status', 'Nama Status', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/statuspeg', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'kode'              => $this->input->post('kode'),
                        'nama_status'       => $this->input->post('nama_status')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'status_pegawai');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('admin/statuspeg', 'refresh');
                }
            } else {
                $params = [
                    'title'         => 'Status Pegawai',
                    'status'         => $this->universal->getMulti('', 'status_pegawai')
                ];

                $this->load->view('statuspeg', $params);
            }
        } elseif ($this->u2 == 'statusmhs') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nama_status', 'Nama Status', 'required|trim');
                $this->form_validation->set_rules('kode_status', 'Kode Status', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/statusmhs', 'refresh');
                } else {
                    $data = [
                        'nama_status'       => $this->input->post('nama_status'),
                        'id_stat_mhs'       => $this->input->post('kode_status')
                    ];

                    $insert = $this->universal->insert($data, 'status_mhs');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/statusmhs', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama_status', 'Nama Status', 'required|trim');
                $this->form_validation->set_rules('kode_status', 'Kode Status', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/statusmhs', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'nama_status'       => $this->input->post('nama_status'),
                        'id_stat_mhs'       => $this->input->post('kode_status')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'status_mhs');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('admin/statusmhs', 'refresh');
                }
            } else {
                $params = [
                    'title'         => 'Status Mahasiswa',
                    'status'         => $this->universal->getMulti('', 'status_mhs')
                ];

                $this->load->view('statusmhs', $params);
            }
        }
    }
}

/* End of file Master.php */