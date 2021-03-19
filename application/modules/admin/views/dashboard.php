<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/admin/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>


<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div
            class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2 text-center text-sm-left">
            <div class="flex-sm-fill">
                <h1 class="h3 font-w700 mb-2">
                    Dashboard
                </h1>
                <h2 class="h6 font-w500 text-muted mb-0">
                    Welcome <a class="font-w600" href="javascript:void(0)"><?= $this->user[0]->nama; ?></a>!!
                    looks great.
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row row-deck">
        <div class="col-sm-6 col-xl-3">
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?= $group; ?></dt>
                        <dd class="text-muted mb-0">Groups</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-users font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/group'); ?>">
                        View all groups
                        <i class="fa fa-arrow-alt-circle-down ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END Pending Orders -->
        </div>
        <div class="col-sm-6 col-xl-3">
            <!-- New Customers -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?= $user; ?></dt>
                        <dd class="text-muted mb-0">Users</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-user font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/user'); ?>">
                        View all users
                        <i class="fa fa-arrow-alt-circle-down ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END New Customers -->
        </div>
        <div class="col-sm-6 col-xl-3">
            <!-- Messages -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?= $prodi; ?></dt>
                        <dd class="text-muted mb-0">Prodi</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-layer-group font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/prodi'); ?>">
                        View all prodi
                        <i class="fa fa-arrow-alt-circle-down ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END Messages -->
        </div>
        <div class="col-sm-6 col-xl-3">
            <!-- Conversion Rate -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?= $jalur; ?></dt>
                        <dd class="text-muted mb-0">Jalur Pendaftaran</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-arrow-right font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/jalur'); ?>">
                        View all jalur pendaftaran
                        <i class="fa fa-arrow-alt-circle-down ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END Conversion Rate-->
        </div>
    </div>
    <!-- END Overview -->

    <!-- Statistics -->
    <div class="row">
        <div class="col-xl-12 d-flex flex-column">
            <!-- Earnings Summary -->
            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grafik User Group</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full align-items-center">
                    <div id="chart-user"></div>
                </div>
            </div>
            <!-- END Earnings Summary -->
        </div>
    </div>
    <!-- END Statistics -->

</div>
<!-- END Page Content -->
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('highcharts/highcharts.js'); ?>
<?php $one->get_js('highcharts/exporting.js'); ?>
<?php $one->get_js('highcharts/export-data.js'); ?>
<?php $one->get_js('highcharts/accessibility.js'); ?>
<script>
let user = <?php echo json_encode($countUser); ?>;
let dataUser = [];

for (let i = 0; i < user.length; i++) {
    dataUser.push({
        name: user[i].nama_group,
        y: parseInt(user[i].total)
    });
}

Highcharts.chart('chart-user', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Grafik User Group'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} User'
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Group User',
        colorByPoint: true,
        data: dataUser
    }]
});
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>