<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/dosen/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<style>
    .hidden-loader{
        display: none !important;
    }
</style>
<!-- Page JS Plugins CSS -->
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<style>
    th::after {
        bottom: 40% !important;
    }

    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        table {
            width: 100% !important;
        }

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr:nth-child(odd) {
            background: #ccc;
        }

        td {
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            text-align: right;
            height: 50px;
        }

        td input {
            position: absolute;
            right: 10px;
            bottom: 5px;
        }

        td:before {
            position: absolute;
            top: 0;
            left: 10px;
            white-space: nowrap;
            height: 50px;
            line-height: 50px;
        }

        td:nth-of-type(1):before {
            font-weight: bold;
            content: "NIM";
        }

        td:nth-of-type(2):before {
            font-weight: bold;
            content: "Nama";
        }

        td:nth-of-type(3):before {
            font-weight: bold;
            content: "Nilai Kehadiran Awal";
        }

        td:nth-of-type(4):before {
            font-weight: bold;
            content: "Nilai Kehadiran Akhir";
        }

        td:nth-of-type(5):before {
            font-weight: bold;
            content: "Nilai Tugas Awal";
        }

        td:nth-of-type(6):before {
            font-weight: bold;
            content: "Nilai Tugas Akhir";
        }

        td:nth-of-type(7):before {
            font-weight: bold;
            content: "Nilai UTS Awal";
        }

        td:nth-of-type(8):before {
            font-weight: bold;
            content: "Nilai UTS Akhir";
        }

        td:nth-of-type(9):before {
            font-weight: bold;
            content: "Nilai UAS Awal";
        }

        td:nth-of-type(10):before {
            font-weight: bold;
            content: "Nilai UAS Akhir";
        }

        td:nth-of-type(11):before {
            font-weight: bold;
            content: "Angka";
        }

        td:nth-of-type(12):before {
            font-weight: bold;
            content: "Huruf";
        }

        td:nth-of-type(3) input,
        td:nth-of-type(4) input,
        td:nth-of-type(5) input,
        td:nth-of-type(6) input,
        td:nth-of-type(7) input,
        td:nth-of-type(8) input,
        td:nth-of-type(9) input,
        td:nth-of-type(10) input {
            width: 52px;
        }
    }
</style>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/dosen/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Input Nilai</h3>
        </div>
        <div class="block-content block-content-full">
        <p class="font-size-sm text-muted">Silakan pilih mata kuliah.</p>
        <input type="hidden" id="tokens" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-textarea-input">Tahun Akademik</label>
                        <select id="tahun_akademik" name="tahun_akademik" class="form-control">
                            <option value="">Pilih...</option>
                            <?php foreach ($tahun_akademik as $ta) : ?>
                                <option value="<?=$ta->id?>"><?=$ta->tahun_akademik?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-textarea-input">Program Studi</label>
                        <select id="prodi" name="prodi" class="form-control">
                            <option value="">Pilih...</option>
                            <?php foreach ($prodi as $pr) : ?>
                                <option value="<?= $pr->kd_prodi ?>"><?= $pr->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-textarea-input">Semester</label>
                        <select id="semester" name="semester" class="form-control">
                            <option value="">Pilih...</option>
                            <?php foreach ($semester as $smt) : ?>
                                <option value="<?= $smt->semester ?>"><?= $smt->semester ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>      
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-textarea-input">Mata Kuliah</label>
                        <select id="makul" name="makul" class="form-control">
                            <option value="">Pilih...</option>
                            <?php foreach ($matkul as $mk) : ?>
                                <option value="<?= $mk->kode_mk ?>"><?= $mk->nama_mk ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>      
                </div>
            </div> 
            <div class="row">
                <div class="col-md-3">
                    <button type="button" id="cari" class="btn btn-sm btn-dark">Cari</button>
                </div>
            </div>
    </div>
        <div class="col-lg-12">
            <center>
                <div class="spinner-border text-dark mt-4 mb-4 hidden-loader" id="loader" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </center>
        </div>
        <div id="mhs" class="col-lg-12">
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
    <script src="<?= base_url('assets/frontend/js/bootstable.min.js') ?>"></script>

    <!-- Page JS Code -->
    <script>
        // PARAMETER BOOTSABLE

        // $('#mytable').SetEditable({

        // columnsEd: null, //Index to editable columns. If null all td editables. Ex.: "1,2,3,4,5"

        // $addButton: null, //Jquery object of "Add" button

        // onEdit: function() {}, //Called after edition

        // onBeforeDelete: function() {}, //Called before deletion

        // onDelete: function() {}, //Called after deletion

        // onAdd: function() {} //Called when added a new row

        // });

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

        // $('#prodi').change(function() {
        //     let prodi = $(this).val(); 

        //     $.ajax({
        //         url: "<?= base_url('dosen/nilai/getMakul/'); ?>" + prodi,
        //         type: 'get',
        //         dataType: 'json',
        //         beforeSend: function () { 
        //             $('#makul').attr('disabled', 'disabled');
        //             $('#loader').removeClass('hidden-loader');
        //             $('#mhs').html('');
        //         },
        //         success: function(result) {
        //             let option = [];
        //             option.push('<option value="">-- Pilih --</option>');
        //             $(result).each(function(i) {
        //                 option.push(
        //                     '<option value="' + result[i].kd_mk + '">' +
        //                     result[i].nama_mk + '</option>');
        //             });

        //             $('#makul').html(option.join(''));
        //         },
        //         complete: function () {
        //             $('#makul').removeAttr('disabled', 'disabled');
        //         }
        //     });
        // });

        // $('#semester').change(function() {
        //     let prodi = $('#prodi').val();
        //     let semester = $(this).val();
        //     console.log(prodi, semester);
        //     $.ajax({
        //         url: "<?= base_url('dosen/nilai/getMakul/'); ?>" + prodi + '/' + semester,
        //         type: 'get',
        //         dataType: 'json',
        //         beforeSend: function () { 
        //             $('#makul').attr('disabled', 'disabled');
        //         },
        //         success: function(result) {
        //             console.log(result);
        //             let option = [];
        //             option.push('<option value="">-- Pilih --</option>');
        //             $(result).each(function(i) {
        //                 option.push(
        //                     '<option value="' + result[i].kd_mk + '">' +
        //                     result[i].nama_mk + '</option>');
        //             });

        //             $('#makul').html(option.join(''));
        //         },
        //         complete: function () {
        //             $('#makul').removeAttr('disabled', 'disabled');
        //         }

        //     });


        // });
        
        $('#cari').click(function() {
                        
            var csrfName = $('#tokens').attr('name');
            var csrfHash = $('#tokens').val();

            var tahun_akademik = $("#tahun_akademik").val();
            var prodi = $('#prodi').val();
            var semester = $('#semester').val();
            var makul = $('#makul').val();

            $.ajax({
                url: "<?php echo base_url('dosen/nilai/getNilaiMhs/'); ?>",
                type: "POST",
                data: {
                    [csrfName]: csrfHash,
                    'tahun_akademik': tahun_akademik,
                    'prodi': prodi,
                    'semester': semester,
                    'makul': makul
                },
                dataType: "html",
                beforeSend: function () { 
                    $('#loader').removeClass('hidden-loader');
                    $('#mhs').html('');
                },
                success: function(data) {
                    $('#mhs').html(data);
                    $('#tokens').val(csrf_name);
                    $('#tokens').attr('name',csrf_hash);
                },
                complete: function () {
                    $('#loader').addClass('hidden-loader')
                },
                error: function () {
                    console.error('CSRF Error!');
                }
            });
        });


function FijModoNormal(but) {
    $(but).parent().find('#bAcep').hide();
    $(but).parent().find('#bCanc').hide();
    $(but).parent().find('#bEdit').show();
    $(but).parent().find('#bElim').show();
    var $row = $(but).parents('tr');
    $row.attr('id', '');
}
function FijModoEdit(but) {
    $(but).parent().find('#bAcep').show();
    $(but).parent().find('#bCanc').show();
    $(but).parent().find('#bEdit').hide();
    $(but).parent().find('#bElim').hide();
    var $row = $(but).parents('tr');
    $row.attr('id', 'editing');
}
function ModoEdicion($row) {
    if ($row.attr('id')=='editing') {
        return true;
    } else {
        return false;
    }
}
function rowAcep(but) {
    var $row = $(but).parents('tr');
    var $cols = $row.find('td');
    if (!ModoEdicion($row)) return;
    IterarCamposEdit($cols, function($td) {
      var cont = $td.find('input').val();
      $td.html(cont);
    });
    FijModoNormal(but);
    params.onEdit($row);

    var $nim = $cols[0].innerHTML;
    var $presensi_akhir = $cols[3].innerHTML;
    var $tugas_akhir = $cols[5].innerHTML;
    var $uts_akhir = $cols[7].innerHTML;
    var $uas_akhir = $cols[9].innerHTML;
    var $semester = $('#semester').val();
    var $makul = $('#makul').val();
    var $tahun_akademik = $('#tahun_akademik').val();
    var $prodi = $('#prodi').val();
    var $nilai_baru = $cols[10];
    var $huruf = $cols[11];
    var csrfName = $('#tokens2').attr('name');
    var csrfHash = $('#tokens2').val();
    $.ajax({
        url: "<?php echo base_url('dosen/nilai/input_nilai/edit/'); ?>",
        type: "POST",
        data: {
            [csrfName]  : csrfHash,
            'nim'       : $nim,
            'presensi'  : $presensi_akhir,
            'tugas'     : $tugas_akhir,
            'uts'       : $uts_akhir,
            'uas'       : $uas_akhir,
            'semester'  : $semester,
            'makul'     : $makul,
            'tahun_akademik' : $tahun_akademik,
            'prodi'     : $prodi
        },
        dataType: "json",
        success: function(data) { 
            console.log(data);
            $('#tokens2').val(data.csrf_hash);
            $('#tokens2').attr('name', data.csrf_name);
            $nilai_baru.innerHTML = data.nilai;
            $huruf.innerHTML = data.huruf;
        },
        error: function(){
            console.log('Ah Error Jon');
        }
    });

}

// function rowEdit(but) {
//     var $row = $(but).parents('tr');
//     var $cols = $row.find('td');
//     if (ModoEdicion($row)) return;
    
//     IterarCamposEdit($cols, function($td) {
//         var cont = $td.html();
//         var div = '<div style="display: none;">' + cont + '</div>';
//         var input = '<input class="form-control input-sm"  value="' + cont + '">';
//         $td.html(div + input);
//     });
//     FijModoEdit(but);
// }
// function rowElim(but) {
//     var $row = $(but).parents('tr');
//     params.onBeforeDelete($row);
//     $row.remove();
//     params.onDelete();
// }
// function rowAddNew(tabId) {
// var $tab_en_edic = $("#" + tabId);
//     var $filas = $tab_en_edic.find('tbody tr');
//     if ($filas.length==0) {
//         var $row = $tab_en_edic.find('thead tr');
//         var $cols = $row.find('th');  //lee campos
//         //construye html
//         var htmlDat = '';
//         $cols.each(function() {
//             if ($(this).attr('name')=='buttons') {
//                 //Es columna de botones
//                 htmlDat = htmlDat + colEdicHtml;  //agrega botones
//             } else {
//                 htmlDat = htmlDat + '<td></td>';
//             }
//         });
//         $tab_en_edic.find('tbody').append('<tr>'+htmlDat+'</tr>');
//     } else {
//         //Hay otras filas, podemos clonar la última fila, para copiar los botones
//         var $ultFila = $tab_en_edic.find('tr:last');
//         $ultFila.clone().appendTo($ultFila.parent());  
//         $ultFila = $tab_en_edic.find('tr:last');
//         var $cols = $ultFila.find('td');  //lee campos
//         $cols.each(function() {
//             if ($(this).attr('name')=='buttons') {
//                 //Es columna de botones
//             } else {
//                 $(this).html('');  //limpia contenido
//             }
//         });
//     }
//   params.onAdd();
// }
// function TableToCSV(tabId, separator) {  //Convierte tabla a CSV
//     var datFil = '';
//     var tmp = '';
//   var $tab_en_edic = $("#" + tabId);  //Table source
//     $tab_en_edic.find('tbody tr').each(function() {
//         //Termina la edición si es que existe
//         if (ModoEdicion($(this))) {
//             $(this).find('#bAcep').click();  //acepta edición
//         }
//         var $cols = $(this).find('td');  //lee campos
//         datFil = '';
//         $cols.each(function() {
//             if ($(this).attr('name')=='buttons') {
//                 //Es columna de botones
//             } else {
//                 datFil = datFil + $(this).html() + separator;
//             }
//         });
//         if (datFil!='') {
//             datFil = datFil.substr(0, datFil.length-separator.length); 
//         }
//         tmp = tmp + datFil + '\n';
//     });
//     return tmp;
// }

// //apply
// $("#table-list").SetEditable({
//         $addButton: $('#add')
// });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>