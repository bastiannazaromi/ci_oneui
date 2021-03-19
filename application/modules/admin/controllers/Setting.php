<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        admin_init();
    }

    private function getOneValue($where, $tabel)
    {
        return $this->universal->getOne($where, $tabel)->value;
    }

    function index()
    {
        if ($this->u2 == 'setnilai') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('mode', 'Mode', 'required');
                $this->form_validation->set_rules('tahun', 'Lama Waktu', 'required|numeric');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/setnilai', 'refresh');
                } else {
                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('kd_prodi')),
                        'mode'          => dekrip($this->input->post('mode')),
                        'lama'          => $this->input->post('tahun')
                    ];

                    $insert = $this->universal->insert($data, 'set_ap_nilai');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/setnilai', 'refresh');
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);

                $data = $this->universal->getOne(['id' => $id], 'set_ap_nilai');

                echo json_encode($data);
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('mode', 'Mode', 'required');
                $this->form_validation->set_rules('tahun', 'Lama Waktu', 'required|numeric');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/setnilai', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));

                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('kd_prodi')),
                        'mode'          => dekrip($this->input->post('mode')),
                        'lama'          => $this->input->post('tahun')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'set_ap_nilai');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('admin/setnilai', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'set_ap_nilai');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('admin/setnilai', 'refresh');
            } else {
                $params = [
                    'title'         => 'Setting Aplikasi Nilai',
                    'data'          => $this->admin->getSetNilai(),
                    'prodi'         => $this->universal->getMulti('', 'prodi')
                ];

                $this->load->view('set_ap_nilai', $params);
            }
        } elseif ($this->u2 == 'setbobotnilai') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('mode', 'Mode', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/setbobotnilai', 'refresh');
                } else {
                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('kd_prodi')),
                        'mode'          => dekrip($this->input->post('mode'))
                    ];

                    $insert = $this->universal->insert($data, 'set_bobot_nilai');

                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/setbobotnilai', 'refresh');
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);

                $data = $this->universal->getOne(['id' => $id], 'set_bobot_nilai');

                echo json_encode($data);
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
                $this->form_validation->set_rules('mode', 'Mode', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/setbobotnilai', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));

                    $data = [
                        'kd_prodi'      => dekrip($this->input->post('kd_prodi')),
                        'mode'          => dekrip($this->input->post('mode'))
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'set_bobot_nilai');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }

                    redirect('admin/setbobotnilai', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'set_bobot_nilai');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('admin/setbobotnilai', 'refresh');
            } else {
                $params = [
                    'title'         => 'Setting Bobot Nilai',
                    'data'          => $this->admin->getSetBobotNilai(),
                    'prodi'         => $this->universal->getMulti('', 'prodi')
                ];

                $this->load->view('set_bobot_nilai', $params);
            }
        } elseif ($this->u2 == 'setwsapi') {
            if ($this->u3 == 'save') {
                $this->form_validation->set_rules('user', 'User Feeder', 'required');
                $this->form_validation->set_rules('pass', 'Password Feeder', 'required');
                $this->form_validation->set_rules('api', 'Host API Feeder', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/setwsapi', 'refresh');
                } else {
                    $user = [
                        'value' => $this->input->post('user')
                    ];
                    $pass = [
                        'value' => $this->input->post('pass')
                    ];
                    $api = [
                        'value' => $this->input->post('api')
                    ];

                    $user = $this->universal->update($user, ['item' => 'username'], 'config');
                    $pass = $this->universal->update($pass, ['item' => 'password'], 'config');
                    $api = $this->universal->update($api, ['item' => 'host-api'], 'config');

                    if ($user && $pass && $api) {
                        $this->notifikasi->success('Data berhasil disimpan');
                    }

                    redirect('admin/setwsapi');
                }
            } elseif ($this->u3 == 'test') {
                feeder_init();
                $test = $this->feeder->GetToken($this->username, $this->password);
                if ($test != 'ERROR: username/password salah') {
                    $this->notifikasi->success('Berhasil melakukan sambungan ke Feeder..');
                } else {
                    $this->notifikasi->error('Gagal melakukan sambungan ke Feeder..');
                }
                redirect('admin/setwsapi');
            } else {
                $user = $this->getOneValue(['item' => 'username'], 'config');
                $pass = $this->getOneValue(['item' => 'password'], 'config');
                $api = $this->getOneValue(['item' => 'host-api'], 'config');
                $params = [
                    'user' => $user,
                    'pass' => $pass,
                    'api' => $api,
                    'title'         => 'Setting Web Service API',
                ];

                $this->load->view('wsapi', $params);
            }
        }
    }

    function set_offsets($value)
    {
        $this->session->set_userdata('offsets', $value);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function kamus()
    {
        feeder_init();
        $table = "mahasiswa";
        $result = $this->feeder->GetDictionary($this->token, $table);

        print_r($result);
    }

    function tabel()
    {
        feeder_init();
        $result = $this->feeder->ListTable($this->token);
        print_r($result);
    }

    function mhs()
    {
        feeder_init();
        $key = '04c271e8-42e9-47a9-90a4-49293e2dff92';
        $filter = "p.id_pd = '" . $key . "'";
        $table = "mahasiswa";
        $order = "";
        $limit = 10;
        $offset = $this->offsets;

        $result = $this->feeder->GetRecordSet($this->token, $table, $filter, $order, $limit, $offset);
        $total = $this->feeder->GetCountRecordSet($this->token, $table, $filter, $order, $limit, $offset);

        print_r($result);
    }

    function mhs_pt()
    {
        feeder_init();
        $key = '04c271e8-42e9-47a9-90a4-49293e2dff92';
        $nim = '20092002';
        // $filter = "";
        $filter = "p.nipd = '" . $nim . "'";
        $table = "mahasiswa_pt";
        $order = "";
        $limit = 10;
        $offset = $this->offsets;

        $result = $this->feeder->GetRecordSet($this->token, $table, $filter, $order, $limit, $offset);
        $total = $this->feeder->GetCountRecordSet($this->token, $table, $filter, $order, $limit, $offset);

        print_r($result);
    }

    function test()
    {
        $key = '';
        $filter = "";
        $table = "agama";
        $order = "";
        $limit = 1000;
        $offset = $this->offsets;

        $result = $this->feeder->GetRecordSet($this->token, $table, $filter, $order, $limit, $offset);
        $total = $this->feeder->GetCountRecordSet($this->token, $table, $filter, $order, $limit, $offset);

        print_r($result);
    }

    function import()
    {
        feeder_init();
        // $key = '19090094';
        $filter = "";
        $table = "mahasiswa";
        $order = "";
        $limit = 10;
        $offset = 20;

        $result = $this->feeder->GetRecordSet($this->token, $table, $filter, $order, $limit, $offset);
        $result = $result['result'];

        $data = array();

        foreach ($result as $row) {
            array_push(
                $data,
                array(
                    'id' => NULL,
                    'nim' => NULL,
                    'nama_lengkap' => $row['nm_pd'],
                    'jk' => $row['jk'],
                    'nisn' => $row['nisn'],
                    'nik' => $row['nik'],
                    'tempat_lahir' => $row['tmpt_lahir'],
                    'tanggal_lahir' => $row['tgl_lahir'],
                    'agama' => $row['id_agama'],
                    'jln' => $row['jln'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'nm_dsn' => $row['nm_dsn'],
                    'ds_kel' => $row['ds_kel'],
                    'id_wil' => $row['id_wil'],
                    'kode_pos' => $row['kode_pos'],
                    'kewarganegaraan' => $row['kewarganegaraan'],
                    'no_hp' => NULL,
                    'email' => $row['email'],
                    'provinsi' => NULL,
                    'kab_kota' => NULL,
                    'kecamatan' => NULL,
                    'kelurahan' => NULL,
                    'asal_sekolah' => NULL,
                    'foto' => NULL,
                    'tahun_masuk' => NULL,
                    'semester_masuk' => NULL,
                    'semester' => NULL,
                    'kelas' => NULL,
                    'status_kelas' => NULL,
                    'status_mahasiswa' => $row['stat_pd'],
                    'id_dosen_wali' => $row['id_dosen_wali'],
                    'a_terima_kps' => $row['a_terima_kps'],
                    'no_kps' => $row['no_kps'],
                    'nm_ayah' => $row['nm_ayah'],
                    'tgl_lahir_ayah' => $row['tgl_lahir_ayah'],
                    'id_jenjang_pendidikan_ayah' => $row['id_jenjang_pendidikan_ayah'],
                    'id_pekerjaan_ayah' => $row['id_pekerjaan_ayah'],
                    'id_penghasilan_ayah' => $row['id_penghasilan_ayah'],
                    'id_kebutuhan_khusus_ayah' => $row['id_kebutuhan_khusus_ayah'],
                    'nm_ibu_kandung' => $row['nm_ibu_kandung'],
                    'tgl_lahir_ibu' => $row['tgl_lahir_ibu'],
                    'id_jenjang_pendidikan_ibu' => $row['id_jenjang_pendidikan_ibu'],
                    'id_penghasilan_ibu' => $row['id_penghasilan_ibu'],
                    'id_pekerjaan_ibu' => $row['id_pekerjaan_ibu'],
                    'id_kebutuhan_khusus_ibu' => $row['id_kebutuhan_khusus_ibu'],
                    'nm_wali' => $row['nm_wali'],
                    'tgl_lahir_wali' => $row['tgl_lahir_wali'],
                    'id_jenjang_pendidikan_wali' => $row['id_jenjang_pendidikan_wali'],
                    'id_pekerjaan_wali' => $row['id_pekerjaan_wali'],
                    'id_penghasilan_wali' => $row['id_penghasilan_wali'],
                )
            );
        }

        // print_r($data);
        $this->db->insert_batch('mahasiswa_test', $data);
    }

    function import_pt()
    {
        feeder_init();

        $table = "mahasiswa_pt";
        $order = "";
        $prodi = '04';
        $limit = 1;
        $offset = 0;

        for ($nim = 18040001; $nim <= 18040250; $nim++) {
            $filter = "p.nipd = '" . $nim . "'";
            $result = $this->feeder->GetRecordSet($this->token, $table, $filter, $order, $limit, $offset);
            $result = $result['result'];

            $data = array();

            foreach ($result as $row) {
                array_push(
                    $data,
                    array(
                        'id' => NULL,
                        'nim' => trim($row['nipd']),
                        'nama_lengkap' => $row['nm_pd'],
                        'jk' => $row['jk'],
                        'nisn' => $row['nisn'],
                        'tempat_lahir' => $row['tmpt_lahir'],
                        'tanggal_lahir' => $row['tgl_lahir'],
                        'agama' => $row['id_agama'],
                    )
                );
            }

            // print_r($data);
            $this->db->insert_batch('mahasiswa', $data);

            
            $key = $row['id_pd'];
            if ($key != ''){
                $filter = "p.id_pd = '" . $key . "'";
                $result = $this->feeder->GetRecordSet($this->token, 'mahasiswa', $filter, $order, $limit, $offset);
                $result = $result['result'];
                foreach ($result as $row) {
                    $data2 = [
                        'nama_lengkap' => ucwords(strtolower($row['nm_pd'])),
                        'prodi' => $prodi,
                        'jk' => $row['jk'],
                        'nisn' => $row['nisn'],
                        'nik' => $row['nik'],
                        'tempat_lahir' => $row['tmpt_lahir'],
                        'tanggal_lahir' => $row['tgl_lahir'],
                        'agama' => $row['id_agama'],
                        'jln' => $row['jln'],
                        'rt' => $row['rt'],
                        'rw' => $row['rw'],
                        'nm_dsn' => $row['nm_dsn'],
                        'ds_kel' => $row['ds_kel'],
                        'id_wil' => $row['id_wil'],
                        'kode_pos' => $row['kode_pos'],
                        'kewarganegaraan' => $row['kewarganegaraan'],
                        'email' => $row['email'],
                        'status_mahasiswa' => $row['stat_pd'],
                        'id_dosen_wali' => $row['id_dosen_wali'],
                        'a_terima_kps' => $row['a_terima_kps'],
                        'no_kps' => $row['no_kps'],
                        'nm_ayah' => $row['nm_ayah'],
                        'tgl_lahir_ayah' => $row['tgl_lahir_ayah'],
                        'id_jenjang_pendidikan_ayah' => $row['id_jenjang_pendidikan_ayah'],
                        'id_pekerjaan_ayah' => $row['id_pekerjaan_ayah'],
                        'id_penghasilan_ayah' => $row['id_penghasilan_ayah'],
                        'id_kebutuhan_khusus_ayah' => $row['id_kebutuhan_khusus_ayah'],
                        'nm_ibu_kandung' => $row['nm_ibu_kandung'],
                        'tgl_lahir_ibu' => $row['tgl_lahir_ibu'],
                        'id_jenjang_pendidikan_ibu' => $row['id_jenjang_pendidikan_ibu'],
                        'id_penghasilan_ibu' => $row['id_penghasilan_ibu'],
                        'id_pekerjaan_ibu' => $row['id_pekerjaan_ibu'],
                        'id_kebutuhan_khusus_ibu' => $row['id_kebutuhan_khusus_ibu'],
                        'nm_wali' => $row['nm_wali'],
                        'tgl_lahir_wali' => $row['tgl_lahir_wali'],
                        'id_jenjang_pendidikan_wali' => $row['id_jenjang_pendidikan_wali'],
                        'id_pekerjaan_wali' => $row['id_pekerjaan_wali'],
                        'id_penghasilan_wali' => $row['id_penghasilan_wali'],
                    ];
                }
    
                $this->universal->update($data2, ['nim' => $nim], 'mahasiswa');
            }
            
        }
    }

    function arey()
    {
        $data = array(
            array(
                'title' => 'My title',
                'name' => 'My Name',
                'date' => 'My date'
            ),
            array(
                'title' => 'Another title',
                'name' => 'Another Name',
                'date' => 'Another date'
            )
        );

        print_r($data);
    }
}

/* End of file Setting.php */