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
        <div class="col-sm-12 mb-3 text-right">
            <button type="button" class="btn btn-sm btn-alt-info" data-toggle="tooltip" title="Kembali" onclick="location.href='<?= $this->session->userdata('previous_url'); ?>';">
                <i class="fa fa-fw fa-arrow-left"></i> Back to rombel
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Tambah Mata Kuliah</h3>
                </div>
                <form action="<?= base_url('prodi/rombel/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" class="form-control" name="kelas" value="<?= enkrip($kelas->id); ?>">
                        <div class="form-group">
                            <label for="kelas">Mata Kuliah</label>
                            <select class="js-select2 form-control" name="mk" required autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih mata kuliah..">
                                <option></option>
                                <?php foreach ($mk as $hasil) : ?>
                                    <option value="<?= enkrip($hasil->kode_mk); ?>"><?= $hasil->nama_mk; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Dosen Inti</label>
                            <select class="js-select2 form-control" name="dosen" id="dosen" required autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih dosen..">
                                <option></option>
                                <?php foreach ($dosen as $hasil) : ?>
                                    <option value="<?= enkrip($hasil->username); ?>">
                                        <?= $hasil->gelar_depan . ' ' . $hasil->nama . ' ' . $hasil->gelar_belakang; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Tim Dosen</label>
                            <select class="js-select2 form-control" multiple name="tim_dosen[]" id="tim_dosen" autocomplete="off" style="width: 100%;" data-placeholder="Silakan pilih dosen..">
                            </select>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-fw fa-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Mata Kuliah Kelas <?= $kelas->nama_kelas; ?></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Mata Kuliah</th>
                                    <th>Nama Dosen</th>
                                    <th><i class="fa fa-fw fa-times text-danger"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($rombel) || is_object($rombel)) : ?>
                                    <?php foreach ($rombel as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_mk; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Total Tim Dosen">
                                                        <?= jmlTim($hasil->id); ?>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-info btn-tim-dosen" data-toggle="modal" title="Lihat Tim Dosen" data-target="#lihat-tim-dosen" data-id="<?= enkrip($hasil->id); ?>">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm tombol-hapus" data-href="<?= base_url('prodi/rombel/delete/') . enkrip($hasil->id); ?>" data-text="mata kuliah akan di hapus dari kelas" data-toggle="tooltip" title="Hapus"><i class="fa fa-fw fa-times"></i></button>
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

<div class="modal" id="lihat-tim-dosen" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Tim Dosen</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" id="tabel_ds">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
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
    $('#dosen').change(function() {
        let id_dosen = $(this).val();
        console.log(id_dosen);

        $.ajax({
            url: "<?= base_url('prodi/rombel/getDosen/'); ?>" + id_dosen,
            type: 'get',
            dataType: 'json',
            success: function(result) {
                let option = [];
                option.push('<option value="">-- Pilih --</option>');
                $(result).each(function(i) {
                    option.push(
                        '<option value="' + result[i].username + '">' +
                        result[i].nama + '</option>');
                });
                $('#tim_dosen').html(option.join(''));
                console.log(result);
            }
        });
    });

    let tim_dosen = $('.btn-tim-dosen');

    $(tim_dosen).each(function(i) {
        $(tim_dosen[i]).click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('prodi/rombel/getTimDosen/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    $('.tr_isi').remove();
                    if (result) {
                        $(result).each(function(i) {
                            $("#tabel_ds").append(
                                "<tr class=" + "tr_isi" + ">" +
                                "<td>" + (i + 1) + "</td>" +
                                "<td>" + result[i].nama + "</td>" +
                                "<td>" + result[i].prodi + "</td>" +
                                "<tr>");
                        });
                    } else {
                        $("#tabel_ds").append(
                            "<tr class=" + "tr_isi" + ">" +
                            "<td colspan='3' class='text-center'>Kosong</td>" +
                            "<tr>");
                    }
                }
            });
        });
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/rombel') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/rombel') ?>"]').parent().parent().parent().addClass('open');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/rombel') ?>"]').parent().parent().parent().parent().parent().addClass('open');
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>