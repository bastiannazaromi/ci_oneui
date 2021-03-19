<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php $one->get_css('js/plugins/flatpickr/flatpickr.min.css'); ?>

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
        <div class="col-sm-4 col-xl-4">
            <div class="form-group">
                <select class="js-select2 form-control" name="by_semester" id="by_semester" style="width: 100%;" data-placeholder="Silakan pilih semester..">
                    <option></option>
                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                        <option value="<?= enkrip($i); ?>" <?= $smst_ini == $i ? 'selected="selected"' : ''; ?>>
                            <?= $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4 col-xl-4">
            <div class="form-group">
                <input type="text" class="js-flatpickr form-control bg-white" id="by_date" name="date_now" placeholder="d-m-Y" data-date-format="d-m-Y" value="<?= $date_ini; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Jadwal Perkuliahan</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Kelas</th>
                                    <th>Mata Kuliah</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Dosen Inti</th>
                                    <th>Tim Dosen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($jadwal) || is_object($jadwal)) : ?>
                                    <?php foreach ($jadwal as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil['jadwal']['makul_smt'] . ' ' . $hasil['jadwal']['jadwal_kelas'] ?></td>
                                            <td class="font-size-sm"><?= $hasil['jadwal']['makul_nama'] ?></td>
                                            <td class="font-size-sm"><?= hari($hasil['jadwal']['jadwal_hari']); ?></td>
                                            <td class="font-size-sm"><?= $hasil['jadwal']['jadwal_jammulai'] . ' <br> ' . $hasil['jadwal']['jadwal_jamselesai']; ?></td>
                                            <td class="font-size-sm"><?= tanggal($hasil['jadwal']['jadwal_tglmulai']); ?></td>
                                            <td class="font-size-sm"><?= tanggal($hasil['jadwal']['jadwal_tglselesai']); ?></td>
                                            <td class="font-size-sm"><?= $hasil['dosen_inti']; ?></td>
                                            <td class="font-size-sm"><?= $hasil['tim_dosen']; ?></td>
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

<?php $one->get_js('js/plugins/flatpickr/flatpickr.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<script>
    $('#by_date').change(function() {
        let semester = $('#by_semester').find(':selected').val();
        let tahun = $('#by_tahun').find(':selected').val();
        let date = $(this).val();

        document.location.href = '<?php echo base_url('prodi/jadwal/') ?>' + tahun + '/' + semester + '/' + date;
    });

    let list_mk = $('.btn-list-mk');

    $(list_mk).each(function(i) {
        $(list_mk[i]).click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('prodi/rombel/getListMK/'); ?>" + id,
                type: 'get',
                dataType: 'json',
                success: function(result) {
                    $('.tr_isi').remove();
                    if (result) {
                        $(result).each(function(i) {
                            $("#tabel_mk").append(
                                "<tr class=" + "tr_isi" + ">" +
                                "<td>" + (i + 1) + "</td>" +
                                "<td>" + result[i].nama_mk + "</td>" +
                                "<tr>");
                        });
                    } else {
                        $("#tabel_mk").append(
                            "<tr class=" + "tr_isi" + ">" +
                            "<td colspan='2' class='text-center'>Kosong</td>" +
                            "<tr>");
                    }
                }
            });
        });
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/jadwal') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/jadwal') ?>"]').parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2', 'flatpickr']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>