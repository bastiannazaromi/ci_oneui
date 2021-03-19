<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dosen extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        dosen_init();
    }

    function index()
    {
        $params = array(
            'title'             => 'Dashboard',
            'kalender_akademik' =>  $this->universal->getOne(['status' => 1], 'tahun_akademik')
        ); 
         
        $this->load->view('dashboard', $params);
    }
    

}
