<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/management/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>

<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="content">

    <div class="row">
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_prodi" id="by_prodi" style="width: 100%;" data-placeholder="Silakan pilih prodi..">
                    <option></option>
                    <?php foreach ($prodi as $data) : ?>
                        <option value="<?= enkrip($data->kd_prodi); ?>" <?= $prodi_ini == $data->kd_prodi ? 'selected="selected"' : ''; ?>><?= $data->nama; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_tahun" id="by_tahun" style="width: 100%;" data-placeholder="Silakan pilih tahun..">
                    <option></option>
                    <?php foreach ($tahun as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $th_ini == $data->id ? 'selected="selected"' : ''; ?>><?= $data->tahun_akademik; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Bobot Nilai</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>range Angka</th>
                                    <th>Huruf</th>
                                    <th>Bobot</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($bobot) || is_object($bobot)) : ?>
                                    <?php foreach ($bobot as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->angka_awal . ' - ' . $hasil->angka_akhir; ?></td>
                                            <td class="font-size-sm"><?= $hasil->huruf; ?></td>
                                            <td class="font-size-sm"><?= $hasil->bobot; ?></td>
                                            <td class="text-center">
                                                <button type="button" data-href="<?= base_url('management/bobotnilai/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-fw fa-times"></i>
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
    <!-- END Dynamic Table Full Pagination -->

</div>
<!-- END Page Content -->

<!-- Modal Add -->
<div class="modal" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Bobot Nilai</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/bobotnilai/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="prodi" style="width: 100%;" data-placeholder="Silakan pilih prodi..">
                                <option></option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="th_akademik">Tahun Akademik</label>
                            <select class="js-select2 form-control" name="th_akademik" style="width: 100%;" data-placeholder="Silakan pilih tahun..">
                                <option></option>
                                <?php foreach ($tahun as $data) : ?>
                                    <option value="<?= enkrip($data->id); ?>"><?= $data->tahun_akademik; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="huruf">Huruf</label>
                            <select class="form-control" name="huruf">
                                <option>-- Pilih Huruf</option>
                                <option value="<?= enkrip('A'); ?>">A</option>
                                <option value="<?= enkrip('B'); ?>">B</option>
                                <option value="<?= enkrip('C'); ?>">C</option>
                                <option value="<?= enkrip('D'); ?>">D</option>
                                <option value="<?= enkrip('E'); ?>">E</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="awal">Angka</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="angka_awal" autocomplete="off" placeholder="From">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-slash fa-rotate-90"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="angka_akhir" autocomplete="off" placeholder="To">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>

<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    let edit_btn = $('.edit_btn');

    $('#by_prodi').change(function() {
        let prodi = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/bobotnilai/'); ?>' + prodi;
    });

    $('#by_tahun').change(function() {
        let prodi = $('#by_prodi').find(':selected').val();
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/bobotnilai/'); ?>' +
            prodi + '/' + tahun;
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('management/bobotnilai') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('management/bobotnilai') ?>"]').parent().parent().parent().addClass('open');


    jQuery(function() {
        One.helpers(['select2', 'maxlength']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>