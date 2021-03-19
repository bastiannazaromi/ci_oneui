<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_js('js/instascan.min.js'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Absensi Scanner</h3>
            <div class="block-options">
                <button type="button" class="btn btn-sm btn-alt-light"><i class="si si-camera mr-1"></i>Fix
                    Camera</button>
            </div>
        </div>
        <div class="block-content">
            <div class="card-body text-center">
                <video style="max-height: 100%; max-width: 100%" id="preview"></video>
            </div>
            <p class="text-center">
                Arahkan pada kode QR dan pemindai akan mulai memindai secara otomatis. Kode QR di sisi dosen akan
                diperbarui setiap 10 detik.<br>Jika muncul notifikasi "Permission Camera", pilih <b>Allow (Izinkan)</b>.
            </p>
        </div>
    </div>
</div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<script type="text/javascript">
let scanner = new Instascan.Scanner({
    video: document.getElementById('preview'),
    mirror: false
});
scanner.addListener('scan', function(content) {
    window.location.href = content;
});
Instascan.Camera.getCameras().then(function(cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[1]);
    } else {
        console.error('Wow kameranya hilang bro!');
    }
}).catch(function(e) {
    console.error(e);
});
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>