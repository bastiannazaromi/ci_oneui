<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        admin_init();
    }

    public function index()
    {
        if ($this->u2 == 'group') {
            if ($this->u3 == 'add') {
                $this->form_validation->set_rules('nama', 'Nama Group', 'required');
                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/group', 'refresh');
                } else {
                    $data = [
                        'name'          => $this->input->post('nama')
                    ];
                    $insert = $this->universal->insert($data, 'groups');
                    if ($insert) {
                        $this->notifikasi->success('Data berhasil ditambah');
                    }

                    redirect('admin/group', 'refresh');
                }
            } elseif ($this->u3 == 'getOne') {
                $id = dekrip($this->u4);
                $data = $this->universal->getOne(['id' => $id], 'groups');
                echo json_encode($data);
            } elseif ($this->u3 == 'edit') {
                $this->form_validation->set_rules('nama', 'Nama Group', 'required');

                if ($this->form_validation->run() == false) {
                    $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                    redirect('admin/group', 'refresh');
                } else {
                    $id = dekrip($this->input->post('id'));
                    $data = [
                        'name'              => $this->input->post('nama')
                    ];

                    $update = $this->universal->update($data, ['id' => $id], 'groups');

                    if ($update) {
                        $this->notifikasi->success('Data berhasil diupdate');
                    }
                    redirect('admin/group', 'refresh');
                }
            } elseif ($this->u3 == 'delete') {
                $id = dekrip($this->u4);

                $delete = $this->universal->delete(['id' => $id], 'groups');
                if ($delete) {
                    $this->notifikasi->success('Data berhasil dihapus');
                }

                redirect('admin/group', 'refresh');
            } else {
                $params = [
                    'title'         => 'Ref. Prodi',
                    'group'         => $this->universal->getMulti('', 'groups')
                ];

                $this->load->view('group', $params);
            }
        } elseif ($this->u2 == 'user') { {
                if ($this->u3 == 'add') {
                    $this->form_validation->set_rules('nama', 'Nama Group', 'required');
                    $this->form_validation->set_rules('username', 'Username', 'required');
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                    $this->form_validation->set_rules('level', 'Level', 'required');
                    $this->_getLevel(dekrip($this->input->post('level')));
                    if ($this->form_validation->run() == false) {
                        $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                        redirect('admin/user', 'refresh');
                    } else {
                        $data = [
                            'kd_prodi'      => $this->prodi,
                            'nama'          => $this->input->post('nama'),
                            'username'      => $this->input->post('username'),
                            'email'         => $this->input->post('email'),
                            'password'      => password_hash('phb123456', PASSWORD_BCRYPT, ['const' => 14]),
                            'level'         => dekrip($this->input->post('level'))
                        ];
                        $insert = $this->universal->insert($data, 'admin');
                        if ($insert) {
                            if (dekrip($this->input->post('level')) == 8) {
                                $dataEkuliah = [
                                    'ekuliah_keys' => $this->keys_synckuliah,
                                    'nama' => $this->input->post('nama'),
                                    'username' => $this->input->post('username'),
                                    'password' => MD5('phb123456'),
                                    'kode_prodi' => $this->prodi,
                                    'foto' => 'default.jpg'
                                ];
                                api_post($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'admin', true);
                            }
                            $this->notifikasi->success('Data berhasil ditambah');
                        }
                        redirect('admin/user', 'refresh');
                    }
                } elseif ($this->u3 == 'getOne') {
                    $id = dekrip($this->u4);
                    $data = $this->universal->getOne(['id' => $id], 'admin');
                    echo json_encode($data);
                } elseif ($this->u3 == 'edit') {
                    $this->form_validation->set_rules('nama', 'Nama Group', 'required');
                    $this->form_validation->set_rules('username', 'Username', 'required');
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                    $this->form_validation->set_rules('level', 'Level', 'required');

                    $this->_getLevel(dekrip($this->input->post('level')));

                    if ($this->form_validation->run() == false) {
                        $this->notifikasi->error(str_replace("\r\n", "", json_encode(strip_tags(validation_errors()))));
                        redirect('admin/user', 'refresh');
                    } else {
                        $id = dekrip($this->input->post('id'));
                        $data = [
                            'kd_prodi'      => $this->prodi,
                            'nama'          => $this->input->post('nama'),
                            'username'      => $this->input->post('username'),
                            'email'         => $this->input->post('email'),
                            'level'         => dekrip($this->input->post('level'))
                        ];

                        $update = $this->universal->update($data, ['id' => $id], 'admin');
                        if ($update) {
                            if (dekrip($this->input->post('level')) == 8) {
                                $dataEkuliah = [
                                    'ekuliah_keys' => $this->keys_synckuliah,
                                    'username' => $this->input->post('username'),
                                    'nama' => $this->input->post('nama'),
                                    'kode_prodi' => $this->prodi,
                                ];
                                api_put($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'admin', true);
                            }
                            $this->notifikasi->success('Data berhasil diupdate');
                        }
                        redirect('admin/user', 'refresh');
                    }
                } elseif ($this->u3 == 'delete') {
                    $id = dekrip($this->u4);
                    $getUsername = $this->universal->getOneSelect('id,username,level', ['id' => $id], 'admin');
                    $delete = $this->universal->delete(['id' => $id], 'admin');
                    if ($delete) {
                        if ($getUsername->level == 8) {
                            $dataEkuliah = [
                                'ekuliah_keys' => $this->keys_synckuliah,
                                'username' => $getUsername->username
                            ];
                            api_delete($this->username_synckuliah, $this->password_synckuliah, $dataEkuliah, $this->urlApiSyncKuliah . 'admin', true);
                        }
                        $this->notifikasi->success('Data berhasil dihapus');
                    }
                    redirect('admin/user', 'refresh');
                } elseif ($this->u3 == 'reset') {
                    $id = dekrip($this->u4);
                    $data = [
                        'password'  => password_hash('phb123456', PASSWORD_BCRYPT, ['const' => 14])
                    ];
                    $update = $this->universal->update($data, ['id' => $id], 'admin');
                    if ($update) {
                        $this->notifikasi->success('Reset password sukses');
                    }
                    redirect('admin/user', 'refresh');
                } else {
                    $params = [
                        'title'         => 'Ref. Prodi',
                        'user'          => $this->admin->getUser(''),
                        'group'         => $this->universal->getMulti('', 'groups'),
                        'prodi'         => $this->universal->getMulti('', 'prodi')
                    ];
                    $this->load->view('user', $params);
                }
            }
        } elseif ($this->u2 == 'log_user') {
            $params = [
                'title'         => 'Ref. Prodi'
            ];

            $this->load->view('log_user', $params);
        }
    }

    private function _getLevel($id_level)
    {
        $group = $this->universal->getOne(['id' => $id_level], 'groups');

        if ($group->name == 'Prodi') {
            $this->form_validation->set_rules('kd_prodi', 'Prodi', 'required');
            $this->prodi = dekrip($this->input->post('kd_prodi'));
        } else {
            $this->prodi = null;
        }
    }
}

/* End of file User.php */