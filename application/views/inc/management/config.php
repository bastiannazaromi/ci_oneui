<?php
$one->inc_sidebar                = APPPATH . 'views/inc/management/views/inc_sidebar.php';
$one->inc_header                 = APPPATH . 'views/inc/management/views/inc_header.php';
$one->inc_footer                 = APPPATH . 'views/inc/management/views/inc_footer.php';
$one->l_m_content                = 'narrow';
$one->main_nav                   = [
    [
        'name'  => 'Dashboard',
        'icon'  => 'si si-speedometer',
        'url'   => base_url('management')
    ],
    [
        'name'  => 'Tabel Ref',
        'icon'  => 'si si-layers',
        'sub'   => [
            [
                'name'  => 'Tahun Akademik',
                'url'   => base_url('management/tahunakademik')
            ],
            [
                'name'  => 'Kalender Akademik',
                'url'   => ''
            ],
            [
                'name'  => 'Gedung',
                'url'   => base_url('management/gedung')
            ],
            [
                'name'  => 'Ruang',
                'url'   => base_url('management/ruang')
            ],
            [
                'name'  => 'Ka. Prodi',
                'url'   => base_url('management/kaprodi')
            ],
            [
                'name'  => 'Direktur',
                'url'   => base_url('management/direktur')
            ],
            [
                'name'  => 'Prog. Studi',
                'url'   => base_url('management/prodi')
            ],
            [
                'name'  => 'Master Kelas',
                'url'   => base_url('management/kelas')
            ],
            [
                'name'  => 'Atur Waktu KRS',
                'url'   => base_url('management/krs')
            ],
            [
                'name'  => 'Jam Kuliah',
                'url'   => base_url('management/jamkuliah')
            ],
            [
                'name'  => 'Bobot Nilai',
                'url'   => base_url('management/bobotnilai')
            ],
        ]
    ],
    [
        'name'  => 'Ruangan',
        'icon'  => 'fa fa-door-open',
        'sub'   => [
            [
                'name'  => 'Ruangan',
                'url'   => ''
            ]
        ]
    ],
    [
        'name'  => 'Kemahasiswaan',
        'icon'  => 'si si-user',
        'sub'   => [
            [
                'name'  => 'Master Data',

                'sub'   => prodi_menu()
            ],
            [
                'name'  => 'Cuti Studi',
                'url'   => base_url('management/cutistudi')
            ]
        ]
    ],
    [
        'name'  => 'Pegawai',
        'icon'  => 'si si-users',
        'sub'   => [
            [
                'name'  => 'Daftar Pegawai',
                'url'   => base_url('management/pegawai')
            ]
        ]
    ],
    [
        'name'  => 'Wisuda',
        'icon'  => 'si si-graduation',
        'sub'   => [
            [
                'name'  => 'Informasi Wisuda',
                'url'   => ''
            ],
            [
                'name'  => 'Daftar Lulus Sidang TA/TKI',
                'url'   => ''
            ],
            [
                'name'  => 'Pembayaran Registrasi Wisuda',
                'url'   => ''
            ],
            [
                'name'  => 'Daftar Wisuda Online',
                'url'   => ''
            ]
        ]
    ]
];
