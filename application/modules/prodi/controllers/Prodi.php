<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Prodi extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        $status_mhs = $this->universal->getOneSelect('id', ['id_stat_mhs' => 'A'], 'status_mhs');
        $params = [
            'title'             => "Dahsboard",
            'dosen'             => $this->universal->getMulti(['status_peg' => 1, 'prodi' => $this->user[0]->kd_prodi], 'pegawai'),
            'mahasiswa'         => $this->universal->getMulti(['status_mahasiswa' => 1, 'prodi' => $this->user[0]->kd_prodi], 'mahasiswa'),
            'mata_kuliah'       => $this->universal->getMulti(['kd_prodi' => $this->user[0]->kd_prodi], 'mata_kuliah'),
            'mhs'               => $this->universal->getGroupSelect('COUNT(id) as total, semester', [
                'prodi' => $this->user[0]->kd_prodi, 'status_mahasiswa' => $status_mhs->id
            ], 'mahasiswa',  'semester', 'semester', 'asc'),
            'mhs_status'        => $this->prodi->getMhsStatus(['mahasiswa.prodi' => $this->user[0]->kd_prodi])
        ];
        $this->load->view('dashboard', $params);
    }
    public function test()
    {
        $username = 'oase_sisfo';
        $password = 'phb123456';
        $keys = '785a4062ab84fad16';
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://oase.phb.my.id/api/tahun_akademik?oase_key=' . $keys . '');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
        $data = curl_exec($curl_handle);
        curl_close($curl_handle);
        header('Content-Type: application/json');
        echo $data;
    }
}

/* End of file Prodi.php */
