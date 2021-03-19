<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Laporan Nilai Akademik</h3>
            <div class="block-options">
                <div class="dropdown d-inline-block">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="js-select2 form-control" name="tahun_akademik" id="tahun_akademik" style="width: 100%;" data-placeholder="Silakan pilih Tahun Akademik">
                                <option></option>
                                <?php foreach ($tahun_akademik as $row) : ?>
                                    <option <?php echo $selected ?> value="<?php echo enkrip($row->id) ?>"><?php echo $row->tahun_akademik ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-akademik">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px;">SMT</th>
                            <th style="width: 340px;">Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th class="text-center">Nilai Hadir</th>
                            <th class="text-center">Nilai Tugas</th>
                            <th class="text-center">Nilai UTS</th>
                            <th class="text-center">Nilai UAS</th>
                            <th class="text-center">Nilai Akhir</th>
                            <th class="text-center">Nilai Huruf</th>
                            <th class="text-center">Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalSks = 0; ?>
                        <?php $totalNilai = 0; ?>
                        <?php foreach ($getNilai as $data) : ?>
                            <?php $totalSks += $data->sks; ?>
                            <tr>
                                <?php
                                $this->db->where("'$data->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
                                $nilai = $this->db->get('bobot_nilai')->row();
                                ?>
                                <?php $totalNilai += $nilai->bobot; ?>
                                <td class="text-center font-size-sm"><?php echo $data->semester ?></td>
                                <td class="font-w600 font-size-sm"><?php echo strtoupper($data->nama_mk) ?>
                                </td>
                                <td class="text-center"><?php echo $data->sks ?></td>
                                <td class="text-center"><?php echo $data->presensi_akhir ?></td>
                                <td class="text-center"><?php echo $data->tugas_akhir ?></td>
                                <td class="text-center"><?php echo $data->uts_akhir ?></td>
                                <td class="text-center"><?php echo $data->uas_akhir ?></td>
                                <td class="text-center"><?php echo $data->nilai_akhir ?></td>
                                <td class="text-center"><?php echo $nilai->huruf ?></td>
                                <td class="text-center"><?php echo $nilai->bobot ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="block mt-1">
                <div class="block-content">
                    <h3 class="block-title">Informasi</h3>
                    <p>Indeks Prestasi Sementara (IPS) Anda saat ini: <b><?php echo sprintf("%.2f", $totalNilai / count($getNilai)); ?></b>
                        <!-- <br>
                        IPS tertinggi diraih saat ini di angkatan Anda adalah: <b>4.00</b>-->
                        <br><br>
                        <b>Rentang Nilai:</b><br>
                        <b>A</b> = 81 - 100<br>
                        <b>B</b> = 71 - 80<br>
                        <b>C</b> = 61 - 70<br>
                        <b>D</b> = 51 - 60<br>
                        <b>E</b> = Kurang dari 60
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $one->get_js('js/plugins/datatables/dataTables.bootstrap4.min.js'); ?>
<?php $one->get_js('js/pages/be_tables_datatables.min.js'); ?>
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>
<script>
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>