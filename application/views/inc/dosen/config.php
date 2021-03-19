<?php

$one->inc_header                 = APPPATH . 'views/inc/dosen/views/inc_header.php';
$one->inc_footer                 = APPPATH . 'views/inc/dosen/views/inc_footer.php';

$one->l_header_dark              = true;
$one->l_header_fixed             = false;

$one->l_m_content                = 'boxed';

$one->main_nav                   = array(
    array(
        'name'  => 'Dashboard',
        'icon'  => 'si si-compass',
        'url'   => base_url('dosen')
    ),
    array(
        'name'  => 'Menu',
        'type'  => 'heading'
    ),
    array(
        'name'  => 'Akademik',
        'icon'  => 'si si-graduation',
        'sub'   => array(
            array(
                'name'  => 'Jadwal Kuliah',
                'url'   => base_url('dosen/akademik/jadwal')
            ),
            array(
                'name'  => 'Mahasiswa Bimbingan',
                'url'   => base_url('dosen/akademik/bimbingan')
            )
        )
    ),
    array(
        'name'  => 'Nilai',
        'icon'  => 'si si-pencil',
        'sub'   => array(
            array(
                'name'  => 'Set Komposisi Nilai',
                'url'   => base_url('dosen/nilai/komposisi_nilai')
            ),
            array(
                'name'  => 'Input Nilai',
                'url'   => base_url('dosen/nilai/input_nilai')
            )
        )
    ),
    array(
        'name'  => 'Data',
        'icon'  => 'si si-chart',
        'sub'   => array(
            array(
                'name'  => 'Profil',
                'url'   => base_url('dosen/profil')
            )
        )
    )
);
