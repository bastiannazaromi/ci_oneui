<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        mhs_init();
        $this->load->library('pdf');
    }
    public function index()
    {
        if ($this->u3 == 'nilai_akademik') {
            $tahun_akademik_active = $this->universal->getOne(['status' => 1], 'tahun_akademik');
            $tahun_akademik = $this->universal->getMulti('', 'tahun_akademik');
            $params = [
                'title' => 'Nilai Akademik',
                'no' => 1,
                'tahun_akademik' => $tahun_akademik,
                'getNilai' => $this->mhs->getNilaiAkademik(['bagikelas.tahun' => $tahun_akademik_active->id, 'anggota_kelas.nim' => $this->user->nim, 'nilai.username' => $this->user->nim])
            ];
            $this->load->view('nilai_akademik', $params);
        } else if ($this->u3 == 'nilai_kehadiran') {
            $params = array('title' => 'Riwayat Pembayaran');
            $this->load->view('riwayat_pembayaran', $params);
        } else if ($this->u3 == 'dns') {
            if ($this->u4 == 'cetakdns') {
                $ttd = $this->input->get('ttd');
                $nilai_min = $this->input->get('nilai_min');
                if (!$ttd || !$nilai_min) {
                    $this->notifikasi->error('Mode cetak tidak boleh kosong');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->_pdfDNS($ttd, $nilai_min);
                }
            } else {
                $params = [
                    'title' => 'Daftar Nilai Siswa',
                    'dns' => $this->mhs->getDns(['mahasiswa.nim' => $this->user->nim, 'nilai.username' => $this->user->nim]),
                    'no' => 1
                ];
                $this->load->view('report_dns', $params);
            }
        } else if ($this->u3 == 'khs') {
            if ($this->u4 == 'getKhs') {
                $tahun_akademik = dekrip($this->u5);

                $this->db->select('anggota_kelas.*, bagikelas.semester');
                $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
                $this->db->where('anggota_kelas.nim', $this->user->nim);
                $this->db->where('bagikelas.tahun', $tahun_akademik);

                $data_semester = $this->db->get('anggota_kelas')->row();

                $getKhs = $this->mhs->getKhs(['bagikelas.tahun' => $tahun_akademik, 'anggota_kelas.nim' => $this->user->nim, 'nilai.username' => $this->user->nim, 'nilai.smt' => $data_semester->semester, 'nilai.thak' => $tahun_akademik]);
                $params = [
                    'dataKhs'   => $getKhs,
                    'th_ak'     => enkrip($tahun_akademik)
                ];
                $this->load->view('v_dataKhs', $params);
            } elseif ($this->u4 == 'cetakkhs') {
                $th_ak = dekrip($this->u5);

                $this->_pdfKHS($th_ak);
            } else {
                $params = [
                    'title' => 'Report KHS',
                    'dataMhs' => $this->user,
                    'tahun_akademik' => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', '')
                ];
                $this->load->view('report_khs', $params);
            }
        } else if ($this->u3 == 'krs') {
            if ($this->u4 == 'getKrs') {
                $tahun_akademik = $this->u5;
                $getData = $this->mhs->getReportKrs(['nim' => $this->user->nim, 'id_th' => dekrip($tahun_akademik)]);
                if ($getData) {
                    $response = [
                        'status' => true,
                        'messege' => 'Data ditemukan',
                        'data' => $getData
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'messege' => 'Data tidak ditemukan'
                    ];
                }
                echo json_encode($response, true);
            } else if ($this->u4 == 'cetakKrs') {
                $id_tahun = dekrip($this->u5);
                $this->_pdfKRS($id_tahun);
            } else if ($this->u4 == 'cek_data') {
                $query = [
                    'simak_key' => '6023521d3053b',
                    'status' => 0,
                    'nim' => '19090074',
                    'akademik' => 1,
                    'kode_prodi' => '56401'
                ];
                echo api_get('simak_sisfo', 'phb123456', $query, $this->urlSimak . 'tagihan', false);
            } else {
                $params = [
                    'title' => 'Report Kartu Studi Rencana (KRS) Mahasiswa',
                    'dataMhs' => $this->user,
                    'totalSks' => $this->mhs->getTotalSKS(['nim' => $this->user->nim, 'krs.status' => 1]),
                    'tahun_akademik' => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', '')
                ];
                $this->load->view('reportKrs', $params);
            }
        }
    }

    private function _pdfKRS($id_tahun)
    {
        $tahun_akademik = $this->universal->getOne(['id' => $id_tahun], 'tahun_akademik');
        $mk = $this->mhs->getReportKrs([
            'krs.id_th'     => $id_tahun,
            'krs.nim'       => $this->user->nim
        ]);
        $status_krs = 0;
        foreach ($mk as $hsl) {
            $status_krs = $hsl->status_krs;
            $semester = $hsl->semester;
        }
        if ($status_krs == 0) {
            $this->notifikasi->error('KRS Anda belum disetujui prodi');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $ka_prodi = $this->mhs->getKAProdi(['kd_prodi' => $this->user->prodi]);
        $dosen_wali = $this->universal->getOneSelect('gelar_depan, nama, gelar_belakang', ['username' => $this->user->id_dosen_wali], 'pegawai');

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
        $pdf->Cell(70, 4, ': ' . $this->user->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $semester, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'NIM', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nim, 0, 0);
        $pdf->Cell(28, 4, 'TA Akademik', 0, 0);
        $pdf->Cell(56, 4, ': ' . $tahun_akademik->th_awal . ' / ' . $tahun_akademik->th_akhir, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Dosen Wali', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nama_dosenWali, 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user->jenjang . ' - ' . $this->user->nama_prodi, 0, 1);

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
        $pdf->Cell(63.3, 7, $this->user->nama_lengkap, 0, 1, 'C');
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
        $pdf->Cell(70, 4, ': ' . $this->user->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $semester, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'NIM', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nim, 0, 0);
        $pdf->Cell(28, 4, 'TA Akademik', 0, 0);
        $pdf->Cell(56, 4, ': ' . $tahun_akademik->th_awal . ' / ' . $tahun_akademik->th_akhir, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Dosen Wali', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nama_dosenWali, 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user->jenjang . ' - ' . $this->user->nama_prodi, 0, 1);

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
        $pdf->Cell(63.3, 7, $this->user->nama_lengkap, 0, 1, 'C');
        $pdf->Cell(63.3, -22, '', 1, 0, 'C');
        $pdf->Cell(63.3, -22, '', 1, 0, 'C');
        $pdf->Cell(63.3, -22, '', 1, 1, 'C');

        $pdf->Output($this->user->nim . '_krs.pdf', 'I');
    }

    private function _pdfKHS($th_ak)
    {
        $tahun_akademik = $this->universal->getOne(['id' => $th_ak], 'tahun_akademik');

        $this->db->select('anggota_kelas.*, bagikelas.semester, bagikelas.kelas');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->where('anggota_kelas.nim', $this->user->nim);
        $this->db->where('bagikelas.tahun', $th_ak);

        $data_semester = $this->db->get('anggota_kelas')->row();
        $getKhs = $this->mhs->getKhs(['bagikelas.tahun' => $th_ak, 'anggota_kelas.nim' => $this->user->nim, 'nilai.username' => $this->user->nim, 'nilai.smt' => $data_semester->semester, 'nilai.thak' => $th_ak]);

        if (!$getKhs) {
            $this->notifikasi->error('KHS Kosong !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $ka_prodi = $this->mhs->getKAProdi(['kd_prodi' => $this->user->prodi]);
        $dosen_wali = $this->universal->getOneSelect('gelar_depan, nama, gelar_belakang, nipy', ['username' => $this->user->id_dosen_wali], 'pegawai');

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
        $pdf->Image('assets/poltek.png', 12, 4, 21, 21);

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(30, 4, '', 0, 0);
        $pdf->Cell(130, 4, 'Yayasan Pendidikan Harapan Bersama', 0, 0, 'C');
        $pdf->SetFont('Times', 'I', 6);
        $pdf->Cell(30, 4, 'Lembar ke 1 Mahasiswa', 0, 1);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 4, 'PoliTekniK Harapan Bersama', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(190, 4, 'PROGRAM STUDI D III TEKNIK KOMPUTER', 0, 1, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(190, 4, 'Kampus I: Jl. Mataram No.9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 0, 1, 'C');
        $pdf->Cell(190, 4, 'Website: www.poltektegal.ac.id       Email: komputer@poltektegal.ac.id', 0, 1, 'C');

        $pdf->SetLineWidth(1);
        $pdf->Line(10, 26, 200, 26);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 27, 200, 27);

        $pdf->Ln(4);
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 5, 'KARTU HASIL STUDI (KHS)', 0, 1, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Nama', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $data_semester->semester . ' / ' . $data_semester->kelas, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'NIM', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nim, 0, 0);
        $pdf->Cell(28, 4, 'TA Akademik', 0, 0);
        $pdf->Cell(56, 4, ': ' . $tahun_akademik->th_awal . ' / ' . $tahun_akademik->th_akhir, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Dosen Wali', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nama_dosenWali, 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user->jenjang . ' - ' . $this->user->nama_prodi, 0, 1);

        $pdf->Ln(1);

        $pdf->SetFillColor(217, 217, 217);
        $pdf->MultiCell(10, 10, 'No', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 10, $yPos - 10);
        $pdf->MultiCell(35, 10, 'Kode MK', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 45, $yPos - 10);
        $pdf->MultiCell(90, 10, 'Mata Kuliah', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 135, $yPos - 10);
        $pdf->MultiCell(10, 10, 'SKS', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 145, $yPos - 10);
        $pdf->MultiCell(45, 5, 'Nilai', 1, 'C', 1);

        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->MultiCell(15, 5, 'Huruf', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 160, $yPos - 5);
        $pdf->MultiCell(15, 5, 'Angka', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 175, $yPos - 5);
        $pdf->MultiCell(15, 5, 'Mutu', 1, 'C', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Times', '', 9);
        $no = 1;
        $sks = 0;
        $mutu = 0;
        $bobot = 0;
        foreach ($getKhs as $hasil) {
            $pdf->Cell(10, 5, $no++, 1, 0, 'C');
            $pdf->Cell(35, 5, $hasil->kode_mk, 1, 0);
            $pdf->Cell(90, 5, strtoupper($hasil->nama_mk), 1, 0);
            $pdf->Cell(10, 5, $hasil->sks, 1, 0, 'C');

            $this->db->where("'$hasil->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
            $nilai = $this->db->get('bobot_nilai')->row();

            $pdf->Cell(15, 5, $nilai->huruf, 1, 0, 'C');
            $pdf->Cell(15, 5, $nilai->bobot, 1, 0, 'C');
            $pdf->Cell(15, 5, sprintf("%.1f", ($hasil->sks * $nilai->bobot)), 1, 1, 'R');

            $sks = $sks + $hasil->sks;
            $mutu = $mutu + ($hasil->sks * $nilai->bobot);
            $bobot = $bobot + $nilai->bobot;
        }
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(135, 4, 'Jumlah SKS', 1, 0, 'R');
        $pdf->Cell(10, 4, $sks, 1, 0, 'C');
        $pdf->Cell(30, 4, '', 0, 0, 'C');
        $pdf->Cell(15, 4, $mutu, 1, 1, 'C');

        $pdf->Cell(135, 4, 'Indeks Prestasi (IP) Semester Ini', 1, 0, 'R');
        $pdf->Cell(10, 4, $bobot / count($getKhs), 1, 1, 'C');
        $pdf->Cell(135, 4, 'Indeks Prestasi Kumulatif (IPK)', 1, 0, 'R');
        $pdf->Cell(10, 4, '', 1, 1, 'C');

        $pdf->Cell(145, 4, '', 0, 0, 'C');
        $pdf->Cell(45, -12, '', 1, 1, 'C');

        $pdf->Cell(10, 14, '', 0, 1, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->Cell(45, 5, 'Tegal, ' . tanggal_indo(), 0, 1);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->Cell(45, 3, 'Ka. Prodi', 0, 1);
        $pdf->Ln(9);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->SetFont('Times', 'U', 9);
        $pdf->Cell(45, 5, $nama_kaProdi, 0, 1);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->Cell(45, 3, 'NIPY. ' . $ka_prodi->nipy, 0, 0);

        // lembar 2

        $pdf->SetXY(0, 168);

        $pdf->Image('assets/poltek.png', 12, 170, 21, 21);
        $pdf->Cell(1, 2, '', 0, 1);

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(30, 4, '', 0, 0);
        $pdf->Cell(130, 4, 'Yayasan Pendidikan Harapan Bersama', 0, 0, 'C');
        $pdf->SetFont('Times', 'I', 6);
        $pdf->Cell(30, 4, 'Lembar ke 2 Prodi', 0, 1);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 4, 'PoliTekniK Harapan Bersama', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(190, 4, 'PROGRAM STUDI D III TEKNIK KOMPUTER', 0, 1, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(190, 4, 'Kampus I: Jl. Mataram No.9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 0, 1, 'C');
        $pdf->Cell(190, 4, 'Website: www.poltektegal.ac.id       Email: komputer@poltektegal.ac.id', 0, 1, 'C');

        $pdf->SetLineWidth(1);
        $pdf->Line(10, 194, 200, 194);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 195, 200, 195);

        $pdf->Ln(4);
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 5, 'KARTU HASIL STUDI (KHS)', 0, 1, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Nama', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $data_semester->semester . ' / ' . $data_semester->kelas, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'NIM', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nim, 0, 0);
        $pdf->Cell(28, 4, 'TA Akademik', 0, 0);
        $pdf->Cell(56, 4, ': ' . $tahun_akademik->th_awal . ' / ' . $tahun_akademik->th_akhir, 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);
        $pdf->Cell(28, 4, 'Dosen Wali', 0, 0);
        $pdf->Cell(70, 4, ': ' . $nama_dosenWali, 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user->jenjang . ' - ' . $this->user->nama_prodi, 0, 1);

        $pdf->Ln(1);

        $pdf->SetFillColor(217, 217, 217);
        $pdf->MultiCell(10, 10, 'No', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 10, $yPos - 10);
        $pdf->MultiCell(35, 10, 'Kode MK', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 45, $yPos - 10);
        $pdf->MultiCell(90, 10, 'Mata Kuliah', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 135, $yPos - 10);
        $pdf->MultiCell(10, 10, 'SKS', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 145, $yPos - 10);
        $pdf->MultiCell(45, 5, 'Nilai', 1, 'C', 1);

        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->MultiCell(15, 5, 'Huruf', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 160, $yPos - 5);
        $pdf->MultiCell(15, 5, 'Angka', 1, 'C', 1);
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();

        $pdf->SetXY($xPos + 175, $yPos - 5);
        $pdf->MultiCell(15, 5, 'Mutu', 1, 'C', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Times', '', 9);
        $no = 1;
        $sks = 0;
        $mutu = 0;
        $bobot = 0;
        foreach ($getKhs as $hasil) {
            $pdf->Cell(10, 5, $no++, 1, 0, 'C');
            $pdf->Cell(35, 5, $hasil->kode_mk, 1, 0);
            $pdf->Cell(90, 5, strtoupper($hasil->nama_mk), 1, 0);
            $pdf->Cell(10, 5, $hasil->sks, 1, 0, 'C');

            $this->db->where("'$hasil->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
            $nilai = $this->db->get('bobot_nilai')->row();

            $pdf->Cell(15, 5, $nilai->huruf, 1, 0, 'C');
            $pdf->Cell(15, 5, $nilai->bobot, 1, 0, 'C');
            $pdf->Cell(15, 5, sprintf("%.1f", ($hasil->sks * $nilai->bobot)), 1, 1, 'R');

            $sks = $sks + $hasil->sks;
            $mutu = $mutu + ($hasil->sks * $nilai->bobot);
            $bobot = $bobot + $nilai->bobot;
        }
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(135, 4, 'Jumlah SKS', 1, 0, 'R');
        $pdf->Cell(10, 4, $sks, 1, 0, 'C');
        $pdf->Cell(30, 4, '', 0, 0, 'C');
        $pdf->Cell(15, 4, $mutu, 1, 1, 'C');

        $pdf->Cell(135, 4, 'Indeks Prestasi (IP) Semester Ini', 1, 0, 'R');
        $pdf->Cell(10, 4, $bobot / count($getKhs), 1, 1, 'C');
        $pdf->Cell(135, 4, 'Indeks Prestasi Kumulatif (IPK)', 1, 0, 'R');
        $pdf->Cell(10, 4, '', 1, 1, 'C');

        $pdf->Cell(145, 4, '', 0, 0, 'C');
        $pdf->Cell(45, -12, '', 1, 1, 'C');

        $pdf->Cell(10, 14, '', 0, 1, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->Cell(45, 5, 'Tegal, ' . tanggal_indo(), 0, 1);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->Cell(45, 3, 'Ka. Prodi', 0, 1);
        $pdf->Ln(9);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->SetFont('Times', 'U', 9);
        $pdf->Cell(45, 5, $nama_kaProdi, 0, 1);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(145, 5, '', 0, 0);
        $pdf->Cell(45, 3, 'NIPY. ' . $ka_prodi->nipy, 0, 0);

        $pdf->Output($this->user->nim . '_khs.pdf', 'I');
    }

    private function _pdfDNS($ttd, $nilai_min)
    {
        if ($ttd == 'Ka. Prodi') {
            $data_ttd = $this->mhs->getKAProdi(['kd_prodi' => $this->user->prodi]);

            if ($data_ttd->gelar_depan) {
                $nama_ttd = $data_ttd->gelar_depan . ' ' . $data_ttd->nama . ', ' . $data_ttd->gelar_belakang;
            } else {
                $nama_ttd = $data_ttd->nama . ', ' . $data_ttd->gelar_belakang;
            }
        } else {
            $data_ttd = $this->mhs->getTTDDNS(['jabatan.nama_jabatan' => $ttd]);
            if ($data_ttd->gelar_depan) {
                $nama_ttd = $data_ttd->gelar_depan . ' ' . $data_ttd->nama . ', ' . $data_ttd->gelar_belakang;
            } else {
                $nama_ttd = $data_ttd->nama . ', ' . $data_ttd->gelar_belakang;
            }
        }

        $dataDNS = $this->mhs->getDns(['mahasiswa.nim' => $this->user->nim, 'nilai.username' => $this->user->nim]);
        if (!$dataDNS) {
            $this->notifikasi->error('DNS Kosong');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $pdf = new FPDF('p', 'mm', 'F4');

        $pdf->AddPage();

        $pdf->Ln(-6);
        $pdf->SetAutoPageBreak(TRUE, 1);
        $pdf->Image('assets/poltek.png', 12, 4, 21, 21);

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(30, 4, '', 0, 0);
        $pdf->Cell(130, 4, 'Yayasan Pendidikan Harapan Bersama', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 4, 'PoliTekniK Harapan Bersama', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(190, 4, 'PROGRAM STUDI D III TEKNIK KOMPUTER', 0, 1, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(190, 4, 'Kampus I: Jl. Mataram No.9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 0, 1, 'C');
        $pdf->Cell(190, 4, 'Website: www.poltektegal.ac.id       Email: komputer@poltektegal.ac.id', 0, 1, 'C');

        $pdf->SetLineWidth(0);
        $pdf->Line(10, 26, 200, 26);
        $pdf->SetLineWidth(0);
        $pdf->Line(10, 27, 200, 27);

        $pdf->Ln(4);
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 5, 'DAFTAR NILAI SEMENTARA', 0, 1, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(33, 4, 'NAMA LENGKAP', 0, 0);
        $pdf->Cell(70, 4, ': ' . strtoupper($this->user->nama_lengkap), 0, 0);
        $pdf->Cell(28, 4, 'Program Studi', 0, 0);
        $pdf->Cell(56, 4, ': ' . $this->user->jenjang . ' - ' . strtoupper($this->user->nama_prodi), 0, 1);
        $pdf->Cell(33, 4, 'NOMOR INDUK', 0, 0);
        $pdf->Cell(70, 4, ': ' . $this->user->nim, 0, 1);

        $pdf->Ln(1);
        $pdf->Cell(15, 10, 'NO', 1, 0, 'C');
        $pdf->Cell(25, 10, 'KODE MK', 1, 0, 'C');
        $pdf->Cell(85, 10, 'NAMA MATA KULIAH', 1, 0, 'C');
        $pdf->Cell(20, 10, 'SEMESTER', 1, 0, 'C');
        $pdf->Cell(15, 5, 'SKS', 1, 0, 'C');
        $pdf->Cell(15, 5, 'NILAI', 1, 0, 'C');
        $pdf->Cell(15, 5, 'BOBOT', 1, 1, 'C');

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(145, 5, '', 0, 0, 'C');
        $pdf->Cell(15, 5, 'credit', 1, 0, 'C');
        $pdf->Cell(15, 5, 'grades', 1, 0, 'C');
        $pdf->Cell(15, 5, 'weight', 1, 1, 'C');

        $no = 1;
        $sks = 0;
        $mutu = 0;
        $bobot = 0;
        $c_d_e = 0;

        foreach ($dataDNS as $hasil) {
            $pdf->Cell(15, 4, $no++, 1, 0, 'C');
            $pdf->Cell(25, 4, $hasil->kode_mk, 1, 0);
            $pdf->Cell(85, 4, strtoupper($hasil->nama_mk), 1, 0);
            $pdf->Cell(20, 4, $hasil->semester, 1, 0, 'C');
            $pdf->Cell(15, 4, $hasil->sks, 1, 0, 'C');

            $this->db->where("'$hasil->nilai_akhir' BETWEEN `angka_awal` AND `angka_akhir`");
            $nilai = $this->db->get('bobot_nilai')->row();

            $pdf->Cell(15, 4, $nilai->huruf, 1, 0, 'C');
            $pdf->Cell(15, 4, sprintf("%.2f", ($hasil->sks * $nilai->bobot)), 1, 1, 'R');

            $sks += $hasil->sks;
            $mutu += ($hasil->sks * $nilai->bobot);
            $bobot += $nilai->bobot;
            if ($nilai->huruf == 'C' || $nilai->huruf == 'D' || $nilai->huruf == 'E') {
                $c_d_e += 1;
            }
        }

        $pdf->Ln(1);
        $pdf->Cell(145, 4, '', 0, 0);
        $pdf->Cell(45, 4, 'Tegal, ' . tanggal_indo(), 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(35, 4, 'JUMLAH SKS', 0, 0);
        $pdf->Cell(110, 4, ': ' . $sks, 0, 0);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(45, 4, 'Disahkan Oleh', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(35, 4, 'INDEX PRESTASI', 0, 0);
        $pdf->Cell(110, 4, ': ' . $bobot / count($dataDNS), 0, 0);
        $pdf->Cell(45, 4, $ttd, 0, 1, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(35, 4, '*) Nilai minimum adalah ' . dekrip($nilai_min), 0, 1);
        $pdf->Cell(35, 4, 'Jumlah Nilai (C,D & E)', 0, 0);
        $pdf->Cell(110, 4, ': ' . $c_d_e, 0, 1);

        $pdf->Ln(2);
        $pdf->Cell(145, 4, '', 0, 0);
        $pdf->SetFont('Times', 'U', 9);
        $pdf->Cell(45, 4, $nama_ttd, 0, 1, 'C');
        $pdf->Cell(145, 3, '', 0, 0);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(45, 3, 'NIPY. ' . $data_ttd->nipy, 0, 1, 'C');

        $pdf->Output($this->user->nim . '_dns.pdf', 'I');
    }
}
