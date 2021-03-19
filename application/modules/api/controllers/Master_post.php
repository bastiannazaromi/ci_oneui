<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
class Master_post extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_api', 'api');
    }
    public function index_post()
    {
        $data = [
            'kode_mp' => $this->post('kode_mp'),
            'nama_mp' => $this->post('nama_mp'),
        ];
        $insert = $this->universal->insert($data, 'master_post');
        if ($insert) {
            $response = [
                'status' => true,
                'message' => 'Berhasil input'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal input'
            ];
        }
        $this->response($response, 200);
    }
}

/* End of file Master_post.php */
