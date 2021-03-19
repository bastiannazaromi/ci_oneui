<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }

    public function index()
    {
        $tahun_akademik = dekrip($this->u3);
        $semester = dekrip($this->u4);
        $date_now = $this->u5;

        if (!$tahun_akademik) {
            $tahun_akademik = $this->universal->getOneSelect('kode', ['status' => 1], 'tahun_akademik');
            $tahun_akademik = $tahun_akademik->kode;
        }
        if (!$semester) {
            $semester = 1;
        }
        if (!$date_now) {
            $date_now = date('Y-m-d');
        }
        $date = strtotime($date_now);
        $newformat = date('Y-m-d', $date);
        $day = date('N', $date);

        $query = [
            'ekuliah_keys'      => '785a4062ab84fad14hd',
            'tahun_akademik'    => $tahun_akademik,
            'level'             => 2,
            'kelas'             => '',
            'dosen'             => '',
            'prodi'             => $this->user[0]->kd_prodi,
            'semester'          => $semester,
            'hari'              => $day,
            'tgl'               => $newformat
        ];

        $jadwal = api_get('ekuliah_sisfo360', 'phb123456', $query, 'https://syncnau.poltektegal.ac.id/api/jadwal', true);

        $params = [
            'title'         => 'Rombel Kelas',
            'jadwal'        => $jadwal['message'],
            'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
            'th_ini'        => $tahun_akademik,
            'smst_ini'      => $semester,
            'date_ini'      => $date_now
        ];

        $this->load->view('jadwal', $params);
    }
}

/* End of file Jadwal.php */
