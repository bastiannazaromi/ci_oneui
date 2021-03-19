<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ref_fakultas extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        admin_init();
    }

    function index()
    {
        if ($this->u2 == 'fakultas')
        {
            $params = [
                'title'         => 'Ref. Fakultas'
            ];
            $this->load->database();

            $data = $this->db->get('fakultas')->result();
            echo json_encode($data); die();
            $this->load->view('fakultas', $params);
        }
    }

}

/* End of file Ref_fakultas.php */