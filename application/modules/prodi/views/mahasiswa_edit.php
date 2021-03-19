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

<!-- Page Content -->
<div class="content">

    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Edit Mahasiswa</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="block-content font-size-sm">
                        <form action="<?= base_url('prodi/mahasiswa/edit/prosess'); ?>" method="post">
                            <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="block-content font-size-sm">
                                        <input type="hidden" class="form-control" value="<?= enkrip($mahasiswa->id); ?>" name="id">
                                        <div class="form-group">
                                            <label for="prodi">Program Studi</label>
                                            <select class="js-select2 form-control" name="prodi" style="width: 100%;" data-placeholder="Choose one..">
                                                <option></option>
                                                <?php foreach ($prodi as $data) : ?>
                                                    <option value="<?= enkrip($data->kd_prodi); ?>" <?= $data->kd_prodi == $mahasiswa->prodi ? 'selected="selected"' : ''; ?>>
                                                        <?= $data->nama; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nik">NIK / No. KTP</label>
                                            <input type="text" class="form-control" name="nik" maxlength="16" required autocomplete="off" value="<?= $mahasiswa->nik; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="nim">NIM</label>
                                            <input type="text" class="form-control" maxlength="8" name="nim" required autocomplete="off" value="<?= $mahasiswa->nim; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama" required autocomplete="off" value="<?= $mahasiswa->nama_lengkap; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="negara">Kewarganegaraan</label>
                                            <select class="form-control" name="negara">
                                                <option value="">-- Pilih --</option>
                                                <option value="<?= enkrip(0); ?>" <?= $mahasiswa->negara == 0 ? 'selected="selected"' : ''; ?>>Warga
                                                    Negara
                                                    Indonesia (WNI)</option>
                                                <option value="<?= enkrip(1); ?>" <?= $mahasiswa->negara == 1 ? 'selected="selected"' : ''; ?>>Warga
                                                    Negara
                                                    Asing (WNA)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tempat">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat" value="<?= $mahasiswa->tempat_lahir; ?>" required autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" value="<?= $mahasiswa->tanggal_lahir; ?>" name="tanggal_lahir" required autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="jk">Jenis Kelamin</label>
                                            <select class="form-control" name="jk">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="<?= enkrip(0); ?>" <?= $mahasiswa->jk == 0 ? 'selected="selected"' : ''; ?>>Laki - laki
                                                </option>
                                                <option value="<?= enkrip(1); ?>" <?= $mahasiswa->jk == 1 ? 'selected="selected"' : ''; ?>>Perempuan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="agama">Agama</label>
                                            <select class="form-control" name="agama">
                                                <option value="">-- Pilih Agama --</option>
                                                <?php foreach ($agama as $hasil) : ?>
                                                    <option value="<?= $hasil->agama; ?>" <?= $mahasiswa->agama == $hasil->agama ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->agama; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status_menikah">Status Menikah</label>
                                            <select class="form-control" name="status_menikah">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="<?= enkrip(0); ?>" <?= $mahasiswa->status_nikah == 0 ? 'selected="selected"' : ''; ?>>
                                                    Belum
                                                    Kawin</option>
                                                <option value="<?= enkrip(1); ?>" <?= $mahasiswa->status_nikah == 1 ? 'selected="selected"' : ''; ?>>
                                                    Kawin
                                                </option>
                                                <option value="<?= enkrip(2); ?>" <?= $mahasiswa->status_nikah == 2 ? 'selected="selected"' : ''; ?>>
                                                    Janda
                                                    / Duda</option>
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
                                                    <option value="<?= enkrip($hasil->id_prov); ?>" <?= $mahasiswa->provinsi == $hasil->id_prov ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->nama; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kab_kota">Kota / Kabupaten</label>
                                            <select class="js-select2 form-control" name="kab_kota" id="kab_kota" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value=""></option>
                                                <?php foreach ($kab as $hasil) : ?>
                                                    <option value="<?= enkrip($hasil->id_kab); ?>" <?= $mahasiswa->kab_kota == $hasil->id_kab ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->nama; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kec">Kecamatan</label>
                                            <select class="js-select2 form-control" name="kec" id="kec" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value=""></option>
                                                <?php foreach ($kec as $hasil) : ?>
                                                    <option value="<?= enkrip($hasil->id); ?>" <?= $mahasiswa->kecamatan == $hasil->id ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->nama; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="desa">Desa / Kelurahan</label>
                                            <select class="js-select2 form-control" name="desa" id="desa" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value=""></option>
                                                <?php foreach ($desa as $hasil) : ?>
                                                    <option value="<?= enkrip($hasil->id); ?>" <?= $mahasiswa->kelurahan == $hasil->id ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->nama; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group pt-2">
                                            <label for="asal_sekolah">Asal Sekolah</label>
                                            <input type="text" class="form-control" name="asal_sekolah" required autocomplete="off" value="<?= $mahasiswa->asal_sekolah; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="ibu">Nama Ibu Kandang</label>
                                            <input type="text" class="form-control" name="ibu" required autocomplete="off" value="<?= $mahasiswa->nama_ibu; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="tahun">Tahun Masuk</label>
                                            <input type="number" class="form-control" name="tahun" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" min="2000" max="<?= $max_th; ?>" required autocomplete="off" value="<?= $mahasiswa->tahun_masuk; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="semester">Semester Masuk</label>
                                            <select class="form-control" name="semester">
                                                <option value="">-- Pilih --</option>
                                                <?php for ($i = 1; $i <= 8; $i++) : ?>
                                                    <option value="<?= $i; ?>" <?= $mahasiswa->semester_masuk == $i ? 'selected="selected"' : ''; ?>>
                                                        <?= $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jalur">Jalur</label>
                                            <select class="form-control" name="jalur">
                                                <option value="">-- Pilih Jalur --</option>
                                                <?php foreach ($jalur as $hasil) : ?>
                                                    <option value="<?= enkrip($hasil->id); ?>" <?= $mahasiswa->jalur == $hasil->id ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->nama_jalur; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status Mahasiswa</label>
                                            <select class="form-control" name="status">
                                                <option value="">-- Pilih Status --</option>
                                                <?php foreach ($status as $hasil) : ?>
                                                    <option value="<?= enkrip($hasil->id); ?>" <?= $mahasiswa->status_mahasiswa == $hasil->id ? 'selected="selected"' : ''; ?>>
                                                        <?= $hasil->nama_status; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full text-right border-top">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->

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

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    $('#provinsi').change(function() {
        let id_prov = $(this).val();
        $.ajax({
            url: "<?= base_url('prodi/mahasiswa/getKab/'); ?>" + id_prov,
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
            url: "<?= base_url('prodi/mahasiswa/getKec/'); ?>" + id_kab,
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
            url: "<?= base_url('prodi/mahasiswa/getDesa/'); ?>" + id_kec,
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
        document.location.href = '<?php echo base_url('prodi/mahasiswa/') ?>' + tahun;
    });
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>