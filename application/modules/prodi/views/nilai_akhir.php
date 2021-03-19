<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-4 col-xl-4">
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
        <div class="col-sm-8 col-xl-8">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_kelas_mk" id="by_kelas_mk" style="width: 100%;" data-placeholder="Silakan pilih mata kuliah & kelas..">
                    <option></option>
                    <?php foreach ($kelas_mk as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $kelas_mk_ini == $data->id ? 'selected="selected"' : ''; ?> data-dosen="<?= enkrip($data->kd_dosen); ?>" data-smt="<?= enkrip($data->smt); ?>" data-kelas="<?= enkrip($data->kelas); ?>" data-makul="<?= enkrip($data->makul); ?>">
                            <?= $data->nama_mk . ' - Smt: ' . $data->smt . ' - Kelas: ' . $data->kelas . ' - Dosen: ' . $data->gelar_depan . ' ' . $data->nama . ', ' . $data->gelar_belakang; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Nilai Akhir</h3>
                </div>
                <center>
                    <div class="spinner-border text-dark mt-4 mb-4 d-none" id="loader" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </center>
                <div class="block-content block-content-full" id="tampil">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END Page Content -->
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>

<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<script>
    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();

        let data = {
            tahun: tahun
        };
        $.ajax({
            url: "<?= base_url('prodi/nilai_akhir/getGroup'); ?>",
            type: 'get',
            dataType: 'json',
            data: data,
            beforeSend: function(e) {
                $('#tampil').addClass('d-none');
            },
            success: function(result) {
                let option = [];
                option.push('<option></option>');
                $(result).each(function(i) {
                    option.push(
                        '<option value="' + result[i].id + '" data-dosen="' + result[i].kd_dosen + '" data-kelas="' + result[i].kelas + '" data-smt="' + result[i].smt + '" data-makul="' + result[i].makul + '">' +
                        result[i].text + '</option>');
                });
                $('#by_kelas_mk').html(option.join(''));
            }
        });
    });
    $('#by_kelas_mk').change(function() {
        let dosen = $(this).find(':selected').data('dosen');
        let smt = $(this).find(':selected').data('smt');
        let kelas = $(this).find(':selected').data('kelas');
        let makul = $(this).find(':selected').data('makul');

        let tahun = $('#by_tahun').find(':selected').val();

        let data = {
            dosen: dosen,
            smt: smt,
            kelas: kelas,
            makul: makul,
            tahun: tahun
        };

        $.ajax({
            url: "<?= base_url('prodi/nilai_akhir/getNilai'); ?>",
            type: 'get',
            dataType: 'html',
            data: data,
            async: true,
            beforeSend: function(e) {
                $('#loader').removeClass('d-none');
                $('#tampil').addClass('d-none');
            },
            success: function(respon) {
                $('#tampil').removeClass('d-none');
                $('#tampil').html(respon);
            },
            complete: function() {
                $('#tampil').removeClass('d-none');
                $('#loader').addClass('d-none');
            }
        });

    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/nilai_akhir') ?>"]').addClass('active');

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>