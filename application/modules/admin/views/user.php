<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/admin/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">User Manager</h3>
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
                                    <th>Prodi</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Level</th>
                                    <th>Create At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($user) || is_object($user)) : ?>
                                    <?php foreach ($user as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_prodi; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama; ?></td>
                                            <td class="font-size-sm"><?= $hasil->username; ?></td>
                                            <td class="font-size-sm"><?= $hasil->email; ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/user/reset/') . enkrip($hasil->id); ?>"><span class="badge badge-success">reset</span></a>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-danger"><?= $hasil->nama_group; ?></span>
                                            </td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-alt-primary edit_btn" data-toggle="modal" data-target="#modal-edit" data-id="<?= enkrip($hasil->id); ?>" data-kd_prodi="<?= enkrip($hasil->kd_prodi); ?>" data-level="<?= enkrip($hasil->level); ?>" title="Edit">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                    <button type="button" data-href="<?= base_url('admin/user/delete/') . enkrip($hasil->id); ?>" class="btn btn-sm btn-alt-primary tombol-hapus" data-text="data akan dihapus" data-toggle="tooltip" title="Delete">
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
                    <h3 class="block-title text-center">User</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('admin/user/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="kd_prodi" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <option>BAA / Admin</option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="js-select2 form-control" name="level" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($group as $data) : ?>
                                    <option value="<?= enkrip($data->id); ?>"><?= $data->name; ?></option>
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
                    <h3 class="block-title text-center">User</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('admin/user/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" id="kd_prodi" name="kd_prodi" style="width: 100%;" data-placeholder="Choose one..">
                                <option>BAA / Admin</option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="js-select2 form-control" id="level" name="level" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($group as $data) : ?>
                                    <option value="<?= enkrip($data->id); ?>"><?= $data->name; ?></option>
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
            let level = $(this).data('level');

            $.ajax({
                url: "<?= base_url('admin/user/getOne/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    $('#id').val(id);
                    $('#nama').val(result.nama);
                    $('#kd_prodi').val(kd_prodi);
                    $('#kd_prodi').select2().trigger('change');
                    $('#level').val(level);
                    $('#level').select2().trigger('change');
                    $('#username').val(result.username);
                    $('#email').val(result.email);
                }
            });
        });
    });

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>