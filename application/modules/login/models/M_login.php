<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_login extends CI_Model
{

    public function validasi($username, $password)
    {
        $data = $this->db->get_where('admin', ['username' => $username])->result();
        if (count($data) === 1) {
            if (password_verify($password, $data[0]->password)) {
                return $dt        =    array(
                    'is_logged_in'    => true,
                    'id'            => $data[0]->id,
                    'username'      => $username,
                    'level'         => $data[0]->level,
                    'role'          => 'admin'
                );
            } else {
                return 0;
            }
        } else {
            $data = $this->db->get_where('mahasiswa', ['nim' => $username])->result();
            if (count($data) === 1) {
                if (password_verify($password, $data[0]->password)) {
                    return $dt        =    array(
                        'is_logged_in'    => true,
                        'nim'            => $data[0]->nim,
                        'username'      => $username,
                        'role'          => 'mahasiswa'
                    );
                } else {
                    return 0;
                }
            } else {
                $data = $this->db->get_where('pegawai', ['username' => $username])->result();
                if (count($data) === 1) {
                    if (password_verify($password, $data[0]->password)) {
                        return $dt        =    array(
                            'is_logged_in'    => true,
                            'id'            => $data[0]->id,
                            'username'      => $username,
                            'level'         => $data[0]->status_peg,
                            'role'          => 'pegawai'
                        );
                    } else {
                        return 0;
                    }
                }
            }
        }
    }
}
