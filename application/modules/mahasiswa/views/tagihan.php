<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-1g8duQne5XQexjAr"></script>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Daftar Tagihan</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Jenis Tagihan</th>
                            <th>Detail Tagihan</th>
                            <th class="text-right">Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tagihan == false) : ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak Ada Tagihan untuk anda</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($tagihan as $row) : ?>
                                <tr>
                                    <td class="font-size-sm">
                                        <?php echo $row->nama_mp ?> [ <?php echo $tahun_akademik->tahun_akademik ?> ]
                                    </td>
                                    <td class="font-size-sm">
                                        <?php echo $row->nama_rbp ?>
                                    </td>
                                    <td>
                                        <strong class="text-right"><div clas="text-right"><?php echo "Rp " . number_format($row->nominal, 2, ",", "."); ?></div></strong>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox d-inline-block aksi">
                                            <input type="checkbox" class="id_tagihan" value="<?php echo enkrip($row->id) ?>" name="id_tagihan[]">
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if ($tagihan) : ?>
                        <tfoot>
                            <tr>
                                <td colspan="5"><button type="submit" class="btn btn-primary" id="bayar" style="float: right;">Bayar</button></td>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<script>
    $('#bayar').click(function(event) {
        event.preventDefault();
        $(this).attr('disabled', 'disabled');
        let data = [];
        $('.id_tagihan:checked').each(function() {
            data.push($(this).val());
        });
        $.ajax({
            url: '<?php echo base_url('mahasiswa/tagihan/token_snap') ?>',
            type: 'POST',
            data: {
                id_tagihan: data,
            },
            cache: false,
            async: true,
            success: function(data) {
                console.log('data ' + data);
                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                }
                snap.pay(data, {
                    onSuccess: function(result) {
                        changeResult('success', result);
                        console.log(result);
                        One.helpers('notify', {
                            from: 'top',
                            align: 'right',
                            type: 'success',
                            icon: 'fa fa-times mr-1',
                            message: 'Success Transaksi'
                        });
                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        console.log(result);
                        One.helpers('notify', {
                            from: 'top',
                            align: 'right',
                            type: 'warning',
                            icon: 'fa fa-times mr-1',
                            message: 'Pendding Transaksi'
                        });
                    },
                    onError: function(result) {
                        changeResult('error', result);
                        One.helpers('notify', {
                            from: 'top',
                            align: 'right',
                            type: 'danger',
                            icon: 'fa fa-times mr-1',
                            message: result
                        });
                    },
                    onClose: function(result) {
                        changeResult('error', result);
                        One.helpers('notify', {
                            from: 'top',
                            align: 'right',
                            type: 'danger',
                            icon: 'fa fa-times mr-1',
                            message: 'customer closed the popup without finishing the payment'
                        });
                    }
                });
            },
            error: function(e) {
                console.log(e);
            }
        });
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>