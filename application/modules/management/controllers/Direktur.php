<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Direktur extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        management_init();
    }

    function index()
    {
        if ($this->u2 == 'direktur') {
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
                $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/direktur', 'refresh');
                } else {
                    $data = [
                        'id_peg'          => dekrip($this->input->post('id_peg')),
                        'jabatan'         => dekrip($this->input->post('jabatan'))
                    ];

                    $insert = $this->universal->insert($data, 'direktur');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('management/direktur', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/direktur', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'jabatan'         => dekrip($this->input->post('jabatan')),
                        'updated_at'       => date('Y-m-d H:i:s')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'direktur');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('management/direktur', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'direktur');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('management/direktur', 'refresh');
            } else {
                $params = [
                    'title'         => 'Direktur',
                    'direktur'      => $this->management->getDirektur(),
                    'jabatan'       => $this->universal->getOrderBy('', 'jabatan', 'nama_jabatan', '', '')
                ];

                $this->load->view('direktur', $params);
            }
        }
    }
}

/* End of file Direktur.php */