<?php

class User
{
    private $koneksi;
    public function __construct()
    {
        global $dbh;
        $this->koneksi;
    }

    public function cekLogin($data)
    {
        $sql = "SELECT * FROM user WHERE username = ? AND pass = SHA1(MD5(SHA1(?))) ";

        $stmt = $this->koneksi->prepare($sql);
        $results = $stmt->execute($data);
        $rows = $results->fetch();

        return $rows;
    }
}