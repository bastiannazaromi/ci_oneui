<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Management extends CI_Model
{

    public function getUser($where)
    {
        $this->db->select('admin.*, prodi.nama as nama_prodi, groups.name as nama_group');
        $this->db->from('admin');
        $this->db->join('prodi', 'prodi.kd_prodi = admin.kd_prodi', 'left');
        $this->db->join('groups', 'groups.id = admin.level', 'inner');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('admin.nama', 'asc');

        return $this->db->get()->result();
    }

    public function getMulti($where, $tabel)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $data = $this->db->get($tabel)->result();
        return $data;
    }

    public function getRuang($where)
    {
        $this->db->select('ruang.*, prodi.nama as nama_prodi, gedung.nama as nama_gedung');
        $this->db->from('ruang');
        $this->db->join('prodi', 'prodi.kd_prodi = ruang.kd_prodi', 'inner');
        $this->db->join('gedung', 'gedung.id = ruang.id_gedung', 'inner');

        $this->db->where($where);
        $this->db->order_by('ruang.nama_ruang', 'asc');

        $data = $this->db->get()->result();
        return $data;
    }

    public function getDirektur()
    {
        $this->db->select('direktur.*, pegawai.nama, jabatan.nama_jabatan');
        $this->db->from('direktur');
        $this->db->join('pegawai', 'pegawai.id = direktur.id_peg', 'inner');
        $this->db->join('jabatan', 'jabatan.id = direktur.jabatan', 'inner');

        $this->db->order_by('jabatan.nama_jabatan', 'asc');
        return $this->db->get()->result();
    }

    public function getKaProdi()
    {
        $this->db->select('ka_prodi.*, pegawai.nama, prodi.nama as nama_prodi');
        $this->db->from('ka_prodi');
        $this->db->join('pegawai', 'pegawai.id = ka_prodi.id_peg', 'inner');
        $this->db->join('prodi', 'prodi.kd_prodi = ka_prodi.kd_prodi', 'inner');

        $this->db->order_by('pegawai.nama', 'asc');
        return $this->db->get()->result();
    }

    public function getAkreditasi()
    {
        $this->db->select('prodi_akred.*, prodi.nama as nama_prodi, prodi.jenjang');
        $this->db->from('prodi_akred');
        $this->db->join('prodi', 'prodi.kd_prodi = prodi_akred.kd_prodi', 'inner');

        $this->db->order_by('prodi.nama', 'asc');
        return $this->db->get()->result();
    }

    public function tahun($where)
    {
        $this->db->select('tahun_masuk as tahun');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->group_by('tahun_masuk');
        return $this->db->get('mahasiswa')->result();
    }

    public function getMhs($where, $like)
    {
        $this->db->select('mahasiswa.*, prodi.nama as nama_prodi, jalur.nama_jalur, status_mhs.nama_status');
        $this->db->from('mahasiswa');
        $this->db->join('prodi', 'prodi.kd_prodi = mahasiswa.prodi', 'inner');
        $this->db->join('jalur', 'jalur.id = mahasiswa.jalur', 'inner');
        $this->db->join('status_mhs', 'status_mhs.id = mahasiswa.status_mahasiswa', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        if ($like) {
            $this->db->like('mahasiswa.status_mahasiswa', $like);
        }
        $this->db->order_by('mahasiswa.nim', 'asc');
        return $this->db->get()->result();
    }

    public function likeMhs($like, $id_aktif)
    {
        $this->db->select('mahasiswa.nim, mahasiswa.nama_lengkap, mahasiswa.semester, prodi.nama as nama_prodi');
        $this->db->from('mahasiswa');
        $this->db->join('prodi', 'mahasiswa.prodi = prodi.kd_prodi', 'inner');
        $this->db->where('status_mahasiswa', $id_aktif);

        $this->db->group_start();
        $this->db->like('nama_lengkap', $like, 'both');
        $this->db->or_like('nim', $like, 'both');
        $this->db->group_end();

        $this->db->order_by('nim', 'ASC');
        $this->db->limit(20);

        return $this->db->get()->result();
    }

    public function likePeg($like)
    {
        $this->db->like('nama', $like, 'both');
        $this->db->or_like('nidn', $like, 'both');
        $this->db->or_like('nik', $like, 'both');
        $this->db->or_like('nipy', $like, 'both');
        $this->db->or_like('username', $like, 'both');
        $this->db->order_by('nama', 'ASC');
        $this->db->limit(20);

        return $this->db->get('pegawai')->result();
    }

    public function getCuti($tahun, $prodi)
    {
        $this->db->select('cutistudi.*, mahasiswa.nim, mahasiswa.nama_lengkap, mahasiswa.semester, prodi.nama as nama_prodi, tahun_akademik.tahun_akademik');
        $this->db->from('cutistudi');
        $this->db->join('mahasiswa', 'cutistudi.nim = mahasiswa.nim', 'inner');
        $this->db->join('prodi', 'mahasiswa.prodi = prodi.kd_prodi', 'inner');
        $this->db->join('tahun_akademik', 'cutistudi.tahun = tahun_akademik.id', 'inner');

        $this->db->where('cutistudi.tahun', $tahun);
        if ($prodi != '111' && $prodi != null) {
            $this->db->where('prodi.kd_prodi', $prodi);
        }

        $this->db->order_by('mahasiswa.nim', 'asc');

        return $this->db->get()->result();
    }

    public function getPegawai($status, $prodi, $st_ini)
    {
        $this->db->select('pegawai.id, pegawai.nik, pegawai.nipy, pegawai.nidn, pegawai.nama, pegawai.gelar_depan, pegawai.gelar_belakang, pegawai.username, pegawai.jk, pegawai.status_peg, pegawai.status_karyawan, status_pegawai.nama_status, prodi.nama as nama_prodi');
        $this->db->from('pegawai');
        $this->db->join('status_pegawai', 'status_pegawai.id = pegawai.status_peg', 'inner');
        $this->db->join('prodi', 'prodi.kd_prodi = pegawai.prodi', 'left');

        $this->db->where('pegawai.status_peg', $status);
        if ($st_ini == 'Dosen') {
            $this->db->where('pegawai.prodi', $prodi);
        }

        $this->db->order_by('pegawai.nama', 'asc');
        return $this->db->get()->result();
    }

    public function countPegawai()
    {
        $this->db->select('COUNT(pegawai.id) as total, status_pegawai.nama_status');
        $this->db->from('pegawai');
        $this->db->join('status_pegawai', 'status_pegawai.id = pegawai.status_peg', 'inner');
        $this->db->group_by('pegawai.status_peg');

        return $this->db->get()->result();
    }

    public function countDosen()
    {
        $this->db->select('COUNT(pegawai.id) as total, prodi.nama');
        $this->db->from('pegawai');
        $this->db->join('prodi', 'prodi.kd_prodi = pegawai.prodi', 'inner');
        $this->db->group_by('prodi.nama');
        $this->db->order_by('prodi.nama', 'asc');

        return $this->db->get()->result();
    }

    public function countMhs($status)
    {
        $this->db->select('COUNT(mahasiswa.id) as total, prodi.nama');
        $this->db->from('mahasiswa');
        $this->db->join('prodi', 'prodi.kd_prodi = mahasiswa.prodi', 'inner');
        $this->db->where('mahasiswa.status_mahasiswa', $status);
        $this->db->group_by('prodi.nama');
        $this->db->order_by('prodi.nama', 'asc');

        return $this->db->get()->result();
    }

    public function getBobotNilai($where)
    {
        $this->db
            ->select('bobot_nilai.*, prodi.nama as nama_prodi, tahun_akademik.tahun_akademik')
            ->join('prodi', 'prodi.kd_prodi = bobot_nilai.kd_prodi', 'inner')
            ->join('tahun_akademik', 'tahun_akademik.id = bobot_nilai.tahun_akademik', 'inner');
        $this->db->where($where);
        $this->db->order_by('bobot_nilai.huruf', 'asc');
        return $this->db->get('bobot_nilai')->result();
    }
}

/* End of file M_Management.php */