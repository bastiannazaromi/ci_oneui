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
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Program Studi Akreditasi</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal"
                            data-target="#modal-add">
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
                                    <th>Program Studi</th>
                                    <th>Jenjang</th>
                                    <th>No. SK Akreditasi</th>
                                    <th>Status Akreditasi</th>
                                    <th>Akreditasi</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($akreditasi) || is_object($akreditasi)) : ?>
                                <?php foreach ($akreditasi as $hasil) : ?>
                                <tr>
                                    <td class="text-center font-size-sm"><?= $i++; ?></td>
                                    <td class="font-size-sm"><?= $hasil->nama_prodi; ?></td>
                                    <td class="font-size-sm"><?= $hasil->jenjang; ?></td>
                                    <td class="font-size-sm"><?= $hasil->no_sk; ?></td>
                                    <td class="font-size-sm">
                                        <?= ($hasil->status == 1) ? 'Terdaftar' : 'Belum Terdaftar'; ?></td>
                                    <td class="font-size-sm"><?= $hasil->akreditasi; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning edit_btn"
                                            data-toggle="modal" data-target="#modal-edit"
                                            data-id="<?= enkrip($hasil->id); ?>"
                                            data-prodi="<?= enkrip($hasil->kd_prodi); ?>"
                                            data-status="<?= enkrip($hasil->status); ?>"
                                            data-no_sk="<?= $hasil->no_sk; ?>"
                                            data-akreditasi="<?= enkrip($hasil->akreditasi); ?>" title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </button>
                                        <button type="button"
                                            data-href="<?= base_url('management/prodi/delete/') . enkrip($hasil->id); ?>"
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
                    <h3 class="block-title text-center">Program Studi Akreditasi</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/prodi/add'); ?>" method="post">
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
                            <label for="prodi">Status</label>
                            <select class="form-control" name="status" id="status_add">
                                <option>-- Pilih Status</option>
                                <option value="<?= enkrip(1); ?>">Terdaftar</option>
                                <option value="<?= enkrip(2); ?>">Belum Terdaftar</option>
                            </select>
                        </div>
                        <div class="d-none" id="ket_add">
                            <div class="form-group">
                                <label for="no_sk">No. SK Akreditasi</label>
                                <input type="text" class="form-control" name="no_sk" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="prodi">Akreditasi</label>
                                <select class="form-control" name="akreditasi">
                                    <option>-- Pilih Akreditasi</option>
                                    <option value="<?= enkrip('A'); ?>">A</option>
                                    <option value="<?= enkrip('B'); ?>">B</option>
                                    <option value="<?= enkrip('C'); ?>">C</option>
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

<!-- Modal Edit -->
<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Program Studi Akreditasi</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('management/prodi/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"
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
                            <label for="prodi">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option>-- Pilih Status</option>
                                <option value="<?= enkrip(1); ?>">Terdaftar</option>
                                <option value="<?= enkrip(2); ?>">Belum Terdaftar</option>
                            </select>
                        </div>
                        <div class="d-none" id="ket_edit">
                            <div class="form-group">
                                <label for="no_sk">No. SK Akreditasi</label>
                                <input type="text" class="form-control" name="no_sk" id="no_sk" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="prodi">Akreditasi</label>
                                <select class="form-control" name="akreditasi" id="akreditasi">
                                    <option>-- Pilih Akreditasi</option>
                                    <option value="<?= enkrip('A'); ?>">A</option>
                                    <option value="<?= enkrip('B'); ?>">B</option>
                                    <option value="<?= enkrip('C'); ?>">C</option>
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
let edit_btn = $('.edit_btn');

$(edit_btn).each(function(i) {
    $(edit_btn[i]).click(function() {
        let id = $(this).data('id');
        let no_sk = $(this).data('no_sk');
        let prodi = $(this).data('prodi');
        let status = $(this).data('status');
        let akreditasi = $(this).data('akreditasi');

        $('#id').val(id);
        $('#kd_prodi').val(prodi);
        $('#kd_prodi').select2().trigger('change');
        $('#no_sk').val(no_sk);
        $('#status').val(status);
        $('#akreditasi').val(akreditasi);

        if (status == '<?= enkrip(1); ?>') {
            $('#ket_edit').removeClass('d-none');
        } else {
            $('#ket_edit').addClass('d-none');
        }
    });
});

$('#status_add').change(function() {
    let status = $(this).find(':selected').val();
    if (status == '<?= enkrip(1); ?>') {
        $('#ket_add').removeClass('d-none');
    } else {
        $('#ket_add').addClass('d-none');
    }
})

$('#status').change(function() {
    let status = $(this).find(':selected').val();
    if (status == '<?= enkrip(1); ?>') {
        $('#ket_edit').removeClass('d-none');
    } else {
        $('#ket_edit').addClass('d-none');
    }
})

jQuery(function() {
    One.helpers(['select2']);
});
</script>

<?= $this->session->flashdata('notif'); ?>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>