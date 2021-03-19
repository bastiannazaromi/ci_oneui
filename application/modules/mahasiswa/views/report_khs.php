<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>
<style>
    .hidden-loader {
        display: none !important;
    }
</style>
<div class="content">
    <div class="row">
        <div class="col-sm-6">
            <a class="block block-rounded block-link-pop" href="<?php echo base_url('mahasiswa/profil') ?>">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Informasi Mahasiswa</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <div class="mb-3 py-1">
                                    <img class="img-thumbnail" style="width: 120px;" src="
                                            <?= ($dataMhs->foto == 'default.jpg' || $dataMhs->foto == '') ? base_url('upload/default.jpg') :
                                                base_url('upload/mhs/' . $dataMhs->foto)
                                            ?>
                                            " alt="<?= $dataMhs->nama_lengkap; ?>">
                                </div>
                            </div>
                            <div class="col-sm-9 py-2">
                                <div class="font-size-h3 font-w600"><?= $dataMhs->nama_lengkap; ?> <sup><span class="badge badge-success"><?= $dataMhs->nama_status ?></span></sup></div>
                                <address class="font-size-sm">
                                    <p class="font-size-h6"><b>NIM:</b> <?= $dataMhs->nim; ?><br><b> <?= $dataMhs->jenjang . ' ' . $dataMhs->nama_prodi ?></b> | <b>Semester <?= $dataMhs->semester ?></b><br><b class="font-size-h5"></b> NUROHIM SST,M.KOM |
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Filter</h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Tahun Akademik">Tahun Akademik</label>
                                <select class="js-select2 form-control" name="tahun_akademik" id="tahun_akademik" style="width: 100%;" data-placeholder="Silakan pilih Tahun Akademik">
                                    <option></option>
                                    <?php foreach ($tahun_akademik as $row) : ?>
                                        <option value="<?php echo enkrip($row->id) ?>"><?php echo $row->tahun_akademik ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <center>
                <div class="spinner-border text-dark mt-4 mb-4 hidden-loader" id="loader" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </center>
        </div>
        <div class="col-sm-12" id="tampil"></div>
    </div>
</div>
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>
<script>
    $('#tahun_akademik').change(function() {
        let tahun_akademik = $(this).val();
        $.ajax({
            url: '<?php echo base_url('mahasiswa/laporan/khs/getKhs/') ?>' + tahun_akademik,
            type: 'GET',
            dataType: 'html',
            async: true,
            beforeSend: function(e) {
                $('#loader').removeClass('hidden-loader');
            },
            success: function(respon) {
                $('#tampil').html(respon);
            },
            complete: function() {
                $('#loader').addClass('hidden-loader');
            }
        })
    });
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>