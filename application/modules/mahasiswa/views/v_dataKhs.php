<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">Detail KHS</h3>
        <?php if ($dataKhs) : ?>
            <a href="<?php echo base_url('mahasiswa/laporan/khs/cetakkhs/') . $th_ak ?>" target="_blank" class="btn btn-sm btn-alt-primary"><i class="fa fa-print"></i> Cetak KHS</a>
        <?php endif; ?>
    </div>
    <div class="block-content">
        <div class="table-responsive">
            <table class="js-table-checkable table table-hover table-vcenter js-table-checkable-enabled">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Mata Kuliah</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Bobot</th>
                        <th class="text-center">Sks</th>
                    </tr>
                </thead>
                <tbody id="table">
                    <?php if ($dataKhs) : ?>
                        <?php $no = 1; ?>
                        <?php $totalSks = 0; ?>
                        <?php $totalNilai = 0; ?>
                        <?php foreach ($dataKhs as $data) : ?>
                            <?php $totalSks += $data->sks; ?>
                            <tr>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td class="text-center"><?php echo $data->kode_mk ?></td>
                                <td class="text-center"><?php echo $data->semester ?></td>
                                <td class="text-center"><?php echo $data->nama_mk ?></td>
                                <td class="text-center">
                                    <?php
                                    $this->db->where("'$data->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
                                    $nilai = $this->db->get('bobot_nilai')->row();
                                    ?>
                                    <?php $totalNilai += $nilai->bobot; ?>
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
                                <td class="text-center"><?php echo $data->sks ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center font-w600">Maaf KHS Kosong</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <?php if ($dataKhs) : ?>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right font-w600">Total</td>
                            <td class="text-center font-w600"></td>
                            <td class="text-center font-w600"><?php echo $totalSks ?></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right font-w600">IPS</td>
                            <td colspan="2" class="text-center font-w600"><?php echo sprintf("%.2f", $totalNilai / count($dataKhs)); ?></td>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>