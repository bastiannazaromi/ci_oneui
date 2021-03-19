<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/backend/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="content">

    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Program Studi</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-add">
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
                                    <th>Kode Prodi</th>
                                    <th>Kode Nasional</th>
                                    <th>Program Studi</th>
                                    <th>Create At</th>
                                    <th>Update At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($prodi as $hasil) : ?>
                                    <tr>
                                        <td class="text-center font-size-sm"><?= $i++; ?></td>
                                        <td class="font-size-sm"><?= $hasil->kd_prodi; ?></td>
                                        <td class="font-size-sm"><?= $hasil->kd_nasional; ?></td>
                                        <td class="font-size-sm"><?= $hasil->nama; ?></td>
                                        <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                        <td class="font-size-sm"><?= $hasil->updated_at; ?></td>
                                        <td class="text-center">
                                            <a href="" class="badge badge-warning edit_prodi" data-toggle="modal" data-target="#modal-edit" data-id_prodi="<?= enkrip($hasil->id); ?>">Edit</a>
                                            <a href="<?= base_url('admin/prodi/delete/') . enkrip($hasil->id); ?>" class="badge badge-danger tombol-hapus">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
                    <h3 class="block-title text-center">Program Studi</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('admin/prodi/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="kd_prodi">Kode Prodi</label>
                            <input type="text" class="form-control" name="kd_prodi" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="kd_nasional">Kode Nasional</label>
                            <input type="text" class="form-control" name="kd_nasional" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Program Studi</label>
                            <input type="text" class="form-control" name="nama" required autocomplete="off">
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
                    <h3 class="block-title text-center">Program Studi</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('admin/prodi/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id" id="id" required>
                            <label for="kd_prodi">Kode Prodi</label>
                            <input type="text" class="form-control" name="kd_prodi" id="kd_prodi" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="kd_nasional">Kode Nasional</label>
                            <input type="text" class="form-control" name="kd_nasional" id="kd_nasional" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Program Studi</label>
                            <input type="text" class="form-control" name="nama" id="nama" required autocomplete="off">
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
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    $(document).ready(function() {
        jQuery(function() {
            One.helpers('notify');
        });

        let edit_prodi = $('.edit_prodi');

        console.log(edit_prodi.length);

        $(edit_prodi).each(function(i) {
            $(edit_prodi[i]).click(function() {
                let id_prodi = $(this).data('id_prodi');

                console.log(id_prodi);

                $.ajax({
                    url: "<?= base_url('admin/prodi/getOne/'); ?>" + id_prodi,
                    type: 'get',
                    dataType: 'json',
                    success: function(result) {
                        $('#id').val(id_prodi);
                        $('#kd_nasional').val(result.kd_nasional);
                        $('#kd_prodi').val(result.kd_prodi);
                        $('#nama').val(result.nama);
                    }
                });
            });
        });
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>