<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ref_prodi extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        admin_init();
    }
    public function index()
    {
        if ($this->u2 == 'prodi') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kd_nasional', 'Kode nasional', 'required|max_length[5]');
                $this->form_validation->set_rules('kd_prodi', 'Kode Prodi', 'required|max_length[2]');
                $this->form_validation->set_rules('sms', 'ID SMS', 'required');
                $this->form_validation->set_rules('nama', 'Nama Prodi', 'required');
                $this->form_validation->set_rules('jenjang', 'Jenjang', 'required');
                $this->form_validation->set_rules('kode', 'Kode', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/prodi', 'refresh');
                } else {
                    $data = [
                        'kd_prodi'      => $this->input->post('kd_prodi'),
                        'id_sms'        => $this->input->post('sms'),
                        'kd_nasional'   => $this->input->post('kd_nasional'),
                        'nama'          => $this->input->post('nama'),
                        'jenjang'       => $this->input->post('jenjang'),
                        'kode'          => $this->input->post('kode')
                    ];
                    $dataSimak = [
                        'simak_key' => '6023521d3053b',
                        'kd_prodi' => $this->input->post('kd_prodi'),
                        'kd_prodi_nasional' => $this->input->post('kd_nasional'),
                        'nama_prodi' => $this->input->post('jenjang') . "." . $this->input->post('nama')
                    ];
                    $insert = $this->universal->insert($data, 'prodi');
                    if ($insert) {
                        api_post('simak_sisfo', 'phb123456', $dataSimak, $this->urlSimak . "addProdi");
                        $this->notifikasi->success('Data berhasil ditambah');
                    }
                    redirect('admin/prodi', 'refresh');
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);
                $data = $this->universal->getOne(['id' => $id], 'prodi');
                echo json_encode($data);
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kd_nasional', 'Kode nasional', 'required|max_length[5]');
                $this->form_validation->set_rules('sms', 'ID SMS', 'required');
                $this->form_validation->set_rules('nama', 'Nama Prodi', 'required');
                $this->form_validation->set_rules('jenjang', 'Jenjang', 'required');
                $this->form_validation->set_rules('kode', 'Kode', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/prodi', 'refresh');
                } else {
                    $kd_prodi = dekrip($this->input->post('kd_prodi'));
                    $data = [
                        'id_sms'            => $this->input->post('sms'),
                        'kd_nasional'       => $this->input->post('kd_nasional'),
                        'nama'              => $this->input->post('nama'),
                        'jenjang'           => $this->input->post('jenjang'),
                        'kode'              => $this->input->post('kode')
                    ];
                    $update = $this->universal->update($data, ['kd_prodi' => $kd_prodi], 'prodi');
                    $dataSimak = [
                        'simak_key' => '6023521d3053b',
                        'kd_prodi' => $kd_prodi,
                        'kd_nasional' => $this->input->post('kd_nasional'),
                        'nama' => $this->input->post('jenjang') . "." . $this->input->post('nama')
                    ];
                    if ($update) {
                        api_put('simak_sisfo', 'phb123456', $dataSimak, $this->urlSimak . "editProdi");
                        $this->notifikasi->success('Data berhasil diupdate');
                    }
                    redirect('admin/prodi', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $kd = dekrip($this->u4);
                $dataSimak = [
                    'simak_key' => '6023521d3053b',
                    'kd_prodi' => $kd
                ];
                $delete = $this->universal->delete(['kd_prodi' => $kd], 'prodi');
                if ($delete) {
                    api_delete('simak_sisfo', 'phb123456', $dataSimak, $this->urlSimak . "hapusProdi");
                    $this->notifikasi->success('toastr-sukses', 'Data berhasil dihapus');
                }
                redirect('admin/prodi', 'refresh');
            } else {
                $params = [
                    'title'         => 'Ref. Prodi',
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', 'ASC', '')
                ];
                $this->load->view('prodi', $params);
            }
        }
    }
}
/* End of file Ref_prodi.php */