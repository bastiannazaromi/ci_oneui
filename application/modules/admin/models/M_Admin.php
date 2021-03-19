<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
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

    public function getSetNilai()
    {
        $this->db->select('set_ap_nilai.*, prodi.nama as nama_prodi');
        $this->db->from('set_ap_nilai');
        $this->db->join('prodi', 'prodi.kd_prodi = set_ap_nilai.kd_prodi', 'inner');
        $this->db->order_by('prodi.nama', 'asc');

        return $this->db->get()->result();
    }

    public function getSetBobotNilai()
    {
        $this->db->select('set_bobot_nilai.*, prodi.nama as nama_prodi');
        $this->db->from('set_bobot_nilai');
        $this->db->join('prodi', 'prodi.kd_prodi = set_bobot_nilai.kd_prodi', 'inner');
        $this->db->order_by('prodi.nama', 'asc');

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

    public function countUser()
    {
        $this->db->select('COUNT(admin.id) as total, groups.name as nama_group');
        $this->db->from('admin');
        $this->db->join('groups', 'groups.id = admin.level', 'inner');
        $this->db->group_by('admin.level');

        return $this->db->get()->result();
    }
}

/* End of file M_Admin.php */