<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_tahun" id="by_tahun" style="width: 100%;" data-placeholder="Silakan pilih tahun..">
                    <option></option>
                    <?php foreach ($tahun as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $th_ini == $data->id ? 'selected="selected"' : ''; ?>>
                            <?= $data->tahun_akademik; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_semester" id="by_semester" style="width: 100%;" data-placeholder="Silakan pilih semester..">
                    <option></option>
                    <?php foreach ($semester as $data) : ?>
                        <option value="<?= enkrip($data->semester); ?>" <?= $smst_ini == $data->semester ? 'selected="selected"' : ''; ?>>
                            <?= 'Semester ' . $data->semester; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Daftar Kelas</h3>
                    <?php if ($status_th == 1) : ?>
                        <div class="block-options">
                            <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-add">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Semester</th>
                                    <th>Kelas</th>
                                    <th>Anggota</th>
                                    <th>Create At</th>
                                    <?php if ($status_th == 1) : ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($bagikelas) || is_object($bagikelas)) : ?>
                                    <?php foreach ($bagikelas as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->semester; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kelas; ?></td>
                                            <td class="font-size-sm">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Total anggota">
                                                        <?= anggotaKelas($hasil->id); ?>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-info " data-toggle="tooltip" title="Custom Anggota kelas" onclick="location.href='<?= base_url('prodi/bagikelas/anggota/') . enkrip($hasil->id); ?>';">
                                                        <i class="fa fa-cogs"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning " data-toggle="tooltip" title="Lanjutkan kelas">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success btn-list-mhs" data-toggle="modal" title="List Mahasiswa" data-target="#list-mhs" data-id="<?= enkrip($hasil->id); ?>">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>

                                            </td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?> </td>
                                            <?php if ($status_th == 1) : ?>
                                                <td class="font-size-sm">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-warning edit_btn" data-toggle="modal" data-target="#modal-edit" data-id="<?= enkrip($hasil->id); ?>" data-kelas="<?= $hasil->kelas; ?>" data-semester="<?= $hasil->semester; ?>" data-kurikulum="<?= $hasil->kode_kurikulum; ?>" title="Edit">
                                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button" data-href="<?= base_url('prodi/bagikelas/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
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

<div class="modal" id="list-mhs" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">List Mahasiswa</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" id="tabel_mhs">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody id="isi_table">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="block-content block-content-full text-right border-top">
                    <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
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
                    <h3 class="block-title text-center">Tambah</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/bagikelas/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="kelas">Semester</label>
                            <select class="form-control" name="semester" required autocomplete="off">
                                <option>Pilih Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <?php if ($i % 2 == 0) : ?>
                                        <?php if ($periode == 2) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?php if ($periode == 1) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Nama Kelas</label>
                            <select class="js-select2 form-control" name="kelas" required autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih kelas..">
                                <option></option>
                                <?php foreach ($kelas as $hasil) : ?>
                                    <option value="<?= $hasil->kelas; ?>"><?= $hasil->kelas; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kurikulum</label>
                            <select class="js-select2 form-control" name="kurikulum" required autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih kelas..">
                                <option></option>
                                <?php foreach ($kurikulum as $hasil) : ?>
                                    <option value="<?= $hasil->kode_kurikulum; ?>">
                                        <?= $hasil->keterangan_kurikulum . ' - ' . $hasil->kode_kurikulum; ?></option>
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
                    <h3 class="block-title text-center">Edit Kelas</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/bagikelas/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="id" id="id" required>
                        <div class="form-group">
                            <label for="kelas">Semester</label>
                            <select class="form-control" name="semester" id="semester" required autocomplete="off">
                                <option>Pilih Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <?php if ($i % 2 == 0) : ?>
                                        <?php if ($periode == 2) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?php if ($periode == 1) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Nama Kelas</label>
                            <select class="js-select2 form-control" name="kelas" id="kelas" required autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih kelas..">
                                <option></option>
                                <?php foreach ($kelas as $hasil) : ?>
                                    <option value="<?= $hasil->kelas; ?>"><?= $hasil->kelas; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kurikulum</label>
                            <select class="js-select2 form-control" name="kurikulum" id="kurikulum" required autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih kelas..">
                                <option></option>
                                <?php foreach ($kurikulum as $hasil) : ?>
                                    <option value="<?= $hasil->kode_kurikulum; ?>">
                                        <?= $hasil->keterangan_kurikulum . ' - ' . $hasil->kode_kurikulum; ?></option>
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
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>


<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<script>
    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?php echo base_url('prodi/bagikelas/') ?>' + tahun;
    });

    $('#by_semester').change(function() {
        let semester = $(this).find(':selected').val();
        let tahun = $('#by_tahun').find(':selected').val();

        document.location.href = '<?php echo base_url('prodi/bagikelas/') ?>' + tahun + '/' + semester;
    });

    let edit_btn = $('.edit_btn');
    $(edit_btn).each(function(i) {
        $(edit_btn[i]).click(function() {
            let id = $(this).data('id');
            let kelas = $(this).data('kelas');
            let semester = $(this).data('semester');
            let kurikulum = $(this).data('kurikulum');

            $('#id').val(id);
            $('#kelas').val(kelas);
            $('#kelas').select2().trigger('change');
            $('#semester').val(semester);
            $('#kurikulum').val(kurikulum);
            $('#kurikulum').select2().trigger('change');
        });
    });

    let list_mhs = $('.btn-list-mhs');

    $(list_mhs).each(function(i) {
        $(list_mhs[i]).click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('prodi/bagikelas/getListMhs/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    $('.tr_isi').remove();
                    if (result) {
                        $(result).each(function(i) {
                            $("#tabel_mhs").append(
                                "<tr class=" + "tr_isi" + ">" +
                                "<td>" + (i + 1) + "</td>" +
                                "<td>" + result[i].nim + "</td>" +
                                "<td>" + result[i].nama_lengkap + "</td>" +
                                "<tr>");
                        });
                    } else {
                        $("#tabel_mhs").append(
                            "<tr class=" + "tr_isi" + ">" +
                            "<td colspan='3' class='text-center'>Kosong</td>" +
                            "<tr>");
                    }
                }
            });
        });
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/bagikelas') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/bagikelas') ?>"]').parent().parent().parent().addClass('open');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/bagikelas') ?>"]').parent().parent().parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>