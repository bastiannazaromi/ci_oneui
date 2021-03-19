<?php require APPPATH.'views/inc/_global/config.php'; ?>
<?php require APPPATH.'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH.'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH.'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH.'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH.'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Riwayat Pembayaran</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">ID</th>
                            <th class="text-center">Waktu Pembayaran</th>
                            <th>Metode</th>
                            <th>Jenis Tagihan</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center font-size-sm">
                                <strong>PHB80137</strong>
                            </td>
                            <td class="font-size-sm text-center">
                                09:32:45 17/09/2021
                            </td>
                            <td class="font-size-sm">
                                Virtual Akun Bank Jateng
                            </td>
                            <td class="font-size-sm">
                                TAGIHAN_BLN_2 [ 2020/2021 - GANJIL ]
                            </td>
                            <td class="font-size-sm">
                                SPP REGULER
                            </td>
                            <td>
                                <strong>Rp. 450.000</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center font-size-sm">
                                <strong>PHB80136</strong>
                            </td>
                            <td class="font-size-sm text-center">
                                08:46:45 16/09/2021
                            </td>
                            <td class="font-size-sm">
                                Virtual Akun BNI
                            </td>
                            <td class="font-size-sm">
                                TAGIHAN_BLN_1 [ 2020/2021 - GANJIL ]
                            </td>
                            <td class="font-size-sm">
                                SPP REGULER
                            </td>
                            <td>
                                <strong>Rp. 450.000</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH.'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH.'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH.'views/inc/_global/views/footer_end.php'; ?>