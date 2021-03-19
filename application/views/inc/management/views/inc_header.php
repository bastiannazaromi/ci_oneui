<header id="page-header">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
            <button type="button" class="btn btn-sm btn-dual mr-2" data-toggle="modal" data-target="#one-modal-apps">
                <i class="fa fa-fw fa-cubes"></i>
            </button>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn btn-sm btn-dual d-flex align-items-center" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle" src="<?= base_url('upload/admin/') . $this->user[0]->foto; ?>" alt="Header Avatar" style="width: 21px;">
                    <span class="d-none d-sm-inline-block ml-2"><?= $this->user[0]->nama; ?></span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ml-1 mt-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 border-0" aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-primary-dark rounded-top">
                        <img class="img-avatar img-avatar48" src="<?= base_url('upload/admin/') . $this->user[0]->foto; ?>" alt="Profile">
                        <p class="mt-2 mb-0 text-white font-w500"><?= $this->user[0]->nama; ?></p>
                        <p class="mb-0 text-white-50 font-size-sm"><?= $this->user[0]->nama_group; ?></p>
                    </div>
                    <div class="p-2">

                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="<?= base_url('management/profile'); ?>">
                            <span class="font-size-sm font-w500">Profile</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="<?= $this->logout ?>">
                            <span class="font-size-sm font-w500">Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn btn-sm btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="text-primary">•</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-2 bg-primary-dark text-center rounded-top">
                        <h5 class="dropdown-header text-uppercase text-white">Notifications</h5>
                    </div>
                    <ul class="nav-items mb-0">
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mr-2 ml-3">
                                    <i class="fa fa-fw fa-check-circle text-success"></i>
                                </div>
                                <div class="media-body pr-2">
                                    <div class="font-w600">You have a new follower</div>
                                    <span class="font-w500 text-muted">15 min ago</span>
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
        </div>
    </div>

    <div id="page-header-search" class="overlay-header bg-white">
        <div class="content-header">
            <form class="w-100" action="be_pages_generic_search.php" method="POST">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                            <i class="fa fa-fw fa-times-circle"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                </div>
            </form>
        </div>
    </div>
    <div id="page-header-loader" class="overlay-header bg-white">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin"></i>
            </div>
        </div>
    </div>
</header>