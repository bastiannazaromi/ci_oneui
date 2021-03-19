<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');
class Kelas extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model', 'universal');
    }
    public function index_put()
    {
        $a = $this->put('a');

        $data = [
            'a'     => $a
        ];

        $this->db->insert('a', $data);
    }
}

/* End of file Kelas.php */