<?php
$one->inc_sidebar                = APPPATH . 'views/inc/prodi/views/inc_sidebar.php';
$one->inc_header                 = APPPATH . 'views/inc/prodi/views/inc_header.php';
$one->inc_footer                 = APPPATH . 'views/inc/prodi/views/inc_footer.php';
$one->l_m_content                = 'narrow';
$one->main_nav                   = [
    [
        'name'  => 'Dashboard',
        'icon'  => 'si si-speedometer',
        'url'   => base_url('prodi')
    ],
    [
        'name'  => 'Master Data',
        'icon'  => 'fas fa-th',
        'sub'   => [
            [
                'name'  => 'Mata Kuliah',
                'url'   => base_url('prodi/mata_kuliah')
            ],
            [
                'name'  => 'Master Data Mahasiswa',
                'url'   => base_url('prodi/mahasiswa')
            ],
            [
                'name'  => 'Master Data Dosen ',
                'url'   => base_url('prodi/pegawai')
            ],
        ]
    ],
    [
        'name'  => 'Akademik',
        'icon'  => 'fa fa-school',
        'sub'   => [
            [
                'name'  => 'Atur Waktu KRS',
                'url'   => base_url('prodi/krs'),
            ],
            [
                'name'  => 'Set Kurikulum - Kelas Mahasiswa',
                'url'   => '',
            ],
            [
                'name'  => 'Mata Kuliah Tawarkan',
                'url'   => base_url('prodi/mk_tawarkan'),
            ],
            [
                'name'  => 'Kelas',
                'sub'   => [
                    [
                        'name'  => 'Pembagian Kelas',
                        'url'   => base_url('prodi/bagikelas')
                    ],
                    [
                        'name'  => 'Rombel Kelas',
                        'url'   => base_url('prodi/rombel')
                    ]
                ]
            ],
            [
                'name'  => 'Jadwal Kuliah',
                'url'   => base_url('prodi/jadwal'),
            ],
            [
                'name'  => 'Nilai Akhir',
                'url'   => base_url('prodi/nilai_akhir'),
            ],
            [
                'name'  => 'Daftar Sidang TA',
                'url'   => '',
            ]
        ]
    ],
    [
        'name'  => 'Kurikulum',
        'icon'  => 'fa fa-calendar',
        'sub'   => [
            [
                'name'  => 'Jenis Kurikulum',
                'url'   => base_url('prodi/kurikulum')
            ]
        ]
    ],
    [
        'name'  => 'Ujian',
        'icon'  => 'fa fa-book',
        'sub'   => [
            [
                'name'  => 'Nomor UTS',
                'url'   => '',
            ],
            [
                'name'  => 'Jadwal UTS',
                'url'   => '',
            ],
            [
                'name'  => 'Cetak Kartu UTS',
                'url'   => '',
            ],
            [
                'name'  => 'Nomor UAS',
                'url'   => '',
            ],
            [
                'name'  => 'Jadwal UAS',
                'url'   => '',
            ],
            [
                'name'  => 'Cetak Kartu UAS',
                'url'   => '',
            ],
            [
                'name'  => 'Absensi Ujian',
                'url'   => '',
            ],
            [
                'name'  => 'Tata Tertib Ujian',
                'url'   => ''
            ]
        ]
    ],
    [
        'name'  => 'Kemahasiswaan',
        'icon'  => 'si si-user',
        'sub'   => [
            [
                'name'  => 'Absensi Kemahasiswa',
                'url'   => '',
            ],
        ]
    ],
    [
        'name'  => 'Ruangan',
        'icon'  => 'fa fa-door-open',
        'sub'   => [
            [
                'name' => 'Ruang',
                'url'   => '',
            ]
        ]
    ],
    [
        'name'  => 'User Management',
        'icon'  => 'si si-users',
        'sub'   => [
            [
                'name'  => 'Ubah Password',
                'url'   => '',
            ],
            [
                'name'  => 'Login Dosen',
                'url'   => ''
            ],
            [
                'name'  => 'Login Mahasiswa',
                'url'   => ''
            ]
        ]
    ],
    [
        'name'  => 'Report',
        'icon'  => 'fa fa-print',
        'sub'   => [
            [
                'name'  => 'Report KRS',
                'url'   => base_url('prodi/reportkrs')
            ],
            [
                'name'  => 'Report KHS',
                'url'   => base_url('prodi/reportkhs')
            ],
            [
                'name'  => 'Nilai Akademik',
                'url'   => ''
            ],
            [
                'name'  => 'Report DKN Mahasiswa',
                'url'   => ''
            ],
            [
                'name'  => 'Total SKS PerSemester',
                'url'   => ''
            ],
            [
                'name'  => 'Matrik Nilai',
                'url'   => ''
            ],
            [
                'name'  => 'Jumlah Mahasiswa',
                'url'   => ''
            ],
            [
                'name'  => 'Lager Nilai',
                'url'   => ''
            ]
        ]
    ],
    [
        'name'  => 'Pengaturan',
        'icon'  => 'fa fa-cogs',
        'sub'   => [
            [
                'name'  => 'Pengaturan Dosen Pembimbing',
                'url'   => ''
            ],
            [
                'name'  => 'Tranfer Nilai',
                'url'   => ''
            ]
        ]
    ]
];
