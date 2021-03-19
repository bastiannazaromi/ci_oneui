<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        mhs_init();
    }
    function scanner()
    {
        $params = array('title' => 'Scanner Absen | OASEPHB');
        $this->load->view('scanner', $params);
    }
}
