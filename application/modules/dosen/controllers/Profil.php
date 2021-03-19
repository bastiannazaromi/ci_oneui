<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profil extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        dosen_init();
    }

    function index()
    {
        if ($this->u3 == 'update') {
            $this->form_validation->set_rules('nik', 'NIK', 'required', ['required' => 'NIK harus diisi!']);
            $this->form_validation->set_rules('nipy', 'NIPY', 'required', ['required' => 'NIPY harus diisi!']);
            $this->form_validation->set_rules('nidn', 'NIDN', 'required', ['required' => 'NIDN harus diisi!']);
            $this->form_validation->set_rules('nama', 'Nama', 'required', ['required' => 'Nama harus diisi!']);
            $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required', ['required' => 'Jenis Kelamin harus diisi!']);
            $this->form_validation->set_rules('agama', 'Agama', 'required', ['required' => 'Agama harus diisi!']);
            $this->form_validation->set_rules('tempatlahir', 'Tempat Lahir', 'required', ['required' => 'Tempat Lahir harus diisi!']);
            $this->form_validation->set_rules('tanggallahir', 'Tanggal Lahir', 'required', ['required' => 'Tanggal Lahir harus diisi!']);
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email', ['required' => 'Email harus diisi!']);
            $this->form_validation->set_rules('telepon', 'Telepon', 'required|numeric|max_length[20]', ['required' => 'Telepon harus diisi!']);
            $this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => 'Alamat harus diisi!']);
            $this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => 'Provini harus diisi!']);
            $this->form_validation->set_rules('kota_kab', 'Kabupaten/Kota', 'required', ['required' => 'Kabupaten/Kota harus diisi!']);
            $this->form_validation->set_rules('kec', 'Kecamatan', 'required', ['required' => 'Kecamatan harus diisi!']);
            $this->form_validation->set_rules('desa', 'Desa', 'required', ['required' => 'Desa harus diisi!']);


            if ($this->form_validation->run() == false) {
                $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                redirect('dosen/profil/edit', 'refresh');
            } else {
                $upload_foto = $_FILES['foto']['name'];

                if ($upload_foto) {
                    $this->load->library('upload');

                    $folder_prodi = $this->user->prodi;
                    if (!$folder_prodi) {
                        $folder_prodi = '!dosen';
                    }
                    $dir = date('Y-m');

                    if (is_dir('upload/dosen/' . $folder_prodi) === false) {
                        mkdir('upload/dosen/' . $folder_prodi);
                        chmod('upload/dosen/' . $folder_prodi, 0777);

                        if (is_dir('upload/dosen/' . $folder_prodi . '/' . $dir) === false) {
                            mkdir('upload/dosen/' . $folder_prodi . '/' . $dir);
                            chmod('upload/dosen/' . $folder_prodi . '/' . $dir, 0777);
                        }
                    } else {
                        if (is_dir('upload/dosen/' . $folder_prodi . '/' . $dir) === false) {
                            mkdir('upload/dosen/' . $folder_prodi . '/' . $dir);
                            chmod('upload/dosen/' . $folder_prodi . '/' . $dir, 0777);
                        }
                    }

                    $config['upload_path']          = './upload/dosen/' . $folder_prodi . '/' . $dir;
                    $config['allowed_types']        = 'jpg|jpeg|png';
                    $config['max_size']             = 3072; // 3 mb
                    $config['remove_spaces']        = TRUE;
                    $config['detect_mime']          = TRUE;
                    $config['encrypt_name']         = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('foto')) {
                        $this->session->set_flashdata('toastr-error', $this->upload->display_errors());
                        redirect('dosen/profil/edit', 'refresh');
                    } else {

                        $upload_data = $this->upload->data();
                        $dataSebelumnya = $this->universal->getOne(['id' => $this->id_user], 'pegawai');

                        if ($dataSebelumnya->foto != 'default.jpg') {
                            unlink(FCPATH . 'upload/dosen/' . $dataSebelumnya->foto);
                        }

                        $data = [
                            'nik'               => $this->input->post('nik', TRUE),
                            'nipy'              => $this->input->post('nipy', TRUE),
                            'nidn'              => $this->input->post('nidn', TRUE),
                            'nama'              => $this->input->post('nama', TRUE),
                            'jk'                => dekrip($this->input->post('jk', TRUE)),
                            'agama'             => dekrip($this->input->post('agama', TRUE)),
                            'tempat'            => $this->input->post('tempatlahir', TRUE),
                            'tanggal'           => $this->input->post('tanggallahir', TRUE),
                            'email'             => $this->input->post('email', TRUE),
                            'alamat'            => $this->input->post('alamat', TRUE),
                            'provinsi'          => dekrip($this->input->post('provinsi', TRUE)),
                            'kota_kab'          => dekrip($this->input->post('kota_kab', TRUE)),
                            'kecamatan'         => dekrip($this->input->post('kec', TRUE)),
                            'desa'              => dekrip($this->input->post('desa', TRUE)),
                            'foto'              => $folder_prodi . '/' . $dir . '/' . $upload_data['file_name']
                        ];

                        $update = $this->universal->update($data, ['id' => $this->id_user], 'pegawai');

                        ($update) ? $this->notifikasi->success('Update profil dengan foto berhasil') : $this->session->set_flashdata('toastr-error', 'Update gagal');

                        redirect('dosen/profil/edit', 'refresh');
                    }
                } else {
                    $data = [
                        'nik'               => $this->input->post('nik', TRUE),
                        'nipy'              => $this->input->post('nipy', TRUE),
                        'nidn'              => $this->input->post('nidn', TRUE),
                        'nama'              => $this->input->post('nama', TRUE),
                        'jk'                => dekrip($this->input->post('jk', TRUE)),
                        'agama'             => dekrip($this->input->post('agama', TRUE)),
                        'tempat'            => $this->input->post('tempatlahir', TRUE),
                        'tanggal'           => $this->input->post('tanggallahir', TRUE),
                        'email'             => $this->input->post('email', TRUE),
                        'telepon'           => $this->input->post('telepon', TRUE),
                        'alamat'            => $this->input->post('alamat', TRUE),
                        'provinsi'          => dekrip($this->input->post('provinsi', TRUE)),
                        'kota_kab'          => dekrip($this->input->post('kota_kab', TRUE)),
                        'kecamatan'         => dekrip($this->input->post('kec', TRUE)),
                        'desa'              => dekrip($this->input->post('desa', TRUE))
                    ];

                    $update = $this->universal->update($data, ['id' => $this->id_user], 'pegawai');

                    ($update) ? $this->notifikasi->success('Update profil tanpa foto berhasil') : $this->session->set_flashdata('toastr-error', 'Update gagal');

                    redirect('dosen/profil/edit', 'refresh');
                }
            }
        } elseif ($this->u3 == 'edit') {
            $params = [
                'title'         => 'Edit Data Diri',
                'agama'         => $this->universal->getMulti('', 'agama'),
                'provinsi'      => $this->universal->getMulti('', 'provinsi'),
                'kabupaten'     => $this->universal->getMulti(['id_prov' => $this->user->id_provinsi], 'kabupaten'),
                'kecamatan'     => $this->universal->getMulti(['id_kab' => $this->user->id_kabupaten], 'kecamatan'),
                'desa'          => $this->universal->getMulti(['id_kec' => $this->user->id_kecamatan], 'desa')
            ];
            $this->load->view('editprofil', $params);
        } elseif ($this->u3 == 'getKab') {
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
        } elseif ($this->u3 == 'getKec') {
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
        } elseif ($this->u3 == 'getDesa') {
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
        } else {
            $params = [
                'title'     => 'Data Diri',
                'agama'     => $this->dosen->getAgama()->agama
            ];
            $this->load->view('profil', $params);
        }
    }
}
