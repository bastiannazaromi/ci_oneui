<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Data Diri</h3>
            <div class="block-options">
                <button type="button" onclick="window.location.href='<?php echo base_url('mahasiswa/profil') ?>'" class="btn btn-sm btn-alt-light"><i class="fa fa-times"></i> Batalkan</button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <form action="<?= base_url('mahasiswa/profil/update') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="col-sm-12">
                    <p class="font-size-sm text-muted">
                        Silakan isi data diri dengan lengkap dan benar, Anda bisa menghubungi admin prodi untuk mengubah
                        data diri jika kolom yang disediakan tidak ada.
                    </p>
                    <div class="form-group">
                        <label for="example-text-input">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" value="<?= $this->user->nisn ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $this->user->nik ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?= $this->user->nim ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namalengkap" name="namalengkap" value="<?= $this->user->nama_lengkap ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="<?= $this->user->tempat_lahir ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" value="<?= $this->user->tanggal_lahir ?>">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Agama</label>
                        <select id="agama" required name="agama" class="form-control">
                            <option value="">Pilih...</option>
                            <?php foreach ($agama as $ag) : ?>
                                <?php if ($ag->agama == $this->user->agama) : ?>
                                    <option selected value="<?= enkrip($ag->id) ?>"><?= $ag->agama ?></option>
                                <?php else : ?>
                                    <option value="<?= enkrip($ag->id) ?>"><?= $ag->agama ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Jenis Kelamin</label>
                        <select id="jk" required name="jk" class="form-control">
                            <option value="">Pilih...</option>
                            <?php if ($this->user->jk == 'L') : ?>
                                <option selected value=<?= enkrip("L") ?>>Laki-laki</option>
                                <option value=<?= enkrip("P") ?>>Perempuan</option>
                            <?php else : ?>
                                <option value=<?= enkrip("L") ?>>Laki-laki</option>
                                <option selected value=<?= enkrip("P") ?>>Perempuan</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <select class="js-select2 form-control" name="provinsi" id="provinsi" style="width: 100%;" data-placeholder="Choose one..">
                            <option value=""></option>
                            <?php foreach ($provinsi as $hasil) : ?>
                                <option value="<?= enkrip($hasil->id_prov); ?>" <?= $this->user->provinsi == $hasil->id_prov ? 'selected="selected"' : ''; ?>>
                                    <?= $hasil->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kota_kab">Kota / Kabupaten</label>
                        <select class="js-select2 form-control" name="kota_kab" id="kota_kab" style="width: 100%;" data-placeholder="Choose one..">
                            <option value=""></option>
                            <?php foreach ($kabupaten as $hasil) : ?>
                                <option value="<?= enkrip($hasil->id_kab); ?>" <?= $this->user->kab_kota == $hasil->id_kab ? 'selected="selected"' : ''; ?>>
                                    <?= $hasil->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kec">Kecamatan</label>
                        <select class="js-select2 form-control" name="kec" id="kec" style="width: 100%;" data-placeholder="Choose one..">
                            <option value=""></option>
                            <?php foreach ($kecamatan as $hasil) : ?>
                                <option value="<?= enkrip($hasil->id); ?>" <?= $this->user->kecamatan == $hasil->id ? 'selected="selected"' : ''; ?>>
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
                                <option value="<?= enkrip($hasil->id); ?>" <?= $this->user->desa == $hasil->id ? 'selected="selected"' : ''; ?>>
                                    <?= $hasil->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Your Avatar</label>
                        <div class="push">
                            <img class="img-avatar img-avatar64" id="gambar_nodin" src="
                                <?=
                                ($this->user->foto == 'default.jpg' || $this->user->foto == '') ?
                                    base_url('upload/default.jpg') :
                                    base_url('upload/mhs/' . $this->user->foto)
                                ?>                                
                                " alt="Profile">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" data-toggle="custom-file-input" name="foto">
                            <label class="custom-file-label" for="one-profile-edit-avatar">Choose a new
                                avatar</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-alt-secondary mb-2">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>

<!-- Page JS Code -->
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>
<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<!-- Page JS Helpers (BS Notify Plugin) -->
<script>
    $('#provinsi').change(function() {
        let id_prov = $(this).val();
        $.ajax({
            url: "<?= base_url('mahasiswa/profil/getKab/'); ?>" + id_prov,
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

                $('#kota_kab').html(option.join(''));

            }
        });
    });

    $('#kota_kab').change(function() {
        let id_kab = $(this).val();
        $.ajax({
            url: "<?= base_url('mahasiswa/profil/getKec/'); ?>" + id_kab,
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
            url: "<?= base_url('mahasiswa/profil/getDesa/'); ?>" + id_kec,
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
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>