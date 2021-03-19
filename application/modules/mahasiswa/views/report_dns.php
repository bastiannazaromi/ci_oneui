<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Detail DNS</h3>
                    <button data-toggle="modal" data-target="#modal-print" class="btn btn-sm btn-alt-primary"><i class="fa fa-print"></i> Cetak DNS</button>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="js-table-checkable table table-hover table-vcenter js-table-checkable-enabled">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">KODE</th>
                                    <th class="text-center">MATA KULIAH</th>
                                    <th class="text-center">SEMESTER</th>
                                    <td class="text-center">JENIS</td>
                                    <th class="text-center">SKS</th>
                                    <th class="text-center">NILAI</th>
                                    <th class="text-center">BOBOT</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                                <?php if ($dns) : ?>
                                    <?php foreach ($dns as $data) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?></td>
                                            <td class="text-center"><?php echo $data->kode_mk ?></td>
                                            <td class="text-center"><?php echo $data->nama_mk ?></td>
                                            <td class="text-center"><?php echo $data->semester ?></td>
                                            <td class="text-center"><?php echo ($data->jalur == 1) ? "Reguler" : "Ekstensi" ?></td>
                                            <td class="text-center"><?php echo $data->sks ?></td>
                                            <td class="text-center">
                                                <?php
                                                $this->db->where("'$data->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
                                                $nilai = $this->db->get('bobot_nilai')->row();
                                                ?>
                                                <?php $totalNilai = ($data->sks * $nilai->bobot); ?>
                                                <?php if ($nilai->huruf == 'A') : ?>
                                                    <p class="font-w600 text-success">A</p>
                                                <?php elseif ($nilai->huruf == 'B') : ?>
                                                    <p class="font-w600 text-success">B</p>
                                                <?php elseif ($nilai->huruf == 'C') : ?>
                                                    <p class="font-w600 text-warning">C</p>
                                                <?php elseif ($nilai->huruf == 'D') : ?>
                                                    <p class="font-w600 text-danger">D</p>
                                                <?php else : ?>
                                                    <p class="font-w600 text-danger">E</p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($nilai->bobot == 4) : ?>
                                                    <p class="font-w600 text-success">4.00</p>
                                                <?php elseif ($nilai->bobot == 3) : ?>
                                                    <p class="font-w600 text-success">3.00</p>
                                                <?php elseif ($nilai->bobot == 2) : ?>
                                                    <p class="font-w600 text-warning">2.00</p>
                                                <?php elseif ($nilai->bobot == 1) : ?>
                                                    <p class="font-w600 text-danger">1.00</p>
                                                <?php else : ?>
                                                    <p class="font-w600 text-danger">0.00</p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center font-w600">Maaf KHS Kosong</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <!-- <?php if ($dns) : ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right font-w600">Total</td>
                                        <td class="text-center font-w600"></td>
                                        <td class="text-center font-w600"><?php echo $totalSks ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-w600">IPS</td>
                                        <td colspan="2" class="text-center font-w600"><?php echo sprintf("%.2f", ($totalNilai / $totalSks)); ?></td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Pilih Mode Cetak</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('mahasiswa/laporan/dns/cetakdns'); ?>" method="get" target="_blank">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="nilai_min">Nilai Minimal</label>
                            <select name="nilai_min" class="form-control">
                                <option value="<?= enkrip('D'); ?>">D</option>
                                <option value="<?= enkrip('E'); ?>">E</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ttd">TDD Oleh</label>
                            <select name="ttd" class="form-control">
                                <option value="Direktur">Direktur</option>
                                <option value="Wakil Derektur 1">Wakir Direktur 1</option>
                                <option value="Ka. Prodi">Ka. Prodi</option>
                            </select>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>
<script></script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>