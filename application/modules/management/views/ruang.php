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
        <div class="col-sm-12 col-xl-12">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_gedung" id="by_gedung" style="width: 100%;" data-placeholder="Silakan pilih gedung..">
                    <option></option>
                    <?php foreach ($gedung as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= ($data->id == $id_gedung) ? 'selected="selected"' : ''; ?>><?= $data->nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">List Ruang</h3>
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
                                    <th>Nama Gedung</th>
                                    <th>Nama Ruang</th>
                                    <th>Kapasitas</th>
                                    <th>Create At</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($ruang) || is_object($ruang)) : ?>
                                    <?php foreach ($ruang as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_prodi; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_gedung; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_ruang; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kapasitas; ?></td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning edit_btn" data-toggle="modal" data-target="#modal-edit" data-id_ruang="<?= enkrip($hasil->id); ?>" data-gedung="<?= enkrip($hasil->id_gedung); ?>" data-prodi="<?= enkrip($hasil->kd_prodi); ?>" title="Edit">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" data-href="<?= base_url('management/gedung/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
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
                    <h3 class="block-title text-center">Ruang</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/ruang/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="prodi" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <option>UPT / Wadir / Lainnya</option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Gedung</label>
                            <select class="js-select2 form-control" name="gedung" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($gedung as $data) : ?>
                                    <option value="<?= enkrip($data->id); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Ruang</label>
                            <input type="text" class="form-control" name="nama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kapasitas</label>
                            <input type="number" class="form-control" min="1" max="100" name="kapasitas" required autocomplete="off">
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

<!-- Modal Edit -->
<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Gedung</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('management/ruang/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="prodi" id="prodi" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <option>UPT / Wadir / Lainnya</option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Gedung</label>
                            <select class="js-select2 form-control" name="gedung" id="gedung" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($gedung as $data) : ?>
                                    <option value="<?= enkrip($data->id); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Ruang</label>
                            <input type="text" class="form-control" name="nama" id="nama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kapasitas</label>
                            <input type="number" class="form-control" min="1" max="100" name="kapasitas" id="kapasitas" required autocomplete="off">
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

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    let edit_btn = $('.edit_btn');

    $(edit_btn).each(function(i) {
        $(edit_btn[i]).click(function() {
            let id = $(this).data('id_ruang');
            let gedung = $(this).data('gedung');
            let prodi = $(this).data('prodi');
            let nama = $(this).data('nama');
            let kapasitas = $(this).data('kapasitas');

            $.ajax({
                url: "<?= base_url('management/ruang/getOne/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    $('#id').val(id);
                    $('#nama').val(result.nama_ruang);
                    $('#gedung').val(gedung);
                    $('#gedung').select2().trigger('change');
                    $('#prodi').val(prodi);
                    $('#prodi').select2().trigger('change');
                    $('#kapasitas').val(result.kapasitas);
                }
            });
        });
    });

    $('#by_gedung').change(function() {
        let gedung = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/ruang/'); ?>' + gedung;
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('management/ruang') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('management/ruang') ?>"]').parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?= $this->session->flashdata('notif'); ?>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>