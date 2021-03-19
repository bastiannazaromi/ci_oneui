<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kurikulum extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u2 == 'kurikulum') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kode', 'kode kurikulum', 'required|trim|min_length[6]|min_length[6]');
                $this->form_validation->set_rules('keterangan', 'keterangan kurikulim', 'required|trim');
                $this->form_validation->set_rules('status', 'Status', 'required|trim|numeric');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/kurikulum', 'refresh');
                } else {
                    $kode = htmlspecialchars($this->input->post('kode', true));
                    if ($this->universal->getOneSelect('kode_kurikulum', ['kode_kurikulum' => $kode], 'kurikulum')) {
                        $this->session->set_flashdata('toastr-error', 'Maaf kode kurikulum sudah ada!!');
                        redirect('prodi/kurikulum', 'refresh');
                    }
                    $data = [
                        'kode_kurikulum'    => $kode,
                        'keterangan_kurikulum'  => htmlspecialchars($this->input->post('keterangan')),
                        'status'    => htmlspecialchars($this->input->post('status', true))
                    ];
                    $insert = $this->universal->insert($data, 'kurikulum');
                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }
                    redirect('prodi/kurikulum', 'refresh');
                }
            } else if ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kode', 'kode kurikulum', 'required|trim|min_length[6]|min_length[6]');
                $this->form_validation->set_rules('keterangan', 'keterangan kurikulim', 'required|trim');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                } else {
                    $id = dekrip($this->input->post('id', true));
                    $data = [
                        'kode_kurikulum'    => htmlspecialchars($this->input->post('kode', true)),
                        'keterangan_kurikulum'  => htmlspecialchars($this->input->post('keterangan')),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    $update = $this->universal->update($data, ['id' => $id], 'kurikulum');
                    if ($update) {
                        $this->notifikasi->success('Berhasil edit data');
                    }
                    redirect('prodi/kurikulum', 'refresh');
                }
            } else if ($this->u3 == 'active_non_active') {
                $id = dekrip($this->u4);
                $chek = $this->u5;
                $status = ($chek == 'active') ? "1" : "0";
                $data = [
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $update = $this->universal->update($data, ['id' => $id], 'kurikulum');
                if ($update) {
                    $this->notifikasi->success(($status == 1) ? 'Berhasil Acivekan' : 'Berhasil Non Activekan');
                }
                redirect('prodi/kurikulum', 'refresh');
            } else if ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $delete = $this->universal->delete(['id' => $id], 'kurikulum');
                if ($delete) {
                    $this->notifikasi->success('Berhasil di hapus');
                }
                redirect('prodi/kurikulum', 'refresh');
            } else {
                $params = [
                    'title' => 'Jenis Karikulum',
                    'list_kurikulum' => $this->universal->getMulti('', 'kurikulum'),
                ];
                $this->load->view('jenis_kurikulum', $params);
            }
        }
    }
}

/* End of file Kurikulum.php */
