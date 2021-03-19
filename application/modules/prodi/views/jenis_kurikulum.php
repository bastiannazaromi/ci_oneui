<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">List Jenis Kurikulum</h3>
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
                                    <th>Kode</th>
                                    <th>Keterangan Kurikulum</th>
                                    <th>Status</th>
                                    <th>Create At</th>
                                    <th>Update At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($list_kurikulum) || is_object($list_kurikulum)) : ?>
                                    <?php foreach ($list_kurikulum as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kode_kurikulum; ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->keterangan_kurikulum ?></td>
                                            <td class="text-center">
                                                <?php echo ($hasil->status == '1') ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Non active</span>'; ?>
                                            </td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                            <td class="font-size-sm"><?= $hasil->updated_at; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary edit_btn" data-toggle="modal" data-target="#modal-edit" data-id_kurikulum="<?= enkrip($hasil->id); ?>" data-kode="<?= $hasil->kode_kurikulum; ?>" data-keterangan="<?php echo $hasil->keterangan_kurikulum ?>" title="Edit">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                    <?php if ($hasil->status == '1') : ?>
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Non active" onclick="activeNonActive('<?php echo base_url('prodi/kurikulum/active_non_active/' . enkrip($hasil->id) . '/non_active') ?>')">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    <?php else : ?>
                                                        <button type="button" class="btn btn-sm btn-alt-success" data-toggle="tooltip" title="active" onclick="activeNonActive('<?php echo base_url('prodi/kurikulum/active_non_active/' . enkrip($hasil->id) . '/active') ?>')">
                                                            <i class="fa fa-fw fa-check"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <button type="button" data-href="<?= base_url('prodi/kurikulum/delete/') . enkrip($hasil->id); ?>" style="display: inline-block;" class="btn btn-sm btn-warning tombol-hapus" data-text="data akan dihapus" data-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-fw fa-trash"></i>
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
</div>

<!-- Modal Add -->
<div class="modal" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Add Jenis Kurikulum</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/kurikulum/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="nama">Kode kurikulum</label>
                            <input type="text" class="form-control" name="kode" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nama">Keterangan kurikulum</label>
                            <input type="text" class="form-control" name="keterangan" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Active">Status Active</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Active</option>
                                <option value="0">Tidak Active</option>
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

<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Edit Kurikulum</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/kurikulum/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="nama">Kode kurikulum</label>
                            <input type="text" class="form-control" name="kode" required autocomplete="off" id="kode">
                        </div>
                        <div class="form-group">
                            <label for="nama">Keterangan kurikulum</label>
                            <input type="text" class="form-control" name="keterangan" required autocomplete="off" id="keterangan">
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
<script>
    let tombol_edit = $('.edit_btn');
    $(tombol_edit).each(function(i) {
        $(tombol_edit[i]).click(function() {
            let id = $(this).data('id_kurikulum');
            let kode = $(this).data('kode');
            let keterangan = $(this).data('keterangan');
            $('#id').val(id);
            $('#kode').val(kode);
            $('#keterangan').val(keterangan);
        });
    });

    function activeNonActive(href) {
        Swal.fire({
            title: 'Apakah anda yakin',
            text: "untuk active atau non acitve",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Active non Acive'
        }).then((result) => {
            if (result.value) {
                location.href = href;
            }
        })
    }
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>