<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pegawai extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
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
                if ($this->form_validation->run() == false) {
                    $this->notifikas->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/pegawai');
                } else {
                    $id_status_peg = dekrip($this->input->post('status_peg'));
                    $kode_prodi = $this->universal->getOneSelect('kode', ['kd_prodi' => $this->user[0]->kd_prodi], 'prodi');
                    $status = $this->universal->getOneSelect('kode', ['id' => $id_status_peg], 'status_pegawai');
                    $status_peg = $status->kode;
                    $username = $status_peg . $kode_prodi->kode;
                    $dt = $this->universal->getOneSelect('MAX(username) as username', ['status_peg' => $id_status_peg, 'prodi' => $this->user[0]->kd_prodi], 'pegawai');
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
                    $username = $username . $urut;
                    $data = [
                        'nama'              => $this->input->post('nama'),
                        'nik'               => $this->input->post('nik'),
                        'nidn'              => $this->input->post('nidn'),
                        'nipy'              => $this->input->post('nipy'),
                        'username'          => $username,
                        'password'          => password_hash('phb123456', PASSWORD_BCRYPT, ['const' => 14]),
                        'jk'                => dekrip($this->input->post('jk')),
                        'prodi'             => $this->user[0]->kd_prodi,
                        'status_peg'        => dekrip($this->input->post('status_peg')),
                        'status_karyawan'   => dekrip($this->input->post('status_karyawan'))
                    ];
                    $insert = $this->universal->insert($data, 'pegawai');
                    if ($insert) {
                        $this->notifikasi->success('Berhasil tambah pegawai');
                    }
                    redirect('prodi/pegawai');
                }
            } else if ($this->u3 == 'getPegawai') {
                $id_peg = dekrip($this->u4);
                $data = $this->universal->getOneSelect('nik, nipy, nidn, nama, username, jk, status_peg, status_karyawan', ['id' => $id_peg], 'pegawai');
                $result = [
                    'nik'               => $data->nik,
                    'nidn'              => $data->nidn,
                    'nipy'              => $data->nipy,
                    'nama'              => $data->nama,
                    'jk'                => enkrip($data->jk),
                    'status_peg'        => enkrip($data->status_peg),
                    'status_karyawan'   => enkrip($data->status_karyawan),
                ];
                echo json_encode($result, true);
            } else if ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama', 'Nama Pegawai', 'required');
                $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
                $this->form_validation->set_rules('nidn', 'NIDN', 'required');
                $this->form_validation->set_rules('nipy', 'nipy', 'required');
                $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
                $this->form_validation->set_rules('status_peg', 'Status Pegawai', 'required');
                $this->form_validation->set_rules('status_karyawan', 'Status Karyawan', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikas->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/pegawai');
                } else {
                    $id_pegawai = dekrip($this->input->post('id', true));
                    $data = [
                        'nama'              => $this->input->post('nama'),
                        'nik'               => $this->input->post('nik'),
                        'nidn'              => $this->input->post('nidn'),
                        'nipy'              => $this->input->post('nipy'),
                        'jk'                => dekrip($this->input->post('jk')),
                        'prodi'             => $this->user[0]->kd_prodi,
                        'status_peg'        => dekrip($this->input->post('status_peg')),
                        'status_karyawan'   => dekrip($this->input->post('status_karyawan'))
                    ];
                    $update = $this->universal->update($data, ['id' => $id_pegawai], 'pegawai');
                    if ($update) {
                        $this->notifikasi->success('Berhasil update data');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else if ($this->u3 == 'delete') {
                $id_pegawai = dekrip($this->u4);
                $delete = $this->universal->delete(['id' => $id_pegawai], 'pegawai');
                if ($delete) {
                    $this->notifikasi->success('Berhasil hapus data');
                    redirect('prodi/pegawai');
                } else {
                    $this->notifikasi->warning('Gagal hapus data');
                    redirect('prodi/pegawai');
                }
            } else if ($this->u3 == 'active_non_active') {
                $id_pegawai = dekrip($this->u4);
                $status = ($this->u5 == 'active') ? 1 : 0;
                $data = [
                    'status_karyawan' => $status,
                ];
                $update = $this->universal->update($data, ['id' => $id_pegawai], 'pegawai');
                if ($update) {
                    $this->notifikasi->success(($status == 1) ? 'Berhasil Active' : 'Berhasil non active');
                    redirect('prodi/pegawai');
                } else {
                    $this->notifikasi->warning(($status == 1) ? 'Gagal active' : 'Gagal non active');
                    redirect('prodi/pegawai');
                }
            } else {
                $params = [
                    'title' => 'Data Pegawai',
                    'list_pegawai' => $this->universal->getMulti(['status_peg' => 1, 'prodi' => $this->user[0]->kd_prodi], 'pegawai'),
                    'status' => $this->universal->getOneSelect('id,nama_status', ['id' => 1], 'status_pegawai')
                ];
                $this->load->view('pegawai', $params);
            }
        }
    }
}

/* End of file Pagawai.php */
