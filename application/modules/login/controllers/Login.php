<?php

use function GuzzleHttp\json_decode;

defined('BASEPATH') or exit('No direct script access allowed');
class Login extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->u1        = $this->uri->segment(1);
        $this->u2        = $this->uri->segment(2);
        if (!empty($this->session->userdata('log_super'))) {
            if ($this->u1 != 'logout') {
                $this->session->set_userdata('proteksi', 1);
                redirect('admin', 'refresh');
            }
        } elseif (!empty($this->session->userdata('log_baa'))) {
            if ($this->u1 != 'logout') {
                $this->session->set_userdata('proteksi', 1);
                redirect('management', 'refresh');
            }
        } elseif (!empty($this->session->userdata('log_prodi'))) {
            if ($this->u1 != 'logout') {
                $this->session->set_userdata('proteksi', 1);
                redirect('prodi', 'refresh');
            }
        } elseif (!empty($this->session->userdata('log_pegawai'))) {
            if ($this->u1 != 'logout') {
                $this->session->set_userdata('proteksi', 1);
                redirect('dosen', 'refresh');
            }
        } else if (!empty($this->session->userdata('log_mhs'))) {
            if ($this->u1 != 'logout') {
                $this->session->set_userdata('proteksi', 1);
                redirect('mahasiswa', 'refresh');
            }
        }

        if (empty($this->session->userdata('proteksi'))) {
            $this->session->set_userdata('proteksi', 1);
        }
        $this->load->model('M_login', 'login');
        $this->load->model('universal_model', 'universal');
    }

    function suspect()
    {
        if (!empty($this->session->userdata('proteksi'))) {
            if ($this->session->userdata('proteksi') > 5) {
                redirect('suspicious', 'refresh');
            }
        }
    }

    function index()
    {
        $this->suspect();
        $params = array('title' => 'Login | OASEPHB');
        $this->load->view('login', $params);
    }

    function suspicious()
    {
        if (empty($this->session->userdata('proteksi'))) {
            redirect('login', 'refresh');
        }
        if (!empty($this->session->userdata('proteksi'))) {
            if ($this->session->userdata('proteksi') <= 5) {
                redirect('login', 'refresh');
            }
        }
        $params = array('title' => 'Suspicious | OASEPHB');
        $this->load->view('banned', $params);
    }

    public function proses()
    {
        $username     = addslashes(trim($this->input->post('username', true)));
        $password     = addslashes(trim($this->input->post('password', true)));
        $row = $this->login->validasi($username, $password);

        if ($row != null) {
            $this->_daftarkan_session($row);
        } else {
            $proteksi = $this->session->userdata('proteksi') + 1;
            if ($proteksi <= 2) {
                $message = "Sepertinya Anda salah memasukkan username atau password!!";
                $this->session->set_flashdata('error', $message);
            } else {
                $message = "Anda akan diblokir jika gagal login sebanyak 5 kali. Percobaan ke-" . $this->session->userdata('proteksi');
                $this->session->set_flashdata('error', $message);
            }
            $this->session->set_userdata('proteksi', $proteksi);
            redirect(base_url());
        }
    }

    public function _daftarkan_session($row)
    {
        array_merge($row, array('is_logged_in' => true));
        if ($row['role'] == 'admin') {
            $data = $this->universal->getOne(['id' => $row['level']], 'groups');

            if ($data->name == 'Super Admin') {
                $this->session->set_userdata('log_super', $row);
                $this->notifikasi->success('Selamat Datang di OASE!');
                redirect('admin');
            } elseif ($data->name == 'BAA') {
                $this->session->set_userdata('log_baa', $row);
                $this->notifikasi->success('Selamat Datang di OASE!');
                redirect('management');
            } elseif ($data->name == 'Prodi') {
                $this->session->set_userdata('log_prodi', $row);
                $this->notifikasi->success('Selamat Datang di OASE!');
                redirect('prodi');
            }
        } elseif ($row['role'] == 'pegawai') {
            $this->session->set_userdata('log_pegawai', $row);
            $this->notifikasi->success('Selamat Datang di OASE!');
            redirect('dosen');
        } else {
            $this->session->set_userdata('log_mhs', $row);
            $this->notifikasi->success('Selamat Datang di OASE!');
            redirect('mahasiswa');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    function debug()
    {
        echo '<b>Kode Bantuan:</b><br> ' . $this->input->cookie('oase_sess');
        echo '<br>';
        echo '<b>IP Address:</b><br> ' . $this->input->ip_address();
        echo '<br>';
        echo '<b>User-Agent:</b><br> ' . $this->input->user_agent();
        echo '<br>';
    }
}
