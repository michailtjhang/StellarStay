<?php
include_once '../../../database/koneksi.php';
include_once '../models/reservasi.php';

// Pemetaan singkatan bulan ke angka
$pemetaanBulan = [
    'JA' => '01', 'FE' => '02', 'MA' => '03', 'AP' => '04',
    'ME' => '05', 'JN' => '06', 'JL' => '07', 'AG' => '08',
    'SE' => '09', 'OK' => '10', 'NO' => '11', 'DE' => '12'
];

// Ambil nomor bulan
$singkatanBulan = htmlspecialchars($_POST['date']);
$bulan = $pemetaanBulan[$singkatanBulan] ?? null;

$model = new reservasi();
$tombol = $_REQUEST['proses'];

switch ($tombol) {
    case 'ambil':
        if ($bulan) {
            $data_reservasi = $model->getReservasi($bulan);
            // Simpan hasil ke file sementara
            $tempFile = tempnam(sys_get_temp_dir(), 'data_reservasi_');
            file_put_contents($tempFile, serialize($data_reservasi));
            header('location:../../index.php?url=laporan&temp_file=' . basename($tempFile));
            exit;
        }
        break;
    default:
        header('location:../../index.php?url=laporan');
        exit;
}