<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/prodi/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('toastr/toastr.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2 text-center text-sm-left">
            <div class="flex-sm-fill">
                <h1 class="h3 font-w700 mb-2">
                    Main Dashboard
                </h1>
                <h2 class="h6 font-w500 text-muted mb-0">
                    Welcome <a class="font-w600" href="javascript:void(0)"><?= $this->user[0]->nama; ?></a>, everything
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
                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?php echo count($dosen) ?></dt>
                        <dd class="text-muted mb-0">Dosen</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-users font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/group'); ?>">
                        View all Dosen
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END Pending Orders -->
        </div>
        <div class="col-sm-6 col-xl-3">
            <!-- New Customers -->
            <div class="block block-rounded d-flex flex-column">
                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?php echo count($mahasiswa) ?></dt>
                        <dd class="text-muted mb-0">Mahasiswa Active</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-user font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/user'); ?>">
                        View all mahasiswa
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END New Customers -->
        </div>
        <div class="col-sm-6 col-xl-3">
            <!-- Messages -->
            <div class="block block-rounded d-flex flex-column">
                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700"><?php echo count($mata_kuliah) ?></dt>
                        <dd class="text-muted mb-0">Mata Kuliah</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-layer-group font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('admin/prodi'); ?>">
                        View all MK
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END Messages -->
        </div>
        <div class="col-sm-6 col-xl-3">
            <!-- Conversion Rate -->
            <div class="block block-rounded d-flex flex-column">
                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt class="font-size-h2 font-w700">4.5%</dt>
                        <dd class="text-muted mb-0">Conversion Rate</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-chart-line font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="javascript:void(0)">
                        View statistics
                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                    </a>
                </div>
            </div>
            <!-- END Conversion Rate-->
        </div>
    </div>
    <!-- END Overview -->

    <div class="row">
        <div class="col-xl-6 d-flex flex-column">
            <!-- Earnings Summary -->
            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grafik Total Mahasiswa Aktif</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full align-items-center">
                    <div id="chart-mahasiswa"></div>
                </div>
            </div>
            <!-- END Earnings Summary -->
        </div>

        <div class="col-xl-6 d-flex flex-column">
            <!-- Earnings Summary -->
            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grafik Status Mahasiswa</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full align-items-center">
                    <div id="chart-status-mhs"></div>
                </div>
            </div>
            <!-- END Earnings Summary -->
        </div>
    </div>

</div>

<!-- END Page Content -->
<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('highcharts/highcharts.js'); ?>
<?php $one->get_js('highcharts/exporting.js'); ?>
<?php $one->get_js('highcharts/export-data.js'); ?>
<?php $one->get_js('highcharts/accessibility.js'); ?>
<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<script>
    // grafik mahasiswa
    let mhs = <?php echo json_encode($mhs); ?>;
    let dataMhs = [];

    for (let i = 0; i < mhs.length; i++) {
        dataMhs.push({
            name: 'Semester ' + mhs[i].semester,
            y: parseInt(mhs[i].total)
        });
    }

    Highcharts.chart('chart-mahasiswa', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Total Mahasiswa Aktif'
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
                    format: '<b>{point.name}</b>: {point.y} mahasiswa'
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Mahasiswa',
            colorByPoint: true,
            data: dataMhs
        }]
    });

    // grafik status mahasiswa
    let status_mhs = <?php echo json_encode($mhs_status); ?>;
    let dataStatusMhs = [];

    for (let i = 0; i < status_mhs.length; i++) {
        dataStatusMhs.push({
            name: status_mhs[i].nama_status,
            y: parseInt(status_mhs[i].total)
        });
    }

    Highcharts.chart('chart-status-mhs', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Status Mahasiswa'
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
                    format: '<b>{point.name}</b>: {point.y} mahasiswa'
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Mahasiswa',
            colorByPoint: true,
            data: dataStatusMhs
        }]
    });
</script>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>