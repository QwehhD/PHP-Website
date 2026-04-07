<?php
$host = "localhost";
$user = "root";
$pass = "ubuntut"; // Isi password database kamu
$db   = "db_sekolah";

$mysqli = mysqli_connect($host, $user, $pass, $db);

if (!$mysqli) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>
