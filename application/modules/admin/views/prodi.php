<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/admin/config.php'; ?>
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Kode Prodi</th>
                                    <th>Kode Nasional</th>
                                    <th style="width: 250px;">Program Studi</th>
                                    <th>Jenjang</th>
                                    <th>Kode</th>
                                    <th class="text-center" style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($prodi) || is_object($prodi)) : ?>
                                    <?php foreach ($prodi as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kd_prodi; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kd_nasional; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama; ?></td>
                                            <td class="font-size-sm"><?= $hasil->jenjang; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kode; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-alt-primary edit_btn" data-toggle="modal" data-target="#modal-edit" data-id_prodi="<?= enkrip($hasil->id); ?>" data-kd_prodi="<?= enkrip($hasil->kd_prodi); ?>" data-sms="<?= $hasil->id_sms; ?>" data-kd_nasional="<?= $hasil->kd_nasional; ?>" data-jenjang="<?= $hasil->jenjang; ?>" data-kode="<?= $hasil->kode; ?>" data-nama="<?= $hasil->nama; ?>" title="Edit">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" data-href="<?= base_url('admin/prodi/delete/') . enkrip($hasil->kd_prodi); ?>" class="btn btn-sm btn-alt-primary tombol-hapus" data-toggle="tooltip" data-text="data akan dihapus" title="Delete">
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
                            <input type="text" class="form-control" name="prodi" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="kd_nasional">ID SMS</label>
                            <input type="text" class="form-control" name="sms" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="kd_nasional">Kode Nasional</label>
                            <input type="text" class="form-control" name="kd_nasional" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Program Studi</label>
                            <input type="text" class="form-control" name="nama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="jenjang">jenjang</label>
                            <select class="form-control" name="jenjang">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="D III">D III</option>
                                <option value="D IV">D IV</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" name="kode" required autocomplete="off">
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
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="kd_prodi" id="prodi" required>
                        <div class="form-group">
                            <label for="kd_prodi">ID SMS</label>
                            <input type="text" class="form-control" name="sms" id="sms" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="kd_nasional">Kode Nasional</label>
                            <input type="text" class="form-control" name="kd_nasional" id="kd_nasional" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Program Studi</label>
                            <input type="text" class="form-control" name="nama" id="nama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="jenjang">jenjang</label>
                            <select class="form-control" id="jenjang" name="jenjang">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="D III">D III</option>
                                <option value="D IV">D IV</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" name="kode" id="kode" required autocomplete="off">
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

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    let edit_btn = $('.edit_btn');

    $(edit_btn).each(function(i) {
        $(edit_btn[i]).click(function() {
            let kd_nasional = $(this).data('kd_nasional');
            let kd_prodi = $(this).data('kd_prodi');
            let nama = $(this).data('nama');
            let jenjang = $(this).data('jenjang');
            let kode = $(this).data('kode');
            let sms = $(this).data('sms');
            console.log(kd_prodi);
            $('#kd_nasional').val(kd_nasional);
            $('#prodi').val(kd_prodi);
            $('#sms').val(sms);
            $('#nama').val(nama);
            $('#jenjang').val(jenjang);
            $('#kode').val(kode);
        });
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>