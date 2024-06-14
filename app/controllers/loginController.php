<?php  
session_start();
include_once '../database/koneksi.php'; // Disesuaikan dengan path yang benar
include_once '../models/user.php'; // Disesuaikan dengan path yang benar

$unama = $_POST['username'];
$password = $_POST['password'];

$data = [
    $unama, $password
];

$obj = new User();
$rs = $obj->cekLogin($data);

header('Content-Type: application/json'); // Menetapkan header konten JSON

if( !empty($rs) ){
    $_SESSION['MEMBER'] = $rs;
    echo json_encode(['success' => true, 'message' => 'Login successful']); // Mengirimkan respons JSON
} else{
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']); // Mengirimkan respons JSON
}

