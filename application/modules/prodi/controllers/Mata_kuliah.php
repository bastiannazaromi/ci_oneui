<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mata_kuliah extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u2 == 'mata_kuliah') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kurikulum', 'kurikulum', 'required|trim');
                $this->form_validation->set_rules('prodi', 'Prodi', 'required|trim');
                $this->form_validation->set_rules('kode', 'Kode Mata Kuliah', 'required|trim|min_length[3]|max_length[10]');
                $this->form_validation->set_rules('nama', 'Nama Matkul', 'required');
                $this->form_validation->set_rules('max_pertemuan', 'Maksimal Pertemuan', 'required|trim|numeric');
                $this->form_validation->set_rules('semester', 'Semester', 'required|trim|numeric');
                $this->form_validation->set_rules('sks', 'SKS', 'required|trim|numeric');
                $this->form_validation->set_rules('jenis', 'Jenis Matkul', 'required|trim');
                $this->form_validation->set_rules('status', 'status', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/mata_kuliah', 'refresh');
                } else {
                    $data = [
                        'kode_mk' => htmlspecialchars($this->input->post('kode', true)),
                        'nama_mk' => htmlspecialchars($this->input->post('nama', true)),
                        'semester' => htmlspecialchars($this->input->post('semester', true)),
                        'sks' => htmlspecialchars($this->input->post('sks', true)),
                        'jenis_mk' => htmlspecialchars($this->input->post('jenis', true)),
                        'status' => htmlspecialchars($this->input->post('status', true)),
                        'kd_prodi' => dekrip($this->input->post('prodi', true)),
                        'kd_kurikulum' => dekrip($this->input->post('kurikulum', true)),
                        'max_pertemuan' => $this->input->post('max_pertemuan', true),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $insert = $this->universal->insert($data, 'mata_kuliah');
                    if ($insert) {
                        $this->notifikasi->success('Berhasil input data');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else if ($this->u3 == 'active_non_active') {
                $id = dekrip($this->u4);
                $status = ($this->u5 == 'active') ? '1' : '0';
                $data = [
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $update = $this->universal->update($data, ['id' => $id], 'mata_kuliah');
                if ($update) {
                    $this->notifikasi->success(($status == '1') ? 'Berhasil Acivekan' : 'Berhasil Non Activekan');
                }
                redirect($_SERVER['HTTP_REFERER']);
            } else if ($this->u3 == 'getMatkul') {
                $id_matkul = dekrip($this->u4);
                $getData = $this->prodi->get_mata_kuliah(['mata_kuliah.id' => $id_matkul], 'mata_kuliah');
                if ($getData) {
                    $response = [
                        'status' => true,
                        'nama_mk' => $getData[0]->nama_mk,
                        'kd_mk' => $getData[0]->kode_mk,
                        'semester' => $getData[0]->semester,
                        'sks' => $getData[0]->sks,
                        'jenis_mk' => $getData[0]->jenis_mk,
                        'status_a' => $getData[0]->status,
                        'kd_prodi' => enkrip($getData->kd_prodi),
                        'kd_kurikulum' => enkrip($getData[0]->kd_kurikulum),
                        'max_pertemuan' => $getData[0]->max_pertemuan,
                        'id_matkul' => enkrip($getData[0]->id),
                    ];
                }
                echo json_encode($response, true);
            } else if ($this->u3 == 'edit') {
                $this->form_validation->set_rules('prodi', 'Prodi', 'required|trim');
                $this->form_validation->set_rules('kode', 'Kode Mata Kuliah', 'required|trim|min_length[3]|max_length[10]');
                $this->form_validation->set_rules('nama', 'Nama Matkul', 'required');
                $this->form_validation->set_rules('semester', 'Semester', 'required|trim|numeric');
                $this->form_validation->set_rules('max_pertemuan', 'Maksimal Pertemuan', 'required|trim|numeric');
                $this->form_validation->set_rules('sks', 'SKS', 'required|trim|numeric');
                $this->form_validation->set_rules('jenis', 'Jenis Matkul', 'required|trim');
                $this->form_validation->set_rules('status', 'status', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('prodi/mata_kuliah', 'refresh');
                } else {
                    $id_matKul = dekrip($this->input->post('id_matkul', true));
                    $data = [
                        'kode_mk' => htmlspecialchars($this->input->post('kode', true)),
                        'nama_mk' => htmlspecialchars($this->input->post('nama', true)),
                        'semester' => htmlspecialchars($this->input->post('semester', true)),
                        'sks' => htmlspecialchars($this->input->post('sks', true)),
                        'jenis_mk' => htmlspecialchars($this->input->post('jenis', true)),
                        'status' => htmlspecialchars($this->input->post('status', true)),
                        'kd_prodi' => dekrip($this->input->post('prodi', true)),
                        'kd_kurikulum' => dekrip($this->input->post('kurikulum', true)),
                        'max_pertemuan' => $this->input->post('max_pertemuan', true),
                    ];
                    $update = $this->universal->update($data, ['id' => $id_matKul], 'mata_kuliah');
                    if ($update) {
                        $this->notifikasi->success('Berhasil update data');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else if ($this->u3 == 'delete') {
                $id = dekrip($this->u4);
                $delete = $this->universal->delete(['id' => $id], 'mata_kuliah');
                if ($delete) {
                    $this->notifikasi->success('Berhasil hapus data');
                }
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $semester = dekrip($this->u3);
                if (!$semester) {
                    $semester = $this->universal->getOrderBy('', 'mata_kuliah', 'semester', 'desc', 1);
                    $semester = $semester[0]->semester;
                }
                $params = [
                    'title'             => 'Mata Kuliah',
                    'list_mataKuliah'   => $this->prodi->get_mata_kuliah(['semester' => $semester]),
                    'kurikulum'         => $this->universal->getMulti(['status' => '1'], 'kurikulum'),
                    'sms_ini'           => $semester,
                    'semester'          => $this->universal->getGroupSelect('semester', '', 'mata_kuliah', 'semester', 'semester', 'asc')
                ];

                $this->load->view('mata_kuliah', $params);
            }
        }
    }
}

/* End of file MataKuliah.php */
