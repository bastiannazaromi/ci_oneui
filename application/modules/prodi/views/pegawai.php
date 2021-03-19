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
                    <h3 class="block-title text-white">Data Pegawai</h3>
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
                                    <th>NIK</th>
                                    <th>NIPY/NIDN</th>
                                    <th>NAMA PEGAWAI</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <!-- <th>KOTA</th> -->
                                    <th>STATUS PEGAWAI</th>
                                    <th>STATUS</th>
                                    <th>Create At</th>
                                    <th>Update At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($list_pegawai) || is_object($list_pegawai)) : ?>
                                    <?php foreach ($list_pegawai as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nik; ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->nipy . "/" . $hasil->nidn ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->nama ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->username ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->email ?></td>
                                            <td class="font-size-sm"><?php echo ($hasil->status_peg == 1) ? "Dosen" : '' ?></td>
                                            <td class="text-center">
                                                <?php echo ($hasil->status_karyawan == '1') ? '<span class="badge badge-success">Tetap</span>' : '<span class="badge badge-warning">Tidak Tetap</span>'; ?>
                                            </td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                            <td class="font-size-sm"><?= $hasil->updated_at; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-warning edit_btn" data-toggle="modal" data-target="#modal-edit" data-id="<?= enkrip($hasil->id); ?>" title="Edit">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                    <button type="button" data-href="<?= base_url('prodi/pegawai/delete/') . enkrip($hasil->id); ?>" style="display: inline-block;" class="btn btn-sm btn-danger tombol-hapus" data-text="data akan dihapus" data-toggle="tooltip" title="Delete">
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
                    <h3 class="block-title text-center">Add Pegawai</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/pegawai/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="nama">Nama Pegawai</label>
                            <input type="text" class="form-control" name="nama" required autocomplete="off" placeholder="Nama pegawai">
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" name="nik" maxlength="16" required autocomplete="off" placeholder="nik">
                        </div>
                        <div class="form-group">
                            <label for="nidn">NIDN</label>
                            <input type="text" class="form-control" name="nidn" required autocomplete="off" placeholder="NIDN">
                        </div>
                        <div class="form-group">
                            <label for="nipy">NIPY</label>
                            <input type="text" class="form-control" name="nipy" required autocomplete="off" placeholder="NIPY">
                        </div>
                        <div class="form-group">
                            <label for="jk">Jenis Kelamin</label>
                            <select class="form-control" name="jk">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="<?= enkrip(0); ?>">Laki - laki</option>
                                <option value="<?= enkrip(1); ?>">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_peg">Status Pegawai</label>
                            <select class="form-control" name="status_peg" id="status_peg">
                                <option value="<?= enkrip($status->id); ?>" data-nm="<?= $status->nama_status; ?>">
                                    <?= $status->nama_status; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_karyawan">Status Karyawan</label>
                            <select class="form-control" name="status_karyawan">
                                <option value="">-- Pilih Status --</option>
                                <option value="<?= enkrip(1); ?>">TETAP</option>
                                <option value="<?= enkrip(2); ?>">TIDAk TETAP
                                </option>
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
                    <h3 class="block-title text-center">Edit Pegawai</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>

                </div>
                <form action="<?= base_url('prodi/pegawai/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="nama">Nama Pegawai</label>
                            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik" maxlength="16" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nidn">NIDN</label>
                            <input type="text" class="form-control" name="nidn" id="nidn" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nipy">NIPY</label>
                            <input type="text" class="form-control" name="nipy" id="nipy" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="jk">Jenis Kelamin</label>
                            <select class="form-control" name="jk" id="jk">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="<?= enkrip(0); ?>">Laki - laki</option>
                                <option value="<?= enkrip(1); ?>">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_peg">Status Pegawai</label>
                            <select class="form-control" name="status_peg" id="status_peg_e">
                                <option value="<?= enkrip($status->id); ?>" data-nm="<?= $status->nama_status; ?>">
                                    <?= $status->nama_status; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_karyawan">Status karyawan</label>
                            <select class="form-control" name="status_karyawan" id="status_karyawan">
                                <option value="">-- Pilih Status --</option>
                                <option value="<?= enkrip(1); ?>">TETAP</option>
                                <option value="<?= enkrip(2); ?>">TIDAk TETAP
                                </option>
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
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('prodi/pegawai/getPegawai/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    $('#id').val(id);
                    $('#nama').val(result.nama);
                    $('#nik').val(result.nik);
                    $('#nidn').val(result.nidn);
                    $('#nipy').val(result.nipy);
                    $('#jk').val(result.jk);
                    $('#status_peg_e').val(result.status_peg);
                    $('#status_karyawan').val(result.status_karyawan);
                }
            });
        });
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>