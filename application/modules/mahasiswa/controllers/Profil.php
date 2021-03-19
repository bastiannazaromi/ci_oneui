<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profil extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        mhs_init();
    }

    function index()
    {

        if ($this->u3 == 'update') {
            // $this->form_validation->set_rules('nisn', 'NISN', 'required');
            // $this->form_validation->set_rules('nik', 'NIK', 'required');
            // $this->form_validation->set_rules('nim', 'NIM', 'required');
            $this->form_validation->set_rules('namalengkap', 'Nama lengkap', 'required');
            $this->form_validation->set_rules('tempatlahir', 'Tempat lahir', 'required');
            $this->form_validation->set_rules('tanggallahir', 'Tanggal lahir', 'required');
            $this->form_validation->set_rules('agama', 'Agama', 'required');
            $this->form_validation->set_rules('jk', 'Jenis kelamin', 'required');

            if ($this->form_validation->run() == false) {

                $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                redirect('mahasiswa/profil/edit', 'refresh');
            } else {

                $upload_foto = $_FILES['foto']['name'];


                if ($upload_foto) {

                    $folder_prodi = $this->user->prodi;

                    $dir = date('Y-m');

                    if (is_dir('upload/mhs/' . $folder_prodi) === false) {
                        mkdir('upload/mhs/' . $folder_prodi);
                        chmod('upload/mhs/' . $folder_prodi, 0777);

                        if (is_dir('upload/mhs/' . $folder_prodi . '/' . $dir) === false) {
                            mkdir('upload/mhs/' . $folder_prodi . '/' . $dir);
                            chmod('upload/mhs/' . $folder_prodi . '/' . $dir, 0777);
                        }
                    } else {
                        if (is_dir('upload/mhs/' . $folder_prodi . '/' . $dir) === false) {
                            mkdir('upload/mhs/' . $folder_prodi . '/' . $dir);
                            chmod('upload/mhs/' . $folder_prodi . '/' . $dir, 0777);
                        }
                    }

                    $this->load->library('upload');
                    $config['upload_path']          = './upload/mhs/' . $folder_prodi . '/' . $dir;
                    $config['allowed_types']        = 'jpg|jpeg|png';
                    $config['max_size']             = 3072; // 3 mb
                    $config['remove_spaces']        = TRUE;
                    $config['detect_mime']          = TRUE;
                    $config['encrypt_name']         = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('foto')) {
                        $this->session->set_flashdata('toastr-error', $this->upload->display_errors());

                        redirect('mahasiswa/profil/edit', 'refresh');
                    } else {

                        $upload_data = $this->upload->data();
                        $dataSebelumnya = $this->universal->getOne(['nim' => $this->nim], 'mahasiswa');

                        if ($dataSebelumnya->foto != 'default.jpg') {
                            unlink(FCPATH . 'upload/mhs/' . $dataSebelumnya->foto);
                        }
                        $data = [
                            'nama_lengkap'   => $this->input->post('namalengkap', TRUE),
                            'tempat_lahir'   => $this->input->post('tempatlahir', TRUE),
                            'tanggal_lahir'  => $this->input->post('tanggallahir', TRUE),
                            'agama'          => dekrip($this->input->post('agama', TRUE)),
                            'jk'             => dekrip($this->input->post('jk', TRUE)),
                            'foto'           => $folder_prodi . '/' . $dir . '/' . $upload_data['file_name']
                        ];

                        $update = $this->universal->update($data, ['nim' => $this->nim], 'mahasiswa');

                        ($update) ? $this->notifikasi->success('Update profil dengan foto berhasil') : $this->session->set_flashdata('toastr-error', 'Update gagal');

                        redirect('mahasiswa/profil/edit', 'refresh');
                    }
                } else {
                    $data = [
                        // 'nisn'          => $this->input->post('nisn', TRUE),
                        // 'nik'           => $this->input->post('nik', TRUE),
                        // 'nim'           => $this->input->post('nim', TRUE),
                        'nama_lengkap'   => $this->input->post('namalengkap', TRUE),
                        'tempat_lahir'   => $this->input->post('tempatlahir', TRUE),
                        'tanggal_lahir'  => $this->input->post('tanggallahir', TRUE),
                        'agama'         => dekrip($this->input->post('agama', TRUE)),
                        'jk'            => dekrip($this->input->post('jk', TRUE))
                    ];
                    $update = $this->universal->update($data, ['nim' => $this->nim], 'mahasiswa');

                    ($update) ? $this->notifikasi->success('Update profil berhasil') : $this->session->set_flashdata('toastr-error', 'Update gagal');

                    redirect('mahasiswa/profil/edit', 'refresh');
                }
            }
        } elseif ($this->u3 == 'edit') {
            $params = [
                'title'     => 'Edit Data Diri',
                'agama'     => $this->universal->getMulti('', 'agama'),
                'provinsi'      => $this->universal->getMulti('', 'provinsi'),
                'kabupaten'     => $this->universal->getMulti(['id_prov' => $this->user->provinsi], 'kabupaten'),
                'kecamatan'     => $this->universal->getMulti(['id_kab' => $this->user->kab_kota], 'kecamatan'),
                'desa'          => $this->universal->getMulti(['id_kec' => $this->user->kecamatan], 'desa')
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
                'kalender_akademik' =>  $this->universal->getOne(['status' => 1], 'tahun_akademik')
            ];
            $this->load->view('profil', $params);
        }
    }

    function edit()
    {
        $params = array('title' => 'Edit Data Diri');
        $this->load->view('editprofil', $params);
    }
}
