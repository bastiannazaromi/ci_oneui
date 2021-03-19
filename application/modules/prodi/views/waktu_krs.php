<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>

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
                        <a class="nav-link" href="#nilai_lulus">NILAI KELULUSAN</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="nav-link" href="javascript:void(0)">
                            <span class="font-w600 px-2 py-2 btn-alt-primary"><i class="fa fa-fw fa-calendar-alt"></i>
                                Tahun Akademik <?php echo $tahun_akademik[0]->tahun_akademik ?></span>
                        </a>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home" role="tabpanel">
                        <h4 class="font-w400">Rule KRS Mahasiswa</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Jenis</th>
                                        <th>Awal</th>
                                        <th>Akhir</th>
                                        <th>Update At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php if (is_array($krs) || is_object($krs)) : ?>
                                        <?php foreach ($krs as $hasil) : ?>
                                            <tr>
                                                <td class="text-center font-size-sm"><?= $i++; ?></td>
                                                <td class="font-size-sm"><?= $hasil->jenis; ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->awal == null) ? 'Kosong' : $hasil->awal ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->akhir == null) ? 'kosong' : $hasil->akhir ?></td>
                                                <td class="font-size-sm"><?= $hasil->updated_at; ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-primary edit_btn" data-toggle="modal" data-target="#modal-edit" data-id_krs="<?= enkrip($hasil->id); ?>" title="Edit">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
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
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Jenis</th>
                                        <th>Awal</th>
                                        <th>Akhir</th>
                                        <th>Update At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php if (is_array($krs_susulan) || is_object($krs_susulan)) : ?>
                                        <?php foreach ($krs_susulan as $hasil) : ?>
                                            <tr>
                                                <td class="text-center font-size-sm"><?= $i++; ?></td>
                                                <td class="font-size-sm"><?= $hasil->jenis; ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->awal == null) ? 'Kosong' : $hasil->awal ?></td>
                                                <td class="font-size-sm"><?php echo ($hasil->akhir == null) ? 'kosong' : $hasil->akhir ?></td>
                                                <td class="font-size-sm"><?= $hasil->updated_at; ?></td>
                                                <td class="text-center" style="display: inline-flex;">
                                                    <button type="button" class="btn btn-sm btn-primary edit_btn_susulan" data-toggle="modal" data-target="#modal-edit-susulan" data-id_krs="<?= enkrip($hasil->id); ?>" title="Edit">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade fade-up" id="nilai_lulus" role="tabpanel">
                        <h4 class="font-w400">Syarat Nilai Lulus</h4>
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Nilai</th>
                                    <th class="text-center">Huruf</th>
                                    <th class="text-center" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center" scope="row">1</th>
                                    <td class="font-w600 font-size-sm">
                                        <form action="<?= base_url('prodi/krs/nilai_min'); ?>" method="post">
                                            <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                            <select name="nilai" id="nilai" class="form-control">
                                                <option value="">-- Pilih Minimal</option>
                                                <option <?php echo ($nilai_min->nilai_min == 'A') ? 'selected' : '' ?> value="A">81 - 100 (A)</option>
                                                <option <?php echo ($nilai_min->nilai_min == 'B') ? 'selected' : '' ?> value="B">69 - 80.9 (B)</option>
                                                <option <?php echo ($nilai_min->nilai_min == 'C') ? 'selected' : '' ?> value="C">60 - 68.9 (C)</option>
                                                <option <?php echo ($nilai_min->nilai_min == 'D') ? 'selected' : '' ?> value="D">49 - 59.9 (D)</option>
                                                <option <?php echo ($nilai_min->nilai_min == 'E') ? 'selected' : '' ?> value="E">0 - 48.9 (E)</option>
                                            </select>
                                    </td>
                                    <td class="text-center">
                                        <p><?php echo $nilai_min->nilai_min ?></p>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit Nilai" data-original-title="Edit Nilai">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                        </div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit -->
<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Edit Waktu Krs</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/krs/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <div class="input-daterange input-group js-datepicker-enabled" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <input type="date" class="form-control" id="awal" name="awal" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-right"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" id="akhir" name="akhir" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
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
<div class="modal" id="modal-edit-susulan" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Edit Waktu Krs Susulan</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/krs/edit_susulan'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id_susulan" id="id_susulan">
                        <div class="form-group">
                            <div class="input-daterange input-group js-datepicker-enabled" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <input type="date" class="form-control" id="awal_susulan" name="awal_susulan" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-right"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control" id="akhir_susulan" name="akhir_susulan" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
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
        One.helpers(['datepicker']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>