<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/dosen/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/dosen/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <form action="<?=base_url('dosen/nilai/komposisi_nilai/set_komposisi')?>" method="post">
    <input type="hidden" id="tokens" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    <div class="block block-rounded">        
        <div class="block-header block-header-default">
            <h3 class="block-title">Set Komposisi Nilai</h3>
        </div>
        <div class="block-content block-content-full">
            <p class="font-size-sm text-muted">
                Halaman untuk menentukan komposisi nilai per mata kuliah per semester.
            </p> 
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-textarea-input">Program Studi</label>
                            <select id="prodi" required="" name="prodi" class="form-control">
                                <option value="">Pilih...</option>
                                <?php foreach ($prodi as $pr) : ?>
                                <option value="<?=$pr->kd_prodi?>"><?=$pr->nama?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-textarea-input">Tahun Akademik</label>
                            <select id="prodi" required="" name="prodi" class="form-control">
                                <option value="">Pilih...</option>  
                                <?php foreach ($tahun_akademik as $thak) : ?>
                                <option value="<?=$thak->id?>"><?=$thak->tahun_akademik?></option>
                                <?php endforeach; ?>                  
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-textarea-input">Mata Kuliah</label>
                            <select id="makul" required="" name="makul" class="form-control">
                                <option value="">Pilih...</option>
                                <?php foreach ($matkul as $mk) : ?>
                                <option value="<?=$mk->kode_mk?>"><?=$mk->nama_mk?></option>
                                <?php endforeach; ?>                 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-textarea-input">Kelas</label>
                            <select id="kelas" required="" name="kelas" class="form-control">
                                <option value="">Pilih...</option>
                                <?php foreach ($kelas as $k) : ?>
                                <option value="<?=$k->kelas?>"><?=$k->kelas?></option>
                                <?php endforeach; ?>                   
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-textarea-input">Semester</label>
                            <select id="semester" required="" name="semester" class="form-control">
                                <option value="">Pilih...</option>
                                <?php foreach ($semester as $smt) : ?>
                                <option value="<?=$smt->semester?>"><?=$smt->semester?></option>
                                <?php endforeach; ?>                  
                            </select>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">
                PROSENTASE (%)
            </h3>
            <div class="block-options">
                <button type="button" class="js-bar-randomize btn-block-option" data-toggle="tooltip" title="Randomize">
                    <i class="fa fa-random"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Kehadiran
                                </span>
                            </div>
                            <input type="number" class="form-control" id="kehadiran" name="kehadiran">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Tugas
                                </span>
                            </div>
                            <input type="number" class="form-control" id="tugas" name="tugas">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    UTS
                                </span>
                            </div>
                            <input type="number" class="form-control" id="uts" name="uts">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    UAS
                                </span>
                            </div>
                            <input type="number" class="form-control" id="uas" name="uas">
                        </div>
                    </div>
                </div>
            </div>
            <div class="progress push">
                <div class="progress-bar bg-danger" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                    <span class="font-size-sm font-w600" id="progress"></span>
                </div>
            </div>
            <button type="submit" class="btn btn-secondary mb-4 mt-4">Simpan Perubahan</button>
        </div>
    </div>
    </form>
       
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>

<script>
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    $('#makul').on('change', function(){
        if ($("#csrf").length == 0) {
            var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        } else {
            var csrfHash = $('#csrf').val();
        }
        var makul = $(this).val();
        $.ajax({
            url: "<?php echo base_url('dosen/nilai/getPresentase/'); ?>",
            type: "POST",
            data: {
                [csrfName]: csrfHash,
                'makul': makul,
            },
            dataType: "json",
          
            success: function(data) {
                console.log(data);
            },
        });
    })

    var kehadiran = 
    $('#kehadiran').keyup(function(){        
        // jika input lebih dari 2 digit dan digit pertama adalah 0 maka hapus digit pertama
        var kehadiran = ($(this).val() == "") ? $(this).val('0') : $(this).val();
        
        if($(this)[0].value.length > 1 && $(this)[0].value[0] == '0'){            
            var deleteZero = $(this)[0].value.substr(1);
            $(this).val(deleteZero);
        }

        if(total()>100){
            var n = 100 - (total() - kehadiran[0].value);            
            $(this).val('0');
        }
        

        $('#progress-bar span').html(total()+'%');
        $('#progress-bar').css('width', total()+'%');
        $(this).attr('value', $('#kehadiran')[0].value);        
        return (kehadiran + total()).toString();            
    })

    var tugas = 
    $('#tugas').keyup(function(){        
        var tugas = ($(this).val() == "") ? $(this).val('0') : $(this).val();
        
        if($(this)[0].value.length > 1 && $(this)[0].value[0] == '0'){            
            var deleteZero = $(this)[0].value.substr(1);
            $(this).val(deleteZero);
        }

        if(total()>100){
            var n = 100 - (total() - tugas[0].value);            
            $(this).val('0');
        }
        
        $('#progress-bar span').html(total()+'%');
        $('#progress-bar').css('width', total()+'%');
        $(this).attr('value', $('#tugas')[0].value);
        return (tugas + total()).toString();
    })

    var uts = 
    $('#uts').keyup(function(){
        var uts = ($(this).val() == "") ? $(this).val('0') : $(this).val();
        
        if($(this)[0].value.length > 1 && $(this)[0].value[0] == '0'){            
            var deleteZero = $(this)[0].value.substr(1);
            $(this).val(deleteZero);
        }

        if(total()>100){
            var n = 100 - (total() - uts[0].value);            
            $(this).val('0');
        }
        
        $('#progress-bar span').html(total()+'%');
        $('#progress-bar').css('width', total()+'%');
        $(this).attr('value', $('#uts')[0].value);
        return (uts + total()).toString();
    })

    var uas = 
    $('#uas').keyup(function(){
        var uas = ($(this).val() == "") ? $(this).val('0') : $(this).val();
        
        if($(this)[0].value.length > 1 && $(this)[0].value[0] == '0'){            
            var deleteZero = $(this)[0].value.substr(1);
            $(this).val(deleteZero);
        }

        if(total()>100){
            var n = 100 - (total() - uas[0].value);            
            $(this).val('0');
        }
        
        $('#progress-bar span').html(total()+'%');
        $('#progress-bar').css('width', total()+'%');
        $(this).attr('value', $('#uas')[0].value);
        return (uas + total()).toString();
    })

    function total(){

        $('#kehadiran').attr('value', 0);
        $('#tugas').attr('value', 0);
        $('#uts').attr('value', 0);
        $('#uas').attr('value', 0);

        if (
            (parseInt(kehadiran[0].value) + 
            parseInt(tugas[0].value) + 
            parseInt(uts[0].value) + 
            parseInt(uas[0].value)) 
            >= 100
        ) {
            $('#progress-bar')[0].classList.remove('bg-danger');
            // return 100;
        }else{
            $('#progress-bar')[0].classList.add('bg-danger');
            return  parseInt(kehadiran[0].value) + 
                    parseInt(tugas[0].value) + 
                    parseInt(uts[0].value) + 
                    parseInt(uas[0].value);
        }
        return  parseInt(kehadiran[0].value) + 
                parseInt(tugas[0].value) + 
                parseInt(uts[0].value) + 
                parseInt(uas[0].value);
        
    }

    total();


</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>