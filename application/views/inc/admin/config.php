<?php
$one->inc_sidebar                = APPPATH . 'views/inc/admin/views/inc_sidebar.php';
$one->inc_header                 = APPPATH . 'views/inc/admin/views/inc_header.php';
$one->inc_footer                 = APPPATH . 'views/inc/admin/views/inc_footer.php';
$one->l_m_content                = 'narrow';
$one->main_nav                   = [
    [
        'name'  => 'Dashboard',
        'icon'  => 'si si-speedometer',
        'url'   => base_url('admin')
    ],
    [
        'name'  => 'Tabel Ref',
        'icon'  => 'si si-layers',
        'sub'   => [
            [
                'name'  => 'Ref. Program Studi',
                'url'   => base_url('admin/prodi')
            ],
            [
                'name'  => 'Agama',
                'url'   => base_url('admin/agama')
            ],
            [
                'name'  => 'Jalur Pendaftaran',
                'url'   => base_url('admin/jalur')
            ],
            [
                'name'  => 'Status Pegawai',
                'url'   => base_url('admin/statuspeg')
            ],
            [
                'name'  => 'Status Mahasiswa',
                'url'   => base_url('admin/statusmhs')
            ]
        ]
    ],
    [
        'name'  => 'Setting Aplikasi',
        'icon'  => 'si si-settings',
        'sub'   => [
            [
                'name'  => 'Keamanan',
                'url'   => ''
            ],
            [
                'name'  => 'Pengaturan Waktu Nilai',
                'url'   => base_url('admin/setnilai')
            ],
            [
                'name'  => 'Mode dan Bobot Nilai',
                'url'   => base_url('admin/setbobotnilai')
            ],
            [
                'name'  => 'Master Waktu Wisuda',
                'url'   => ''
            ],
            [
                'name'  => 'Token Nilai',
                'url'   => ''
            ],
            [
                'name'  => 'Web Service API',
                'url'   => base_url('admin/setwsapi')
            ]
        ]
    ],
    [
        'name'  => 'User Management',
        'icon'  => 'si si-user',
        'sub'   => [
            [
                'name'  => 'Grup User',
                'url'   => base_url('admin/group')
            ],
            [
                'name'  => 'User Admin Manager',
                'url'   => base_url('admin/user')
            ],
            [
                'name'  => 'Log User',
                'url'   => ''
            ]
        ]
    ]
];
