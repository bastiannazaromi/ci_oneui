<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

if (!function_exists('global_init')) {
    function global_init()
    {
        $CI = &get_instance();
        $CI->logout   = base_url('logout');
        $CI->u2        = $CI->uri->segment(2);
        $CI->u3        = $CI->uri->segment(3);
        $CI->u4        = $CI->uri->segment(4);
        $CI->u5        = $CI->uri->segment(5);
        $CI->u6        = $CI->uri->segment(6);
        $CI->u7        = $CI->uri->segment(7);
        $CI->global_notif      = $CI->universal->getMulti(['global' => '1'], 'notifikasi');
    }
}

if (!function_exists('enkrip')) {
    function enkrip($string)
    {
        $bumbu = md5(str_replace("=", "", base64_encode("oase.poltektegal.ac.id")));
        $katakata = false;
        $metodeenkrip = "AES-256-CBC";
        $kunci = hash('sha256', $bumbu);
        $kodeiv = substr(hash('sha256', $bumbu), 0, 16);

        $katakata = str_replace("=", "", openssl_encrypt($string, $metodeenkrip, $kunci, 0, $kodeiv));
        $katakata = str_replace("=", "", base64_encode($katakata));

        return $katakata;
    }
}

if (!function_exists('dekrip')) {
    function dekrip($string)
    {
        $bumbu = md5(str_replace("=", "", base64_encode("oase.poltektegal.ac.id")));
        $katakata = false;
        $metodeenkrip = "AES-256-CBC";
        $kunci = hash('sha256', $bumbu);
        $kodeiv = substr(hash('sha256', $bumbu), 0, 16);

        $katakata = openssl_decrypt(base64_decode($string), $metodeenkrip, $kunci, 0, $kodeiv);
        return $katakata;
    }
}

if (!function_exists('base64img')) {
    function base64img($url)
    {
        $type = pathinfo($url, PATHINFO_EXTENSION);
        $data = file_get_contents($url);
        $base64img = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64img;
    }
}

if (!function_exists('feeder_init')) {
    function feeder_init()
    {
        $CI = &get_instance();
        $CI->username = $CI->universal->getOne(['item' => 'username'], "config")->value;
        $CI->password = $CI->universal->getOne(['item' => 'password'], "config")->value;
        $CI->hostapi = $CI->universal->getOne(['item' => 'host-api'], "config")->value;

        $api = "http://" . $CI->hostapi . "/ws/live.php?wsdl";

        $CI->session->set_userdata('ws', $api);

        $CI->load->library(['nusoap', 'feeder']);  // Manual load, avoid GetToken Null

        $CI->token = $CI->feeder->GetToken($CI->username, $CI->password);

        $filter = "npsn = '" . $CI->username . "'";
        $table = "satuan_pendidikan";
        $result = $CI->feeder->GetRecord($CI->token, $table, $filter);
        $CI->id_sp = $result['result']['id_sp'];

        if (empty($CI->session->userdata('offsets'))) {
            $CI->session->set_userdata('offsets', 0);
        }

        $CI->offsets = $CI->session->userdata('offsets');
    }
}

if (!function_exists('admin_init')) {
    function admin_init()
    {
        $CI = &get_instance();
        $CI->idletimer = $CI->universal->getOne(['item' => 'idletimer-admin'], "config")->value;
        if (empty($CI->session->userdata('log_super'))) {
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu!!');
            redirect('login', 'refresh');
        } else {
            $CI->login            = $CI->session->userdata('log_super')['is_logged_in'];
            $CI->id_user          = $CI->session->userdata('log_super')['id'];
        }
        global_init();
        $CI->urlSimak  = 'https://localhost/SIMAK/api/';
        $CI->urlApiSyncKuliah = 'https://syncnau.poltektegal.ac.id/api/';
        $CI->keys_synckuliah = '785a4062ab84fad14hd';
        $CI->username_synckuliah = 'ekuliah_sisfo360';
        $CI->password_synckuliah = 'phb123456';

        $CI->load->model('M_Admin', 'admin');
        $CI->user      = $CI->admin->getUser(['admin.id' => $CI->id_user]);
    }
}

if (!function_exists('mhs_init')) {
    function mhs_init()
    {
        $CI = &get_instance();
        $CI->idletimer = $CI->universal->getOne(['item' => 'idletimer-mhs'], "config")->value;
        if (empty($CI->session->userdata('log_mhs'))) {
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu!!');
            redirect('login', 'refresh');
        } else {
            $CI->login            = $CI->session->userdata('log_mhs')['is_logged_in'];
            $CI->nim          = $CI->session->userdata('log_mhs')['nim'];
        }
        global_init();
        $CI->urlApiSyncKuliah = 'https://syncnau.poltektegal.ac.id/api/';
        $CI->keys_synckuliah = '785a4062ab84fad14hd';
        $CI->username_synckuliah = 'ekuliah_sisfo360';
        $CI->password_synckuliah = 'phb123456';

        $CI->load->model('M_mahasiswa', 'mhs');
        $CI->user              = $CI->mhs->getUser(['nim' => $CI->nim], 'mahasiswa');
    }
}

if (!function_exists('management_init')) {
    function management_init()
    {
        $CI = &get_instance();
        $CI->idletimer = $CI->universal->getOne(['item' => 'idletimer-admin'], "config")->value;
        if (empty($CI->session->userdata('log_baa'))) {
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu!!');
            redirect('login', 'refresh');
        } else {
            $CI->login            = $CI->session->userdata('log_baa')['is_logged_in'];
            $CI->id_user          = $CI->session->userdata('log_baa')['id'];
        }
        global_init();
        $CI->urlApiSyncKuliah = 'https://syncnau.poltektegal.ac.id/api/';
        $CI->keys_synckuliah = '785a4062ab84fad14hd';
        $CI->username_synckuliah = 'ekuliah_sisfo360';
        $CI->password_synckuliah = 'phb123456';

        $CI->load->model('M_Management', 'management');
        $CI->user      = $CI->management->getUser(['admin.id' => $CI->id_user]);
    }
}

if (!function_exists('prodi_init')) {
    function prodi_init()
    {
        $CI = &get_instance();
        $CI->idletimer = $CI->universal->getOne(['item' => 'idletimer-prodi'], "config")->value;
        if (empty($CI->session->userdata('log_prodi'))) {
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu!!');
            redirect('login', 'refresh');
        } else {
            $CI->login            = $CI->session->userdata('log_prodi')['is_logged_in'];
            $CI->id_user          = $CI->session->userdata('log_prodi')['id'];
        }
        global_init();
        $CI->urlApiSyncKuliah = 'https://syncnau.poltektegal.ac.id/api/';
        $CI->keys_synckuliah = '785a4062ab84fad14hd';
        $CI->username_synckuliah = 'ekuliah_sisfo360';
        $CI->password_synckuliah = 'phb123456';

        $CI->load->model('M_prodi', 'prodi');
        $CI->user      = $CI->prodi->getUser(['admin.id' => $CI->id_user]);
    }
}

if (!function_exists('dosen_init')) {
    function dosen_init()
    {
        $CI = &get_instance();
        $CI->idletimer = $CI->universal->getOne(['item' => 'idletimer-dosen'], "config")->value;
        if (empty($CI->session->userdata('log_pegawai'))) {
            $CI->session->set_flashdata('error', 'Silakan login terlebih dahulu!!');
            redirect('login', 'refresh');
        } else {
            $CI->login            = $CI->session->userdata('log_pegawai')['is_logged_in'];
            $CI->id_user          = $CI->session->userdata('log_pegawai')['id'];
        }
        global_init();
        $CI->urlApiSyncKuliah = 'https://syncnau.poltektegal.ac.id/api/';
        $CI->keys_synckuliah = '785a4062ab84fad14hd';
        $CI->username_synckuliah = 'ekuliah_sisfo360';
        $CI->password_synckuliah = 'phb123456';

        $CI->load->model('M_dosen', 'dosen');
        $CI->user              = $CI->dosen->getUser(['pegawai.id' => $CI->id_user]);
    }
}

if (!function_exists('prodi_menu')) {
    function prodi_menu()
    {
        $CI = &get_instance();

        $data = $CI->universal->getOrderBy('', 'prodi', 'nama', '', '');

        $prodi = [];
        foreach ($data as $hasil) {
            array_push($prodi, [
                'name'      => $hasil->nama,
                'url'       => base_url('management/mastermhs/') . enkrip($hasil->kd_prodi)
            ]);
        }
        return $prodi;
    }
}

if (!function_exists('anggotaKelas')) {
    function anggotaKelas($id)
    {
        $CI = &get_instance();

        $CI->db->where('id_kelas', $id);
        $data = $CI->db->get('anggota_kelas')->result();

        return count($data);
    }
}

if (!function_exists('jmlMK')) {
    function jmlMK($id)
    {
        $CI = &get_instance();

        $CI->db->where('id_kelas', $id);
        $data = $CI->db->get('rombel')->result();

        return count($data);
    }
}

if (!function_exists('jmlTim')) {
    function jmlTim($id)
    {
        $CI = &get_instance();

        $CI->db->select('id_dosen_tim');
        $CI->db->where('id', $id);
        $data = $CI->db->get('rombel')->row();

        if ($data->id_dosen_tim) {
            $tim_dosen = explode(',', $data->id_dosen_tim);
            return count($tim_dosen);
        } else {
            return 0;
        }
    }
}

if (!function_exists('prodi')) {
    function prodi($kd_prodi)
    {
        $CI = &get_instance();
        $CI->db->where('kd_prodi', $kd_prodi);
        $data = $CI->db->get('prodi')->row();
        return $data->nama;
    }
}
if (!function_exists('api_post')) {
    function api_post($username, $password, $data, $url, $verify)
    {
        $client = new Client();
        $response = $client->post(
            $url,
            [
                'verify' => $verify,
                'auth' => [$username, $password],
                'form_params' => $data
            ]
        );
        return $response->getBody()->getContents();
    }
}
if (!function_exists('api_delete')) {
    function api_delete($username, $password, $data, $url, $verify)
    {
        $client = new Client();
        $response = $client->request(
            'DELETE',
            $url,
            [
                'verify' => $verify,
                'auth' => [$username, $password],
                'form_params' => $data
            ]
        );
        return $response->getBody()->getContents();
    }
}
if (!function_exists('api_put')) {
    function api_put($username, $password, $data, $url, $verify)
    {
        $client = new Client();
        $response = $client->put(
            $url,
            [
                'verify' => $verify,
                'auth' => [$username, $password],
                'form_params' => $data
            ]
        );
        return $response->getBody()->getContents();
    }
}
if (!function_exists('api_get')) {
    function api_get($username, $password, $query, $url, $verify)
    {
        $client = new Client();
        $response = $client->request('GET', $url, [
            'verify' => $verify,
            'auth' => [$username, $password],
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
function bulan($bulan)
{
    switch ($bulan) {
        case 1:
            $bulan = "Januari";
            break;
        case 2:
            $bulan = "Februari";
            break;
        case 3:
            $bulan = "Maret";
            break;
        case 4:
            $bulan = "April";
            break;
        case 5:
            $bulan = "Mei";
            break;
        case 6:
            $bulan = "Juni";
            break;
        case 7:
            $bulan = "Juli";
            break;
        case 8:
            $bulan = "Agustus";
            break;
        case 9:
            $bulan = "September";
            break;
        case 10:
            $bulan = "Oktober";
            break;
        case 11:
            $bulan = "November";
            break;
        case 12:
            $bulan = "Desember";
            break;

        default:
            $bulan = Date('F');
            break;
    }
    return $bulan;
}

function hari($hari)
{
    if ($hari == 1) {
        $hari = "Senin";
    } else if ($hari == 2) {
        $hari = "Selasa";
    } else if ($hari == 3) {
        $hari = "Rabu";
    } else if ($hari == 4) {
        $hari = "Kamis";
    } else if ($hari == 5) {
        $hari = "Jum'at";
    } else if ($hari == 6) {
        $hari = "Sabtu";
    } else if ($hari == 7) {
        $hari = "Ahad";
    }
    return $hari;
}
function tanggal($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = bulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    $waktu = substr($tgl, 11);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function tanggal_indo()
{
    $tanggal = Date('d') . " " . bulan(date('m')) . " " . Date('Y');
    return $tanggal;
}
