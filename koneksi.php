<?php
/**
 * Praktikum 8 - PHP dan Database MySQL
 * Nama : Fauzan Dwi Nur Hafizh
 * NIM  : 312510180
 */
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false)
{
    echo "Koneksi ke server gagal.";
    die();
} #else echo "Koneksi berhasil";
?>
