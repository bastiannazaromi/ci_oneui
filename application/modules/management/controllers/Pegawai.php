<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        management_init();
    }

    function index()
    {
        if ($this->u2 == 'pegawai') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nama', 'Nama Pegawai', 'required');
                $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
                $this->form_validation->set_rules('nidn', 'NIDN', 'required');
                $this->form_validation->set_rules('nipy', 'nipy', 'required');
                $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
                $this->form_validation->set_rules('status_peg', 'Status Pegawai', 'required');
                $this->form_validation->set_rules('status_karyawan', 'Status Karyawan', 'required');
                $id_status_peg = dekrip($this->input->post('status_peg'));
                $st = $this->universal->getOne(['id' => $id_status_peg], 'status_pegawai');
                if ($st->nama_status == 'Dosen') {
                    $prodi = dekrip($this->input->post('prodi'));
                } else {
                    $prodi = null;
                }
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $status = $this->universal->getOneSelect('kode', ['id' => $id_status_peg], 'status_pegawai');
                    $status_peg = $status->kode;

                    $dt = $this->universal->getOneSelect('MAX(username) as username', ['status_peg' => $id_status_peg], 'pegawai');
                    if ($dt) {
                        $a = $dt->username;
                        $newstring = substr($a, -4);
                        $urut = (int)$newstring;
                        if (strlen($urut) == 1) {
                            $urut = '000' . ($urut + 1);
                        } else if ((strlen($urut) == 2)) {
                            $urut = '00' . ($urut + 1);
                        } else if ((strlen($urut) == 3)) {
                            $urut = '0' . ($urut + 1);
                        } else {
                            $urut = $urut + 1;
                        }
                    } else {
                        $urut = '0001';
                    }

                    $username = $status_peg . $urut;

                    $data = [
                        'nama'              => $this->input->post('nama'),
                        'gelar_depan'       => $this->input->post('depan'),
                        'gelar_belakang'    => $this->input->post('belakang'),
                        'nik'               => $this->input->post('nik'),
                        'nidn'              => $this->input->post('nidn'),
                        'nipy'              => $this->input->post('nipy'),
                        'username'          => $username,
                        'password'          => password_hash('phb123456', PASSWORD_BCRYPT, ['const' => 14]),
                        'jk'                => dekrip($this->input->post('jk')),
                        'prodi'             => $prodi,
                        'status_peg'        => dekrip($this->input->post('status_peg')),
                        'status_karyawan'   => dekrip($this->input->post('status_karyawan')),
                        'foto'              => 'default.jpg'
                    ];
                    $insert = $this->universal->insert($data, 'pegawai');
                    if ($insert) {
                        if ($id_status_peg == 1) {
                            $dataEkuliah = [
                                'ekuliah_keys' => $this->keys_synckuliah,
                                'username'        => $username,
                                'nama'      => $this->input->post('depan') . ' ' . $this->input->post('nama') . ' ' . $this->input->post('belakang'),
                                'password'          => password_hash('phb123456', PASSWORD_BCRYPT, ['const' => 14]),
                                'kode_prodi'    => $prodi,
                                'foto'              => 'default.jpg'
                            ];
                            api_post($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'dosen', true);
                        }
                        $this->notifikasi->success('Data berhasil ditambah');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama', 'Nama Pegawai', 'required');
                $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
                $this->form_validation->set_rules('nidn', 'NIDN', 'required');
                $this->form_validation->set_rules('nipy', 'nipy', 'required');
                $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
                $this->form_validation->set_rules('status_peg', 'Status Pegawai', 'required');
                $this->form_validation->set_rules('status_karyawan', 'Status Karyawan', 'required');
                $id_status_peg = dekrip($this->input->post('status_peg'));
                $st = $this->universal->getOne(['id' => $id_status_peg], 'status_pegawai');
                if ($st->nama_status == 'Dosen') {
                    $prodi = dekrip($this->input->post('prodi'));
                } else {
                    $prodi = null;
                }
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $id = dekrip($this->input->post('id'));
                    $peg = $this->universal->getOneSelect('status_peg, prodi, username', ['id' => $id], 'pegawai');
                    if ($peg->status_peg != $id_status_peg) {

                        $status = $this->universal->getOneSelect('kode', ['id' => $id_status_peg], 'status_pegawai');
                        $status_peg = $status->kode;

                        $dt = $this->universal->getOneSelect('MAX(username) as username', ['status_peg' => $id_status_peg], 'pegawai');
                        if ($dt) {
                            $a = $dt->username;
                            $newstring = substr($a, -4);

                            $urut = (int)$newstring;
                            if (strlen($urut) == 1) {
                                $urut = '000' . ($urut + 1);
                            } else if ((strlen($urut) == 2)) {
                                $urut = '00' . ($urut + 1);
                            } else if ((strlen($urut) == 3)) {
                                $urut = '0' . ($urut + 1);
                            } else {
                                $urut = $urut + 1;
                            }
                        } else {
                            $urut = '0001';
                        }
                        $username = $status_peg . $urut;
                    } else {
                        $username = $peg->username;
                    }
                    $data = [
                        'nama'              => $this->input->post('nama'),
                        'gelar_depan'       => $this->input->post('depan'),
                        'gelar_belakang'    => $this->input->post('belakang'),
                        'nik'               => $this->input->post('nik'),
                        'nidn'              => $this->input->post('nidn'),
                        'nipy'              => $this->input->post('nipy'),
                        'username'          => $username,
                        'jk'                => dekrip($this->input->post('jk')),
                        'prodi'             => $prodi,
                        'status_peg'        => dekrip($this->input->post('status_peg')),
                        'status_karyawan'   => dekrip($this->input->post('status_karyawan'))
                    ];
                    $getFotoAndpassword = $this->universal->getOneSelect('username,foto,password', ['username' => $username], 'pegawai');

                    $update = $this->universal->update($data, ['id' => $id], 'pegawai');
                    if ($update) {
                        if ($id_status_peg == 1) {
                            $dataEkuliah = [
                                'ekuliah_keys' => $this->keys_synckuliah,
                                'username' => $username,
                                'nama' =>  $this->input->post('depan') . ' ' . $this->input->post('nama') . ' ' . $this->input->post('belakang'),
                                'password' => $getFotoAndpassword->password,
                                'prodi' => $prodi,
                                'foto' => $getFotoAndpassword->foto,
                                'status' => 1
                            ];
                            api_put($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'dosen', true);
                        }
                        $this->notifikasi->success('Data berhasil diupdate');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);
                $data = $this->universal->getOneSelect('nik, nipy, nidn, nama, gelar_depan, gelar_belakang, username, jk, status_peg, status_karyawan, prodi', ['id' => $id], 'pegawai');
                $status = $this->universal->getOneSelect('nama_status', ['id' => $data->status_peg], 'status_pegawai');
                $st = $status->nama_status;
                $dt = [
                    'nik'               => $data->nik,
                    'nidn'              => $data->nidn,
                    'nipy'              => $data->nipy,
                    'nama'              => $data->nama,
                    'depan'             => $data->gelar_depan,
                    'belakang'          => $data->gelar_belakang,
                    'jk'                => enkrip($data->jk),
                    'status_peg'        => enkrip($data->status_peg),
                    'status_karyawan'   => enkrip($data->status_karyawan),
                    'prodi'             => enkrip($data->prodi),
                    'nama_status'       => $st
                ];
                echo json_encode($dt);
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $getUsername = $this->universal->getOneSelect('id,username,status_peg', ['id' => $id], 'pegawai');
                $delete = $this->universal->delete(['id' => $id], 'pegawai');
                if ($delete) {
                    if ($getUsername->status_peg == 1) {
                        $dataEkuliah = [
                            'ekuliah_keys' => $this->keys_synckuliah,
                            'username' => $getUsername->username
                        ];
                        api_delete($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'dosen', true);
                    }
                    $this->notifikasi->success('Data berhasil dihapus');
                }
                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->u3 == 'a') {
                $this->db->select('MAX(username) as username');
                $this->db->where('status_peg', 4);

                echo json_encode($this->db->get('pegawai')->result());
                die;
                $a = 'dsaspgrerhreh3277';
                $newstring = substr($a, -4);

                $urut = (int)$newstring;
                if (strlen($urut) == 1) {
                    $urut = '000' . ($urut + 1);
                } else if ((strlen($urut) == 2)) {
                    $urut = '00' . ($urut + 1);
                } else if ((strlen($urut) == 3)) {
                    $urut = '0' . ($urut + 1);
                } else {
                    $urut = $urut + 1;
                }
                echo $urut;
            } else {
                $status = dekrip($this->u3);
                $prodi  = dekrip($this->u4);

                if (!$status) {
                    $st_ini = 'Dosen';
                    $st = $this->universal->getOneSelect('id', ['nama_status' => 'Dosen'], 'status_pegawai');
                    $status = $st->id;
                } else {
                    $st = $this->universal->getOneSelect('nama_status', ['id' => $status], 'status_pegawai');
                    $st_ini = $st->nama_status;
                }
                if (!$prodi) {
                    $pd = $this->universal->getOneSelect('kd_prodi', ['nama' => 'Akuntansi'], 'prodi');
                    $prodi = $pd->kd_prodi;
                }
                $params = [
                    'title'         => 'Pegawai',
                    'pegawai'       => $this->management->getPegawai($status, $prodi, $st_ini),
                    'status'        => $this->universal->getOrderBy('', 'status_pegawai', 'nama_status', '', ''),
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', '', ''),
                    'st_ini'        => $st_ini,
                    'prodi_ini'     => $prodi
                ];

                $this->load->view('pegawai', $params);
            }
        }
    }
}

/* End of file Pegawai.php */