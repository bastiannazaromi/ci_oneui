<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_api extends CI_Model
{
    public function getTahunAngkatan()
    {
        $this->db->distinct('tahun_masuk');
        $this->db->select('tahun_masuk');
        $this->db->where('tahun_masuk != ', null);
        $this->db->order_by('tahun_masuk');
        return $this->db->get('mahasiswa')->result();
    }
    public function getSemester($where = null)
    {
        $this->db->distinct('semester');
        $this->db->select('semester');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->group_by('semester');
        $this->db->order_by('semester');
        $query = $this->db->get('mahasiswa')->result();
        return (count((array)$query) > 0) ? $query : false;
    }
    public function getMhs($nim, $akademik, $prodi, $thn_angkatan, $smt, $jalur)
    {
        $this->db->select('
            mahasiswa.nim,
            mahasiswa.nama_lengkap,
            mahasiswa.semester,
            mahasiswa.tahun_masuk AS tahun_angkatan,
            prodi.nama AS nama_prodi,
            prodi.kd_prodi AS kd_prodi,
            tahun_akademik.id AS id_tahun_akademik,
            jalur.id AS id_jalur
        ');

        $this->db->from('mahasiswa');
        $this->db->join('prodi', 'mahasiswa.prodi = prodi.kd_prodi', 'inner');
        $this->db->join('anggota_kelas', 'mahasiswa.nim = anggota_kelas.nim', 'left');
        $this->db->join('bagikelas', 'anggota_kelas.id_kelas = bagikelas.id', 'left');
        $this->db->join('tahun_akademik', 'bagikelas.tahun = tahun_akademik.id', 'left');
        $this->db->join('jalur', 'mahasiswa.jalur = jalur.id', 'inner');

        if ($akademik !== null) {
            $this->db->where('tahun_akademik.id', $akademik);
        }
        if ($prodi !== null) {
            $this->db->where('prodi.kd_nasional', $prodi);
        }
        if ($thn_angkatan !== null) {
            $this->db->where('mahasiswa.tahun_masuk', $thn_angkatan);
        }
        if ($smt !== null) {
            $this->db->where('mahasiswa.semester', $smt);
        }
        if ($jalur !== null) {
            $this->db->where('mahasiswa.jalur', $jalur);
        }
        if ($nim !== null) {
            $this->db->where('mahasiswa.nim', $nim);
        }

        if ($akademik == null && $prodi == null && $thn_angkatan == null && $smt == null && $jalur == null && $nim == null) {
            return false;
        }
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }

    public function getMhsByNIM_EPT($nim)
    {
        $this->db->select('
            nim,
            nama_lengkap,
            tanggal_lahir,
            no_hp
        ');
        $this->db->where('nim', $nim);
        return $this->db->get('mahasiswa')->result();
    }
}

/* End of file M_api.php */
