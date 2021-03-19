<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>

<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>

<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-sm-6 col-xl-6">
            <div class="form-group">
                <label for="by_semester">Semester</label>
                <select class="form-control" name="by_semester" id="by_semester" data-placeholder="Silakan pilih semester..">
                    <?php foreach ($semester as $data) : ?>
                        <option value="<?= enkrip($data->semester); ?>" <?= $sms_ini == $data->semester ? 'selected="selected"' : ''; ?>><?= $data->semester; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="block block-rounded">
                <div class="block-header bg-dark">
                    <h3 class="block-title text-white">Mata Kuliah</h3>
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter start-at-25">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Prodi</th>
                                    <th>Semester</th>
                                    <th>Kurikulum</th>
                                    <th>Kode Matkul</th>
                                    <th>Nama Matkul</th>
                                    <th>SKS</th>
                                    <th>Jenis Matkul</th>
                                    <th>Max Pertemuan</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (is_array($list_mataKuliah) || is_object($list_mataKuliah)) : ?>
                                    <?php foreach ($list_mataKuliah as $hasil) : ?>
                                        <tr>
                                            <td class="text-center font-size-sm"><?= $i++; ?></td>
                                            <td class="font-size-sm"><?= $hasil->nama; ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->semester ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->kd_kurikulum ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->kode_mk ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->nama_mk ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->sks ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->jenis_mk ?></td>
                                            <td class="font-size-sm"><?php echo $hasil->max_pertemuan ?> Pertemuan</td>
                                            <td class="text-center">
                                                <?php echo ($hasil->status == '1') ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Non active</span>'; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary edit_btn" data-toggle="modal" data-target="#modal-edit" data-id="<?php echo enkrip($hasil->id) ?>" data-kd_kurikulum="<?php echo enkrip($hasil->kd_kurikulum) ?>" data-kd_prodi="<?php echo enkrip($hasil->kd_prodi) ?>" data-matkul="<?php echo $hasil->nama_mk ?>" data-kd_mk="<?php echo enkrip($hasil->kode_mk) ?>" data-semester="<?php echo $hasil->semester ?>" <?php echo $hasil->sks ?> data-jenis="<?php echo $hasil->jenis_mk ?>" <?php echo $hasil->status ?> title="Edit">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                    <?php if ($hasil->status == '1') : ?>
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Non active" onclick="activeNonActive('<?php echo base_url('prodi/mata_kuliah/active_non_active/' . enkrip($hasil->id) . '/non_active') ?>')">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    <?php else : ?>
                                                        <button type="button" class="btn btn-sm btn-alt-success" data-toggle="tooltip" title="active" onclick="activeNonActive('<?php echo base_url('prodi/mata_kuliah/active_non_active/' . enkrip($hasil->id) . '/active') ?>')">
                                                            <i class="fa fa-fw fa-check"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <button type="button" data-href="<?= base_url('prodi/mata_kuliah/delete/') . enkrip($hasil->id); ?>" style="display: inline-block;" class="btn btn-sm btn-warning tombol-hapus" data-text="data akan dihapus" data-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Add Mata Kuliah</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/mata_kuliah/add'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-group">
                            <label for="nama">kurikulum</label>
                            <select name="kurikulum" class="form-control">
                                <option value="">-- Pilih Kurikulum --</option>
                                <?php foreach ($kurikulum as $hasil) : ?>
                                    <option value="<?php echo enkrip($hasil->kode_kurikulum) ?>"><?php echo  $hasil->kode_kurikulum . '|' . $hasil->keterangan_kurikulum ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Prodi</label>
                            <select name="prodi" class="form-control">
                                <option value="<?php echo enkrip($this->user[0]->kd_prodi) ?>"><?php echo $this->user[0]->nama ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Kode Mata Kuliah">Kode Mata Kuliah</label>
                            <input type="text" name="kode" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Nama Mata Kuliah">Nama Mata Kuliah</label>
                            <input type="text" name="nama" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Maksimal Pertemuan">Maksimal Pertemuan</label>
                            <input type="nummber" name="max_pertemuan" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Semester">Semester</label>
                            <select name="semester" class="form-control">
                                <option value="">-- Pilih Semester --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="SKS">SKS</label>
                            <select name="sks" class="form-control">
                                <option value="">-- Pilih SKS --</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Jenis">Jenis Mata Kuliah</label>
                            <select name="jenis" class="form-control">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="teori">Teori</option>
                                <option value="prektek">Prektek</option>
                                <option value="teroriPraktek">Teori dan Praktek</option>
                                <option value="klinik"></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Active">Status Active</label>
                            <select name="status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Active</option>
                                <option value="0">Tidak Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Edit Mata Kuliah</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form action="<?= base_url('prodi/mata_kuliah/edit'); ?>" method="post">
                    <div class="block-content font-size-sm">
                        <input type="hidden" class="csrf_tokem" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="id_matkul" id="id_matkul">
                        <div class="form-group">
                            <label for="nama">kurikulum</label>
                            <select name="kurikulum" id="kurikulum" class="form-control">
                                <option value="">-- Pilih Kurikulum --</option>
                                <?php foreach ($kurikulum as $hasil) : ?>
                                    <option value="<?php echo enkrip($hasil->kode_kurikulum) ?>"><?php echo  $hasil->kode_kurikulum . '|' . $hasil->keterangan_kurikulum ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Prodi</label>
                            <select name="prodi" id="prodi" class="form-control">
                                <option value="<?php echo enkrip($this->user[0]->kd_prodi) ?>"><?php echo $this->user[0]->nama ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Kode Mata Kuliah">Kode Mata Kuliah</label>
                            <input type="text" name="kode" id="kode" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Nama Mata Kuliah">Nama Mata Kuliah</label>
                            <input type="text" name="nama" id="nama_matkul" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Maksimal Pertemuan">Maksimal Pertemuan</label>
                            <input type="nummber" name="max_pertemuan" id="max_pertemuan" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Semester">Semester</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="SKS">SKS</label>
                            <select name="sks" id="sks" class="form-control">
                                <option value="">-- Pilih SKS --</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Jenis">Jenis Mata Kuliah</label>
                            <select name="jenis" id="jenis" class="form-control">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="teori">Teori</option>
                                <option value="prektek">Prektek</option>
                                <option value="teroriPraktek">Teori dan Praktek</option>
                                <option value="klinik"></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Active">Status Active</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Active</option>
                                <option value="0">Tidak Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
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

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>
<script>
    let tombol_edit = $('.edit_btn');
    $(tombol_edit).each(function(i) {
        $(tombol_edit[i]).click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url('prodi/mata_kuliah/getMatkul/') ?>' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(respon) {
                    $('#id_matkul').val(respon.id_matkul);
                    $('#kurikulum').val(respon.kd_kurikulum);
                    $('#kd_prodi').val(respon.kd_prodi);
                    $('#kode').val(respon.kd_mk);
                    $('#nama_matkul').val(respon.nama_mk);
                    $('#max_pertemuan').val(respon.max_pertemuan);
                    $('#semester').val(respon.semester);
                    $('#sks').val(respon.sks);
                    $('#jenis').val(respon.jenis_mk);
                    $('#status').val(respon.status_a);
                },
                error: function(e) {
                    console.log(e);
                }
            });
        });
    });

    function activeNonActive(href) {
        Swal.fire({
            title: 'Apakah anda yakin',
            text: "untuk active atau non acitve",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Active non Acive'
        }).then((result) => {
            if (result.value) {
                location.href = href;
            }
        })
    }

    $('#by_semester').change(function() {
        let semester = $(this).find(':selected').val();
        document.location.href = '<?= base_url('prodi/mata_kuliah/') ?>' + semester;
    });

    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/mata_kuliah') ?>"]').addClass('active');
    $('li.nav-main-item').find('a[href*="<?= base_url('prodi/mata_kuliah') ?>"]').parent().parent().parent().addClass('open');
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>