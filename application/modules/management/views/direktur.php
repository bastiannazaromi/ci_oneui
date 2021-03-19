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
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Direktur</h3>
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
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Create At</th>
                                    <th>Update At</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($direktur) || is_object($direktur)) : ?>
                                <?php foreach ($direktur as $hasil) : ?>
                                <tr>
                                    <td class="text-center font-size-sm"><?= $i++; ?></td>
                                    <td class="font-size-sm"><?= $hasil->nama; ?></td>
                                    <td class="font-size-sm"><?= $hasil->nama_jabatan; ?></td>
                                    <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                    <td class="font-size-sm"><?= $hasil->updated_at; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning edit_btn"
                                            data-toggle="modal" data-target="#modal-edit"
                                            data-id="<?= enkrip($hasil->id); ?>"
                                            data-jabatan="<?= enkrip($hasil->jabatan); ?>" title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </button>
                                        <button type="button"
                                            data-href="<?= base_url('management/direktur/delete/') . enkrip($hasil->id); ?>"
                                            data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus"
                                            data-toggle="tooltip" title="Delete">
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
                    <h3 class="block-title text-center">Direktur</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/direktur/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="id_peg">Nama Pegawai</label>
                            <select class="form-control basicAutoSelect" name="id_peg" placeholder="Cari pegawai..."
                                data-url="<?= base_url('management/direktur/getPeg/?'); ?>" autocomplete="off"></select>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Jabatan</label>
                            <select class="js-select2 form-control" name="jabatan" style="width: 100%;"
                                data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($jabatan as $data) : ?>
                                <option value="<?= enkrip($data->id); ?>"><?= $data->nama_jabatan; ?></option>
                                <?php endforeach; ?>
                            </select>
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
                    <h3 class="block-title text-center">Direktur</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('management/direktur/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="prodi">Jabatan</label>
                            <select class="js-select2 form-control" name="jabatan" id="jabatan" style="width: 100%;"
                                data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($jabatan as $data) : ?>
                                <option value="<?= enkrip($data->id); ?>"><?= $data->nama_jabatan; ?></option>
                                <?php endforeach; ?>
                            </select>
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

<?php $one->get_js('autocomplete/bootstrap-autocomplete.min.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
let basicAutoSelect = $('.basicAutoSelect');

$(basicAutoSelect).autoComplete({
    minLength: 2
});

let edit_btn = $('.edit_btn');

$(edit_btn).each(function(i) {
    $(edit_btn[i]).click(function() {
        let id = $(this).data('id');
        let jabatan = $(this).data('jabatan');

        $('#id').val(id);
        $('#jabatan').val(jabatan);
        $('#jabatan').select2().trigger('change');

    });
});

jQuery(function() {
    One.helpers(['select2']);
});
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>