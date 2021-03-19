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
            <h3 class="block-title">Data Diri</h3>
            <div class="block-options">
                <button type="button" onclick="window.location.href='<?= base_url('dosen/profil/edit') ?>'" class="btn btn-sm btn-alt-light"><i class="fa fa-edit"></i> Perbarui Data Diri</button>
            </div>
        </div>
        <div class="block-content">
            <div class="row push">
                <div class="col-sm-3 text-center">
                    <div class="mb-3 py-1">
                        <img class="img-thumbnail" style="width: 200px;" src="<?= ($this->user->foto == 'default.jpg' || $this->user->foto == '') ? base_url('upload/default.jpg') : base_url('upload/dosen/' . $this->user->foto)
                                                                                ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Upload foto dalam format JPEG/PNG/JPG. Usahakan menggunakan skala 1x1 agar foto menjadi lebih rapi. Klik foto untuk merubah foto saat ini. Maksimal 2MB" alt="Alifa Putri Mirza">
                        <br>
                        <span class="mt-3">
                            <?= $this->user->status_karyawan ?
                                '<span class="badge badge-success">
                            Aktif
                        </span>' :
                                '<span class="badge badge-secondary">
                            Tidak Aktif
                        </span>'
                            ?>
                        </span>
                        <address class="font-size-sm">
                            2020/2021 - Ganjil
                            <br>
                            Semester 3
                        </address>
                    </div>
                </div>
                <div class="col-sm-9 py-2 d-none d-sm-block">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width:240px"><b>Prodi</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nama_prodi ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table>
                        <tbody>
                            <tr>
                                <td><b>Nama Lengkap</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->gelar_depan . " " . $this->user->nama . " " . $this->user->gelar_belakang ?></td>
                            </tr>
                            <tr>
                                <td><b>NIK</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nik ?></td>
                            </tr>
                            <tr>
                                <td style="width:240px;"><b>NIPY</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nipy ?></td>
                            </tr>
                            <tr>
                                <td><b>NIDN</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nidn ?></td>
                            </tr>

                            <tr>
                                <td><b>Tempat Lahir</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->tempat ?></td>
                            </tr>
                            <tr>
                                <td><b>Tanggal Lahir</b></td>
                                <td><b>:</b>&nbsp;
                                    <?= date_format(date_create($this->user->tanggal), "d M Y") ?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Jenis Kelamin</b></td>
                                <td><b>:</b>&nbsp;<?= ($this->user->jk == 'L') ? "Laki-laki" : "Perempuan" ?></td>
                            </tr>
                            <tr>
                                <td><b>Agama</b></td>
                                <td><b>:</b>&nbsp;<?= $agama ?></td>
                            </tr>
                            <tr>
                                <td><b>Status Nikah</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->status_nikah ? 'Sudah nikah' : 'Belum nikah' ?></td>
                            </tr>
                            <tr>
                                <td><b>Status Pegawai</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nama_status ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table>
                        <tbody>
                            <tr>
                                <td style="width:240px;"><b>Kewarganegaraan</b></td>
                                <td><b>:</b>&nbsp;Warga Negara Indonesia (WNI)</td>
                            </tr>
                            <tr>
                                <td><b>Telepon</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->telepon ?></td>
                            </tr>
                            <tr>
                                <td><b>Email</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->email ?></td>
                            </tr>
                            <tr>
                                <td><b>Alamat</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->alamat ?></td>
                            </tr>
                            <tr>
                                <td><b>Desa</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nama_desa ?></td>
                            </tr>
                            <tr>
                                <td><b>Kecamatan</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nama_kecamatan ?></td>
                            </tr>
                            <tr>
                                <td><b>Kota / Kabupaten</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nama_kabupaten ?></td>
                            </tr>
                            <tr>
                                <td><b>Provinsi</b></td>
                                <td><b>:</b>&nbsp;<?= $this->user->nama_provinsi ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>