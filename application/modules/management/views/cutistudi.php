<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/management/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>

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
                        <option value="<?= enkrip($data->kd_prodi); ?>" <?= $prodi_i == $data->kd_prodi ? 'selected="selected"' : ''; ?>><?= $data->nama; ?></option>
                    <?php endforeach; ?>
                    <option value="<?= enkrip(111); ?>" <?= $prodi_i == 111 ? 'selected="selected"' : ''; ?>>Semua
                    </option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_tahun" id="by_tahun" style="width: 100%;" data-placeholder="Silakan pilih tahun akademik..">
                    <option></option>
                    <?php foreach ($tahun as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $data->id == $th_ini ? 'selected="selected"' : ''; ?>>
                            <?= $data->tahun_akademik; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Cuti Studi</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Prodi</th>
                                    <th>Tahun</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Nomor Surat</th>
                                    <th>Semester</th>
                                    <th>Mulai Cuti</th>
                                    <th>Lama Cuti</th>
                                    <th>keterangan</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($cuti) || is_object($cuti)) : ?>
                                    <?php foreach ($cuti as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_prodi; ?></td>
                                            <td class="font-size-sm"><?= $hasil->tahun_akademik; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nim; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_lengkap; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nomor; ?></td>
                                            <td class="font-size-sm"><?= $hasil->semester; ?></td>
                                            <td class="font-size-sm"><?= 'Smst ' . $hasil->mulai; ?></td>
                                            <td class="font-size-sm"><?= $hasil->lama . ' Tahun'; ?></td>
                                            <td class="font-size-sm"><?= $hasil->ket; ?></td>

                                            <td class="text-center">
                                                <button type="button" data-href="<?= base_url('management/cutistudi/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
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
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromright modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Tambah Data Cuti</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <form action="<?= base_url('management/cutistudi/add'); ?>" method="post">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="nim">Mahasiswa</label>
                                <select class="form-control basicAutoSelect" name="nim" id="nim" placeholder="Cari mahasiswa..." data-url="<?= base_url('management/cutistudi/getMhs/?'); ?>" autocomplete="off"></select>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun Akademik</label>
                                <select class="js-select2 form-control" name="tahun" style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option>
                                    <?php foreach ($tahun as $data) : ?>
                                        <option value="<?= enkrip($data->id); ?>"><?= $data->tahun_akademik; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nomor">Nomor Surat</sup></label>
                                <input type="text" class="form-control" name="nomor" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="mulai">Semester Mulai Cuti</label>
                                <select class="form-control" name="mulai">
                                    <option value="">-- Pilih --</option>
                                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                                        <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lama">Lama Cuti <sup>* (Tahun)</sup></label>
                                <input type="number" class="form-control" name="lama" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="2" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="ket">Keterangan</label>
                                <textarea name="ket" class="form-control" cols="20" rows="10"></textarea>
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
</div>
<!-- End Modal Add -->

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

<?php $one->get_js('autocomplete/bootstrap-autocomplete.min.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    $('.basicAutoSelect').autoComplete({
        minLength: 2
    });

    $('#by_prodi').change(function() {
        let prodi = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/cutistudi/'); ?>' + prodi + '<?= $th_ini; ?>';
    });

    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/cutistudi/') . enkrip($prodi_i) . '/'; ?>' + tahun;
    });
    $('li.nav-main-item').find('a[href*="<?= base_url('management/cutistudi') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('management/cutistudi') ?>"]').parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>