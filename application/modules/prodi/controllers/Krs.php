<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Krs extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u2 == 'krs') {
            if ($this->u3 == 'edit') {
                $this->form_validation->set_rules('awal', 'Tanggal Awal', 'required');
                $this->form_validation->set_rules('akhir', 'Tanggal Akhir', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'awal' => htmlspecialchars($this->input->post('awal', true)),
                        'akhir' => htmlspecialchars($this->input->post('akhir', true)),
                        'status' => 1,
                    ];
                    $update = $this->universal->update($data, ['id' => $this->input->post('id')], 'waktu_krs');
                    if ($update) {
                        $this->notifikasi->success('Berhasil update waktu krs');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else if ($this->u3 == 'getOne') {
                $id_krs = dekrip($this->u4);
                if (empty($id_krs)) {
                    redirect('prodi/krs');
                }
                $data = $this->universal->getOne(['id' => $id_krs], 'waktu_krs');
                if ($data) {
                    echo json_encode($data, true);
                }
            } else if ($this->u3 == 'getOneSusulan') {
                $id_krs = dekrip($this->u4);
                if (empty($id_krs)) {
                    redirect('prodi/krs');
                }
                $data = $this->universal->getOne(['id' => $id_krs], 'waktu_krs');
                if ($data) {
                    echo json_encode($data, true);
                }
            } else if ($this->u3 == 'edit_susulan') {
                $this->form_validation->set_rules('id_susulan', 'id', 'required');
                $this->form_validation->set_rules('awal_susulan', 'Awal', 'required');
                $this->form_validation->set_rules('awal_susulan', 'Akhir', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'awal' => htmlspecialchars($this->input->post('awal_susulan', true)),
                        'akhir' => htmlspecialchars($this->input->post('awal_susulan', true)),
                    ];
                    $update = $this->universal->update($data, ['id' => $this->input->post('id_susulan', true)], 'waktu_krs');
                    if ($update) {
                        $this->notifikasi->success('Berhal update waktu susulan krs');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else if ($this->u3 == 'nilai_min') {
                $this->form_validation->set_rules('nilai', 'Nilai', 'required|min_length[1]|max_length[1]');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'nilai_min' => htmlspecialchars($this->input->post('nilai', true))
                    ];
                    $tahun_akademik = $this->universal->getOneSelect('status,periode', ['status' => 1], 'tahun_akademik');
                    $update = $this->universal->update($data, ['periode' => $tahun_akademik->periode, 'kd_prodi' => $this->user[0]->kd_prodi], 'waktu_krs');
                    if ($update) {
                        $this->notifikasi->success('Berhasil update nilai min');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $tahun_akademik = $this->universal->getMulti(['status' => 1], 'tahun_akademik');
                $params = [
                    'title' => 'Atur Waktu KRS',
                    'tahun_akademik' => $tahun_akademik,
                    'krs' => $this->universal->getMulti(['periode' => $tahun_akademik[0]->periode, 'kd_prodi' => $this->user[0]->kd_prodi, 'status' => 1], 'waktu_krs'),
                    'krs_susulan' => $this->universal->getMulti(['periode' => $tahun_akademik[0]->periode, 'kd_prodi' => $this->user[0]->kd_prodi, 'status' => 2], 'waktu_krs'),
                    'nilai_min' => $this->universal->getOne(['periode' => $tahun_akademik[0]->periode, 'kd_prodi' => $this->user[0]->kd_prodi], 'waktu_krs')
                ];
                $this->load->view('waktu_krs', $params);
            }
        }
    }
}

/* End of file Krs.php */
