<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_prodi extends CI_Model
{
    public function getUser($where)
    {
        $this->db->select('admin.*, prodi.jenjang, prodi.nama as nama_prodi, groups.name as nama_group');
        $this->db->from('admin');
        $this->db->join('prodi', 'prodi.kd_prodi = admin.kd_prodi', 'left');
        $this->db->join('groups', 'groups.id = admin.level', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('admin.nama', 'asc');
        return $this->db->get()->result();
    }
    public function get_mata_kuliah($where = null)
    {
        $this->db->select('kurikulum.kode_kurikulum,kurikulum.keterangan_kurikulum,prodi.kd_prodi,prodi.nama,mata_kuliah.*');
        $this->db->from('mata_kuliah');
        $this->db->join('kurikulum', 'mata_kuliah.kd_kurikulum=kurikulum.kode_kurikulum', 'inner');
        $this->db->join('prodi', 'mata_kuliah.kd_prodi=prodi.kd_prodi', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('mata_kuliah.id', 'DESC');
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function get_pegawai($where = [])
    {
        $this->db->select('pegawai.*,status_pegawa.id');
        $this->db->from('pegawai');
        $this->db->join('status_pegawai', 'pegawai.status_peg=status_pegawai.id', 'inner');
        $this->db->join('prodi', 'pegawai.prodi=prodi.kd_prodi', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('pegawai.id', 'DESC');
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function get_tahun_mhs($where)
    {
        $this->db->select('tahun_masuk as tahun');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->group_by('tahun_masuk');
        $data = $this->db->get('mahasiswa')->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function get_mahasiswa($where, $like)
    {
        $this->db->select('mahasiswa.*, prodi.nama as nama_prodi, jalur.nama_jalur, status_mhs.nama_status');
        $this->db->from('mahasiswa');
        $this->db->join('prodi', 'prodi.kd_prodi = mahasiswa.prodi', 'inner');
        $this->db->join('jalur', 'jalur.id = mahasiswa.jalur', 'inner');
        $this->db->join('status_mhs', 'status_mhs.id = mahasiswa.status_mahasiswa', 'inner');
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($like != null) {
            $this->db->like('mahasiswa.status_mahasiswa', $like);
        }
        $this->db->order_by('mahasiswa.nim', 'asc');
        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getBagiKelas($where)
    {
        $this->db->where($where);
        $this->db->order_by('semester', 'asc');
        $this->db->order_by('kelas', 'asc');
        $data = $this->db->get('bagikelas')->result();
        return $data;
    }
    public function getSmstKelas()
    {
        $this->db->group_by('semester');
        $this->db->order_by('semester', 'asc');

        return $this->db->get('bagikelas')->result();
    }
    public function get_mata_kuliah_tawar($where = null, $where2 = null)
    {
        $this->db->select('mata_kuliah.*,kurikulum.kode_kurikulum,kurikulum.keterangan_kurikulum,mk_tawarkan.id as id_tawarkan,mk_tawarkan.kode_mk,mk_tawarkan.kode_kurikulum,mk_tawarkan.periode,mk_tawarkan.created_at,mk_tawarkan.updated_at');
        $this->db->from('mk_tawarkan');
        $this->db->join('kurikulum', 'kurikulum.kode_kurikulum=mk_tawarkan.kode_kurikulum', 'inner');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk=mk_tawarkan.kode_mk', 'inner');
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($where2)) {
            $this->db->where($where2);
        }
        $this->db->order_by('mata_kuliah.semester', 'asc');

        $data = $this->db->get()->result();
        return (count((array)$data) > 0) ? $data : false;
    }
    public function getAnggotaKelas($id_kelas)
    {
        $this->db->select('anggota_kelas.*, bagikelas.nama_kelas, mahasiswa.nama_lengkap');
        $this->db->from('anggota_kelas');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->join('mahasiswa', 'mahasiswa.nim = anggota_kelas.nim', 'inner');

        $this->db->where('anggota_kelas.id_kelas', $id_kelas);
        $this->db->order_by('anggota_kelas.nim', 'asc');
        return $this->db->get()->result();
    }

    public function getRombel($where)
    {
        $this->db->select('rombel.*, mata_kuliah.nama_mk, pegawai.nama');
        $this->db->from('rombel');
        $this->db->join('mata_kuliah', 'rombel.kode_mk = mata_kuliah.kode_mk', 'inner');
        $this->db->join('pegawai', 'pegawai.username = rombel.id_dosen', 'inner');

        $this->db->where($where);
        $this->db->order_by('mata_kuliah.nama_mk', 'asc');
        return $this->db->get()->result();
    }

    public function getMhsStatus($where)
    {
        $this->db->select('COUNT(mahasiswa.id) as total, status_mhs.nama_status');
        $this->db->from('mahasiswa');
        $this->db->join('status_mhs', 'status_mhs.id = mahasiswa.status_mahasiswa', 'inner');

        $this->db->where($where);

        $this->db->group_by('mahasiswa.status_mahasiswa');
        $this->db->order_by('mahasiswa.status_mahasiswa', 'asc');

        return $this->db->get()->result();
    }

    public function getDetailKrs($where)
    {
        $this->db->select('krs.*, mahasiswa.nama_lengkap, mata_kuliah.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks');
        $this->db->from('krs');
        $this->db->join('mahasiswa', 'mahasiswa.nim = krs.nim', 'inner');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = krs.kode_mk', 'inner');

        $this->db->where($where);
        // $this->db->order_by('krs.kode_mk', 'asc');

        return $this->db->get()->result();
    }

    public function getListMK($where)
    {
        $this->db->select('rombel.kode_mk, mata_kuliah.nama_mk');
        $this->db->from('rombel');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = rombel.kode_mk', 'inner');

        $this->db->where($where);
        $this->db->order_by('mata_kuliah.nama_mk', 'asc');

        return $this->db->get()->result();
    }

    public function getListMhs($where)
    {
        $this->db->select('anggota_kelas.nim, mahasiswa.nama_lengkap');
        $this->db->from('anggota_kelas');
        $this->db->join('mahasiswa', 'mahasiswa.nim = anggota_kelas.nim', 'inner');

        $this->db->where($where);
        $this->db->order_by('mahasiswa.nim', 'asc');

        return $this->db->get()->result();
    }

    public function getListDs($where)
    {
        $this->db->select('pegawai.nama, pegawai.gelar_depan, pegawai.gelar_belakang, prodi.nama as nama_prodi');
        $this->db->from('pegawai');
        $this->db->join('prodi', 'prodi.kd_prodi = pegawai.prodi', 'inner');

        $this->db->where($where);
        $this->db->order_by('pegawai.nama', 'asc');

        return $this->db->get()->result();
    }

    public function getMK($mk, $where)
    {
        $this->db->where($where);
        foreach ($mk as $hasil) {
            $this->db->where('kode_mk !=', $hasil->kode_mk);
        }
        $this->db->order_by('nama_mk', 'asc');

        return $this->db->get('mata_kuliah')->result();
    }

    public function getMhsKelas($where)
    {
        $this->db->select('krs.*, mahasiswa.nama_lengkap, mahasiswa.kelas, mahasiswa.status_kelas');
        $this->db->from('krs');
        $this->db->join('mahasiswa', 'mahasiswa.nim = krs.nim', 'inner');
        $this->db->group_by('krs.nim');
        $this->db->where($where);

        $this->db->order_by('krs.nim', 'asc');

        return $this->db->get()->result();
    }

    public function getMKTawarkan($mk_sebelumnya, $where, $periode)
    {
        $this->db->where($where);

        $this->db->group_start();
        $a = 1;
        for ($i = 1; $i <= 8; $i++) {
            if ($periode == 1) {
                if ($i % 2 == 1) {
                    if ($a == 1) {
                        $this->db->where('semester', $i);
                        $a += 1;
                    } else {
                        $this->db->or_where('semester', $i);
                    }
                }
            } else {
                if ($i % 2 == 0) {
                    if ($a == 1) {
                        $this->db->where('semester', $i);
                        $a += 1;
                    } else {
                        $this->db->or_where('semester', $i);
                    }
                }
            }
        }
        $this->db->group_end();
        foreach ($mk_sebelumnya as $hasil) {
            $this->db->where('kode_mk !=', $hasil->kode_mk);
        }
        $this->db->order_by('nama_mk', 'asc');
        return $this->db->get('mata_kuliah')->result();
    }

    public function getMhs($th_ini)
    {
        $this->db->select('mahasiswa.nim, mahasiswa.nama_lengkap, mahasiswa.tahun_masuk, mahasiswa.jk, jalur.nama_jalur');
        $this->db->join('jalur', 'jalur.id = mahasiswa.jalur', 'inner');
        $this->db->where('mahasiswa.prodi', $this->user[0]->kd_prodi);
        $this->db->where('mahasiswa.tahun_masuk', $th_ini);
        $this->db->order_by('mahasiswa.nim', 'asc');

        return $this->db->get('mahasiswa')->result();
    }

    public function getDetailKHS($where)
    {
        $this->db->select('mahasiswa.nama_lengkap, anggota_kelas.id_kelas, bagikelas.kelas, bagikelas.semester, rombel.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, nilai.nilai_akhir');
        $this->db->join('anggota_kelas', 'anggota_kelas.nim = mahasiswa.nim', 'inner');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->join('rombel', 'rombel.id_kelas = bagikelas.id', 'inner');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = rombel.kode_mk', 'inner');
        $this->db->join('nilai', 'nilai.makul = rombel.kode_mk', 'left');
        $this->db->where($where);
        $this->db->order_by('mata_kuliah.nama_mk', 'asc');

        return $this->db->get('mahasiswa')->result();
    }

    public function getReportKrs($where)
    {
        $this->db->select('krs.nim, krs.kode_mk as kode_mk_krs, krs.id_th, krs.semester, krs.status as status_krs, mata_kuliah.nama_mk,mata_kuliah.kode_mk as kode_matkul,mata_kuliah.sks');
        $this->db->from('krs');
        $this->db->join('mata_kuliah', 'krs.kode_mk=mata_kuliah.kode_mk', 'inner');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('mata_kuliah.nama_mk', 'ASC');
        $data = $this->db->get()->result();
        return $data;
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
        return $data;
    }

    public function getGroupKelasMK($where)
    {
        $this->db->select('nilai.*, mata_kuliah.nama_mk, pegawai.gelar_depan, pegawai.nama, pegawai.gelar_belakang');
        $this->db->join('mata_kuliah', 'mata_kuliah.kode_mk = nilai.makul', 'inner');
        $this->db->join('pegawai', 'pegawai.username = nilai.kd_dosen', 'inner');
        $this->db->where($where);
        $this->db->group_by('nilai.makul');
        $this->db->order_by('mata_kuliah.nama_mk', 'asc');

        return $this->db->get('nilai')->result();
    }

    public function getKelasMK($where)
    {
        $this->db->select('nilai.*, mahasiswa.nama_lengkap');
        $this->db->join('mahasiswa', 'mahasiswa.nim = nilai.username', 'inner');
        $this->db->where($where);
        $this->db->order_by('mahasiswa.nim', 'asc');

        return $this->db->get('nilai')->result();
    }
}

/* End of file M_prodi.php */