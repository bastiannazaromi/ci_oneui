<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/dosen/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/dosen/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Mahasiswa Bimbingan</h3>
        </div>
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">No</th>
                        <th>Nama</th>
                        <th class="d-none d-sm-table-cell" style="width: 30%;">NIM</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Smt/kelas</th>
                        <th style="width: 15%;">status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1 ?>
                <?php foreach ($mahasiswa as $mhs) : ?>                
                    <tr>
                        <td class="text-center font-size-sm"><?=$i?></td>
                        <td class="font-w600 font-size-sm">
                            <a href="#"><?=strtoupper($mhs->nama_lengkap)?></a>
                        </td>
                        <td class="d-none d-sm-table-cell font-size-sm">
                            <span class="text-muted"><?=$mhs->nim?></span>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span class="badge badge-warning text-dark"><?=$mhs->semester.$mhs->kelas?></span>
                        </td>
                        <td>
                            <?php if ($mhs->nama_status == 'Lulus') : ?>
                            <span class="badge badge-success"><?=$mhs->nama_status?></span>
                            <?php elseif ($mhs->nama_status == 'Aktif'): ?>
                            <span class="badge badge-danger"><?=$mhs->nama_status?></span>
                            <?php elseif ($mhs->nama_status == 'Cuti'): ?>
                            <span class="badge badge-secondary"><?=$mhs->nama_status?></span>
                            <?php else : ?>
                            <span class="badge badge-dark"><?=$mhs->nama_status?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-alt-primary detail_btn"
                                data-toggle="modal" data-target="#modal-detail" title="Detail Mahasiswa" data-id_mhs="<?= enkrip($mhs->nim) ?>">
                                <i class="fa fa-fw fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                <?php $i++ ?>
                <?php endforeach; ?>                 
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Page Content -->

<!-- Modal Detail -->

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-block-fromright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromright modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Detail Mahasiswa</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                    <div class="row row-deck">
                        <div class="col-md">
                        <!-- Referred User -->
                        <a class="block block-rounded block-bordered" href="javascript:void(0)">
                            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="font-w600 mb-1" id="detail-nama">Nama Mahasiswa</div>
                                    <div class="font-weight-sm text-muted" id="detail-semester-kelas"></div>
                                </div>
                                <div class="ml-3">
                                    <img class="img-avatar img-avatar64" id="detail-foto"
                                    src="<?=base_url('upload/profile/'.$this->user->kd_prodi.'/default.jpg')?>" alt="Profile">   
                                </div>
                            </div>
                        </a>
                        <!-- END Referred User -->
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-username">NIM</span></small>
                                    <span>19090074</span>
                                </div>
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-email">Jenis Kelamin</span></small>
                                    <span>Laki-laki</span>         
                                </div>
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-password">Tempat Lahir</span></small>
                                    <span>Tegal</span>                       
                                </div>
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-password-confirm">Tanggal Lahir</span></small>
                                    <span>25 Januari 2002</span>                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-username">NIK</span></small>
                                    <span>21398683164096213</span>
                                </div>
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-email">Email</span></small> 
                                    <span>galih11120@gmail.com</span>                           
                                </div>
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-password">Agama</span></small>        
                                    <span>Islam</span>                         
                                </div>
                                <div class="form-group">
                                    <small><span class="text-muted d-block mb-2" for="checkout-password-confirm">No Telp</span></small> 
                                    <span>08986676180</span>                                 
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary float-right mb-4" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->

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


<script>
let detail_btn = $('.detail_btn');

$(detail_btn).each(function(i) {
    $(detail_btn[i]).click(function() {
        let nim = $(this).data('id_mhs');
        $.ajax({
            url: "<?= base_url('dosen/akademik/getMhs/'); ?>" + nim,
            type: 'get',
            dataType: 'json',
            success: function(result) {
                $('#detail-nama')[0].innerHTML = result.nama_lengkap;
                $('#detail-foto')[0].setAttribute('src', 
                (result.foto == 'default.jpg' || result.foto == '') ? 
                `<?=base_url('upload/default.jpg')?>` :
                `<?=base_url('upload/mhs/')?>`+result.prodi+'/'+result.foto );
                $('#detail-semester-kelas')[0].innerHTML = 'Semester '+result.semester+' | Kelas '+result.kelas;
                console.log(result.nama_lengkap);
            }
        });
    });
});
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>