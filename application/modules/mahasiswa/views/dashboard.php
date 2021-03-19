<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <a class="block block-rounded block-link-pop" href="<?php echo base_url('mahasiswa/profil') ?>">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Informasi Mahasiswa</h3>
                            </div>
                            <div class="block-content">
                                <div class="row">
                                    <div class="col-sm-3 text-center">
                                        <div class="mb-3 py-1">
                                            <img class="img-thumbnail" style="width: 120px;" src="
                                            <?= ($this->user->foto == 'default.jpg' || $this->user->foto == '') ? base_url('upload/default.jpg') :
                                                base_url('upload/mhs/' . $this->user->foto)
                                            ?>
                                            " alt="<?= $this->user->nama_lengkap; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-9 py-2">
                                        <div class="font-size-h3 font-w600"><?= $this->user->nama_lengkap; ?> <sup><span class="badge badge-success"><?= $this->user->nama_status ?></span></sup></div>
                                        <address class="font-size-sm">
                                            <p class="font-size-h6"><b>NIM:</b> <?= $this->user->nim; ?><br><b> <?= $this->user->jenjang . ' ' . $this->user->nama_prodi ?></b> | <b>Semester <?= $this->user->semester ?></b><br><b class="font-size-h5">IPk:</b> 3.85 | <b class="font-size-h5">SKSk:</b> 21</p>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Jadwal Perkuliahan Hari Ini</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <span class="badge"><?php echo hari(date('N')) ?>, <?php echo tanggal(date('Y-m-d')) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Waktu</th>
                                            <th>Mata Kuliah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($jadwal_hari_ini['status'] == false) : ?>
                                            <tr>
                                                <td colspan="2" class="text-center font-size-sm font-w600 text-muted">Tidak Ada Jadwal Hari Ini </td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($jadwal_hari_ini['message'] as $jadwal) : ?>
                                                <tr <?php echo $jadwal['jam_sekarang'] ?>>
                                                    <td class="text-center font-size-sm font-w600 text-muted"><?php echo $jadwal['jadwal']['jadwal_jammulai'] ?> - <?php echo $jadwal['jadwal']['jadwal_jamselesai'] ?></td>
                                                    <td class="font-size-sm font-w600">
                                                        <?php echo $jadwal['jadwal']['makul_nama'] ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Kalender Akademik</h3>
                        </div>
                        <div class="block-content block-content-full pt-2">
                            <div class="font-size-h1 font-w400 text-dark"><?= $kalender_akademik->th_awal ?>/<?= $kalender_akademik->th_akhir ?></div><small>Semester Ganjil</small>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Jadwal Perkuliahan</h3>
                        </div>
                        <div class="block-content block-content-full pt-2">
                            <div class="font-size-h1 font-w400 text-dark">Semester 1</div><small>Th. 2021/2022 | Kelas
                                1A</small>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="block block-rounded block-link-pop" href="<?php echo base_url('mahasiswa/absensi/scanner') ?>">
                        <div class="block block-rounded">
                            <div class="block-content block-content-full">
                                <div class="text-center py-3">
                                    <p>
                                        <i class="fas fa-4x fa-qrcode"></i>
                                    </p>
                                    <h4 class="mb-0">Absensi Scanner</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="block block-rounded block-link-pop" href="<?php echo base_url('mahasiswa/tagihan') ?>">
                        <div class="block block-rounded">
                            <div class="block-content block-content-full">
                                <div class="text-center py-3">
                                    <p>
                                        <i class="fas fa-4x fa-money-check"></i>
                                    </p>
                                    <h4 class="mb-0">Tagihan Kuliah</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                        <div class="block block-rounded">
                            <div class="block-content block-content-full">
                                <div class="text-center py-3">
                                    <p>
                                        <i class="fas fa-4x fa-tasks"></i>
                                    </p>
                                    <h4 class="mb-0">Riwayat Perkuliahan</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>