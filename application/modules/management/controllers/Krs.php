<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Krs extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        management_init();
    }
    public function index()
    {
        if ($this->u2 == 'krs') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('periode', 'Periode', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $periode = dekrip($this->input->post('periode'));
                    if ($periode == 1) {
                        $jenis = 'Semester Ganjil';
                    } else {
                        $jenis = 'Semester Genap';
                    }
                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('prodi')),
                        'jenis'         => $jenis,
                        'periode'       => $periode,
                        'awal'          => null,
                        'akhir'         => null,
                        'nilai_min'     => null,
                        'status'        => 1,
                    ];
                    $update = $this->universal->insert($data, 'waktu_krs');
                    if ($update) {
                        $this->notifikasi->success('Berhasil tambah waktu krs');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else if ($this->u3 == 'add_susulan') {
                $this->form_validation->set_rules('prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('periode', 'Periode', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $periode = dekrip($this->input->post('periode'));
                    if ($periode == 1) {
                        $jenis = 'Semester Ganjil';
                    } else {
                        $jenis = 'Semester Genap';
                    }
                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('prodi')),
                        'jenis'         => $jenis,
                        'periode'       => $periode,
                        'awal'          => null,
                        'akhir'         => null,
                        'nilai_min'     => null,
                        'status'        => 2,
                    ];
                    $update = $this->universal->insert($data, 'waktu_krs');
                    if ($update) {
                        $this->notifikasi->success('Berhasil tambah waktu krs susulan');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else {
                $params = [
                    'title'         => 'Atur Waktu KRS',
                    'krs'           => $this->universal->getMulti(['status' => 1], 'waktu_krs'),
                    'krs_susulan'   => $this->universal->getMulti(['status' => 2], 'waktu_krs'),
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', 'asc', '')
                ];
                $this->load->view('waktu_krs', $params);
            }
        }
    }
}

/* End of file Krs.php */
