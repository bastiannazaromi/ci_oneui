<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/management/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>

<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideup-home">KRS MHS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-profile">KRS SUSULAN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript(void:0)" data-toggle="modal" data-target="#modal-add-krs">
                            <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-info text-white"><i class="fa fa-plus"></i> KRS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript(void:0)" data-toggle="modal" data-target="#modal-add-susulan">
                            <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-info text-white"><i class="fa fa-plus"></i> KRS Susulan</span>
                        </a>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home" role="tabpanel">
                        <h4 class="font-w400">Rule KRS Mahasiswa</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter start-at-25">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Prodi</th>
                                        <th>Jenis</th>
                                        <th>Awal</th>
                                        <th>Akhir</th>
                                        <th>Nilai Minimal</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php if (is_array($krs) || is_object($krs)) : ?>
                                        <?php foreach ($krs as $hasil) : ?>
                                            <tr>
                                                <td class="text-center font-size-sm"><?= $i++; ?></td>
                                                <td class="font-size-sm"><?= prodi($hasil->kd_prodi); ?></td>
                                                <td class="font-size-sm"><?= $hasil->jenis; ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->awal == null) ? 'Kosong' : $hasil->awal ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->akhir == null) ? 'kosong' : $hasil->akhir ?></td>
                                                <td class="font-size-sm"><?= $hasil->nilai_min; ?></td>
                                                <td class="text-center" style="display: inline-flex;">
                                                    <button type="button" data-href="<?= base_url('management/krs/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
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
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile" role="tabpanel">
                        <h4 class="font-w400">Rule KRS Susulan Mahasiswa</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter start-at-25">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Prodi</th>
                                        <th>Jenis</th>
                                        <th>Awal</th>
                                        <th>Akhir</th>
                                        <th>Nilai Minimal</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php if (is_array($krs_susulan) || is_object($krs_susulan)) : ?>
                                        <?php foreach ($krs_susulan as $hasil) : ?>
                                            <tr>
                                                <td class="text-center font-size-sm"><?= $i++; ?></td>
                                                <td class="font-size-sm"><?= prodi($hasil->kd_prodi); ?></td>
                                                <td class="font-size-sm"><?= $hasil->jenis; ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->awal == null) ? 'Kosong' : $hasil->awal ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->akhir == null) ? 'kosong' : $hasil->akhir ?></td>
                                                <td class="font-size-sm"><?= $hasil->nilai_min; ?></td>
                                                <td class="text-center" style="display: inline-flex;">
                                                    <button type="button" data-href="<?= base_url('management/krs/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
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
    </div>
</div>
<!-- Modal add krs -->
<div class="modal" id="modal-add-krs" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Add Waktu Krs</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/krs/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="awal">Prgram Studi</label>
                            <div class="input-group">
                                <select class="js-select2 form-control" name="prodi" style="width: 75%;" data-placeholder="Choose one..">
                                    <option></option>
                                    <option>UPT / Wadir / Lainnya</option>
                                    <?php foreach ($prodi as $data) : ?>
                                        <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-slash fa-rotate-90"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="periode">
                                    <option value="<?= enkrip(1); ?>">Ganjil</option>
                                    <option value="<?= enkrip(2); ?>">Genap</option>
                                </select>
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
<div class="modal" id="modal-add-susulan" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Add Waktu Krs Susulan</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/krs/add_susulan'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="awal">Prgram Studi</label>
                            <div class="input-group">
                                <select class="js-select2 form-control" name="prodi" style="width: 75%;" data-placeholder="Choose one..">
                                    <option></option>
                                    <option>UPT / Wadir / Lainnya</option>
                                    <?php foreach ($prodi as $data) : ?>
                                        <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-slash fa-rotate-90"></i>
                                    </span>
                                </div>
                                <select class="form-control" name="periode">
                                    <option value="<?= enkrip(1); ?>">Ganjil</option>
                                    <option value="<?= enkrip(2); ?>">Genap</option>
                                </select>
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
<!-- END Page Content -->
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $one->get_js('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/dataTables.bootstrap4.min.js'); ?>

<!-- Page JS Code -->
<?php $one->get_js('js/pages/be_tables_datatables.min.js'); ?>

<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>
<script>
    let tombol_edit = $('.edit_btn');
    let tombol_edit_susulan = $('.edit_btn_susulan');
    $(tombol_edit_susulan).each(function(i) {
        $(tombol_edit_susulan[i]).click(function() {
            let id = $(this).data('id_krs');
            $.ajax({
                url: '<?php echo base_url('prodi/krs/getOneSusulan/') ?>' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(respon) {
                    console.log(respon);
                    $('#id_susulan').val(respon.id);
                    $('#awal_susulan').val(respon.awal);
                    $('#akhir_susulan').val(respon.akhir);
                },
                error: function(e) {
                    console.log(e);
                }
            })
        });
    });
    $(tombol_edit).each(function(i) {
        $(tombol_edit[i]).click(function() {
            let id = $(this).data('id_krs');
            $.ajax({
                url: '<?php echo base_url('prodi/krs/getOne/') ?>' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(respon) {
                    $('#id').val(respon.id);
                    $('#awal').val(respon.awal);
                    $('#akhir').val(respon.akhir);
                },
                error: function(e) {
                    console.log(e);
                }
            })
        });
    });
    jQuery(function() {
        One.helpers(['datepicker', 'select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>