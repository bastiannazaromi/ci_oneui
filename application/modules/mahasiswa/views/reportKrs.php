<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>
<style>
    .hidden-loader {
        display: none !important;
    }
</style>
<div class="content">
    <div class="row">
        <div class="col-sm-6">
            <a class="block block-rounded block-link-pop" href="<?php echo base_url('mahasiswa/profil') ?>">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Informasi Mahasiswa</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <div class="mb-3 py-1">
                                    <img class="img-thumbnail" style="width: 120px;" src="
                                            <?= ($dataMhs->foto == 'default.jpg' || $dataMhs->foto == '') ? base_url('upload/default.jpg') :
                                                base_url('upload/mhs/' . $dataMhs->foto)
                                            ?>
                                            " alt="<?= $dataMhs->nama_lengkap; ?>">
                                </div>
                            </div>
                            <div class="col-sm-9 py-2">
                                <div class="font-size-h3 font-w600"><?= $dataMhs->nama_lengkap; ?> <sup><span class="badge badge-success"><?= $dataMhs->nama_status ?></span></sup></div>
                                <address class="font-size-sm">
                                    <p class="font-size-h6"><b>NIM:</b> <?= $dataMhs->nim; ?><br><b> <?= $dataMhs->jenjang . ' ' . $dataMhs->nama_prodi ?></b> | <b>Semester <?= $dataMhs->semester ?></b><br><b class="font-size-h5"></b> NUROHIM SST,M.KOM | <b class="font-size-h5">Total SKS:</b> <?php echo $totalSks[0]->TotalSks ?></p>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Filter</h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        <!-- <div class="col-sm-12">
                            <div class="form-group">
                                <select class="js-select2 form-control" name="jenis" id="jenis" style="width: 100%;" data-placeholder="Silakan pilih Jenis">
                                    <option></option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Tahun Akademik">Tahun Akademik</label>
                                <select class="js-select2 form-control" name="tahun_akademik" id="tahun_akademik" style="width: 100%;" data-placeholder="Silakan pilih Tahun Akademik">
                                    <option></option>
                                    <?php foreach ($tahun_akademik as $row) : ?>
                                        <option value="<?php echo enkrip($row->id) ?>"><?php echo $row->tahun_akademik ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <center>
                <div class="spinner-border text-dark mt-4 mb-4 hidden-loader" id="loader" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </center>
        </div>
        <div class="col-sm-12" id="tampil"></div>
    </div>
</div>
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('js/plugins/select2/js/select2.full.min.js'); ?>
<script>
    $('#tahun_akademik').change(function() {
        let tahun_akademik = $(this).val();
        let table = '';
        html = '<div class="block block-rounded"><div class="block-header block-header-default"><h3 class="block-title">Detail KRS</h3><a href="<?php echo base_url('mahasiswa/laporan/krs/cetakKrs/') ?>' + tahun_akademik + '" target="_blank" class="btn btn-sm btn-alt-primary"><i class="fa fa-print"></i> Cetak KRS</a></div><div class="block-content"><div class="table-responsive"><table class="js-table-checkable table table-hover table-vcenter js-table-checkable-enabled"><thead><tr><th class="text-center">No</th><th class="text-center">Kode</th><th class="text-center">Semester</th><th class="text-center">Mata Kuliah</th><th class="text-center">Sks</th><th class="text-center">Status</th></tr></thead><tbody id="table"></tbody><tfoot><tr><td colspan="6"><p class="font-w600" id="totalSks" style="float: right"></p></td></tr></tfoot></table></div></div></div>';
        $.ajax({
            url: '<?php echo base_url('mahasiswa/laporan/krs/getKrs/') ?>' + tahun_akademik,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            beforeSend: function(e) {
                $('#loader').removeClass('hidden-loader');
            },
            success: function(respon) {
                if (respon.status == true) {
                    $('#tampil').html(html);
                    let no = 1;
                    let totalSks = 0;
                    $.each(respon.data, function(index, item) {
                        totalSks += +item.sks;
                        table += '<tr><td class="text-center">' + (no++) + '</td><td class="text-center">' + item.kode_matkul + '</td><td class="text-center">' + item.semester + '</td><td class="text-center">' + item.nama_mk + '</td><td class="text-center">' + item.sks + '</td><td class="text-center"><span class="badge ' + (item.status_krs == 1 ? 'badge-success' : 'badge-danger') + '">' + (item.status_krs == 1 ? 'Disetujui' : 'Menunggu') + '</span></td></tr>';
                    });
                    $('#table').html(table);
                    $('#totalSks').text('Jumlah SKS : ' + totalSks);
                } else {
                    $('#tampil').remove();
                    jQuery(function() {
                        One.helpers('notify', {
                            from: 'top',
                            align: 'right',
                            type: 'warning',
                            icon: 'fa fa-exclamation mr-1',
                            message: respon.messege
                        });
                    });
                }
            },
            complete: function() {
                $('#loader').addClass('hidden-loader');
            }
        });
    });
    jQuery(function() {
        One.helpers(['select2']);
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>