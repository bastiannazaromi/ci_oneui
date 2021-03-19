<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_data extends MX_Controller
{
    function __construct()
    {
        parent::__construct();

        management_init();
    }

    public function index()
    {
        if ($this->u2 == 'mastermhs') {
            if ($this->u3 == 'getKab') {
                $id_prov = dekrip($this->u4);

                $data = $this->universal->getOrderBy(['id_prov' => $id_prov], 'kabupaten', 'nama', '', '');
                $kab = [];
                foreach ($data as $dt) {
                    array_push($kab, [
                        'id_kab'    => enkrip($dt->id_kab),
                        'nama'      => $dt->nama
                    ]);
                }
                echo json_encode($kab);
            } else if ($this->u3 == 'getKec') {
                $id_kab = dekrip($this->u4);

                $data = $this->universal->getOrderBy(['id_kab' => $id_kab], 'kecamatan', 'nama', '', '');
                $kec = [];
                foreach ($data as $dt) {
                    array_push($kec, [
                        'id_kec'    => enkrip($dt->id),
                        'nama'      => $dt->nama
                    ]);
                }
                echo json_encode($kec);
            } else if ($this->u3 == 'getDesa') {
                $id_kec = dekrip($this->u4);

                $data = $this->universal->getOrderBy(['id_kec' => $id_kec], 'desa', 'nama', '', '');
                $desa = [];
                foreach ($data as $dt) {
                    array_push($desa, [
                        'id'        => enkrip($dt->id),
                        'nama'      => $dt->nama
                    ]);
                }
                echo json_encode($desa);
            } else if ($this->u3 == 'import') {
                $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                $config['upload_path']      = realpath('excel/upload');
                $config['allowed_types']    = 'xlsx|xls|csv';
                $config['max_size']         = '10000';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file_excel')) {
                    //upload gagal
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags($this->upload->display_errors()))));
                    //redirect halaman

                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {
                        $arr_file = explode('.', $_FILES['file_excel']['name']);
                        $extension = end($arr_file);
                        if ('csv' == $extension) {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } else {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }
                        $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
                        $sheetData = $spreadsheet->getActiveSheet()->toArray();
                        echo "<pre>";
                        $numrow = 1;
                        $data = [];
                        foreach ($sheetData as $hasil) {
                            if ($numrow > 1) {
                                if ($hasil[0] && $hasil[1]) {
                                    array_push($data, [
                                        'nim'               => $hasil[1],
                                        'nama'              => $hasil[2],
                                        'tempat_lahir'      => $hasil[3],
                                        'tanggal_lahir'     => $hasil[4],
                                        'nik'               => $hasil[5],
                                        'kelas'             => $hasil[6],
                                        'semester'          => $hasil[7],
                                        'tahun_masuk'       => $hasil[8],
                                        'semester_masuk'    => $hasil[9],
                                        'asal_sekolah'      => $hasil[10],
                                        'prodi'             => $hasil[11],
                                        'nisn'              => $hasil[12],
                                        'jk'                => $hasil[13]
                                    ]);
                                }
                            }
                            $numrow++;
                        }
                        //delete file from server
                        unlink(realpath('excel/upload' . $_FILES['file_excel']['name']));
                        if (count($data) != 0) {
                            //$insert = $this->db->insert_batch('mahasiswa', $data);
                            $insert = $this->universal->insert_batch($data, 'mahasiswa');
                            if ($insert) {
                                $this->notifikasi->success('Data berhasil diimport');
                            } else {
                                $this->notifikasi->error('Data gagal diimport');
                            }
                        } else {
                            $this->session->set_flashdata('flash-error', 'Gagal import ! Data kosong / sudah ada dalam database');
                        }
                        //redirect halaman
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else if ($this->u3 == 'add') {
                $this->form_validation->set_rules('prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
                $this->form_validation->set_rules('nim', 'NIM', 'required|numeric|min_length[8]|max_length[8]');
                $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
                $this->form_validation->set_rules('negara', 'Kewarganegaraan', 'required');
                $this->form_validation->set_rules('tempat', 'Tempat Lahir', 'required');
                $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
                $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
                $this->form_validation->set_rules('agama', 'Agama', 'required');
                $this->form_validation->set_rules('status_menikah', 'Status Menikah', 'required');
                $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
                $this->form_validation->set_rules('kab_kota', 'Kota / kabupaten', 'required');
                $this->form_validation->set_rules('kec', 'Kecamatan', 'required');
                $this->form_validation->set_rules('desa', 'Desa', 'required');
                $this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required');
                $this->form_validation->set_rules('ibu', 'Ibu kandung', 'required');
                $this->form_validation->set_rules('tahun', 'tahun Masuk', 'required|numeric|min_length[4]|max_length[4]');
                $this->form_validation->set_rules('semester', 'Semester', 'required|numeric|min_length[1]|max_length[1]');
                $this->form_validation->set_rules('jalur', 'Jalur', 'required');
                $this->form_validation->set_rules('status', 'Status Mahasiswa', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'nik'               => $this->input->post('nik'),
                        'nim'               => $this->input->post('nim'),
                        'nama_lengkap'      => $this->input->post('nama'),
                        'password'          => password_hash($this->input->post('nim'), PASSWORD_BCRYPT, ['const' => 14]),
                        'kewarganegaraan'            => dekrip($this->input->post('negara')),
                        'tempat_lahir'      => $this->input->post('tempat'),
                        'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
                        'agama'             => dekrip($this->input->post('agama')),
                        'jk'                => dekrip($this->input->post('jk')),
                        'provinsi'          => dekrip($this->input->post('provinsi')),
                        'kab_kota'          => dekrip($this->input->post('kab_kota')),
                        'kecamatan'         => dekrip($this->input->post('kec')),
                        'kelurahan'         => dekrip($this->input->post('desa')),
                        'asal_sekolah'      => $this->input->post('asal_sekolah'),
                        'foto'              => 'default.jpg',
                        'nm_ibu_kandung'          => $this->input->post('ibu'),
                        'tahun_masuk'       => $this->input->post('tahun'),
                        'semester_masuk'    => $this->input->post('semester'),
                        'semester'          => $this->input->post('semester'),
                        'jalur'             => dekrip($this->input->post('jalur')),
                        'prodi'             => dekrip($this->input->post('prodi')),
                        'status_mahasiswa'  => dekrip($this->input->post('status'))
                    ];
                    $insert = $this->universal->insert($data, 'mahasiswa');
                    $dataEkuliah = [
                        'ekuliah_keys' => '785a4062ab84fad14hd',
                        'username' => $this->input->post('nim'),
                        'nama' => $this->input->post('nama'),
                        'password' => md5($this->input->post('nim')),
                        'kode_prodi' => dekrip($this->input->post('prodi')),
                        'foto' => 'default.jpg'
                    ];
                    if ($insert) {
                        api_post('ekuliah_sisfo360', 'phb123456', $dataEkuliah, 'https://syncnau.poltektegal.ac.id/api/mahasiswa', true);
                        $this->notifikasi->success('Data berhasil ditambah');
                    } else {
                        $this->notifikasi->error('Gagal tambah data');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else if ($this->u3 == 'edit') {
                if ($this->u4 == 'proses') {
                    $this->form_validation->set_rules('prodi', 'Prodi', 'required');
                    $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|min_length[16]|max_length[16]');
                    $this->form_validation->set_rules('nim', 'NIM', 'required|numeric|min_length[8]|max_length[8]');
                    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
                    $this->form_validation->set_rules('negara', 'Kewarganegaraan', 'required');
                    $this->form_validation->set_rules('tempat', 'Tempat Lahir', 'required');
                    $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
                    $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
                    $this->form_validation->set_rules('agama', 'Agama', 'required');
                    $this->form_validation->set_rules('status_menikah', 'Status Menikah', 'required');
                    $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
                    $this->form_validation->set_rules('kab_kota', 'Kota / kabupaten', 'required');
                    $this->form_validation->set_rules('kec', 'Kecamatan', 'required');
                    $this->form_validation->set_rules('desa', 'Desa', 'required');
                    $this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required');
                    $this->form_validation->set_rules('ibu', 'Ibu kandung', 'required');
                    $this->form_validation->set_rules('tahun', 'tahun Masuk', 'required|numeric|min_length[4]|max_length[4]');
                    $this->form_validation->set_rules('semester', 'Semester', 'required|numeric|min_length[1]|max_length[1]');
                    $this->form_validation->set_rules('jalur', 'Jalur', 'required');
                    $this->form_validation->set_rules('status', 'Status Mahasiswa', 'required');

                    if ($this->form_validation->run() == false) {
                        $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $id = dekrip($this->input->post('id'));
                        $data = [
                            'nik'               => $this->input->post('nik'),
                            'nim'               => $this->input->post('nim'),
                            'nama_lengkap'      => $this->input->post('nama'),
                            'password'          => password_hash($this->input->post('nim'), PASSWORD_BCRYPT, ['const' => 14]),
                            'kewarganegaraan'            => dekrip($this->input->post('negara')),
                            'tempat_lahir'      => $this->input->post('tempat'),
                            'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
                            'agama'             => $this->input->post('agama'),
                            'jk'                => dekrip($this->input->post('jk')),
                            'provinsi'          => dekrip($this->input->post('provinsi')),
                            'kab_kota'          => dekrip($this->input->post('kab_kota')),
                            'kecamatan'         => dekrip($this->input->post('kec')),
                            'kelurahan'         => dekrip($this->input->post('desa')),
                            'asal_sekolah'      => $this->input->post('asal_sekolah'),
                            'foto'              => 'default.jpg',
                            'nm_ibu_kandung'          => $this->input->post('ibu'),
                            'tahun_masuk'       => $this->input->post('tahun'),
                            'semester_masuk'    => $this->input->post('semester'),
                            'semester'          => $this->input->post('semester'),
                            'jalur'             => dekrip($this->input->post('jalur')),
                            'prodi'             => dekrip($this->input->post('prodi')),
                            'status_mahasiswa'  => dekrip($this->input->post('status'))
                        ];
                        $dataEkuliah = [
                            'ekuliah_keys' => '785a4062ab84fad14hd',
                            'username' => $this->input->post('nim'),
                            'nama' => $this->input->post('nama'),
                            'password' => md5($this->input->post('nim')),
                            'kode_prodi' => dekrip($this->input->post('prodi')),
                        ];
                        $update = $this->universal->update($data, ['id' => $id], 'mahasiswa');
                        if ($update) {
                            $data = api_put('ekuliah_sisfo360', 'phb123456', $dataEkuliah, 'https://syncnau.poltektegal.ac.id/api/mahasiswa', true);
                            $this->notifikasi->success('Data berhasil diupdate');
                        } else {
                            $this->notifikas->error('Gagal update data');
                        }
                        $previous_url = $this->session->userdata('previous_url');
                        redirect($previous_url);
                    }
                } else {
                    $mahasiswa = $this->universal->getOne(['id' => dekrip($this->u4)], 'mahasiswa');
                    $params = [
                        'title'         => 'Master Mahasiswa',
                        'mahasiswa'     => $mahasiswa,
                        'kab'           => $this->universal->getMulti(['id_prov' => $mahasiswa->provinsi], 'kabupaten'),
                        'kec'           => $this->universal->getMulti(['id_kab' => $mahasiswa->kab_kota], 'kecamatan'),
                        'desa'          => $this->universal->getMulti(['id_kec' => $mahasiswa->kecamatan], 'desa'),
                        'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', '', ''),
                        'agama'         => $this->universal->getMulti('', 'agama'),
                        'provinsi'      => $this->universal->getMulti('', 'provinsi'),
                        'max_th'        => date('Y'),
                        'jalur'         => $this->universal->getMulti('', 'jalur'),
                        'status'        => $this->universal->getMulti('', 'status_mhs'),
                        'prodi_ini'     => $this->session->userdata('prodi_ini'),
                        'negara' => $this->universal->getMulti('', 'negara')
                    ];
                    $this->load->view('mastermhs_edit', $params);
                }
            } else if ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $nim = $this->universal->getOneSelect('nim', ['id' => $id], 'mahasiswa');
                $dataEkuliah = [
                    'ekuliah_keys' => '785a4062ab84fad14hd',
                    'username' => $nim->nim
                ];
                $delete = $this->universal->delete(['id' => $id], 'mahasiswa');
                if ($delete) {
                    api_delete('ekuliah_sisfo360', 'phb123456', $dataEkuliah, 'https://syncnau.poltektegal.ac.id/api/mahasiswa', true);
                    $this->notifikasi->success('Data berhasil dihapus');
                }
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $prodi = dekrip($this->u3);
                if ($this->u4 != '') {
                    $tahun = dekrip($this->u4);
                } else {
                    $tahun = date('Y');
                }
                if ($this->u5 != '') {
                    $status = dekrip($this->u5);
                } else if (dekrip($this->u5) == 0) {
                    $status = null;
                } else {
                    $status = 1;
                }
                $mahasiswa = $this->management->getMhs(['mahasiswa.prodi' => $prodi, 'mahasiswa.tahun_masuk' => $tahun], $status);
                $params = [
                    'title'         => 'Master Mahasiswa',
                    'mahasiswa'     => $mahasiswa,
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', '', ''),
                    'agama'         => $this->universal->getMulti('', 'agama'),
                    'provinsi'      => $this->universal->getMulti('', 'provinsi'),
                    'max_th'        => date('Y'),
                    'th_ini'        => $tahun,
                    'jalur'         => $this->universal->getMulti('', 'jalur'),
                    'status'        => $this->universal->getMulti('', 'status_mhs'),
                    'status_ini'    => $status,
                    'tahun'         => $this->management->tahun(['prodi' => $prodi]), 'negara' => $this->universal->getMulti('', 'negara')
                ];
                $this->session->set_userdata('prodi_ini', $this->u3);
                $this->session->set_userdata('previous_url', current_url());
                $this->load->view('mastermhs', $params);
            }
        } elseif ($this->u2 == 'cutistudi') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nim', 'Mahasiswa', 'required');
                $this->form_validation->set_rules('tahun', 'Tahun Akademik', 'required');
                $this->form_validation->set_rules('mulai', 'Mulai Cuti', 'required|numeric|min_length[1]|max_length[1]');
                $this->form_validation->set_rules('lama', 'Lama Cuti', 'required|numeric|min_length[1]|max_length[1]');
                $this->form_validation->set_rules('ket', 'Keterangan', 'required');
                $this->form_validation->set_rules('nomor', 'No. Surat', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data = [
                        'nomor'             => $this->input->post('nomor'),
                        'nim'               => dekrip($this->input->post('nim')),
                        'tahun'             => dekrip($this->input->post('tahun')),
                        'mulai'             => $this->input->post('mulai'),
                        'lama'              => $this->input->post('lama'),
                        'ket'               => $this->input->post('ket')
                    ];
                    $insert = $this->universal->insert($data, 'cutistudi');
                    $this->universal->update(['status_mahasiswa' => 4], ['nim' => dekrip($this->input->post('nim'))], 'mahasiswa');
                    if ($insert) {
                        $cuti = $this->universal->getOneSelect('id', ['nama_status' => 'Cuti'], 'status_mhs');
                        $data = [
                            'status_mahasiswa' => $cuti->id
                        ];
                        $update = $this->universal->update($data, ['nim' => dekrip($this->input->post('nim'))], 'mahasiswa');
                        if ($update) {
                            $this->notifikasi->success('Data berhasil ditambah');
                        }
                    }

                    redirect($_SERVER['HTTP_REFERER']);
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'cutistudi');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect($_SERVER['HTTP_REFERER']);
            } elseif ($this->u3 == 'getMhs') {
                $id_aktif = $this->universal->getOneSelect('id', ['nama_status' => 'Aktif'], 'status_mhs');
                $mhs = $this->management->likeMhs($this->input->get('q'), $id_aktif->id);
                $data = [];
                foreach ($mhs as $hasil) {
                    array_push($data, [
                        "value"         => enkrip($hasil->nim),
                        "text"          => $hasil->nim . ' - ' . $hasil->nama_lengkap . ' ( Semester : ' . $hasil->semester . ', ' . $hasil->nama_prodi . ' )'
                    ]);
                }

                $this->output->set_header('Content-Type: application/json');
                echo json_encode($data);
            } elseif ($this->u3 == 'getSemester') {
                $data = $this->universal->getOne(['nim' => dekrip($this->u4)], 'mahasiswa');

                echo json_encode($data->semester);
            } else {
                $prodi = dekrip($this->u3);

                if ($this->u4 != '') {
                    $tahun = dekrip($this->u4);
                } else {
                    $tahun = $this->universal->getOneSelect('id', ['status' => 1], 'tahun_akademik');
                    $tahun = $tahun->id;
                }

                if (!$prodi) {
                    $prodi = 111;
                }

                $data_cuti = $this->management->getCuti($tahun, $prodi);

                $params = [
                    'title'         => 'Cuti Studi',
                    'prodi'         => $this->universal->getOrderBy('', 'prodi', 'nama', '', ''),
                    'th_ini'        => $tahun,
                    'cuti'          => $data_cuti,
                    'prodi_i'       => $prodi,
                    'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', '')
                ];

                $this->session->set_userdata('previous_url', current_url());
                $this->load->view('cutistudi', $params);
            }
        }
    }
}

/* End of file Master_data.php */