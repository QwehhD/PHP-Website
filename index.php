<?php 
// 1. Koneksi ke Database
include('config.php'); 

// 2. Logika Pencarian (Agar tidak error saat search kosong)
$search = isset($_GET['search']) ? mysqli_real_escape_string($mysqli, $_GET['search']) : '';

// 3. Bangun Query SQL dengan benar
$query_sql = "SELECT * FROM siswa";
if($search != '') {
    $query_sql .= " WHERE nama LIKE '%$search%' OR kelas LIKE '%$search%'";
}
$query_sql .= " ORDER BY id DESC";

// 4. Jalankan Query untuk Tabel
$result = mysqli_query($mysqli, $query_sql);

// 5. Hitung Total Siswa untuk Statistik (Query terpisah agar bersih)
$query_total = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM siswa");
$data_total = mysqli_fetch_assoc($query_total);
$total_siswa = $data_total['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
        .navbar { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 12px; }
        .stat-card { background: #fff; border-left: 4px solid #4e73df; }
        .img-profile { width: 45px; height: 45px; object-fit: cover; border-radius: 10px; }
        .search-box { border-radius: 20px; padding-left: 20px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="fas fa-graduation-cap me-2"></i> SISWA-APP</a>
    </div>
</nav>

<div class="container pb-5">
    
    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary text-white p-3 rounded-circle me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Siswa</small>
                        <h4 class="fw-bold mb-0"><?php echo $total_siswa; ?> Orang</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar: Search & Add -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <form action="" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control search-box" placeholder="Cari nama..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="tambah.php" class="btn btn-success rounded-pill px-4"><i class="fas fa-plus me-2"></i>Tambah Siswa</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Foto</th>
                            <th>Nama & Alamat</th>
                            <th>Kelas</th>
                            <th>Presensi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4">
                                    <?php 
                                    $foto_path = "uploads/" . $row['foto'];
                                    $foto = (!empty($row['foto']) && file_exists($foto_path)) ? $foto_path : "https://ui-avatars.com/api/?name=".urlencode($row['nama']);
                                    ?>
                                    <img src="<?php echo $foto; ?>" class="img-profile">
                                </td>
                                <td>
                                    <div class="fw-bold"><?php echo $row['nama']; ?></div>
                                    <small class="text-muted"><?php echo $row['alamat']; ?></small>
                                </td>
                                <td><span class="badge bg-info text-dark"><?php echo $row['kelas']; ?></span></td>
                                <td>#<?php echo $row['nomor_presensi']; ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                                    <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted">Data tidak ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
