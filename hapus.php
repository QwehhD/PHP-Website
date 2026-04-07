<?php
include("config.php");

if( isset($_GET['id']) ){
    $id = $_GET['id'];

    // Ambil nama file foto dulu
    $sql_foto = mysqli_query($mysqli, "SELECT foto FROM siswa WHERE id=$id");
    $data = mysqli_fetch_array($sql_foto);
    
    // Hapus file fisik jika ada
    if(file_exists("uploads/".$data['foto'])) {
        unlink("uploads/".$data['foto']);
    }

    // Hapus data di DB
    $query = mysqli_query($mysqli, "DELETE FROM siswa WHERE id=$id");

    if( $query ){
        header('Location: index.php');
    } else {
        die("gagal menghapus...");
    }
}
?>
