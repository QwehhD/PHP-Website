<?php 
include('config.php'); 

if(isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $presensi = $_POST['nomor_presensi'];
    $alamat = $_POST['alamat'];
    
    // Upload Foto
    $foto_name = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $new_name = uniqid()."-".$foto_name;

    if(move_uploaded_file($tmp_name, "uploads/".$new_name)) {
        $sql = "INSERT INTO siswa (nama, kelas, nomor_presensi, alamat, foto) VALUES ('$nama', '$kelas', '$presensi', '$alamat', '$new_name')";
        if(mysqli_query($mysqli, $sql)) header('Location: index.php?status=sukses');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">Tambah Siswa Baru</h4>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Presensi</label>
                                <input type="number" name="nomor_presensi" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Pilih Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Data</button>
                        <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
