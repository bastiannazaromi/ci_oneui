<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Akademik extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        mhs_init();
    }
    public function index()
    {
        if ($this->u3 == 'jadwal') {
            $params = [
                'title'     => 'Jadwal Perkuliahan'
            ];
            $this->load->view('jadwal_perkuliahan', $params);
        } else if ($this->u3 == 'isi_krs') {
            $tanggal = date('Y-m-d');
            $tahun_akademik = $this->universal->getOne(['status' => 1], 'tahun_akademik');
            $waktu_krs = $this->universal->getOne(['periode' => $tahun_akademik->periode, 'status' => 1, 'kd_prodi' => $this->user->prodi, 'awal <=' => $tanggal, 'akhir >=' => $tanggal], 'waktu_krs');
            $status = $this->universal->getMulti(['id_th' => $tahun_akademik->id, 'nim' => $this->user->nim], 'krs');
            if (!$waktu_krs) {
                $this->notifikasi->warning('Waktu Pengisian KRS Telah ditutup');
            }
            $params = [
                'title' => 'Pengisian Kartu Rencana Studi (KRS)',
                'tahun_akademik' => $tahun_akademik,
                'mahasiswa' => $this->user,
                'waktu_krs' => $waktu_krs,
                'krs' => $this->mhs->getKrsMhs(['mata_kuliah.kd_prodi' => $this->user->prodi, 'mata_kuliah.status' => '1', 'mata_kuliah.semester' => $this->user->semester]),
            ];
            $this->load->view('isi_krs', $params);
        } else if ($this->u3 == 'ambil_krs') {
            $ambil = $this->input->post('checkbox', true);
            $tahun_akademik = $this->universal->getOne(['status' => 1], 'tahun_akademik');
            $data_insert = [];
            foreach ($ambil as $row) {
                array_push($data_insert, [
                    'nim' => $this->user->nim,
                    'kode_mk' => dekrip($row),
                    'id_th' => $tahun_akademik->id,
                    'semester' => $this->user->semester,
                    'status' => 0,
                ]);
            }
            $insert = $this->universal->insert_batch($data_insert, 'krs');
            if ($insert) {
                $this->notifikasi->success('Berhasil pengisi KRS');
                redirect('mahasiswa/akademik/isi_krs');
            }
        } else {
            redirect(base_url());
        }
    }
}
