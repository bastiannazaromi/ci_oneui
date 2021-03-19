<?php
$one->inc_header                 = APPPATH . 'views/inc/mahasiswa/views/inc_header.php';
$one->inc_footer                 = APPPATH . 'views/inc/mahasiswa/views/inc_footer.php';

$one->l_header_dark              = true;
$one->l_header_fixed             = false;

$one->l_m_content                = 'boxed';

$one->main_nav                   = array(
    array(
        'name'  => 'Dashboard',
        'icon'  => 'si si-compass',
        'url'   => base_url('mahasiswa')
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
                'name'  => 'Kalender Akademik',
                'url'   => base_url('mahasiswa/akademik/kalender')
            ),
            array(
                'name'  => 'Jadwal Perkuliahan',
                'url'   => base_url('mahasiswa/akademik/jadwal')
            ),
            array(
                'name'  => 'Isi Kartu Rencana Studi (KRS)',
                'url'   => base_url('mahasiswa/akademik/isi_krs')
            ),
            array(
                'name'  => 'Jadwal & Kartu Ujian',
                'url'   => base_url('mahasiswa/ujian/cetak_kartu')
            )
        )
    ),
    // array(
    //     'name'  => 'Ujian',
    //     'icon'  => 'si si-pencil',
    //     'sub'   => array(
    //         array(
    //             'name'  => 'Jadwal Ujian',
    //             'url'   => base_url('mahasiswa/ujian/jadwal')
    //         ),
    //         array(
    //             'name'  => 'Jadwal & Kartu Ujian',
    //             'url'   => base_url('mahasiswa/ujian/cetak_kartu')
    //         )
    //     )
    // ),
    array(
        'name'  => 'Laporan',
        'icon'  => 'si si-chart',
        'sub'   => array(
            array(
                'name'  => 'Nilai Akademik',
                'url'   => base_url('mahasiswa/laporan/nilai_akademik')
            ),
            array(
                'name'  => 'Nilai Kehadiran',
                'url'   => base_url('mahasiswa/laporan/nilai_kehadiran')
            ),
            array(
                'name'  => 'Riwayat Perkuliahan',
                'url'   => base_url('mahasiswa/laporan/riwayat_perkuliahan')
            ),
            array(
                'name'  => 'Kartu Rencana Studi (KRS)',
                'url'   => base_url('mahasiswa/laporan/krs')
            ),
            array(
                'name'  => 'Kartu Hasil Studi (KHS)',
                'url'   => base_url('mahasiswa/laporan/khs')
            ),
            array(
                'name'  => 'Daftar Nilai Mahasiswa (DNS)',
                'url'   => base_url('mahasiswa/laporan/dns')
            ),
            array(
                'name'  => 'Riwayat Studi',
                'url'   => base_url('mahasiswa/laporan/riwayat_studi')
            )
        )
    ),
    array(
        'name'  => 'Keuangan',
        'icon'  => 'si si-credit-card',
        'sub'   => array(
            array(
                'name'  => 'Daftar Tagihan',
                'url'   => base_url('mahasiswa/tagihan')
            ),
            array(
                'name'  => 'Riwayat Pembayaran',
                'url'   => base_url('mahasiswa/tagihan/riwayat')
            )
        )
    )
);
