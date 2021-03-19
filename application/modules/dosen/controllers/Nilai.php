<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Nilai extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        dosen_init();
    }

    function index()
    {
        if ($this->u3 == 'komposisi_nilai') {
            if ($this->u4 == 'set_komposisi') {
                $tahun_akademik = $this->input->post('tahun_akademik');
                $prodi = $this->input->post('prodi');
                $makul = $this->input->post('makul');
                $kelas = $this->input->post('kelas');
                $semester = $this->input->post('semester');

                $kehadiran = $this->input->post('kehadiran');
                $tugas = $this->input->post('tugas');
                $uts = $this->input->post('uts');
                $uas = $this->input->post('uas');

                $id_dosen = $this->user->username;

                $data = array(
                    'kode_mk'           => $makul,
                    'kelas'             => $kelas,
                    'kd_prodi'          => $prodi,
                    'tahun_akademik'    => $tahun_akademik,
                    'semester'          => $semester,
                    'kd_dosen'          => $id_dosen,
                    'presensi'          => $kehadiran,
                    'tugas'             => $tugas,
                    'uts'               => $uts,
                    'uas'               => $uas
                );
                // Jika sudah ada ya brati diupdate
                $this->db->where('prodi', $prodi);
                $this->db->where('makul', $makul);
                $this->db->where('kelas', $kelas);
                $this->db->where('semester', $semester);

                if($this->db->get('presentase_nilai')->num_rows()){
                    $this->universal->update('presentase_nilal', $data);
                    $this->notifikasi->success('Berhasil Update');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    // Jika belum ada ya brati insert
                    if($this->universal->insert($data, 'presentase_nilai')){
                        $this->notifikasi->success('Berhasil Insert');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }

            } else {
                $params = [
                    'title'     => 'Set Komposisi Nilai',
                    'prodi'     => $this->universal->getMulti('', 'prodi'),
                    'matkul'    => $this->universal->getMulti('', 'mata_kuliah'),
                    'semester'  => $this->db->select('semester')->group_by('semester')->get('mahasiswa')->result(),
                    'kelas'     => $this->universal->getMulti('', 'kelas'),
                    'tahun_akademik' => $this->universal->getMulti('', 'tahun_akademik')
                ];
    
                $this->load->view('komposisi_nilai', $params);
            }
        } elseif ($this->u3 == 'input_nilai') {
            if ($this->u4 == 'edit') {
                
                $nim = $this->input->post('nim');
                $semester = $this->input->post('semester');
                $makul = $this->input->post('makul');
                $prodi = $this->input->post('prodi');
                $tahun_akademik = $this->input->post('tahun_akademik');

                $data = [
                    'presensi_akhir'           => (int)$this->input->post('presensi'),
                    'tugas_akhir'              => (int)$this->input->post('tugas'),
                    'uts_akhir'                => (int)$this->input->post('uts'),
                    'uas_akhir'                => (int)$this->input->post('uas')
                ];

                $this->universal->update($data, ['username' => $nim], 'nilai');

                $pres = $this->universal->getOneSelect('presensi, tugas, uts, uas', [
                    'semester' => $semester,
                    'kode_mk' => $makul,
                    'kd_prodi' => $prodi,
                    'tahun_akademik' => $tahun_akademik,
                    'kd_dosen' => $this->user->username
                ], 'presentase_nilai');

                $nil =
                    ($data['presensi_akhir'] * ($pres->presensi / 100)) +

                    ($data['tugas_akhir'] * ($pres->tugas / 100)) +

                    ($data['uts_akhir'] * ($pres->uts / 100)) +

                    ($data['uas_akhir'] * ($pres->uas / 100));

                $this->db->where("'$nil' BETWEEN `angka_awal` AND `angka_akhir`");
                $huruf = $this->db->get('bobot_nilai')->row('huruf');

                $this->db->update(['nilai_akhir' => $nil, 'huruf_akhir' => $huruf], ['username' => $nim], 'nilai');

                $data = [
                    'nilai' => $nil,
                    'huruf' => $huruf,
                    'csrf_name' => $this->security->get_csrf_token_name(),
                    'csrf_hash' => $this->security->get_csrf_hash()
                ];

                echo json_encode($data);
                exit;
            }

            $this->db->select('
            mahasiswa.nim, mahasiswa.nama_lengkap, nilai.uts, nilai.presensi, presensi_akhir, uas_akhir, tugas_akhir, uts_akhir, nilai.id, nilai.uas, nilai.tugas, nilai.nilai_akhir, mata_kuliah.kode_mk, mahasiswa.kelas, mahasiswa.prodi, mahasiswa.semester');
            $this->db->join('nilai', 'nilai.username = mahasiswa.nim', 'inner');
            $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = nilai.makul', 'inner');
            $this->db->join('pegawai', 'pegawai.username = nilai.kd_dosen', 'inner');

            $this->db->where('nilai.kd_dosen', $this->user->username);
            $this->db->where('mata_kuliah.kode_mk', '14214');
            $mahasiswa = $this->db->get('mahasiswa')->result();

            $params = [
                'title'             => 'Input Nilai',
                'prodi'             => $this->universal->getMulti('', 'prodi'),
                'matkul'            => $this->universal->getMulti('', 'mata_kuliah'),
                'tahun_akademik'    => $this->universal->getMulti('', 'tahun_akademik'),
                'mahasiswa'         => $mahasiswa,
                'semester'          => $this->db->select('semester')->group_by('semester')->get('mahasiswa')->result()
            ];

            $this->load->view('input_nilai', $params);
        } elseif ($this->u3 == 'getNilaiMhs') {

            $tahun_akademik = $this->input->post('tahun_akademik');
            $prodi = $this->input->post('prodi');
            $semester = $this->input->post('semester');
            $makul = $this->input->post('makul');
            $id_dosen = $this->user->username;
            
            // $data = [
            //     'prodi'     => $prodi,
            //     'kd_dosen'  => $id_dosen,
            //     'makul'     => $makul,
            //     'smt'       => $semester
            // ];

            $this->db->select('
                mahasiswa.nim,
                mahasiswa.nama_lengkap,
                nilai.*
            ');
            
            $this->db->join('mahasiswa', 'mahasiswa.nim = nilai.username', 'inner');

            if($tahun_akademik){
                $this->db->where('thak', $tahun_akademik);
            }
            if($prodi){
                $this->db->where('nilai.prodi', $prodi);
            }
            if($semester){
                $this->db->where('smt', $semester);
            }
            if($makul){
                $this->db->where('makul', $makul);
            }
            
            $this->db->where('kd_dosen', $id_dosen);
            
            $nilai_mhs = $this->db->get('nilai')->result();

            $nilai['mahasiswa'] = $nilai_mhs;
            $nilai['csrf_name'] = $this->security->get_csrf_token_name();
            $nilai['csrf_hash'] = $this->security->get_csrf_hash();
            $this->load->view('input_mhs', $nilai);
        } elseif ($this->u3 == 'getMakul') {
            $prodi = $this->u4;
            $semester = $this->u5;

            $this->db->select('nama_mk, kode_mk');
            if ($prodi !== '') {
                $this->db->where('kd_prodi', $prodi);
            }
            if ($semester !== '') {
                $this->db->where('semester', $semester);
            }
            $data = $this->db->get('mata_kuliah')->result();
            $makul = [];
            foreach ($data as $dt) {
                array_push($makul, [
                    'kode_mk'    => $dt->kode_mk,
                    'nama_mk'      => $dt->nama_mk
                ]);
            }
            echo json_encode($makul);
        } elseif ($this->u3 == 'getPresentase') {
            echo 'coba';
        }
    }
}
