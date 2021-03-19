<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/management/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

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
                    <h3 class="block-title text-white">Jam Kuliah</h3>
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
                                    <th>Nama Jam</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($jam) || is_object($jam)) : ?>
                                <?php foreach ($jam as $hasil) : ?>
                                <tr>
                                    <td class="text-center font-size-sm"><?= $i++; ?></td>
                                    <td class="font-size-sm"><?= $hasil->nama_jam; ?></td>
                                    <td class="font-size-sm"><?= $hasil->mulai; ?></td>
                                    <td class="font-size-sm"><?= $hasil->selesai; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning edit_btn"
                                            data-toggle="modal" data-target="#modal-edit"
                                            data-id_gedung="<?= enkrip($hasil->id); ?>"
                                            data-nama_jam="<?= $hasil->nama_jam; ?>" data-mulai="<?= $hasil->mulai; ?>"
                                            data-selesai="<?= $hasil->selesai; ?>" title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </button>
                                        <button type="button"
                                            data-href="<?= base_url('management/jamkuliah/delete/') . enkrip($hasil->id); ?>"
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
                    <h3 class="block-title text-center">Jam Kuliah</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('management/jamkuliah/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="nama_jam">Nama Jam</label>
                            <input type="text" class="form-control" name="nama_jam" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="mulai">Mulai</label>
                            <input type="time" class="form-control" name="mulai" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="selesai">Selesai</label>
                            <input type="time" class="form-control" name="selesai" required autocomplete="off">
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
                <form action="<?= base_url('management/jamkuliah/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="nama_jam">Nama Jam</label>
                            <input type="text" class="form-control" name="nama_jam" id="nama_jam" required
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="mulai">Mulai</label>
                            <input type="time" class="form-control" name="mulai" id="mulai" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="selesai">Selesai</label>
                            <input type="time" class="form-control" name="selesai" id="selesai" required
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

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
let edit_btn = $('.edit_btn');

$(edit_btn).each(function(i) {
    $(edit_btn[i]).click(function() {
        let id = $(this).data('id_gedung');
        let nama = $(this).data('nama_jam');
        let mulai = $(this).data('mulai');
        let selesai = $(this).data('selesai');

        $('#id').val(id);
        $('#nama_jam').val(nama);
        $('#mulai').val(mulai);
        $('#selesai').val(selesai);
    });
});
</script>

<?= $this->session->flashdata('notif'); ?>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>