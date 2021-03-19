<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/dosen/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/dosen/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Jadwal Kuliah</h3>
        </div>
        <div class="block-content block-content-full">
        <table class="table table-striped table-vcenter">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Semester</th>
                    <th>Kelas</th>
                    <th>Jam</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($jadwal_hari_ini['status'] == false) : ?>
                    <tr>
                        <td colspan="2" class="text-center font-size-sm font-w600 text-muted">Tidak Ada Jadwal Hari Ini </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($jadwal_hari_ini['message'] as $jadwal) : ?>
                        <tr <?php echo $jadwal['jam_sekarang'] ?>>
                            <td class="font-size-sm font-w600">
                                <?php echo $jadwal['jadwal']['makul_nama'] ?>
                            </td>
                            <td class="font-size-sm font-w600">
                                <?php echo $jadwal['jadwal']['makul_smt'] ?>
                            </td>
                            <td class="font-size-sm font-w600">
                                <?php echo $jadwal['jadwal']['makul_kelas'] ?>
                            </td>
                            <td class="font-size-sm font-w600 text-muted"><?php echo $jadwal['jadwal']['jadwal_jammulai'] ?> - <?php echo $jadwal['jadwal']['jadwal_jamselesai'] ?></td>
                            <td class="font-size-sm font-w600">
                                <?php echo $jadwal['jadwal']['jadwal_tglmulai']  . " - ". $jadwal['jadwal']['jadwal_tglselesai'] ?>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>