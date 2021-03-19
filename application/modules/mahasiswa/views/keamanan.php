<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/mahasiswa/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>
<?php include APPPATH . 'views/inc/mahasiswa/views/inc_navigation.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Ubah Password</h3>
        </div>
        <div class="block-content block-content-full">
            <form action="<?= base_url('mahasiswa/keamanan/updatePass'); ?>" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="col-sm-12">
                    <p class="font-size-sm text-muted">
                        <?=$this->uri->segment(3)?>
                        Ganti password secara berkala, untuk meningkatkan keamanan akun Anda. Gunakan kombinasi password yang sulit ditebak, sehingga peretas tidak bisa membobol akun Anda dengan mudah.
                    </p>
                    <div class="form-group">
                        <label for="example-text-input">Password Lama</label>
                        <input type="password" class="form-control" id="oldPass" name="oldPass" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Password Baru</label>
                        <input type="password" class="form-control" id="newPass" name="newPass" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirPass" name="confirPass" required>
                    </div>
                    <button type="submit" class="btn btn-alt-secondary mb-2">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Verifikasi 2 Langkah (Coming Soon)</h3>
        </div>
        <div class="block-content block-content-full">
            <form action="be_forms_elements.php" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                <div class="col-sm-12">
                    <p class="font-size-sm text-muted">
                        Dengan mengaktifkan fitur keamanan Verifikasi 2 Langkah (2FA), akun Anda akan sulit untuk dijebol, sekalipun peretas mengetahui kata sandi Anda. Setiap kali Anda masuk, sistem kami akan mengirim kode OTP melalui email Anda.
                    </p>
                    <div class="form-group">
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="2FA" name="2fa" disabled>
                            <label class="custom-control-label" for="2FA">Aktifkan 2FA</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Log Aktivitas (Coming Soon)</h3>
        </div>
        <div class="block-content block-content-full">
            <p class="font-size-sm text-muted">
                Dengan fitur Log Aktivitas, Anda bisa memantau kapan terakhir kali Anda mengakses sistem.
            </p>
            Coming Soon...
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>