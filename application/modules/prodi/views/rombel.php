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
                    <h3 class="block-title text-white">Rombel Kelas</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Kelas</th>
                                    <th>Mata Kuliah</th>
                                    <th>Create At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($kelas) || is_object($kelas)) : ?>
                                    <?php foreach ($kelas as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_kelas; ?></td>
                                            <td class="font-size-sm">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Total Mata Kuliah">
                                                        <?= jmlMK($hasil->id); ?>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-info " data-toggle="tooltip" title="Tambah Mata Kuliah" onclick="location.href='<?= base_url('prodi/rombel/mk/') . enkrip($hasil->id); ?>';">
                                                        <i class="fa fa-fw fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning btn-list-mk" data-toggle="modal" title="List Mata Kuliah" data-target="#list-mk" data-id="<?= enkrip($hasil->id); ?>">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?> </td>
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

<div class="modal" id="list-mk" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Mata Kuliah</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" id="tabel_mk">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Mata Kuliah</th>
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
    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?php echo base_url('prodi/rombel/') ?>' + tahun;
    });

    $('#by_semester').change(function() {
        let semester = $(this).find(':selected').val();
        let tahun = $('#by_tahun').find(':selected').val();

        document.location.href = '<?php echo base_url('prodi/rombel/') ?>' + tahun + '/' + semester;
    });

    let edit_btn = $('.edit_btn');
    $(edit_btn).each(function(i) {
        $(edit_btn[i]).click(function() {
            let id = $(this).data('id');
            let kelas = $(this).data('kelas');
            let semester = $(this).data('semester');

            $('#id').val(id);
            $('#kelas').val(kelas);
            $('#kelas').select2().trigger('change');
            $('#semester').val(semester);
        });
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

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/rombel') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/rombel') ?>"]').parent().parent().parent().addClass('open');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/rombel') ?>"]').parent().parent().parent().parent().parent().addClass('open');

    jQuery(function() {
        One.helpers(['select2']);
    });
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>