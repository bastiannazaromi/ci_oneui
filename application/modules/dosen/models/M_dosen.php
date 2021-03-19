<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_dosen extends CI_Model {

    public function getUser($where)
    {

        $this->db->select(
            'pegawai.*,
            status_pegawai.nama_status, 
            prodi.nama AS nama_prodi, prodi.kd_prodi,
            desa.id AS id_desa, desa.id_kec, desa.nama AS nama_desa,
	        kecamatan.id AS id_kecamatan, kecamatan.id_kab, kecamatan.nama AS nama_kecamatan,
	        kabupaten.id_kab AS id_kabupaten, kabupaten.id_prov, kabupaten.nama AS nama_kabupaten,
	        provinsi.id_prov AS id_provinsi, provinsi.nama AS nama_provinsi'
        );

        $this->db->from('pegawai');
        $this->db->join('status_pegawai', 'status_pegawai.id = pegawai.status_peg', 'left');
        $this->db->join('prodi', 'prodi.kd_prodi = pegawai.prodi', 'left');        
        $this->db->join('desa', 'desa.id = pegawai.desa', 'left');
        $this->db->join('kecamatan', 'kecamatan.id = pegawai.kecamatan', 'left');
        $this->db->join('kabupaten', 'kabupaten.id_kab = pegawai.kota_kab', 'left');
        $this->db->join('provinsi', 'provinsi.id_prov = pegawai.provinsi', 'left');
        

        if ($where) {
            $this->db->where($where);
        }
        
        return $this->db->get()->result()[0];
    }
    function getMhsBimbingan($where){        
        $this->db->select('
            mahasiswa.*,            
            status_mhs.nama_status,
            prodi
        ');

        $this->db->from('dosen_wali');

        $this->db->join('mahasiswa', 'mahasiswa.nim = dosen_wali.nim', 'inner');
        $this->db->join('status_mhs','status_mhs.id = mahasiswa.status_mahasiswa', 'inner');

        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('mahasiswa.nama_lengkap', 'asc');
        
        return $this->db->get()->result();
    }
    function getAgama(){
        $this->db->select('agama');
        return $this->db->get_where('agama', ['id' => $this->user->agama])->row();
    }

}
