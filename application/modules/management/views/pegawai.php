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
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_status" id="by_status">
                    <?php foreach ($status as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $st_ini == $data->nama_status ? 'selected="selected"' : ''; ?>>
                            <?= $data->nama_status; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if ($st_ini == 'Dosen') : ?>
            <div class="col-sm-6 col-xl-6">
                <div class="form-group">
                    <select class="js-select2 form-control" name="by_prodi" id="by_prodi">
                        <?php foreach ($prodi as $data) : ?>
                            <option value="<?= enkrip($data->kd_prodi); ?>" <?= $prodi_ini == $data->kd_prodi ? 'selected="selected"' : ''; ?>>
                                <?= $data->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">List Pegawai</h3>
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
                                    <?php if ($st_ini == 'Dosen') : ?>
                                        <th>Program Studi</th>
                                    <?php endif; ?>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Status Pegawai</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($pegawai) || is_object($pegawai)) : ?>
                                    <?php foreach ($pegawai as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <?php if ($st_ini == 'Dosen') : ?>
                                                <td class="font-size-sm"><?= $hasil->nama_prodi; ?></td>
                                            <?php endif; ?>
                                            <td class="font-size-sm">
                                                <?= $hasil->gelar_depan . ' ' . $hasil->nama . ', ' . $hasil->gelar_belakang; ?>
                                            </td>
                                            <td class="font-size-sm"><?= $hasil->username; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_status; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning edit_btn" data-toggle="modal" data-target="#modal-edit" data-id="<?= enkrip($hasil->id); ?>" title="Edit">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" data-href="<?= base_url('management/pegawai/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
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
    <div class="modal-dialog modal-lg" role="document">
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
                <form action="<?= base_url('management/pegawai/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="nama">Nama Pegawai</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="depan" placeholder="Drs." autocomplete="off">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama pegawai.." required autocomplete="off">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="belakang" placeholder="M. Kom" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="js-maxlength form-control" name="nik" maxlength="16" required autocomplete="off" data-always-show="true" data-placement="bottom-right">
                        </div>
                        <div class="form-group">
                            <label for="nidn">NIDN</label>
                            <input type="text" class="form-control" name="nidn" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="nipy">NIPY</label>
                            <input type="text" class="form-control" name="nipy" required autocomplete="off">
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
                                <option value="">-- Pilih Status --</option>
                                <?php foreach ($status as $hasil) : ?>
                                    <option value="<?= enkrip($hasil->id); ?>" data-nm="<?= $hasil->nama_status; ?>">
                                        <?= $hasil->nama_status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group d-none" id="prodi_add">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="prodi" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>">
                                        <?= $data->nama; ?>
                                    </option>
                                <?php endforeach; ?>

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
    <div class="modal-dialog modal-lg" role="document">
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
                <form action="<?= base_url('management/pegawai/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="nama">Nama Pegawai</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="depan" id="depan" placeholder="Drs." autocomplete="off">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama pegawai.." required autocomplete="off">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="belakang" id="belakang" placeholder="M. Kom" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="js-maxlength form-control" name="nik" id="nik" maxlength="16" required autocomplete="off" data-always-show="true" data-placement="bottom-right">
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
                                <option value="">-- Pilih Status --</option>
                                <?php foreach ($status as $hasil) : ?>
                                    <option value="<?= enkrip($hasil->id); ?>" data-nm="<?= $hasil->nama_status; ?>">
                                        <?= $hasil->nama_status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group d-none" id="prodi_edit">
                            <label for="prodi">Program Studi</label>
                            <select class="js-select2 form-control" name="prodi" id="prodi" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <?php foreach ($prodi as $data) : ?>
                                    <option value="<?= enkrip($data->kd_prodi); ?>">
                                        <?= $data->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="">
                                    Tidak ada
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
<?php $one->get_js('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>

<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    $('#by_status').change(function() {
        let status = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/pegawai/'); ?>' + status;
    });

    $('#by_prodi').change(function() {
        let prodi = $(this).find(':selected').val();
        let status = $('#by_status').find(':selected').val();
        document.location.href = '<?= base_url('management/pegawai/'); ?>' + status + '/' + prodi;
    });

    $('#status_peg').change(function() {
        let status = $(this).find('option:selected').data('nm');
        if (status != 'Dosen') {
            $('#prodi_add').addClass('d-none');
        } else {
            $('#prodi_add').removeClass('d-none');
        }
    });

    $('#status_peg_e').change(function() {
        let status = $(this).find('option:selected').data('nm');
        if (status != 'Dosen') {
            $('#prodi_edit').addClass('d-none');
        } else {
            $('#prodi_edit').removeClass('d-none');
        }
    });

    let edit_btn = $('.edit_btn');

    $(edit_btn).each(function(i) {
        $(edit_btn[i]).click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('management/pegawai/getOne/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    if (result.nama_status == 'Dosen') {
                        $('#prodi_edit').removeClass('d-none');
                    } else {
                        $('#prodi_edit').addClass('d-none');
                    }
                    $('#id').val(id);
                    $('#nama').val(result.nama);
                    $('#depan').val(result.depan);
                    $('#belakang').val(result.belakang);
                    $('#nik').val(result.nik);
                    $('#nidn').val(result.nidn);
                    $('#nipy').val(result.nipy);
                    $('#jk').val(result.jk);
                    $('#status_peg_e').val(result.status_peg);
                    $('#status_karyawan').val(result.status_karyawan);
                    $('#prodi').val(result.prodi);
                    $('#prodi').select2().trigger('change');

                    console.log(result.gelar_belakang)
                }
            });
        });
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('management/pegawai') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('management/pegawai') ?>"]').parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2', 'maxlength']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>