<div class="block block-rounded">
<!-- Dynamic Table Full Pagination -->
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="editable-nilai">
                <input type="hidden" id="tokens2" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th class="text-center" rowspan="2" style="vertical-align: middle">NIM</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle">Nama</th>
                            <th class="text-center" colspan="2" rowspan="1" style="border:1px solid #ddd">Kehadiran</th>
                            <th class="text-center" colspan="2" rowspan="1" style="border:1px solid #ddd">Tugas</th>
                            <th class="text-center" colspan="2" rowspan="1" style="border:1px solid #ddd">UTS</th>
                            <th class="text-center" colspan="2" rowspan="1" style="border:1px solid #ddd">UAS</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle">Angka</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle">Huruf</th>
                        </tr>
                        <tr>
                            <th style="border:1px solid #ddd">Awal</th>
                            <th style="border:1px solid #ddd" class="text-center">Akhir</th>
                            <th style="border:1px solid #ddd">Awal</th>
                            <th style="border:1px solid #ddd" class="text-center">Akhir</th>
                            <th style="border:1px solid #ddd">Awal</th>
                            <th style="border:1px solid #ddd" class="text-center">Akhir</th>
                            <th style="border:1px solid #ddd">Awal</th>
                            <th style="border:1px solid #ddd" class="text-center">Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mahasiswa as $mhs) :
                                    $this->db->select('
                                presentase_nilai.presensi,
                                presentase_nilai.tugas,
                                presentase_nilai.uts,
                                presentase_nilai.uas
                        ');

                            $this->db->where('kode_mk', $mhs->kode_mk);
                            $this->db->where('kd_dosen', $this->user->username);
                            $this->db->where('tahun_akademik', 1);
                            $this->db->where('semester', $mhs->semester);
                            $this->db->where('kelas', $mhs->kelas);
                            $this->db->where('kd_prodi', $mhs->prodi);

                            $pres = $this->db->get('presentase_nilai')->row();

                        ?>
                            <tr>
                                <input type="hidden" id="id" name="id" value="<?=$mhs->id?>">
                                <td class="font-size-sm"><?= $mhs->nim ?></td>
                                <td class="font-size-sm"><?= $mhs->nama_lengkap ?></td>
                                <td class="font-size-sm"><?= $mhs->presensi ?></td>
                                <td class="font-size-sm" id="presensi_akhir"><?= $mhs->presensi_akhir ?></td>
                                <td class="font-size-sm"><?= $mhs->tugas ?></td>
                                <td class="font-size-sm" id="tugas_akhir"><?= $mhs->tugas_akhir ?></td>
                                <td class="font-size-sm"><?= $mhs->uts ?></td>
                                <td class="font-size-sm" id="uts_akhir"><?= $mhs->uts_akhir ?></td>
                                <td class="font-size-sm"><?= $mhs->uas ?></td>
                                <td class="font-size-sm" id="uas_akhir"><?= $mhs->uas_akhir ?></td>
                                <td class="font-size-sm"><?= $mhs->nilai_akhir ?></td>
                                <td class="font-size-sm">
                                    <?php
                                    $nil =

                                    ($mhs->presensi_akhir * ($pres->presensi / 100)) +
                    
                                    ($mhs->tugas_akhir * ($pres->tugas / 100)) +
                    
                                    ($mhs->uts_akhir * ($pres->uts / 100)) +
                    
                                    ($mhs->uas_akhir * ($pres->uas / 100));

                                    $this->db->where("'$nil' BETWEEN `angka_awal` AND `angka_akhir`");
                                    echo $this->db->get('bobot_nilai')->row('huruf');
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
</div>

<script>
$(document).ready(function() {

$('#editable-nilai').dataTable({
    "columnDefs": [{
        "targets": [2, 3, 4, 5, 6, 7, 8, 9, 11],
        "orderable": false,
        // "buttons": [{
        //             extend: "copy",
        //             className: "btn btn-sm btn-alt-primary"
        //         }, {
        //             extend: "csv",
        //             className: "btn btn-sm btn-alt-primary"
        //         }, {
        //             extend: "print",
        //             className: "btn btn-sm btn-alt-primary"
        //         }, {
        //             extend: 'pdf',
        //             className: "btn btn-sm btn-alt-primary"
        //         }, {
        //             extend: 'excel',
        //             className: "btn btn-sm btn-alt-primary"
        //         }
        // ]

    }]
});

    $('#editable-nilai').SetEditable({
        $addButton: $('#addNewRow'),
        columnsEd: "3,5,7,9",
    });

    $('tr:first-child th:last-child')[0].setAttribute("rowspan", "2");
    $('tr:first-child th:last-child')[0].setAttribute("class", "text-center");
    $('tr:first-child th:last-child')[0].style.verticalAlign = "middle";
    $('tr:first-child th:last-child')[0].style.width = "40px";
    $('tr:first-child th:last-child')[0].innerHTML = "Aksi";
    $('tr:nth-child(2) th:last-child')[0].remove();

    var i = 0;
    while (i <= document.querySelectorAll('#bAcep').length) {

        document.querySelectorAll('#bAcep')[i].classList.add('btn-success');
        document.querySelectorAll('#bAcep')[i].setAttribute("data-toggle", "tooltip");
        document.querySelectorAll('#bAcep')[i].setAttribute("data-animation", "true");
        document.querySelectorAll('#bAcep')[i].setAttribute("data-placement", "bottom");
        document.querySelectorAll('#bAcep')[i].setAttribute("title", "Accept");

        document.querySelectorAll('#bCanc')[i].classList.add('btn-danger');
        document.querySelectorAll('#bCanc')[i].setAttribute("data-toggle", "tooltip");
        document.querySelectorAll('#bCanc')[i].setAttribute("data-animation", "true");
        document.querySelectorAll('#bCanc')[i].setAttribute("data-placement", "bottom");
        document.querySelectorAll('#bCanc')[i].setAttribute("title", "Cancel");

        document.querySelectorAll('#bEdit')[i].classList.add('btn-warning');
        document.querySelectorAll('#bEdit')[i].setAttribute("data-toggle", "tooltip");
        document.querySelectorAll('#bEdit')[i].setAttribute("data-animation", "true");
        document.querySelectorAll('#bEdit')[i].setAttribute("data-placement", "bottom");
        document.querySelectorAll('#bEdit')[i].setAttribute("title", "Edit");

        $('.glyphicon-pencil')[i].classList.add('fa');
        $('.glyphicon-pencil')[i].classList.add('fa-pencil-alt');

        $('.glyphicon-ok')[i].classList.add('fa');
        $('.glyphicon-ok')[i].classList.add('fa-check');

        $('.glyphicon-remove')[i].classList.add('fa');
        $('.glyphicon-remove')[i].classList.add('fa-times');
        i++;

    }
});
</script>