<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/admin/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Setting Web Service API</h3>
        </div>
        <div class="block-content block-content-full">
            <form action="<?= base_url('admin/setwsapi/save') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                <div class="col-sm-12">
                    <p class="font-size-sm text-muted">
                        <?= $this->uri->segment(3) ?>
                        Harap gunakan akun Feeder PDDIKTI yang benar dan tepat, agar sinkronisasi sistem bisa berjalan dengan baik dan benar.
                    </p>
                    <div class="form-group">
                        <label for="example-text-input">Username</label>
                        <input type="text" class="form-control" name="user" value="<?= $user ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Password</label>
                        <input type="password" class="form-control" name="pass" value="<?= $pass ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Host API</label>
                        <input type="text" class="form-control" id="confirPass" name="api" value="<?= $api ?>" required>
                    </div>
                    <button type="submit" class="btn btn-alt-primary mb-2">Save</button>
                    <a href="<?= base_url('admin/setwsapi/test') ?>" class="btn btn-alt-secondary mb-2">Test Connection</a>
                </div>
            </form>
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Mode Web Service API</h3>
        </div>
        <div class="block-content block-content-full">
            <form action="<?= base_url('admin/setwsapi/save') ?>" method="POST">
                <div class="col-sm-12">
                    <p class="font-size-sm text-muted">
                        Setting mode Web Service API Feeder PDDIKTI.
                    </p>
                    <div class="form-group">
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="mode" name="mode">
                            <label class="custom-control-label" for="mode">Live Mode</label>
                        </div>
                    </div>
                    <div class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0">Jika Anda ingin melakukan uji coba terhadap aplikasi, harap untuk mematikan Live Mode.
                            </p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>