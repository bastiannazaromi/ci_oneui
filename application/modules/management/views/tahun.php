<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/management/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>

<?php $one->get_css('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>

<style>
.ui-datepicker-calendar {
    display: none;
}
</style>

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
                    <h3 class="block-title text-white">Tahun Akademik</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal"
                            data-target="#modal-add">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Tahun</th>
                                    <th>Kalender</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($tahun) || is_object($tahun)) : ?>
                                <?php foreach ($tahun as $hasil) : ?>
                                <tr>
                                    <td class="text-center font-size-sm"><?= $i++; ?></td>
                                    <td class="font-size-sm"><?= $hasil->tahun_akademik; ?></td>
                                    <td class="font-size-sm"><?= $hasil->awal . ' - ' . $hasil->akhir; ?></td>
                                    <td class="font-size-sm">
                                        <span
                                            class="badge <?= ($hasil->status == 0) ? 'badge-danger' : 'badge-success'; ?>"><?= ($hasil->status == 0) ? 'Non Aktif' : 'Aktif'; ?></span>
                                    </td>
                                    <td class=" text-center">
                                        <button type="button" class="btn btn-sm btn-warning edit_btn"
                                            data-toggle="modal" data-target="#modal-edit"
                                            data-id="<?= enkrip($hasil->id); ?>"
                                            data-periode="<?= enkrip($hasil->periode); ?>" title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </button>
                                        <button type="button"
                                            data-href="<?= base_url('management/tahunakademik/status/') . enkrip($hasil->id); ?>"
                                            data-text="status akan diubah" class="btn btn-sm btn-info tombol-hapus"
                                            data-toggle="tooltip" title="Edit Status">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </button>
                                        <button type="button"
                                            data-href="<?= base_url('management/tahunakademik/delete/') . enkrip($hasil->id); ?>"
                                            data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus"
                                            data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-fw fa-trash"></i>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Tahun Akademik</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/tahunakademik/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="awal">Tahun Akademik</label>
                            <div class="input-group">
                                <input type="number" class="form-control" min="<?= date('Y') - 5; ?>"
                                    max="<?= date('Y') + 2; ?>" name="th_awal" placeholder="From">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-slash fa-rotate-90"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" name="th_akhir" placeholder="To">
                                <select class="form-control" name="periode">
                                    <option value="<?= enkrip(1); ?>">Ganjil</option>
                                    <option value="<?= enkrip(2); ?>">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="awal">Kalander</label>
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="awal" placeholder="From"
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-right"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="akhir" placeholder="To"
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true">
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
                    <h3 class="block-title text-center">Tahun Akademik</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('management/tahunakademik/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="awal">Tahun Akademik</label>
                            <div class="input-group">
                                <input type="number" class="form-control" min="<?= date('Y') - 5; ?>"
                                    max="<?= date('Y') + 2; ?>" name="th_awal" id="th_awal" placeholder="From">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-slash fa-rotate-90"></i>
                                    </span>
                                </div>
                                <input type="number" class="form-control" name="th_akhir" id="th_akhir"
                                    placeholder="To">
                                <select class="form-control" name="periode" id="periode">
                                    <option value="<?= enkrip(1); ?>">Ganjil</option>
                                    <option value="<?= enkrip(2); ?>">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="awal">Tahun Kalander</label>
                            <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1"
                                data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" name="awal" id="awal" placeholder="From"
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600">
                                        <i class="fa fa-fw fa-arrow-right"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="akhir" id="akhir" placeholder="To"
                                    data-week-start="1" data-autoclose="true" data-today-highlight="true">
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

<?php $one->get_js('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
let edit_btn = $('.edit_btn');

$(edit_btn).each(function(i) {
    $(edit_btn[i]).click(function() {
        let id = $(this).data('id');
        let periode = $(this).data('periode');

        $.ajax({
            url: "<?= base_url('management/tahunakademik/getOne/'); ?>" + id,
            type: 'get',
            dataType: 'json',
            success: function(result) {
                $('#id').val(id);
                $('#periode').val(periode);
                $('#th_awal').val(result.th_awal);
                $('#th_akhir').val(result.th_akhir);
                $('#awal').val(result.awal);
                $('#akhir').val(result.akhir);
            }
        });
    });
});
jQuery(function() {
    One.helpers(['datepicker']);
});
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>