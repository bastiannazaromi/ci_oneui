<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Keamanan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        dosen_init();
    }

    function index()
    {

        if ($this->u3 == 'updatePass') {            
            $this->form_validation->set_rules('oldPass', 'Password Lama', 'required', [
                'required' => 'Password lama harap di isi !'
            ]);
            $this->form_validation->set_rules('newPass', 'Password Baru', 'required|trim|min_length[5]', [
                'required'      => 'Password baru harap di isi !',
                'min_length'    => 'Password baru kurang dari 5'
            ]);
            $this->form_validation->set_rules('confirPass', 'Password Konfirmasi', 'required|trim|min_length[5]|matches[newPass]', [
                'required'      => 'Password konfirmasi harap di isi !',
                'matches'       => 'Password konfirmasi salah !',
                'min_length'    => 'Password konfirmasi kurang dari 5'
            ]);

            if ($this->form_validation->run() == false) {
                $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                redirect($_SERVER['HTTP_REFERER']);                
            } else {
                $oldPass = $this->input->post('oldPass', TRUE);
                $newPass = $this->input->post('newPass', TRUE);

                $user = $this->universal->getOne(['id'  => $this->id_user], 'pegawai');

                if (password_verify($oldPass, $user->password)) {
                    $data = [
                        "password" =>  password_hash($newPass, PASSWORD_BCRYPT, ['const' => 14])
                    ];

                    $update = $this->universal->update($data, ['id' => $this->id_user], 'pegawai');

                    ($update) ? $this->notifikasi->success('Password berhasil diupdate :)') : $this->notifikasi->set_flashdata('toastr-error', 'Password gagal diupdate');
                } else {
                    $this->notifikasi->error('Password lama salah');
                }
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $params = [
                'title'     => 'Keamanan'
            ];
            
            $this->load->view('keamanan', $params);
        }
    }

    public function ceknik()
    {
        $username = "admin";
        $password = "phb123456";
        $nik = '3328165607780004';
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl_handle, CURLOPT_URL, 'https://e-gateway.poltektegal.ac.id/Api_nik/index/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'id' => 'ZxJjN9iyna',
            'nik' => $nik,
        ));
        curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        header('Content-Type: application/json');
        echo json_decode($buffer);
    }
}
