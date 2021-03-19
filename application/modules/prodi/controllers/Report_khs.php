<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_khs extends MX_Controller
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

            $this->db->select('anggota_kelas.*, bagikelas.semester');
            $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
            $this->db->where('anggota_kelas.nim', $nim);
            $this->db->where('bagikelas.tahun', $tahun);

            $data_semester = $this->db->get('anggota_kelas')->row();

            if ($tahun) {
                $data_khs = $this->prodi->getDetailKHS(['bagikelas.tahun' => $tahun, 'anggota_kelas.nim' => $nim, 'nilai.username' => $nim, 'nilai.smt' => $data_semester->semester, 'nilai.thak' => $tahun]);
            } else {
                $data_khs = null;
            }

            $params = [
                'title'     => 'Report KRS',
                'tahun'     => $this->universal->getOrderBy('', 'tahun_akademik', 'tahun_akademik', 'desc', ''),
                'data_khs'  => $data_khs,
                'th_ini'    => $tahun,
                'nim'       => enkrip($nim)
            ];

            $this->load->view('detail_report_khs', $params);
        } elseif ($this->u3 == 'cetak') {
            $nim        = dekrip($this->u4);
            $th_ak      = dekrip($this->u5);

            $this->_pdfKHS($nim, $th_ak);
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
                'data_khs'  => $this->prodi->getMhs($th_ini),
                'th_ini'    => $th_ini
            ];

            $this->session->set_userdata('previous_url', current_url());
            $this->load->view('report_khs', $params);
        }
    }

    private function _pdfKHS($nim, $th_ak)
    {
        $this->load->library('pdf');

        $mhs = $this->universal->getOne(['nim' => $nim], 'mahasiswa');
        $tahun_akademik = $this->universal->getOne(['id' => $th_ak], 'tahun_akademik');

        $this->db->select('anggota_kelas.*, bagikelas.semester, bagikelas.kelas');
        $this->db->join('bagikelas', 'bagikelas.id = anggota_kelas.id_kelas', 'inner');
        $this->db->where('anggota_kelas.nim', $nim);
        $this->db->where('bagikelas.tahun', $th_ak);

        $data_semester = $this->db->get('anggota_kelas')->row();
        $getKhs = $this->prodi->getKhs(['bagikelas.tahun' => $th_ak, 'anggota_kelas.nim' => $nim, 'nilai.username' => $nim, 'nilai.smt' => $data_semester->semester, 'nilai.thak' => $th_ak]);

        if (!$getKhs) {
            $this->notifikasi->error('KHS Kosong !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $ka_prodi = $this->prodi->getKAProdi(['kd_prodi' => $this->user[0]->kd_prodi]);
        $dosen_wali = $this->universal->getOneSelect('gelar_depan, nama, gelar_belakang, nipy', ['username' => $mhs->id_dosen_wali], 'pegawai');

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
        $pdf->Cell(70, 4, ': ' . $mhs->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $data_semester->semester . ' / ' . $data_semester->kelas, 0, 1);
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
        $pdf->Cell(70, 4, ': ' . $mhs->nama_lengkap, 0, 0);
        $pdf->Cell(28, 4, 'Semester', 0, 0);
        $pdf->Cell(56, 4, ': ' . (($tahun_akademik->periode == 1) ? 'GANJIL' : 'GENAP') . ' / ' . $data_semester->semester . ' / ' . $data_semester->kelas, 0, 1);
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

        $pdf->Output($nim . '_khs.pdf', 'I');
    }
}

/* End of file Report_khs.php */
