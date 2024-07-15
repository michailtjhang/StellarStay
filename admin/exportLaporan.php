<?php
require '../vendor/autoload.php';
include_once '../database/koneksi.php';
include_once 'app/models/reservasi.php';

use Fpdf\Fpdf;
use Carbon\Carbon;

// Fungsi untuk mendapatkan nama bulan dalam Bahasa Indonesia
function getNamaBulan($bulan) {
    $namaBulan = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    return $namaBulan[$bulan] ?? '';
}

// Inisialisasi model reservasi dan ambil data
$model = new reservasi();

// Periksa apakah ada data filter
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    // Jika tidak ada filter, gunakan bulan saat ini
    $bulan = Carbon::now()->format('m');
}

$data_reservasi = $model->getReservasi($bulan);
$namaBulan = getNamaBulan($bulan);

class PDF extends FPDF
{
    protected $namaBulan;

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4', $namaBulan = '')
    {
        parent::__construct($orientation, $unit, $size);
        $this->namaBulan = $namaBulan;
    }

    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Laporan Reservasi Bulan ' . $this->namaBulan, 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 10, '#', 1, 0, 'C');
        $this->Cell(30, 10, 'Tanggal Checkin', 1, 0, 'C');
        $this->Cell(35, 10, 'Tanggal Checkout', 1, 0, 'C');
        $this->Cell(25, 10, 'Jumlah Kamar', 1, 0, 'C');
        $this->Cell(25, 10, 'Tipe Tamu', 1, 0, 'C');
        $this->Cell(35, 10, 'Nama Pengunjung', 1, 0, 'C');
        $this->Cell(30, 10, 'No. KTP', 1, 0, 'C');
        $this->Cell(25, 10, 'Tipe Kamar', 1, 0, 'C');
        $this->Cell(25, 10, 'Travel', 1, 0, 'C');
        $this->Cell(30, 10, 'Harga Total', 1, 0, 'C');
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function FancyTable($data)
    {
        $this->SetFont('Arial', '', 9);
        $id = 1;
        foreach ($data as $row) {
            if (!is_null($row['komisi'])) {
                $harga_noppn = (($row['harga'] * $row['jumlah_kamar']) * $row['komisi']) / 100 + $row['harga'];
                $harga_total = ($harga_noppn * 11) / 100 + $harga_noppn;
            } else {
                $harga_noppn = $row['harga'] * $row['jumlah_kamar'];
                $harga_total = ($harga_noppn * 11) / 100 + $harga_noppn;
            }

            $this->Cell(10, 10, $id++, 1);
            $this->Cell(30, 10, $row['tanggal_checkin'], 1);
            $this->Cell(35, 10, $row['tanggal_checkout'], 1);
            $this->Cell(25, 10, $row['jumlah_kamar'], 1);
            $this->Cell(25, 10, $row['tipe_tamu'], 1);
            $this->Cell(35, 10, $row['nama'], 1);
            $this->Cell(30, 10, $row['no_ktp'], 1);
            $this->Cell(25, 10, $row['tipe'], 1);
            $this->Cell(25, 10, is_null($row['nama_travel']) ? '-' : $row['nama_travel'], 1);
            $this->Cell(30, 10, number_format($harga_total, 0, ',', '.'), 1);
            $this->Ln();
        }
    }
}

// Inisialisasi model reservasi
$model = new reservasi();

// Periksa apakah ada data filter
if (isset($_GET['temp_file'])) {
    $tempFile = sys_get_temp_dir() . '/' . $_GET['temp_file'];
    if (file_exists($tempFile)) {
        $data_reservasi = unserialize(file_get_contents($tempFile));
        unlink($tempFile); // Hapus file sementara setelah digunakan
    } else {
        // Jika file tidak ada, gunakan bulan saat ini
        $bulanSekarang = Carbon::now()->format('m');
        $data_reservasi = $model->getReservasi($bulanSekarang);
    }
} else {
    // Jika tidak ada filter, gunakan bulan saat ini
    $bulanSekarang = Carbon::now()->format('m');
    $data_reservasi = $model->getReservasi($bulanSekarang);
}

// Buat PDF
$pdf = new PDF('L', 'mm', 'A4', $namaBulan); // Landscape, mm, A4
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->FancyTable($data_reservasi);

// Generate nama file dengan timestamp
$timestamp = Carbon::now()->format('Ymd_His');
$filename = 'LaporanReservasi_' . $timestamp . '.pdf';

$pdf->Output('D', $filename);