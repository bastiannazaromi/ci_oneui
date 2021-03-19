<div class="table-responsive">
    <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>NIM</th>
                <th>SMT</th>
                <th>Nama</th>
                <th>Kehadiran</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Angka</th>
                <th>Bobot</th>
                <th>Huruf</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php if (is_array($nilai) || is_object($nilai)) : ?>
                <?php foreach ($nilai as $hasil) : ?>
                    <?php $this->db->where("'$hasil->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
                    $nilai = $this->db->get('bobot_nilai')->row();; ?>
                    <tr>
                        <td class="text-center font-size-sm"><?= $i++; ?></td>
                        <td class="font-size-sm"><?= $hasil->username; ?></td>
                        <td class="font-size-sm"><?= $hasil->smt; ?></td>
                        <td class="font-size-sm"><?= $hasil->nama_lengkap; ?></td>
                        <td class="font-size-sm"><?= $hasil->presensi_akhir; ?></td>
                        <td class="font-size-sm"><?= $hasil->tugas_akhir; ?></td>
                        <td class="font-size-sm"><?= $hasil->uts_akhir; ?></td>
                        <td class="font-size-sm"><?= $hasil->uas_akhir; ?></td>
                        <td class="font-size-sm"><?= $hasil->nilai_akhir; ?></td>
                        <td class="font-size-sm"><?= $nilai->bobot; ?></td>
                        <td class="font-size-sm"><?= $hasil->huruf_akhir; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>