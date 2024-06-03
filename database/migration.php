<?php

include_once 'koneksi.php';

global $dbh;

// create table user
$sqlTableUser = "CREATE TABLE user (
    id CHAR(6) PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(50) NOT NULL,
    role ENUM('admin', 'manajer', 'resepsionis') NOT NULL
    )";

$dbh->exec($sqlTableUser);

// create table Tamu
$sqlTableTamu = "CREATE TABLE tamu (
    id CHAR(6) PRIMARY KEY,
    nama VARCHAR(30) NOT NULL,
    no_ktp VARCHAR(50) UNIQUE NOT NULL,
    no_telp VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(30) NOT NULL
    )";

$dbh->exec($sqlTableTamu);

// create table kamar
$sqlTableKamar = "CREATE TABLE kamar (
    id CHAR(6) PRIMARY KEY,
    tipe ENUM('suite', 'superior', 'deluxe') NOT NULL,
    hari ENUM('weekdays', 'weekends', 'holidays') NOT NULL,
    harga VARCHAR(20) NOT NULL
    )";

$dbh->exec($sqlTableKamar);

// create table travel_online
$sqlTableTravelOnline = "CREATE TABLE travel_online (
    id CHAR(6) PRIMARY KEY,
    nama_travel VARCHAR(30) NOT NULL,
    komisi VARCHAR(20) NOT NULL
    )";

$dbh->exec($sqlTableTravelOnline);

// create table pembayaran
$sqlTablePembayaran = "CREATE TABLE pembayaran (
    id CHAR(6) PRIMARY KEY,
    tanggal_bayar DATE NOT NULL,
    total_bayar VARCHAR(20) NOT NULL
    metode_bayar VARCHAR(20) NOT NULL
    idReservasi CHAR(6) NOT NULL,
    FOREIGN KEY (idReservasi) REFERENCES reservasi(id)
    )";

$dbh->exec($sqlTablePembayaran);

// create table reservasi
$sqlTableReservasi = "CREATE TABLE reservasi (
    id CHAR(6) PRIMARY KEY,
    tanggal_checkin DATE NOT NULL,
    tanggal_checkout DATE NOT NULL,
    jumlah_tamu INT(3) NOT NULL,
    tipe_tamu ENUM('Perseorangan', 'Rombongan', 'Travel_Online') NOT NULL,
    idTamu CHAR(6) NOT NULL,
    idKamar CHAR(6) NOT NULL,
    idTravelOnline CHAR(6) NOT NULL,
    FOREIGN KEY (idTamu) REFERENCES tamu(id),
    FOREIGN KEY (idKamar) REFERENCES kamar(id),
    FOREIGN KEY (idTravelOnline) REFERENCES travel_online(id)
    )";

$dbh->exec($sqlTableReservasi);
