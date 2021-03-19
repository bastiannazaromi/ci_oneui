<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_mahasiswa extends CI_Model
{
    public function getUser($where)
    {
        $this->db->select('
            mahasiswa.*,
            agama.agama,
            status_mhs.nama_status,
            desa.nama AS nama_desa,
            kecamatan.nama AS nama_kecamatan,
            kabupaten.nama AS nama_kabupaten,
            provinsi.nama AS nama_provinsi,
            prodi.jenjang, prodi.nama AS nama_prodi
        ');
        $this->db->from('mahasiswa');
        $this->db->join('agama', 'mahasiswa.agama = agama.id', 'left');
        $this->db->join('status_mhs', 'mahasiswa.status_mahasiswa = status_mhs.id', 'left');
        $this->db->join('desa', 'desa.id=mahasiswa.kelurahan', 'left');
        $this->db->join('kecamatan', 'kecamatan.id=mahasiswa.kecamatan', 'left');
        $this->db->join('kabupaten', 'kabupaten.id_kab=mahasiswa.kab_kota', 'left');
        $this->db->join('provinsi', 'provinsi.id_prov=mahasiswa.provinsi', 'left');
        $this->db->join('prodi', 'prodi.kd_prodi=mahasiswa.prodi', 'left');
        $this->db->where($where);
        return $this->db->get()->result()[0];
    }
    public function getKrsMhs($where = null)
    {
        $this->db->select('mata_kuliah.*,mata_kuliah.status as status_mk,kurikulum.kode_kurikulum,kurikulum.keterangan_kurikulum,kurikulum.status as status_kurikulum,mk_tawarkan.kode_mk as kode_tawarkan');
        $this->db->from('mata_kuliah');
        $this->db->join('mk_tawarkan', 'mata_kuliah.kode_mk=mk_tawarkan.kode_mk', 'inner');
        $this->db->join('kurikulum', 'mata_kuliah.kd_kurikulum=kurikulum.kode_kurikulum', 'inner');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getReportKrs($where)
    {
        $this->db->select('krs.nim,krs.kode_mk as kode_mk_krs,krs.id_th,krs.semester,krs.status as status_krs,mata_kuliah.nama_mk,mata_kuliah.kode_mk as kode_matkul,mata_kuliah.sks');
        $this->db->from('krs');
        $this->db->join('mata_kuliah', 'krs.kode_mk=mata_kuliah.kode_mk', 'inner');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('mata_kuliah.nama_mk', 'ASC');
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getTotalSKS($where)
    {
        $this->db->select('krs.nim,krs.kode_mk as kode_mk_krs,krs.status as status_krs,mata_kuliah.kode_mk as kode_matkul,mata_kuliah.sks,SUM(mata_kuliah.sks) as TotalSks');
        $this->db->from('krs');
        $this->db->join('mata_kuliah', 'krs.kode_mk=mata_kuliah.kode_mk', 'inner');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }

    public function getMKKrs($where)
    {
        $this->db->select('krs.*, mata_kuliah.nama_mk, mata_kuliah.sks');
        $this->db->from('krs');
        $this->db->join('mata_kuliah', 'matakuliah.kode_mk = krs.kode_mk', 'inner');

        $this->db->where($where);
        $this->db->order_by('matakuliah.nama_mk', 'asc');

        return $this->db->get()->result();
    }
    public function getKAProdi($where)
    {
        $this->db->select('ka_prodi.*, pegawai.nama, pegawai.gelar_depan, pegawai.gelar_belakang, pegawai.nipy');
        $this->db->from('ka_prodi');
        $this->db->join('pegawai', 'pegawai.id = ka_prodi.id_peg', 'inner');
        $this->db->where($where);
        return $this->db->get()->row();
    }
    public function getKhs($where)
    {
        $this->db->select('mahasiswa.nama_lengkap, anggota_kelas.id_kelas, bagikelas.kelas, bagikelas.semester, rombel.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, nilai.nilai_akhir');
        $this->db->join('anggota_kelas', 'anggota_kelas.nim = mahasiswa.nim', 'inner');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->join('rombel', 'rombel.id_kelas = bagikelas.id', 'inner');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = rombel.kode_mk', 'inner');
        $this->db->join('nilai', 'nilai.makul = rombel.kode_mk', 'left');
        $this->db->where($where);
        $this->db->order_by('mata_kuliah.nama_mk', 'asc');
        $data = $this->db->get('mahasiswa')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getDns($where)
    {
        $this->db->select('mahasiswa.nama_lengkap,mahasiswa.jalur, anggota_kelas.id_kelas, bagikelas.kelas, bagikelas.semester, rombel.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, nilai.nilai_akhir');
        $this->db->join('anggota_kelas', 'anggota_kelas.nim=mahasiswa.nim', 'inner');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->join('rombel', 'rombel.id_kelas = bagikelas.id', 'inner');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = rombel.kode_mk', 'inner');
        $this->db->join('nilai', 'nilai.makul = rombel.kode_mk', 'left');
        $this->db->where($where);
        $this->db->order_by('mata_kuliah.nama_mk', 'asc');
        $data = $this->db->get('mahasiswa')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getTTDDNS($where)
    {
        $this->db->select('jabatan.*, pegawai.nama, pegawai.gelar_depan, pegawai.gelar_belakang, pegawai.nipy');
        $this->db->from('jabatan');
        $this->db->join('direktur', 'direktur.jabatan = jabatan.id', 'inner');
        $this->db->join('pegawai', 'pegawai.id = direktur.id_peg', 'inner');
        $this->db->where($where);
        return $this->db->get()->row();
    }
    public function getTagihanMhs($where = null)
    {
        $this->db->select('tagihan.*,master_post.kode_mp,master_post.nama_mp');
        $this->db->join('master_post', 'tagihan.kd_mp=master_post.kode_mp', 'inner');
        $this->db->where($where);
        $data = $this->db->get('tagihan')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getTagihanOne($where)
    {
        $this->db->select('tagihan.*,master_post.kode_mp,master_post.nama_mp');
        $this->db->join('master_post', 'tagihan.kd_mp=master_post.kode_mp', 'inner');
        $this->db->where($where);
        $data = $this->db->get('tagihan')->row();
        return $data;
    }
    public function getNilaiAkademik($where)
    {
        $this->db->select('mahasiswa.nama_lengkap, anggota_kelas.id_kelas, bagikelas.kelas, bagikelas.semester, rombel.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks,nilai.presensi_akhir,nilai.tugas_akhir,nilai.uts_akhir,nilai.uas_akhir, nilai.nilai_akhir');
        $this->db->join('anggota_kelas', 'anggota_kelas.nim = mahasiswa.nim', 'inner');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->join('rombel', 'rombel.id_kelas = bagikelas.id', 'inner');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = rombel.kode_mk', 'inner');
        $this->db->join('nilai', 'nilai.makul = rombel.kode_mk', 'left');
        $this->db->where($where);
        $data = $this->db->get('mahasiswa')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
}
