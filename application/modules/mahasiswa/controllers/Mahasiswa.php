<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        mhs_init();
    }
    public function index()
    {
        $tahun_akademik = $this->universal->getOne(['status' => 1], 'tahun_akademik');
        $date_now = date('Y-m-d');
        $query = [
            'ekuliah_keys' => $this->keys_synckuliah,
            'tahun_akademik' => $tahun_akademik->id,
            'level' => 4,
            'kelas' => $this->user->kelas,
            'prodi' => $this->user->prodi,
            'semester' => $this->user->semester,
            'tgl' => $date_now,
            'hari' => date('N')
        ];
        $params = array(
            'title' => 'Dashboard',
            'kalender_akademik' =>  $tahun_akademik,
            'jadwal_hari_ini' => api_get($this->username_synckuliah, $this->password_synckuliah, $query, $this->urlApiSyncKuliah . 'jadwal', true)
        );
        $this->load->view('dashboard', $params);
    }
    public function cek_jadwal()
    {
        $query = [
            'oase_key' => '785a4062ab84fad16',
            'username' => '21040049',
            'prodi' => '04',
            'kd_dosen' => 'ds0001',
            'makul' => '14214',
            'kd_ta' => 1,
            'semester' => 3,
            'kelas' => $this->user->kelas,
            'presensi' => 100,
            'tugas' => 100,
            'uas' => 100,
            'uts' => 100,
        ];
        $jadwal = api_get('oase_sisfo', 'phb123456', $query, 'https://oase.phb.my.id/api/nilai', true);
        var_dump($jadwal);
    }
}
