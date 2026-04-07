<?php
include("config.php");

// Kalau tidak ada id di query string, kembalikan ke index
if( !isset($_GET['id']) ){
    header('Location: index.php');
}

$id = $_GET['id'];

// Ambil data siswa berdasarkan ID
$query = mysqli_query($mysqli, "SELECT * FROM siswa WHERE id=$id");
$s = mysqli_fetch_assoc($query);

// Jika data yang di-edit tidak ditemukan
if( mysqli_num_rows($query) < 1 ){
    die("data tidak ditemukan...");
}

// Proses Update saat tombol Simpan ditekan
if(isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $presensi = $_POST['nomor_presensi'];
    $alamat = $_POST['alamat'];
    
    // Logika Ganti Foto (Opsional)
    if($_FILES['foto']['name'] != "") {
        $foto_name = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $new_name = uniqid()."-".$foto_name;
        move_uploaded_file($tmp_name, "uploads/".$new_name);
        
        // Hapus foto lama jika ada
        if(file_exists("uploads/".$s['foto'])) unlink("uploads/".$s['foto']);
        
        $sql = "UPDATE siswa SET nama='$nama', kelas='$kelas', nomor_presensi='$presensi', alamat='$alamat', foto='$new_name' WHERE id=$id";
    } else {
        // Jika foto tidak diganti
        $sql = "UPDATE siswa SET nama='$nama', kelas='$kelas', nomor_presensi='$presensi', alamat='$alamat' WHERE id=$id";
    }

    if(mysqli_query($mysqli, $sql)) {
        header('Location: index.php?status=update-berhasil');
    } else {
        die("Gagal menyimpan perubahan...");
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
                    <h4 class="mb-4">Edit Data Siswa</h4>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $s['id'] ?>" />
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $s['nama'] ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="<?php echo $s['kelas'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Presensi</label>
                                <input type="number" name="nomor_presensi" class="form-control" value="<?php echo $s['nomor_presensi'] ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"><?php echo $s['alamat'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Saat Ini</label><br>
                            <img src="uploads/<?php echo $s['foto'] ?>" width="100" class="mb-2 img-thumbnail">
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                        </div>
                        <button type="submit" name="update" class="btn btn-warning w-100">Simpan Perubahan</button>
                        <a href="index.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
