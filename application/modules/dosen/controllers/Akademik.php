<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Akademik extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        dosen_init();
    }

    function index()
    {
        if ($this->u3 == 'jadwal')
        {
            $tahun_akademik = $this->universal->getOne(['status' => 1], 'tahun_akademik');
            $date_now = '2020-09-14';
            $query = [
                'ekuliah_keys' => $this->keys_synckuliah,
                'tahun_akademik' => $tahun_akademik->id,
                'level' => 3,
                'kelas' => '',
                'dosen' => 'dskmp204',
                'prodi' => '',
                'semester' => '',
                'tgl' => $date_now
            ];
            $params = array(
                'title' => 'Dashboard',
                'kalender_akademik' =>  $tahun_akademik,
                'jadwal_hari_ini' => api_get($this->username_synckuliah, $this->password_synckuliah, $query, $this->urlApiSyncKuliah . 'jadwal', true)
            );
            var_dump($params).die();
            $this->load->view('jadwal', $params);
        }
        elseif ($this->u3 == 'bimbingan')
        {
            $params = [
                'title'     => 'Mahasiswa Bimbingan',
                'mahasiswa' => $this->dosen->getMhsBimbingan([
                    'id_dosen'  => $this->user->id
                ])            
            ];
            $this->load->view('bimbingan', $params);
        }
        elseif ($this->u3 == 'getMhs') {
        
            $nim = dekrip($this->u4);

            $data = $this->universal->getOne(['nim' => $nim], 'mahasiswa');

            echo json_encode($data);

        }
    }
}
