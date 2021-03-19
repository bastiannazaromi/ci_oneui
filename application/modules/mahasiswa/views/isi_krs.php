<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2 text-center text-sm-left">
            <div class="flex-sm-fill">
                <h1 class="h3 font-w700 mb-2">
                    Pengisian Kartu Rencana Studi (KRS)
                </h1>
                <h2 class="h6 font-w500 text-muted mb-0">
                    <?php if (!$waktu_krs) : ?>
                        Waktu Pengisian KRS Semester <?php echo ($tahun_akademik->periode == 1) ? 'Ganjil' : 'Genap' ?> telah ditutup.
                    <?php else : ?>
                        Halaman pengisian KRS mahasiswa Semester <?php echo ($tahun_akademik->periode == 1) ? 'Ganjil' : 'Genap' ?>.
                    <?php endif; ?>
                </h2>
            </div>
            <div class="mt-3 mt-sm-0 ml-sm-3">
                <a class="nav-link" href="javascript:void(0)">
                    <span class="font-size-sm font-w600 px-3 py-2 rounded btn-alt-primary">Tahun Akademik <?php echo $tahun_akademik->tahun_akademik ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <?php if ($waktu_krs) : ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Halaman Pengisian Kartu Studi Mahasiswa</h3>
                    </div>
                    <div class="block-content">
                        <div class="table-responsive">
                            <form action="<?php echo base_url('mahasiswa/akademik/ambil_krs') ?>" method="post">
                                <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                <table class="js-table-checkable table table-hover table-vcenter js-table-checkable-enabled">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kurikulum</th>
                                            <th class="text-center">Mata Kuliah</th>
                                            <th class="text-center">Jenis MK</th>
                                            <th class="d-sm-table-cell text-center" style="width: 15%;">SKS</th>
                                            <th class="text-center">Semester</th>
                                            <th class="d-sm-table-cell text-center" style="width: 20%;">Status</th>
                                            <th class="text-center" style="width: 70px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($krs as $row) : ?>
                                            <?php
                                            $status = $this->universal->getMulti(['id_th' => $tahun_akademik->id, 'nim' => $this->user->nim, 'kode_mk' => $row->kode_mk], 'krs');
                                            ?>
                                            <tr>
                                                <td class="font-size-sm text-center">
                                                    <p class="text-muted mb-0"><?php echo $no++ ?></p>
                                                </td>
                                                <td class="font-size-sm text-center">
                                                    <p class="text-muted mb-0"><?php echo $row->keterangan_kurikulum ?></p>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <span class="badge badge-primary"><?php echo $row->nama_mk ?></span>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <p class="font-size-sm text-muted" style="text-transform: uppercase;"><?php echo $row->jenis_mk ?></p>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <p class="font-size-sm text-muted"><?php echo $row->sks ?></p>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <p class="font-size-sm text-muted"><?php echo $row->semester ?></p>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <span class="badge <?php echo ($status[0]->status == 1) ? 'badge-primary' : 'badge-danger' ?>"><?php echo ($status[0]->status == 1) ? 'Setujui' : 'Menunggu' ?></span>
                                                </td>
                                                <?php if (!$status) : ?>
                                                    <td class="text-center">
                                                        <div class="custom-control custom-checkbox d-inline-block">
                                                            <input type="checkbox" id="nik" value="<?php echo enkrip($row->kode_mk) ?>" name="checkbox[]">
                                                        </div>
                                                    </td>
                                                <?php else : ?>
                                                    <td class="text-center">
                                                        <div class="custom-control custom-checkbox d-inline-block">
                                                            <input type="checkbox" id="nik" value="<?php echo enkrip($row->kode_mk) ?>" name="checkbox[]" <?php echo ($status) ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <?php if (!$status) : ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10"><button type="submit" class="btn btn-primary" style="float: right;">Ambil</button></td>
                                            </tr>
                                        </tfoot>
                                    <?php endif; ?>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>