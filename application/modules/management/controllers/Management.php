<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Management extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        management_init();
    }

    function index()
    {
        if ($this->u2 == 'profile') {
            if ($this->u3 == 'updateFoto') {
                $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
                $this->form_validation->set_rules('nama', 'Nama', 'required');

                if ($this->form_validation->run() == false) {

                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/profile', 'refresh');
                } else {
                    $nama = $this->input->post('nama', TRUE);
                    $email = trim($this->input->post('email', TRUE));

                    $upload_foto = $_FILES['foto']['name'];

                    if ($upload_foto) {
                        $this->load->library('upload');
                        $config['upload_path']          = './upload/admin';
                        $config['allowed_types']        = 'jpg|jpeg|png';
                        $config['max_size']             = 3072; // 3 mb
                        $config['remove_spaces']        = TRUE;
                        $config['detect_mime']            = true;
                        $config['encrypt_name']         = true;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('foto')) {
                            $this->session->set_flashdata('toastr-error', $this->upload->display_errors());
                            redirect('management/admin', 'refresh');
                        } else {

                            $upload_data = $this->upload->data();
                            $dataSebelumnya = $this->universal->getOne(['id' => $this->id_user], 'admin');

                            if ($dataSebelumnya->foto != 'default.jpg') {
                                unlink(FCPATH . 'upload/profile/' . $dataSebelumnya->foto);
                            }
                            $data = [
                                "nama"              => $nama,
                                "email"             => $email,
                                "foto"              => $upload_data['file_name']
                            ];

                            $update = $this->universal->update($data, ['id' => $this->id_user], 'admin');

                            ($update) ? $this->notifikasi->success('Update profil dengan foto berhasil') : $this->session->set_flashdata('toastr-error', 'Update gagal');

                            redirect('management/profile', 'refresh');
                        }
                    } else {
                        $data = [
                            "nama"              => $nama,
                            "email"             => $email
                        ];

                        $update = $this->universal->update($data, ['id' => $this->id_user], 'admin');

                        ($update) ? $this->notifikasi->success('Update profil tanpa foto berhasil') : $this->session->set_flashdata('toastr-error', 'Update gagal');

                        redirect('management/profile', 'refresh');
                    }
                }
            } elseif ($this->u3 == 'updatePass') {
                $this->form_validation->set_rules('oldPass', 'Password Lama', 'required', [
                    'required' => 'Password lama harap di isi !'
                ]);
                $this->form_validation->set_rules('newPass', 'Password Baru', 'required|trim|min_length[5]', [
                    'required' => 'Password baru harap di isi !',
                    'min_length' => 'Password baru kurang dari 5'
                ]);
                $this->form_validation->set_rules('confirPass', 'Password Konfirmasi', 'required|trim|min_length[5]|matches[newPass]', [
                    'required' => 'Password konfirmasi harap di isi !',
                    'matches' => 'Password konfirmasi salah !',
                    'min_length' => 'Password konfirmasi kurang dari 5'
                ]);

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/profile', 'refresh');
                } else {
                    $oldPass = $this->input->post('oldPass', TRUE);
                    $newPass = $this->input->post('newPass', TRUE);

                    $user = $this->universal->getOne(['id'  => $this->id_user], 'admin');

                    if (password_verify($oldPass, $user->password)) {
                        $data = [
                            "password" =>  password_hash($newPass, PASSWORD_BCRYPT, ['const' => 14])
                        ];

                        $update = $this->universal->update($data, ['id' => $this->id_user], 'admin');

                        ($update) ? $this->notifikasi->success('Password berhasil diupdate') : $this->session->set_flashdata('toastr-error', 'Password gagal diupdate');
                    } else {
                        $this->session->set_flashdata('toastr-error', 'Password lama salah');
                    }

                    redirect('management/profile', 'refresh');
                }
            } else {
                $params = [
                    'title'     => 'Profile'
                ];
                $this->load->view('profile', $params);
            }
        } else if ($this->u2 == 'tahunakademik') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('th_awal', 'Tahun Awal', 'required|numeric|min_length[4]|max_length[4]');
                $this->form_validation->set_rules('th_akhir', 'Akhir Awal', 'required|numeric|min_length[4]|max_length[4]');
                $this->form_validation->set_rules('periode', 'Periode', 'required');
                $this->form_validation->set_rules('awal', 'Awal Kalander', 'required');
                $this->form_validation->set_rules('akhir', 'akhir Kalander', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/tahunakademik', 'refresh');
                } else {
                    $th_awal = $this->input->post('th_awal');
                    $th_akhir = $this->input->post('th_akhir');
                    $periode = dekrip($this->input->post('periode'));
                    if ($periode == 1) {
                        $per = 'Ganjil';
                    } else {
                        $per = 'Genap';
                    }
                    $kode = $this->universal->getMulti('', 'tahun_akademik');
                    $data = [
                        'tahun_akademik'    => $th_awal . '/' . $th_akhir . ' - ' . $per,
                        'periode'           => $periode,
                        'th_awal'           => $th_awal,
                        'th_akhir'          => $th_akhir,
                        'awal'              => $this->input->post('awal'),
                        'akhir'             => $this->input->post('akhir'),
                        'kode' => count($kode) + 1,
                        'status'            => 0
                    ];
                    $dataEkuliah = [
                        'ekuliah_keys' => '785a4062ab84fad14hd',
                        'kode_ta' => count($kode) + 1,
                        'nama_ta' => $th_awal . '/' . $th_akhir . ' ' . $per,
                        'status' => 0,
                    ];
                    $insert = $this->universal->insert($data, 'tahun_akademik');
                    if ($insert) {
                        api_post($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'tahun_akademik', true);
                        $this->notifikasi->success('Data berhasil ditambah');
                    }
                    redirect('management/tahunakademik', 'refresh');
                }
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('th_awal', 'Tahun Awal', 'required|numeric|min_length[4]|max_length[4]');
                $this->form_validation->set_rules('th_akhir', 'Akhir Awal', 'required|numeric|min_length[4]|max_length[4]');
                $this->form_validation->set_rules('periode', 'Periode', 'required');
                $this->form_validation->set_rules('awal', 'Awal Kalander', 'required');
                $this->form_validation->set_rules('akhir', 'akhir Kalander', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('management/tahunakademik', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $th_awal = $this->input->post('th_awal');
                    $th_akhir = $this->input->post('th_akhir');
                    $periode = dekrip($this->input->post('periode'));
                    if ($periode == 1) {
                        $per = 'Ganjil';
                    } else {
                        $per = 'Genap';
                    }
                    $data = [
                        'tahun_akademik'    => $th_awal . '/' . $th_akhir . ' - ' . $per,
                        'periode'           => $periode,
                        'th_awal'           => $th_awal,
                        'th_akhir'          => $th_akhir,
                        'awal'              => $this->input->post('awal'),
                        'akhir'             => $this->input->post('akhir'),
                        'status'            => 0
                    ];
                    $dataEkuliah = [
                        'ekuliah_keys' => '785a4062ab84fad14hd',
                        'kode_ta' => $this->universal->getOneSelect('id,kode', ['id' => $id], 'tahun_akademik')->kode,
                        'nama_ta' => $th_awal . '/' . $th_akhir . ' ' . $per,
                    ];
                    $update = $this->universal->update($data, ['id' => $id], 'tahun_akademik');
                    if ($update) {
                        api_put($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'tahun_akademik', true);
                        $this->notifikasi->success('Data berhasil diupdate');
                    }
                    redirect('management/tahunakademik', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $dataEkuliah = [
                    'ekuliah_keys' => '785a4062ab84fad14hd',
                    'kode_thak' => $this->universal->getOneSelect('kode', ['id' => $id], 'tahun_akademik')->kode
                ];
                $delete = $this->universal->delete(['id' => $id], 'tahun_akademik');
                if ($delete) {
                    api_delete($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'tahun_akademik', true);
                    $this->notifikasi->success('Data berhasil dihapus');
                }
                redirect('management/tahunakademik', 'refresh');
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);
                $data = $this->universal->getOne(['id' => $id], 'tahun_akademik');
                echo json_encode($data);
            } elseif ($this->u3 == 'status') {
                $id = dekrip($this->u4);
                $kode = $this->universal->getOneSelect('kode', ['id' => $id], 'tahun_akademik')->kode;
                $data = [
                    'status'    => 1
                ];
                $data2 = [
                    'status'    => 0
                ];
                $dataEkuliah = [
                    'ekuliah_keys' => '785a4062ab84fad14hd',
                    'kode_thak' => $kode,
                    'status' => 1
                ];
                $dataEkuliah1 = [
                    'ekuliah_keys' => '785a4062ab84fad14hd',
                    'kode_thak' => $kode,
                    'status' => 0
                ];
                $update = $this->universal->update($data, ['id' => $id], 'tahun_akademik');
                $update = $this->universal->update($data2, ['id !=' => $id], 'tahun_akademik');
                if ($update) {
                    $this->notifikasi->success('Status berhasil diubah');
                }
                redirect('management/tahunakademik', 'refresh');
            } else {
                $params = [
                    'title'         => 'Tahun Akademik',
                    'tahun'         => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', '')
                ];

                $this->load->view('tahun', $params);
            }
        } else {
            $status_mhs = $this->universal->getOneSelect('id', [
                'id_stat_mhs' => 'A'
            ], 'status_mhs');
            $status_peg = $this->universal->getOneSelect('id', [
                'nama_status' => 'Dosen'
            ], 'status_pegawai');
            $params = [
                'title'         => 'Dashboard',
                'peg_group'     => $this->management->countPegawai(),
                'pegawai'       => count($this->universal->getMulti('', 'pegawai')),
                'prodi'         => count($this->universal->getMulti('', 'prodi')),
                'gedung'        => count($this->universal->getMulti('', 'gedung')),
                'mahasiswa'     => count($this->universal->getMulti([
                    'status_mahasiswa' => $status_mhs->id
                ], 'mahasiswa')),
                'dosen_group'   => $this->management->countDosen(),
                'mhs_group'     => $this->management->countMhs($status_mhs->id)
            ];

            $this->load->view('dashboard', $params);
        }
    }
}

/* End of file Management.php */