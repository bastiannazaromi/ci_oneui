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
                <select class="js-select2 form-control" name="by_tahun" id="by_tahun" style="width: 100%;" data-placeholder="Silakan pilih tahun..">
                    <option></option>
                    <?php foreach ($tahun as $data) : ?>
                        <option value="<?= enkrip($data->tahun); ?>" <?= $th_ini == $data->tahun ? 'selected="selected"' : ''; ?>><?= $data->tahun; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_status" id="by_status" style="width: 100%;" data-placeholder="Silakan pilih status..">
                    <option></option>
                    <?php foreach ($status as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $status_ini == $data->id ? 'selected="selected"' : ''; ?>><?= $data->nama_status; ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="<?= enkrip(0); ?>" <?= $status_ini == 0 ? 'selected="selected"' : ''; ?>>Semua
                    </option>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Master Mahasiswa</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Download Format" onclick="window.location='<?= base_url('excel/Format_mhs.xlsx'); ?>'">
                            <i class="fa fa-download"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import" title="Import Excel">
                            <i class="fa fa-upload"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
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
                                    <th>Tahun Masuk</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>JK</th>
                                    <th>Jalur</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($mahasiswa) || is_object($mahasiswa)) : ?>
                                    <?php foreach ($mahasiswa as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->tahun_masuk; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nim; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_lengkap; ?></td>
                                            <td class="font-size-sm"><?= ($hasil->jk == '0') ? 'L' : 'P'; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_jalur; ?></td>
                                            <td class="font-size-sm">
                                                <span class="badge <?php if ($hasil->status_mahasiswa == 1) echo 'badge-success';
                                                                    elseif ($hasil->status_mahasiswa == 2) echo 'badge-info';
                                                                    elseif ($hasil->status_mahasiswa == 3) echo 'badge-danger';
                                                                    elseif ($hasil->status_mahasiswa == 4) echo 'badge-warning'; ?>"><?= $hasil->nama_status; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit" onclick="location.href='<?= base_url('management/mastermhs/edit/') . enkrip($hasil->id); ?>';">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" data-href="<?= base_url('management/mastermhs/delete/') . enkrip($hasil->id); ?>" data-text="data akan dihapus" class="btn btn-sm btn-danger tombol-hapus" data-toggle="tooltip" title="Delete">
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
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromright modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Add Mahasiswa</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <form action="<?= base_url('management/mastermhs/add'); ?>" method="post">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="block-content font-size-sm">
                                    <div class="form-group">
                                        <label for="prodi">Program Studi</label>
                                        <select class="js-select2 form-control" name="prodi" style="width: 100%;" data-placeholder="Choose one..">
                                            <option></option>
                                            <?php foreach ($prodi as $data) : ?>
                                                <option value="<?= enkrip($data->kd_prodi); ?>"><?= $data->nama; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK / No. KTP</label>
                                        <input type="text" class="js-maxlength form-control" name="nik" maxlength="16" required autocomplete="off" data-always-show="true" data-placement="bottom-right">
                                    </div>
                                    <div class="form-group">
                                        <label for="nim">NIM</label>
                                        <input type="text" class="js-maxlength form-control" maxlength="8" name="nim" required autocomplete="off" data-always-show="true" data-placement="bottom-right">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="negara">Kewarganegaraan</label>
                                        <select class="form-control js-select2" name="negara" style="width: 100%;" data-placeholder="Silakan pilih Kewarganegaraan..">
                                            <?php foreach ($negara as $data) : ?>
                                                <option value="<?php echo enkrip($data->id_negara) ?>"><?php echo $data->nm_negara ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select class="form-control" name="jk">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="<?= enkrip('L'); ?>">Laki - laki</option>
                                            <option value="<?= enkrip('P'); ?>">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <select class="form-control" name="agama">
                                            <option value="">-- Pilih Agama --</option>
                                            <?php foreach ($agama as $hasil) : ?>
                                                <option value="<?php echo enkrip($hasil->id) ?>"><?= $hasil->agama; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_menikah">Status Menikah</label>
                                        <select class="form-control" name="status_menikah">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="<?= enkrip(0); ?>">Belum Kawin</option>
                                            <option value="<?= enkrip(1); ?>">Kawin</option>
                                            <option value="<?= enkrip(2); ?>">Janda / Duda</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="block-content font-size-sm">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <select class="js-select2 form-control" name="provinsi" id="provinsi" style="width: 100%;" data-placeholder="Choose one..">
                                            <option value=""></option>
                                            <?php foreach ($provinsi as $hasil) : ?>
                                                <option value="<?= enkrip($hasil->id_prov); ?>"><?= $hasil->nama; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kab_kota">Kota / Kabupaten</label>
                                        <select class="js-select2 form-control" name="kab_kota" id="kab_kota" style="width: 100%;" data-placeholder="Choose one..">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kec">Kecamatan</label>
                                        <select class="js-select2 form-control" name="kec" id="kec" style="width: 100%;" data-placeholder="Choose one..">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="desa">Desa / Kelurahan</label>
                                        <select class="js-select2 form-control" name="desa" id="desa" style="width: 100%;" data-placeholder="Choose one..">
                                        </select>
                                    </div>
                                    <div class="form-group pt-2">
                                        <label for="asal_sekolah">Asal Sekolah</label>
                                        <input type="text" class="form-control" name="asal_sekolah" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="ibu">Nama Ibu Kandung</label>
                                        <input type="text" class="form-control" name="ibu" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun">Tahun Masuk</label>
                                        <input type="number" class="js-maxlength form-control" name="tahun" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" min="2000" max="<?= $max_th; ?>" required autocomplete="off" data-always-show="true" data-placement="bottom-right">

                                    </div>
                                    <div class="form-group">
                                        <label for="semester">Semester Masuk</label>
                                        <select class="form-control" name="semester">
                                            <option value="">-- Pilih --</option>
                                            <?php for ($i = 1; $i <= 8; $i++) : ?>
                                                <option value="<?= $i; ?>"><?= $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jalur">Jalur</label>
                                        <select class="form-control" name="jalur">
                                            <option value="">-- Pilih Jalur --</option>
                                            <?php foreach ($jalur as $hasil) : ?>
                                                <option value="<?= enkrip($hasil->id); ?>"><?= $hasil->nama_jalur; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status Mahasiswa</label>
                                        <select class="form-control" name="status">
                                            <option value="">-- Pilih Status --</option>
                                            <?php foreach ($status as $hasil) : ?>
                                                <option value="<?= enkrip($hasil->id); ?>"><?= $hasil->nama_status; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->

<!-- Modal Import -->
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromright" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Import Mahasiswa</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <form action="<?= base_url('management/mastermhs/import'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="block-content font-size-sm">
                                    <div class="form-group">
                                        <label for="nama">File Upload</label>
                                        <input type="file" class="form-control" accept=".xlsx" name="file_excel" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full text-right border-top">
                                <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MEnd Modal Import -->

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
    $('#provinsi').change(function() {
        let id_prov = $(this).val();

        $.ajax({
            url: "<?= base_url('management/mastermhs/getKab/'); ?>" + id_prov,
            type: 'get',
            dataType: 'json',
            success: function(result) {
                let option = [];
                option.push('<option value="">-- Pilih --</option>');
                $(result).each(function(i) {
                    option.push(
                        '<option value="' + result[i].id_kab + '">' +
                        result[i].nama + '</option>');
                });
                $('#kab_kota').html(option.join(''));
            }
        });
    });
    $('#kab_kota').change(function() {
        let id_kab = $(this).val();
        $.ajax({
            url: "<?= base_url('management/mastermhs/getKec/'); ?>" + id_kab,
            type: 'get',
            dataType: 'json',
            success: function(result) {
                let option = [];
                option.push('<option value="">-- Pilih --</option>');
                $(result).each(function(i) {
                    option.push(
                        '<option value="' + result[i].id_kec + '">' +
                        result[i].nama + '</option>');
                });
                $('#kec').html(option.join(''));
            }
        });
    });
    $('#kec').change(function() {
        let id_kec = $(this).val();
        $.ajax({
            url: "<?= base_url('management/mastermhs/getDesa/'); ?>" + id_kec,
            type: 'get',
            dataType: 'json',
            success: function(result) {
                let option = [];
                option.push('<option value="">-- Pilih --</option>');
                $(result).each(function(i) {
                    option.push(
                        '<option value="' + result[i].id + '">' +
                        result[i].nama + '</option>');
                });

                $('#desa').html(option.join(''));
            }
        });
    });

    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/mastermhs/') . $this->u3 . '/'; ?>' + tahun;
    });

    $('#by_status').change(function() {
        let tahun = $('#by_tahun').find(':selected').val();
        if (!tahun) {
            tahun = '<?= enkrip($th_ini); ?>';
        }

        let status = $(this).find(':selected').val();
        document.location.href = '<?= base_url('management/mastermhs/') . $this->u3 . '/'; ?>' + tahun + '/' +
            status;
    });
    $('li.nav-main-item').find('a[href*="<?= base_url('management/mastermhs/') . $this->u3 ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('management/mastermhs/') . $this->u3 ?>"]').parent().parent().parent().addClass('open');
    $('li.nav-main-item').find('a[href*="<?= base_url('management/mastermhs/') . $this->u3 ?>"]').parent().parent().parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2', 'maxlength']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>