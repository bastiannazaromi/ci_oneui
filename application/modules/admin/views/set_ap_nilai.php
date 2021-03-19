<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/admin/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="content">

    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Pengaturan Setting Aplikasi Nilai</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal"
                            data-target="#modal-add">
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
                                    <th>Prodi</th>
                                    <th>Mode</th>
                                    <th>Lama</th>
                                    <th>Create At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($data) || is_object($data)) : ?>
                                <?php foreach ($data as $hasil) : ?>
                                <tr>
                                    <td class="text-center font-size-sm"><?= $i++; ?></td>
                                    <td class="font-size-sm"><?= $hasil->nama_prodi; ?></td>
                                    <td class="font-size-sm">
                                        <?= ($hasil->mode == 1) ? 'TAHUN AKADEMIK AKTIF' : 'RENTAN TAHUN AKADEMIK'; ?>
                                    </td>
                                    <td class="font-size-sm"><?= $hasil->lama . " Tahun"; ?></td>
                                    <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-alt-primary edit_btn"
                                                data-toggle="modal" data-target="#modal-edit"
                                                data-id="<?= enkrip($hasil->id); ?>"
                                                data-kd_prodi="<?= enkrip($hasil->kd_prodi); ?>"
                                                data-mode="<?= enkrip($hasil->mode); ?>"
                                                data-lama="<?= $hasil->lama; ?>" title="Edit">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                            <button type="button"
                                                data-href="<?= base_url('admin/setnilai/delete/') . enkrip($hasil->id); ?>"
                                                class="btn btn-sm btn-alt-primary tombol-hapus" data-toggle="tooltip" data-text="data akan dihapus"
                                                title="Delete">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
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
                    <h3 class="block-title text-center">Setting Aplikasi Nilai</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('admin/setnilai/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="kd_prodi" style="width: 100%;"
                                data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($prodi as $data) : ?>
                                <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mode">Mode</label>
                            <select class="js-select2 form-control" name="mode" style="width: 100%;"
                                data-placeholder="Choose one..">
                                <option></option>
                                <option value="<?= enkrip(1); ?>">TAHUN AKADEMIK AKADEMIK</option>
                                <option value="<?= enkrip(2); ?>">RENTAN TAHUN AKADEMIK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Lama Waktu</label>
                            <input type="number" class="form-control" name="tahun" min="1" max="99" required
                                autocomplete="off">
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
                    <h3 class="block-title text-center">Setting Aplikasi Nilai</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('admin/setnilai/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="kd_prodi" id="kd_prodi" style="width: 100%;"
                                data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($prodi as $data) : ?>
                                <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mode">Mode</label>
                            <select class="js-select2 form-control" id="mode" name="mode" style="width: 100%;"
                                data-placeholder="Choose one..">
                                <option></option>
                                <option value="<?= enkrip(1); ?>">TAHUN AKADEMIK AKADEMIK</option>
                                <option value="<?= enkrip(2); ?>">RENTAN TAHUN AKADEMIK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Lama Waktu</label>
                            <input type="number" class="form-control" id="tahun" min="1" max="99" name="tahun" required
                                autocomplete="off">
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
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>
<!-- Page JS Code -->
<?php $one->get_js('js/pages/be_tables_datatables.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
let edit_btn = $('.edit_btn');

$(edit_btn).each(function(i) {
    $(edit_btn[i]).click(function() {
        let id = $(this).data('id');
        let kd_prodi = $(this).data('kd_prodi');
        let mode = $(this).data('mode');
        let lama = $(this).data('lama');

        $('#id').val(id);
        $('#kd_prodi').val(kd_prodi);
        $('#kd_prodi').select2().trigger('change');
        $('#mode').val(mode);
        $('#mode').select2().trigger('change');
        $('#tahun').val(lama);
    });
});

jQuery(function() {
    One.helpers(['select2']);
});
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>