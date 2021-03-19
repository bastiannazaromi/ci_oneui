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
            <h3 class="block-title">Ubah Password</h3>
        </div>
        <div class="block-content block-content-full">
            <form action="<?=base_url('dosen/keamanan/updatePass')?>" method="POST">
            <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>"value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="col-sm-12">
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
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Verifikasi 2 Langkah</h3>
        </div>
        <div class="block-content block-content-full">
            <form action="be_forms_elements.php" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="example-sw-custom1"
                                name="example-sw-custom1" checked="">
                            <label class="custom-control-label" for="example-sw-custom1">Aktifkan 2FA</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>