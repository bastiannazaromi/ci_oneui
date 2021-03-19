<header id="page-header">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <a class="font-w600 font-size-h5 tracking-wider text-dual mr-3" href="<?php echo base_url() ?>">
                OASE<span class="font-w400">PHB</span>
            </a>
        </div>

        <div class="d-flex align-items-center">
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn btn-sm btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="text-primary">•</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-2 bg-primary-dark text-center rounded-top">
                        <h5 class="dropdown-header text-uppercase text-white">Pemberitahuan</h5>
                    </div>
                    <ul class="nav-items mb-0">
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mr-2 ml-3">
                                    <i class="fa fa-fw fa-check-circle text-success"></i>
                                </div>
                                <div class="media-body pr-2">
                                    <div class="font-w600">Pembayaran Tagihan UAS Anda Berhasil</div>
                                    <span class="font-w500 text-muted">08:45 17-04-2021</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                            <i class="fa fa-fw fa-arrow-down mr-1"></i> Load More..
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded" src="
                    <?=
                    ($this->user->foto) ?
                        base_url('upload/dosen/' . $this->user->foto) :
                        base_url('upload/default.jpg');
                    ?>
                    " alt="<?= $this->user->nama; ?>" style="width: 21px;">
                    <span class="d-none d-sm-inline-block ml-1"><?= $this->user->nama; ?></span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0" aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-primary-dark rounded-top">
                        <img class="rounded" src="
                    <?=
                    ($this->user->foto) ?
                        base_url('upload/dosen/' . $this->user->foto) : base_url('upload/default.jpg');
                    ?>
                    " alt="<?= $this->user->nama; ?>" style="width: 48px;">
                        <p class="mt-2 mb-0 text-white font-w500"><?= $this->user->nama; ?></p>
                        <p class="mb-0 text-white-50 font-size-sm"><?= $this->user->nipy; ?></p>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="<?= base_url('dosen/profil') ?>">
                            <span class="font-size-sm font-w500">Data Diri</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="<?= base_url('dosen/keamanan') ?>">
                            <span class="font-size-sm font-w500">Keamanan</span>
                        </a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="<?= $this->logout ?>">
                            <span class="font-size-sm font-w500">Keluar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="page-header-loader" class="overlay-header bg-primary-lighter">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
            </div>
        </div>
    </div>
</header>