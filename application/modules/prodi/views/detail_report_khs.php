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
                <select class="form-control" name="by_tahun" id="by_tahun">
                    <option>-- Pilih tahun akademik --</option>
                    <?php foreach ($tahun as $data) : ?>
                        <option value="<?= enkrip($data->id); ?>" <?= $th_ini == $data->id ? 'selected="selected"' : ''; ?>><?= $data->tahun_akademik; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 text-right">
            <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Back" onclick="location.href='<?= $this->session->userdata('previous_url'); ?>';">
                <i class="fa fa-fw fa-arrow-left"></i> back to Report KHS
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Detail Report KHS</h3>
                    <div class="block-options">
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-t-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Kode MK</th>
                                    <th>Mata Kuliah</th>
                                    <th>Semester</th>
                                    <th>Nilai</th>
                                    <th>Bobot</th>
                                    <th>SKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $totalSks = 0;
                                $totalNilai = 0; ?>
                                <?php if (is_array($data_khs) || is_object($data_khs)) : ?>
                                    <?php foreach ($data_khs as $hasil) : ?>
                                        <?php
                                        $totalSks += $hasil->sks;
                                        $this->db->where("'$hasil->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
                                        $nilai = $this->db->get('bobot_nilai')->row();

                                        $totalNilai += $nilai->bobot
                                        ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->kode_mk; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama_mk ?></td>
                                            <td class="font-size-sm"><?= $hasil->semester; ?></td>
                                            <td class="font-size-sm"><?= $nilai->huruf; ?></td>
                                            <td class="font-size-sm"><?= $nilai->bobot . '.00'; ?></td>
                                            <td class="font-size-sm"><?= $hasil->sks ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <?php if ($data_khs) : ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right font-w600">Total</td>
                                        <td class="text-center font-w600"></td>
                                        <td class="text-center font-w600"><?php echo $totalSks ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-w600">IPS</td>
                                        <td colspan="2" class="text-center font-w600"><?php echo sprintf("%.2f", $totalNilai / count($data_khs)); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <button type="button" class="btn btn-sm btn-success btn-block" data-toggle="tooltip" title="Cetak KHS" onclick="window.open('<?= base_url('prodi/reportkhs/cetak/') . $nim . '/' . enkrip($th_ini); ?>')">
                                                <i class="fa fa-fw fa-check"></i> Cetak
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?>
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

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>
<script>
    let nim = '<?= $nim; ?>';
    $('#by_tahun').change(function() {
        let tahun = $(this).find(':selected').val();
        document.location.href = '<?= base_url('prodi/reportkhs/detail/') ?>' + nim + '/' + tahun;
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/reportkhs') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/reportkhs') ?>"]').parent().parent().parent().addClass('open');
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>