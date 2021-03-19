<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Nilai_akhir extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u3 == 'getNilai') {
            $dosen = dekrip($this->input->get('dosen'));
            $kelas = dekrip($this->input->get('kelas'));
            $smt = dekrip($this->input->get('smt'));
            $makul = dekrip($this->input->get('makul'));
            $tahun = dekrip($this->input->get('tahun'));

            $nilai = $this->prodi->getKelasMK([
                'nilai.kd_dosen'        => $dosen,
                'nilai.kelas'           => $kelas,
                'nilai.smt'             => $smt,
                'nilai.makul'           => $makul,
                'nilai.thak'            => $tahun
            ]);

            $params = [
                'nilai'      => $nilai
            ];

            $this->load->view('v_nilai_akhir', $params);
        } elseif ($this->u3 == 'getGroup') {
            $tahun = dekrip($this->input->get('tahun'));

            $kelas_mk = $this->prodi->getGroupKelasMK(['nilai.prodi' => $this->user[0]->kd_prodi, 'nilai.thak' => $tahun]);

            $data = [];

            foreach ($kelas_mk as $row) {
                array_push($data, [
                    'id'            => dekrip($row->id),
                    'smt'           => enkrip($row->smt),
                    'kd_dosen'      => enkrip($row->kd_dosen),
                    'kelas'         => enkrip($row->kelas),
                    'makul'         => enkrip($row->makul),
                    'text'          => $row->nama_mk . ' - Smt: ' . $row->smt . ' - Kelas: ' . $row->kelas . ' - Dosen: ' . $row->gelar_depan . ' ' . $row->nama . ', ' . $row->gelar_belakang
                ]);
            }

            echo json_encode($data);
        } else {
            $tahun = dekrip($this->u3);
            if (!$tahun) {
                $tahun_ak = $this->universal->getOneSelect('id', ['status' => 1], 'tahun_akademik');
                $tahun = $tahun_ak->id;
            }

            $kelas_mk = $this->prodi->getGroupKelasMK(['nilai.prodi' => $this->user[0]->kd_prodi, 'nilai.thak' => $tahun]);

            $params = [
                'title'         => 'Nilai Akhir',
                'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                'th_ini'        => $tahun,
                'kelas_mk'      => $kelas_mk
            ];

            $this->session->set_userdata('previous_url', current_url());
            $this->load->view('nilai_akhir', $params);
        }
    }
}
/* End of file Nilai_akhir.php */