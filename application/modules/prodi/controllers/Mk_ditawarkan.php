<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mk_ditawarkan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }
    public function index()
    {
        if ($this->u2 == 'mk_tawarkan') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('kurikulum_add', 'Kurikulum', 'required');
                $this->form_validation->set_rules('mata_kuliah', 'Mata Kuliah', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $kode_mk = dekrip($this->input->post('mata_kuliah', true));
                    $periode = dekrip($this->input->post('periode'));
                    $cek_mk = $this->universal->getOneSelect('kode_mk', ['kode_mk' => $kode_mk, 'periode' => $periode], 'mk_tawarkan');
                    if (count((array)$cek_mk) > 0) {
                        $this->notifikasi->error('Maaf MK ini sudah ditawarkan!!');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                    $data = [
                        'kode_mk' => $kode_mk,
                        'kode_kurikulum	' => dekrip($this->input->post('kurikulum_add')),
                        'periode' => $periode,
                    ];
                    $insert = $this->universal->insert($data, 'mk_tawarkan');
                    if ($insert) {
                        $this->notifikasi->success('Berhasil tambah mata kuliah tawarkan');
                    }
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else if ($this->u3 == 'getMataKuliah') {
                $kd_kurikulum   = dekrip($this->u4);
                $periode        = dekrip($this->u5);

                $mk_seblumnya = $this->universal->getMultiSelect('kode_mk', ['kode_kurikulum' => $kd_kurikulum, 'periode' => $periode], 'mk_tawarkan');

                $data = $this->prodi->getMKTawarkan($mk_seblumnya, ['kd_kurikulum' => $kd_kurikulum], $periode);

                $mata_kuliah = [];
                foreach ($data as $row) {
                    array_push($mata_kuliah, [
                        'kd_mk' => enkrip($row->kode_mk),
                        'nama' => $row->nama_mk,
                    ]);
                }
                echo json_encode($mata_kuliah, true);
            } else if ($this->u3 == 'delete') {
                $id_mk = dekrip($this->u4);
                $delete = $this->universal->delete(['id' => $id_mk], 'mk_tawarkan');
                if ($delete) {
                    $this->notifikasi->success('Berhasil hapus data');
                }
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                // $mk_seblumnya = $this->universal->getMultiSelect('kode_mk', ['kode_kurikulum' => 'K56401', 'periode' => 1], 'mk_tawarkan');

                // $data = $this->prodi->getMKTawarkan($mk_seblumnya, ['kd_kurikulum' => 'K56401'], 1);

                // echo json_encode($data);
                // die;
                if ($this->u3 != '') {
                    $kode_kurikulum = $this->u3;
                    $where = ['mk_tawarkan.kode_kurikulum' => dekrip($this->u3)];
                }
                if ($this->u4 != '') {
                    $periode = dekrip($this->u4);
                    $where2 = ['mk_tawarkan.periode' => dekrip($this->u4)];
                } else {
                    $periode = 1;
                }

                $get_tawarkan = $this->prodi->get_mata_kuliah_tawar($where, $where2);
                $data = [
                    'title' => 'Mata Kuliah Ditawarkan',
                    'kurikulum' => $this->universal->getMulti(['status' => '1'], 'kurikulum'),
                    'mk_tawarkan' => $get_tawarkan,
                    'kode_kurikulum' => $kode_kurikulum,
                    'periode' => $periode,
                ];
                $this->load->view('mk_tawarkan', $data);
            }
        }
    }
}

/* End of file Mk_ditawarkan.php */
