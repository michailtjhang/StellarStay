<?php

class reservasi
{
    private $koneksi;
    public function __construct()
    {
        global $dbh;
        $this->koneksi = $dbh;
    }

    public function dataReservasi()
    {
        $sql = "SELECT r.tanggal_checkin, r.tanggal_checkout, r.jumlah_kamar, r.tipe_tamu, 
        u.nama, u.no_ktp, 
        k.tipe, k.harga,
        t.nama_travel, t.komisi
        FROM reservasi r
        INNER JOIN tamu u ON u.id = r.idTamu 
        INNER JOIN kamar k ON k.id = r.idKamar 
        LEFT JOIN travel_online t ON t.id = r.idTravelOnline";

        // menggunakan mekanisme prepere statement PDO
        $ps = $this->koneksi->prepare($sql);
        $ps->execute();
        $rs = $ps->fetchALL();

        return $rs;
    }

    public function getReservasi($id)
    {
        // mengambil dan melihat table jenis_produk
        $sql = "SELECT * FROM reservasi where id = ?";

        // menggunakan mekanisme prepere statement PDO
        $ps = $this->koneksi->prepare($sql);
        $ps->execute([$id]);
        $rs = $ps->fetch();

        return $rs;
    }

    public function simpan($data)
    {
        // Convert date format
        $checkin = DateTime::createFromFormat('d/m/Y', $data['in'])->format('Y-m-d');
        $checkout = DateTime::createFromFormat('d/m/Y', $data['out'])->format('Y-m-d');

        // Convert name to lowercase
        $namatamu = strtolower($data['namatamu']);

        // Check if the tamu already exists
        $sql = "SELECT id FROM tamu WHERE LOWER(nama) = ? AND no_ktp = ?";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute([$namatamu, $data['notamu']]);
        $existingTamu = $ps->fetch();

        if ($existingTamu) {
            $idTamu = $existingTamu['id'];
        } else {
            // Create new tamu
            $idTamu = $this->kodeAutoTamu();
            $sql = "INSERT INTO tamu (id, nama, no_ktp)
                VALUES (?, ?, ?)";
            $ps = $this->koneksi->prepare($sql);
            $ps->execute([$idTamu, $namatamu, $data['notamu']]);
        }

        // Create data reservasi
        $kodeAuto = $this->kodeAuto();
        $sql = "INSERT INTO reservasi (id, tanggal_checkin, tanggal_checkout, jumlah_kamar, tipe_tamu, idTamu, idKamar, idTravelOnline)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $ps = $this->koneksi->prepare($sql);

        $idTravelOnline = ($data['tpetamu'] === 'Travel_Online') ? $data['travel'] : null;

        $ps->execute([
            $kodeAuto,
            $checkin,
            $checkout,
            $data['jmltamu'],
            $data['tpetamu'],
            $idTamu,
            $data['nokmr'],
            $idTravelOnline
        ]);
    }

    public function ubah($data)
    {
        $sql = "UPDATE reservasi SET tanggal_checkin=?, tanggal_checkout=?, jumlah_tamu=?, tipe_tamu=?, idTamu=?, idKamar=?, idTravelOnline=?
        WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute($data);
    }

    public function hapus($data)
    {
        $sql = "DELETE FROM reservasi WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute($data);
    }

    public function kodeAuto()
    {
        $sql = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) as max_id FROM reservasi";
        $rs = $this->koneksi->query($sql)->fetch();

        $kode = ($rs['max_id'] ?? 0) + 1;
        return "RV" . sprintf("%04d", $kode);
    }
    public function kodeAutoTamu()
    {
        $sql = "SELECT MAX(CAST(SUBSTRING(id, 2) AS UNSIGNED)) as max_id FROM tamu";
        $rs = $this->koneksi->query($sql)->fetch();

        $kode = ($rs['max_id'] ?? 0) + 1;
        return "P" . sprintf("%05d", $kode);
    }
}
