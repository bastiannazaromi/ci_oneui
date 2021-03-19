<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>

<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="kurikulum" id="kurikulum" style="width: 100%;" data-placeholder="Silakan pilih kurikulum..">
                    <option></option>
                    <?php foreach ($kurikulum as $data) : ?>
                        <option <?php echo ($kode_kurikulum == enkrip($data->kode_kurikulum) ? 'selected="selected"' : '') ?> value="<?= enkrip($data->kode_kurikulum); ?>"><?= $data->keterangan_kurikulum; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <select class="js-select2 form-control" name="periode" id="periode" style="width: 100%;" data-placeholder="Silakan pilih periode..">
                    <option></option>
                    <option <?php echo ($periode == 1) ? 'selected="selected"' : '' ?> value="<?php echo enkrip(1) ?>">Ganjil</option>
                    <option <?php echo ($periode == 2) ? 'selected="selected"' : '' ?> value="<?php echo enkrip(2) ?>">Genap</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Mata Kuliah Di Tawarkan</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-add" id="add">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>KODE MK</th>
                                    <th>MATA KULIAH</th>
                                    <th>SEMESTER</th>
                                    <th>SKS</th>
                                    <th>DITAWARKAN</th>
                                    <th>Create At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?php $i = 1; ?>
                                <?php if (is_array($mk_tawarkan) || is_object($mk_tawarkan)) : ?>
                                    <?php foreach ($mk_tawarkan as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kode_mk; ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->nama_mk ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->semester ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->sks ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-success">YA</span>
                                            </td>
                                            <td class="font-size-sm"><?= $hasil->created_at; ?></td>
                                            <td class="text-center" style="display: inline-flex;">
                                                <button type="button" data-href="<?= base_url('prodi/mk_tawarkan/delete/') . enkrip($hasil->id_tawarkan); ?>" style="display: inline-block;" class="btn btn-sm btn-danger tombol-hapus" data-text="data akan dihapus" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-fw fa-trash"></i>
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
</div>

<!-- Modal Add -->
<div class="modal" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Tambah Mata Kuliah Tawarkan</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/mk_tawarkan/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="periode" value="<?= enkrip($periode); ?>">
                        <div class="form-group">
                            <select class="js-select2 form-control" name="kurikulum_add" id="kurikulum_select" style="width: 100%;" data-placeholder="Silakan pilih kurikulum..">
                                <option></option>
                                <?php foreach ($kurikulum as $data) : ?>
                                    <option value="<?= enkrip($data->kode_kurikulum); ?>"><?= $data->keterangan_kurikulum; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="js-select2 form-control" name="mata_kuliah" id="mata_kuliah" style="width: 100%;" data-placeholder="Silakan pilih mata kuliah..">
                                <option></option>
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

<?php $one->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/dataTables.bootstrap4.min.js'); ?>

<!-- Page JS Code -->
<?php $one->get_js('js/pages/be_tables_datatables.min.js'); ?>
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>
<script>
    $('#kurikulum').change(function() {
        let kd_kurikulum = $(this).val();
        document.location.href = '<?php echo base_url('prodi/mk_tawarkan/') ?>' + kd_kurikulum;
    });
    $('#periode').change(function() {
        $('#add').remove();
        let kurikulum = $('#kurikulum').find(':selected').val();
        let periode = $(this).val();
        document.location.href = '<?php echo base_url('prodi/mk_tawarkan/') ?>' + kurikulum + '/' + periode;
    });
    $('#kurikulum_select').change(function() {
        let kd_kurikulum = $(this).val();
        let k = '<?= enkrip($periode); ?>';

        $.ajax({
            url: '<?php echo base_url('prodi/mk_tawarkan/getMataKuliah/') ?>' + kd_kurikulum + '/' + k,
            type: 'GET',
            dataType: 'JSON',
            success: function(respon) {
                let option = [];
                option.push('<option value="">-- Pilih Mata Kuliah --</option>');
                $(respon).each(function(i) {
                    option.push('<option value="' + respon[i].kd_mk + '">' + respon[i].nama + '</option>')
                });
                $('#mata_kuliah').html(option.join(''));
            }
        })
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/mk_tawarkan') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/mk_tawarkan') ?>"]').parent().parent().parent().addClass('open');
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>