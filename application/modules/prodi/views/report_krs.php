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
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <label for="by_tahun">Tahun Masuk</label>
                <select class="form-control" name="by_tahun" id="by_tahun" data-placeholder="Silakan pilih tahun..">
                    <?php foreach ($tahun as $data) : ?>
                        <option value="<?= enkrip($data->tahun); ?>" <?= $th_ini == $data->tahun ? 'selected="selected"' : ''; ?>><?= $data->tahun; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Report KRS</h3>
                    <div class="block-options">
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NIM</th>
                                    <th>NAMA</th>
                                    <th>TAHUN MASUK</th>
                                    <th>JK</th>
                                    <th>JALUR</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($data_krs) || is_object($data_krs)) : ?>
                                    <?php foreach ($data_krs as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nim; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_lengkap ?></td>
                                            <td class="font-size-sm"><?= $hasil->tahun_masuk; ?></td>
                                            <td class="font-size-sm"><?= $hasil->jk ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_jalur; ?></td>
                                            <!-- <td>
                                                <span class="badge <?= ($hasil->status == 0) ? 'badge-warning' : 'badge-success'; ?>"><?= ($hasil->status == 0) ? 'Menunggu' : 'Setujui'; ?></span>
                                            </td> -->
                                            <td class="text-center" style="display: inline-flex;">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Lihat KRS" onclick="location.href='<?= base_url('prodi/reportkrs/detail/') . enkrip($hasil->nim); ?>';">
                                                    <i class="fa fa-fw fa-info"></i>
                                                </button>
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
    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?php echo base_url('prodi/reportkrs/') ?>' + tahun;
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/reportkrs') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/reportkrs') ?>"]').parent().parent().parent().addClass('open');
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>