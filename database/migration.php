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
    password VARCHAR(50) NOT NULL
    )";

$dbh->exec($sqlTableUser);

// create table 
