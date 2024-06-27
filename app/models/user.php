<?php

class user
{
    private $koneksi;
    public function __construct()
    {
        global $dbh;
        $this->koneksi = $dbh;
    }

    public function dataUser()
    {
        // mengambil dan melihat table jenis_produk
        $sql = "SELECT * FROM user";

        // menggunakan mekanisme prepere statement PDO
        $ps = $this->koneksi->prepare($sql);
        $ps->execute();
        $rs = $ps->fetchALL();

        return $rs;
    }

    public function getUser($id)
    {
        // mengambil dan melihat table jenis_produk
        $sql = "SELECT * FROM user where id = ?";

        // menggunakan mekanisme prepere statement PDO
        $ps = $this->koneksi->prepare($sql);
        $ps->execute([$id]);
        $rs = $ps->fetch();

        return $rs;
    }

    public function simpan($data)
    {
        $sql = "INSERT INTO user (firstname, lastname, username, password, email, role)
        VALUES (?,?,?,?,?,?,?)";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute($data);
    }

    public function ubah($data)
    {
        $sql = "UPDATE user SET firstname=?, lastname=?, username=?, password=?, email=?, role=?
        WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute($data);
    }

    public function hapus($data)
    {
        $sql = "DELETE FROM user WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute($data);
    }
}
