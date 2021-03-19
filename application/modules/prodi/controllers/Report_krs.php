<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_krs extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        prodi_init();
    }

    public function index()
    {
        if ($this->u3 == 'detail') {
            $nim    = dekrip($this->u4);
            $tahun  = dekrip($this->u5);

            if ($tahun) {
                $data_krs = $this->prodi->getDetailKrs(['krs.id_th' => $tahun, 'krs.nim' => $nim, 'mahasiswa.prodi' => $this->user[0]->kd_prodi]);
            } else {
                $data_krs = null;
            }

            $params = [
                'title'     => 'Report KRS',
                'tahun'     => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                'data_krs'  => $data_krs,
                'th_ini'    => $tahun,
                'nim'       => enkrip($nim)
            ];

            $this->load->view('detail_report_krs', $params);
        } elseif ($this->u3 == 'setujui') {
            $nim        = dekrip($this->u4);
            $tahun      = dekrip($this->u5);

            $data = [
                'status'    => 1
            ];

            $update = $this->universal->update($data, ['nim' => $nim, 'id_th' => $tahun], 'krs');
            if ($update) {
                $this->notifikasi->success('Berhasil setujui KRS');
            }
            redirect($_SERVER['HTTP_REFERER']);
        } elseif ($this->u3 == 'cetak') {
            $nim        = dekrip($this->u4);
            $th_ak      = dekrip($this->u5);

            $this->_pdfKRS($nim, $th_ak);
        } else {
            $th_ini = dekrip($this->u3);

            if (!$th_ini) {
                $th_ini = $this->universal->getOrderBy(['prodi' => $this->user[0]->kd_prodi], 'mahasiswa', 'tahun_masuk', 'desc', 1);

                $th_ini = $th_ini[0]->tahun_masuk;
            }
            $tahun = $this->universal->getGroupSelect('tahun_masuk as tahun', ['prodi' => $this->user[0]->kd_prodi], 'mahasiswa', 'tahun', 'tahun', 'asc');

            $params = [
                'title'     => 'Report KRS',
                'tahun'     => $tahun,
                'data_krs'  => $this->prodi->getMhs($th_ini),
                'th_ini'    => $th_ini
            ];

            // echo json_encode($params);
            // die;

            $this->session->set_userdata('previous_url', current_url());
            $this->load->view('report_krs', $params);
        }
    }

    private function _pdfKRS($nim, $id_tahun)
    {
        $this->load->library('pdf');

        $mhs = $this->universal->getOne(['nim' => $nim], 'mahasiswa');
        $tahun_akademik = $this->universal->getOne(['id' => $id_tahun], 'tahun_akademik');
        $mk = $this->prodi->getReportKrs([
            'krs.id_th'     => $id_tahun,
            'krs.nim'       => $nim
        ]);

        $status_krs = 0;
        foreach ($mk as $hsl) {
            $status_krs = $hsl->status_krs;
            $semester = $hsl->semester;
        }
        if ($status_krs == 0) {
            $this->notifikasi->error('KRS belum disetujui');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $ka_prodi = $this->prodi->getKAProdi(['kd_prodi' => $this->user[0]->kd_prodi]);
        $dosen_wali = $this->universal->getOneSelect('gelar_depan, nama, gelar_belakang', ['username' => $mhs->id_dosen_wali], 'pegawai');

        if ($ka_prodi->gelar_depan) {
            $nama_kaProdi = $ka_prodi->gelar_depan . ' ' . $ka_prodi->nama . ', ' . $ka_prodi->gelar_belakang;
        } else {
            $nama_kaProdi = $ka_prodi->nama . ', ' . $ka_prodi->gelar_belakang;
        }

        if ($dosen_wali->gelar_depan) {
            $nama_dosenWali = $dosen_wali->gelar_depan . ' ' . $dosen_wali->nama . ', ' . $dosen_wali->gelar_belakang;
        } else {
            $nama_dosenWali = $dosen_wali->nama . ', ' . $dosen_wali->gelar_belakang;
        }

        $pdf = new FPDF('p', 'mm', 'F4');

        $pdf->AddPage();

        $pdf->Ln(-6);
        $pdf->SetAutoPageBreak(TRUE, 1);
        $pdf->Image('assets/poltek.png', 12, 4, 22, 22);

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(30, 4.5, '', 0, 0);
        $pdf->Cell(130, 4.5, 'Yayasan Pendidikan Harapan Bersama', 0, 0, 'C');
        $pdf->SetFont('Times', 'I', 6);
        $pdf->Cell(30, 4.5, 'Lembar ke 1 Mahasiswa', 0, 1);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 4.5, 'PoliTekniK Harapan Bersama', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(190, 4.5, 'PROGRAM STUDI D III TEKNIK KOMPUTER', 0, 1, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(190, 4.5, 'Kampus I: Jl. Mataram No.9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 0, 1, 'C');
        $pdf->Cell(190, 4.5, 'Website: www.poltektegal.ac.id       Email: komputer@poltektegal.ac.id', 0, 1, 'C');

        $pdf->SetLineWidth(1);
        $pdf->Line(10, 28, 200, 28);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 29, 200, 29);

        $pdf->Ln(4);
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 5, 'KARTU RENCANA STUDI (KRS)', 0, 1, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Nama', 0, 0);
        $pdf->Cell(70, 4, ': ' . $mhs->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $semester, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'NIM', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nim, 0, 0);
        $pdf->Cell(28, 4, 'TA Akademik', 0, 0);
        $pdf->Cell(56, 4, ': ' . $tahun_akademik->th_awal . ' / ' . $tahun_akademik->th_akhir, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Dosen Wali', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nama_dosenWali, 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user[0]->jenjang . ' - ' . $this->user[0]->nama_prodi, 0, 1);

        $pdf->Ln(2);

        $pdf->SetFillColor(217, 217, 217);
        $pdf->MultiCell(15, 5, 'No', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 15, $yPos - 5);
        $pdf->MultiCell(35, 5, 'Kode MK', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 50, $yPos - 5);
        $pdf->MultiCell(125, 5, 'Mata Kuliah', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 175, $yPos - 5);
        $pdf->MultiCell(15, 5, 'SKS', 1, 'C', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Times', '', 9);
        $no = 1;
        $sks = 0;
        foreach ($mk as $hasil) {
            $pdf->Cell(15, 5, $no++, 1, 0, 'C');
            $pdf->Cell(35, 5, $hasil->kode_mk_krs, 1, 0);
            $pdf->Cell(125, 5, strtoupper($hasil->nama_mk), 1, 0);
            $pdf->Cell(15, 5, $hasil->sks, 1, 1, 'C');

            $sks = $sks + $hasil->sks;
        }
        $pdf->Cell(175, 5, 'Jumlah SKS', 1, 0, 'R');
        $pdf->Cell(15, 5, $sks, 1, 1, 'C');

        $pdf->Ln(3);
        $pdf->Cell(190, 6, 'Tanggal Pengesahan : ' . tanggal_indo(), 1, 1, 'C');
        $pdf->Cell(63.3, 6, 'Ka. Prodi,', 0, 0, 'C');
        $pdf->Cell(63.3, 6, 'Dosen Wali,', 0, 0, 'C');
        $pdf->Cell(63.3, 6, 'Mahasiswa,', 0, 0, 'C');
        $pdf->Cell(1, 15, '', 0, 1, 'C');
        $pdf->SetFont('Times', 'U', 9);
        $pdf->Cell(63.3, 7, $nama_kaProdi, 0, 0, 'C');
        $pdf->Cell(63.3, 7, $nama_dosenWali, 0, 0, 'C');
        $pdf->Cell(63.3, 7, $mhs->nama_lengkap, 0, 1, 'C');
        $pdf->Cell(63.3, -22, '', 1, 0, 'C');
        $pdf->Cell(63.3, -22, '', 1, 0, 'C');
        $pdf->Cell(63.3, -22, '', 1, 1, 'C');

        // lembar 2

        $pdf->SetXY(0, 168);

        $pdf->Image('assets/poltek.png', 12, 170, 22, 22);
        $pdf->Cell(1, 2, '', 0, 1);

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(30, 4.5, '', 0, 0);
        $pdf->Cell(130, 4.5, 'Yayasan Pendidikan Harapan Bersama', 0, 0, 'C');
        $pdf->SetFont('Times', 'I', 6);
        $pdf->Cell(30, 4.5, 'Lembar ke 2 Arsip', 0, 1);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 4.5, 'PoliTekniK Harapan Bersama', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(190, 4.5, 'PROGRAM STUDI D III TEKNIK KOMPUTER', 0, 1, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(190, 4.5, 'Kampus I: Jl. Mataram No.9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 0, 1, 'C');
        $pdf->Cell(190, 4.5, 'Website: www.poltektegal.ac.id       Email: komputer@poltektegal.ac.id', 0, 1, 'C');

        $pdf->SetLineWidth(1);
        $pdf->Line(10, 194, 200, 194);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 195, 200, 195);

        $pdf->Ln(4);
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 5, 'KARTU RENCANA STUDI (KRS)', 0, 1, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Nama', 0, 0);
        $pdf->Cell(70, 4, ': ' . $mhs->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $semester, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'NIM', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nim, 0, 0);
        $pdf->Cell(28, 4, 'TA Akademik', 0, 0);
        $pdf->Cell(56, 4, ': ' . $tahun_akademik->th_awal . ' / ' . $tahun_akademik->th_akhir, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Dosen Wali', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nama_dosenWali, 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user[0]->jenjang . ' - ' . $this->user[0]->nama_prodi, 0, 1);

        $pdf->Ln(2);

        $pdf->SetFillColor(217, 217, 217);
        $pdf->MultiCell(15, 5, 'No', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 15, $yPos - 5);
        $pdf->MultiCell(35, 5, 'Kode MK', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 50, $yPos - 5);
        $pdf->MultiCell(125, 5, 'Mata Kuliah', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 175, $yPos - 5);
        $pdf->MultiCell(15, 5, 'SKS', 1, 'C', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Times', '', 9);
        $no = 1;
        $sks = 0;

        foreach ($mk as $hasil) {
            $pdf->Cell(15, 5, $no++, 1, 0, 'C');
            $pdf->Cell(35, 5, $hasil->kode_mk_krs, 1, 0);
            $pdf->Cell(125, 5, strtoupper($hasil->nama_mk), 1, 0);
            $pdf->Cell(15, 5, $hasil->sks, 1, 1, 'C');

            $sks = $sks + $hasil->sks;
        }
        $pdf->Cell(175, 5, 'Jumlah SKS', 1, 0, 'R');
        $pdf->Cell(15, 5, $sks, 1, 1, 'C');

        $pdf->Ln(3);
        $pdf->Cell(190, 6, 'Tanggal Pengesahan : ' . tanggal_indo(), 1, 1, 'C');
        $pdf->Cell(63.3, 6, 'Ka. Prodi,', 0, 0, 'C');
        $pdf->Cell(63.3, 6, 'Dosen Wali,', 0, 0, 'C');
        $pdf->Cell(63.3, 6, 'Mahasiswa,', 0, 0, 'C');
        $pdf->Cell(1, 15, '', 0, 1, 'C');
        $pdf->SetFont('Times', 'U', 9);
        $pdf->Cell(63.3, 7, $nama_kaProdi, 0, 0, 'C');
        $pdf->Cell(63.3, 7, $nama_dosenWali, 0, 0, 'C');
        $pdf->Cell(63.3, 7, $mhs->nama_lengkap, 0, 1, 'C');
        $pdf->Cell(63.3, -22, '', 1, 0, 'C');
        $pdf->Cell(63.3, -22, '', 1, 0, 'C');
        $pdf->Cell(63.3, -22, '', 1, 1, 'C');

        $pdf->Output($nim . '_krs.pdf', 'I');
    }
}

/* End of file Report_krs.php */
