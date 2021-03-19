<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u2 == 'bagikelas') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kelas', 'Nama Kelas', 'required|trim|alpha|max_length[1]');
                $this->form_validation->set_rules('semester', 'Semester', 'required|trim|numeric|max_length[1]');
                $this->form_validation->set_rules('kurikulum', 'Kurikulum', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/bagikelas', 'refresh');
                } else {
                    $data = [
                        'prodi'             => $this->user[0]->kd_prodi,
                        'kode_kurikulum'    => $this->input->post('kurikulum'),
                        'nama_kelas'        => $this->input->post('semester') . $this->input->post('kelas'),
                        'kelas'             => $this->input->post('kelas'),
                        'semester'          => $this->input->post('semester'),
                        'tahun'             => $this->_tahun()
                    ];
                    $insert = $this->universal->insert($data, 'bagikelas');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('prodi/bagikelas', 'refresh');
                }
            } elseif ($this->u3 == 'getListMhs') {
                $id = dekrip($this->u4);

                $data = $this->prodi->getListMhs(['id_kelas' => $id]);
                if ($data) {
                    echo json_encode($data);
                } else {
                    echo json_encode(null);
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kelas', 'kelas', 'required|trim|alpha|max_length[1]');
                $this->form_validation->set_rules('semester', 'Semester', 'required|trim|numeric|max_length[1]');
                $this->form_validation->set_rules('kurikulum', 'Kurikulum', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/bagikelas', 'refresh');
                } else {

                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'prodi'             => $this->user[0]->kd_prodi,
                        'kode_kurikulum'    => $this->input->post('kurikulum'),
                        'nama_kelas'        => $this->input->post('semester') . $this->input->post('kelas'),
                        'kelas'             => $this->input->post('kelas'),
                        'semester'          => $this->input->post('semester')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'bagikelas');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }
                    redirect('prodi/bagikelas', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $delete = $this->universal->delete(['id' => $id], 'bagikelas');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }
                redirect('prodi/bagikelas', 'refresh');
            } elseif ($this->u3 == 'anggota') {
                if ($this->u4 == 'out') {
                    $nim = dekrip($this->u5);

                    $delete = $this->universal->delete(['nim' => $nim], 'anggota_kelas');
                    if ($delete) {
                        $update = $this->universal->update(['status_kelas' => 0], ['nim' => $nim], 'mahasiswa');
                        if ($update) {
                            $this->notifikasi->success('Data berhasil dihapus');
                        }
                    }

                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $id = dekrip($this->u4);
                    $kelas = $this->universal->getOne(['id' => $id], 'bagikelas');

                    $st_mhs = $this->universal->getOneSelect('id', ['nama_status' => 'Aktif'], 'status_mhs');

                    $params = [
                        'title'     => 'Anggota Kelas',
                        'mhs'       => $this->prodi->getMhsKelas([
                            'mahasiswa.prodi'             => $this->user[0]->kd_prodi,
                            'mahasiswa.semester'          => $kelas->semester,
                            'mahasiswa.status_kelas'      => 0,
                            'mahasiswa.status_mahasiswa'  => $st_mhs->id,
                            'krs.status'                  => 1
                        ]),
                        'kelas'     => $kelas,
                        'bagikelas' => $this->prodi->getAnggotaKelas($id)
                    ];

                    $this->load->view('anggotakelas', $params);
                }
            } else if ($this->u3 == 'addmhs') {
                $nim = $this->input->post('nim');
                if ($nim) {
                    $data = [];
                    foreach ($nim as $hasil) {
                        $kelas = dekrip($this->input->post('kelas'));
                        $semester = dekrip($this->input->post('semester'));
                        $prodi = dekrip($this->input->post('prodi'));

                        array_push($data, [
                            'id_kelas'  => dekrip($this->input->post('id_kelas')),
                            'nim'       => $hasil
                        ]);
                        $dataEkuliah = [
                            'ekuliah_keys'  => '785a4062ab84fad14hd',
                            'nim'           => $hasil,
                            'prodi'         => $prodi,
                            'kelas'         => $kelas,
                            'semester'      => $semester
                        ];
                    }

                    $insert = $this->universal->insert_batch($data, 'anggota_kelas');
                    if ($insert) {
                        $this->universal->update(['kelas' => $kelas, 'status_kelas' => 1], ['nim' => $hasil], 'mahasiswa');
                        api_put($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'kls', true);
                        $this->notifikasi->success('Data berhasil ditambahkan');
                    } else {
                        $this->notifikasi->error('Server error');
                    }
                } else {
                    $this->notifikasi->error('Data kosong');
                }

                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $tahun = dekrip($this->u3);
                $semester = dekrip($this->u4);
                if (!$semester) {
                    $semester = $this->_semester();
                }
                if (!$tahun) {
                    $tahun = $this->_tahun();
                }
                $status_tahun = $this->universal->getOneSelect('periode, status', ['id' => $tahun], 'tahun_akademik');
                $params = [
                    'title'         => 'Pembagian Kelas',
                    'kelas'         => $this->universal->getOrderBy('', 'kelas', 'kelas', 'asc', ''),
                    'bagikelas'     => $this->prodi->getBagiKelas(['prodi' => $this->user[0]->kd_prodi, 'tahun' => $tahun, 'semester' => $semester]),
                    'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                    'th_ini'        => $tahun,
                    'status_th'     => $status_tahun->status,
                    'kurikulum'     => $this->universal->getMulti(['prodi' => $this->user[0]->kd_prodi, 'status' => '1'], 'kurikulum'),
                    'periode'       => $status_tahun->periode,
                    'semester'      => $this->prodi->getSmstKelas(),
                    'smst_ini'      => $semester
                ];
                $this->session->set_userdata('previous_url', current_url());
                $this->load->view('bagikelas', $params);
            }
        } else if ($this->u2 == 'rombel') {
            if ($this->u3 == 'getDosen') {
                $id_dosen = dekrip($this->u4);
                $status_peg = $this->universal->getOneSelect('id', ['nama_status' => 'Dosen'], 'status_pegawai');
                $data = $this->universal->getOrderBy([
                    'status_peg'    => $status_peg->id,
                    'username !='   => $id_dosen,
                ], 'pegawai', 'nama', 'asc', '');
                $dosen = [];
                foreach ($data as $dt) {
                    array_push($dosen, [
                        'username'  => $dt->username,
                        'nama'      => $dt->gelar_depan . ' ' . $dt->nama . ', ' . $dt->gelar_belakang
                    ]);
                }
                echo json_encode($dosen);
            } elseif ($this->u3 == 'getTimDosen') {
                $id = dekrip($this->u4);

                $data = $this->universal->getOneSelect('id_dosen_tim', ['id' => $id], 'rombel');
                $dataDs = [];
                if ($data->id_dosen_tim) {
                    $tim_dosen = explode(',', $data->id_dosen_tim);

                    if ($tim_dosen != "") {
                        foreach ($tim_dosen as $hasil) {
                            $dt = $this->prodi->getListDs(['pegawai.username' => $hasil]);
                            array_push($dataDs, [
                                'nama'      => $dt[0]->gelar_depan . ' ' . $dt[0]->nama . ', ' . $dt[0]->gelar_belakang,
                                'prodi'     => $dt[0]->nama_prodi
                            ]);
                        }
                    }
                    echo json_encode($dataDs);
                } else {
                    echo json_encode(null);
                }
            } elseif ($this->u3 == 'getListMK') {
                $id = dekrip($this->u4);

                $data = $this->prodi->getListMK(['id_kelas' => $id]);
                if ($data) {
                    echo json_encode($data);
                } else {
                    echo json_encode(null);
                }
            } elseif ($this->u3 == 'add') {
                $this->form_validation->set_rules('kelas', 'Nama Kelas', 'required');
                $this->form_validation->set_rules('mk', 'Mata Kuliah', 'required');
                $this->form_validation->set_rules('dosen', 'Nama Dosen', 'required|trim');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    if ($this->input->post('tim_dosen')) {
                        $tim_dosen = implode(',', $this->input->post('tim_dosen'));
                    } else {
                        $tim_dosen = null;
                    }
                    $data = [
                        'id_kelas'      => dekrip($this->input->post('kelas')),
                        'kode_mk'       => dekrip($this->input->post('mk')),
                        'id_dosen'      => dekrip($this->input->post('dosen')),
                        'id_dosen_tim'  => $tim_dosen
                    ];
                    $kelas = $this->universal->getOneSelect('semester, kelas, tahun', ['id' => dekrip($this->input->post('kelas'))], 'bagikelas');
                    $th_akademik = $this->universal->getOneSelect('kode', ['id' => $kelas->tahun], 'tahun_akademik');
                    $mk = $this->universal->getOneSelect('nama_mk', ['kode_mk' => dekrip($this->input->post('mk'))], 'mata_kuliah');
                    $dataEkuliah = [
                        'ekuliah_keys' => '785a4062ab84fad14hd',
                        'kode_mk'           => dekrip($this->input->post('mk')),
                        'nama_mk'           => $mk->nama_mk,
                        'kode_prodi'             => $this->user[0]->kd_prodi,
                        'code_thn_akad'    => $th_akademik->kode,
                        'semester'          => $kelas->semester,
                        'kelas'             => $kelas->kelas,
                        'dosen_inti'        => dekrip($this->input->post('dosen')),
                        'dosen_anak'         => $tim_dosen
                    ];
                    $insert = $this->universal->insert($data, 'rombel');
                    if ($insert) {
                        api_post($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'matkul', true);
                        $this->notifikasi->success('Mata kuliah berhasil ditambah');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $kode_matkul = $this->universal->getOneSelect('id,kode_mk', ['id' => $id], 'rombel');
                $delete = $this->universal->delete(['id' => $id], 'rombel');
                $dataEkuliah = [
                    'ekuliah_keys' => '785a4062ab84fad14hd',
                    'id' => $kode_matkul->kode_mk
                ];
                if ($delete) {
                    api_delete($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'matkul', true);
                    $this->notifikasi->success('Data berhasil dihapus');
                }
                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->u3 == 'mk') {
                $id = dekrip($this->u4);
                $kelas = $this->universal->getOne(['id' => $id], 'bagikelas');
                $status_peg = $this->universal->getOneSelect('id', ['nama_status' => 'Dosen'], 'status_pegawai');
                $kode_mk = $this->universal->getMultiSelect('kode_mk', ['id_kelas' => $id], 'rombel');
                $params = [
                    'title'     => 'Anggota Kelas',
                    'rombel'    => $this->prodi->getRombel(['rombel.id_kelas' => $id]),
                    'kelas'     => $kelas,
                    'mk'        => $this->prodi->getMK($kode_mk, [
                        'kd_prodi'      => $this->user[0]->kd_prodi,
                        'status'        => '1',
                        'kd_kurikulum'  => $kelas->kode_kurikulum,
                        'semester'      => $kelas->semester
                    ]),
                    'dosen'     => $this->universal->getOrderBy([
                        'status_peg'    => $status_peg->id
                    ], 'pegawai', 'nama', 'asc', '')
                ];
                $this->load->view('rombelmk', $params);
            } else {
                $tahun      = dekrip($this->u3);
                $semester   = dekrip($this->u4);
                $kelas      = dekrip($this->u5);
                if (!$semester) {
                    $semester = $this->_semester();
                }
                if (!$tahun) {
                    $tahun = $this->_tahun();
                }
                if (!$kelas) {
                    $kelas = 'Semua';
                }

                $status_tahun = $this->universal->getOneSelect('status', ['id' => $tahun], 'tahun_akademik');
                $params = [
                    'title'         => 'Rombel Kelas',
                    'kelas'         => $this->prodi->getBagiKelas([
                        'prodi' => $this->user[0]->kd_prodi,
                        'tahun' => $tahun,
                        'semester' => $semester
                    ]),
                    'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                    'th_ini'        => $tahun,
                    'semester'      => $this->prodi->getSmstKelas(),
                    'smst_ini'      => $semester
                ];

                $this->session->set_userdata('previous_url', current_url());
                $this->load->view('rombel', $params);
            }
        }
    }

    private function _tahun()
    {
        $tahun = $this->universal->getOneSelect('id', ['status' => 1], 'tahun_akademik');
        return $tahun->id;
    }

    private function _semester()
    {
        $semester = $this->universal->getOneSelect('MAX(semester) as semester', '', 'bagikelas');
        return $semester->semester;
    }
}
/* End of file Kelas.php */