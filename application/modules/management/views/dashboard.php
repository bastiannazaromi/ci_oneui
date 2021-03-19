<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/management/config.php'; ?>
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
                        <dt class="font-size-h2 font-w700"><?= $pegawai; ?></dt>
                        <dd class="text-muted mb-0">Pegawai</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-users font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('management/pegawai'); ?>">
                        View all pegawai
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
                        <dt class="font-size-h2 font-w700"><?= $prodi; ?></dt>
                        <dd class="text-muted mb-0">Prodi</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-layer-group font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('management/prodi'); ?>">
                        View all prodi
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
                        <dt class="font-size-h2 font-w700"><?= $gedung; ?></dt>
                        <dd class="text-muted mb-0">Gedung</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-building font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="<?= base_url('management/gedung'); ?>">
                        View all gedung
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
                        <dt class="font-size-h2 font-w700"><?= $mahasiswa; ?></dt>
                        <dd class="text-muted mb-0">Mahasiswa Aktif</dd>
                    </dl>
                    <div class="item item-rounded bg-body">
                        <i class="fa fa-users font-size-h3 text-primary"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500 d-flex align-items-center" href="javascript:void(0)">

                    </a>
                </div>
            </div>
            <!-- END Conversion Rate-->
        </div>
    </div>
    <!-- END Overview -->

    <!-- Statistics -->
    <div class="row">
        <div class="col-xl-6 d-flex flex-column">
            <!-- Earnings Summary -->
            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grafik Pegawai Group</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full align-items-center">
                    <div id="chart-pegawai"></div>
                </div>
            </div>
            <!-- END Earnings Summary -->
        </div>

        <div class="col-xl-6 d-flex flex-column">
            <!-- Earnings Summary -->
            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grafik Dosen</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full align-items-center">
                    <div id="chart-dosen"></div>
                </div>
            </div>
            <!-- END Earnings Summary -->
        </div>

        <div class="col-xl-12 d-flex flex-column">
            <!-- Earnings Summary -->
            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Grafik Mahasiswa Aktif</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full align-items-center">
                    <div id="chart-mhs"></div>
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

<?php $one->get_js('toastr/toastr.min.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>

<script>
    // grafik pegawai
    let peg_group = <?php echo json_encode($peg_group); ?>;
    let dataPeg = [];

    for (let i = 0; i < peg_group.length; i++) {
        dataPeg.push({
            name: peg_group[i].nama_status,
            y: parseInt(peg_group[i].total)
        });
    }

    Highcharts.chart('chart-pegawai', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Grafik Pegawai Group'
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
                    format: '<b>{point.name}</b>: {point.y} pegawai'
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Pegawai',
            colorByPoint: true,
            data: dataPeg
        }]
    });

    // grafik dosen
    let dosen_group = <?php echo json_encode($dosen_group); ?>;
    let dataDosen = [];

    for (let i = 0; i < dosen_group.length; i++) {
        dataDosen.push({
            name: dosen_group[i].nama,
            y: parseInt(dosen_group[i].total)
        });
    }

    Highcharts.chart('chart-dosen', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Grafik Dosen'
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
                    format: '<b>{point.name}</b>: {point.y} dosen'
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Dosen',
            colorByPoint: true,
            data: dataDosen
        }]
    });

    // grafik mhs
    let mhs_group = <?php echo json_encode($mhs_group); ?>;
    let dataMhs = [];

    for (let i = 0; i < mhs_group.length; i++) {
        dataMhs.push({
            name: mhs_group[i].nama,
            y: parseInt(mhs_group[i].total)
        });
    }

    Highcharts.chart('chart-mhs', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Grafik Mahasiswa Aktif'
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
</script>

<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>