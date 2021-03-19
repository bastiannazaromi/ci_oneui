<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u2 == 'mahasiswa') {
            if ($this->u3 == 'edit') {
                if ($this->u4 == 'prosess') {
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
                        $id_mhs = dekrip($this->input->post('id'));
                        $data = [
                            'nik'               => $this->input->post('nik'),
                            'nim'               => $this->input->post('nim'),
                            'nama_lengkap'      => $this->input->post('nama'),
                            'negara'            => dekrip($this->input->post('negara')),
                            'tempat_lahir'      => $this->input->post('tempat'),
                            'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
                            'agama'             => $this->input->post('agama'),
                            'status_nikah'      => dekrip($this->input->post('status_menikah')),
                            'jk'                => dekrip($this->input->post('jk')),
                            'provinsi'          => dekrip($this->input->post('provinsi')),
                            'kab_kota'          => dekrip($this->input->post('kab_kota')),
                            'kecamatan'         => dekrip($this->input->post('kec')),
                            'kelurahan'         => dekrip($this->input->post('desa')),
                            'asal_sekolah'      => $this->input->post('asal_sekolah'),
                            'foto'              => 'default.jpg',
                            'nama_ibu'          => $this->input->post('ibu'),
                            'tahun_masuk'       => $this->input->post('tahun'),
                            'semester_masuk'    => $this->input->post('semester'),
                            'semester'          => $this->input->post('semester'),
                            'jalur'             => dekrip($this->input->post('jalur')),
                            'prodi'             => dekrip($this->input->post('prodi')),
                            'status_mahasiswa'  => dekrip($this->input->post('status'))
                        ];
                        $update = $this->universal->update($data, ['id' => $id_mhs], 'mahasiswa');
                        if ($update) {
                            $this->notifikasi->success('Berhasil update mahasiswa');
                        }
                        $previous_url = $this->session->userdata('previous_url');
                        redirect($previous_url);
                    }
                } else {
                    $mahasiswa = $this->universal->getOne(['id' => dekrip($this->u4)], 'mahasiswa');
                    $params = [
                        'title' => 'Edit Mahasiswa',
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
                    ];
                    $this->load->view("mahasiswa_edit", $params);
                }
            } else if ($this->u3 == 'getKab') {
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
            } else {
                $prodi = $this->user[0]->kd_prodi;
                if ($this->u3 == '') {
                    $tahun = date('Y');
                } else {
                    $tahun = dekrip($this->u3);
                }
                if ($this->u4 == '') {
                    $status = null;
                } else {
                    $status = dekrip($this->u4);
                }
                $mahasiswa = $this->prodi->get_mahasiswa(['mahasiswa.prodi' => $prodi, 'tahun_masuk' => $tahun], $status);
                $params = [
                    'title' => 'Mahasiswa',
                    'mahasiswa' => $mahasiswa,
                    'tahun' => $this->prodi->get_tahun_mhs(['prodi' => $this->user[0]->kd_prodi]),
                    'status' => $this->universal->getMulti('', 'status_mhs'),
                    'th_ini' => $tahun,
                    'status_ini' => $status,
                    'agama'         => $this->universal->getMulti('', 'agama'),
                    'provinsi'      => $this->universal->getMulti('', 'provinsi'),
                    'max_th'        => date('Y'),
                    'jalur'         => $this->universal->getMulti('', 'jalur'),
                ];
                $this->session->set_userdata('previous_url', current_url());
                $this->load->view('mahasiswa', $params);
            }
        }
    }
}

/* End of file Mahasiswa.php */
