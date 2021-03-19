<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 mb-3 text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Back" onclick="location.href='<?= $this->session->userdata('previous_url'); ?>';">
                <i class="fa fa-fw fa-arrow-left"></i> back to Kelas
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Master Mahasiswa</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <?php echo form_open('prodi/bagikelas/addmhs', ['class' => 'form-add']); ?>
                        <input type="hidden" class="form-control" name="id_kelas" value="<?= enkrip($kelas->id); ?>">
                        <input type="hidden" class="form-control" name="kelas" value="<?= enkrip($kelas->kelas); ?>">
                        <input type="hidden" class="form-control" name="semester" value="<?= enkrip($kelas->semester); ?>">
                        <input type="hidden" class="form-control" name="prodi" value="<?= enkrip($kelas->prodi); ?>">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>kelas</th>
                                    <th><i class="fa fa-fw fa-plus text-info"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($mhs) || is_object($mhs)) : ?>
                                    <?php foreach ($mhs as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nim; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_lengkap; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kelas; ?></td>
                                            <td>
                                                <input type="checkbox" class="check-item" name="nim[]" value="<?= $hasil->nim ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <?php if ($mhs) : ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right">
                                            <button type="button" class="btn btn-success btn-sm tombol-add" data-text="data akan ditambahkan ke kelas"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?>
                        </table>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Anggota Kelas <?= $kelas->nama_kelas; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th><i class="fa fa-fw fa-times text-danger"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($bagikelas) || is_object($bagikelas)) : ?>
                                    <?php foreach ($bagikelas as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nim; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_lengkap; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm tombol-hapus" data-href="<?= base_url('prodi/bagikelas/anggota/out/') . enkrip($hasil->nim); ?>" data-text="mahasiswa akan dikeluarkan dari kelas"><i class="fa fa-times"></i></button>
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

<!-- END Page Content -->
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $one->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/dataTables.bootstrap4.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/buttons/dataTables.buttons.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/buttons/buttons.print.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/buttons/buttons.html5.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/buttons/buttons.flash.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/buttons/buttons.colVis.min.js'); ?>

<!-- Page JS Code -->
<?php $one->get_js('js/pages/be_tables_datatables.min.js'); ?>
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>


<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<script>
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/bagikelas') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/bagikelas') ?>"]').parent().parent().parent().addClass('open');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/bagikelas') ?>"]').parent().parent().parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>