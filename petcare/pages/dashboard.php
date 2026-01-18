<?php
session_start();
include "../config/db.php";

// Hitung summary
$antrian = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_booking WHERE tanggal = CURDATE() AND status != 'Selesai'"));
$rawat_inap = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_booking WHERE status = 'Rawat Inap'"));
$reservasi_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_booking WHERE status != 'Selesai'"));
$selesai_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_booking WHERE status = 'Selesai'"));

// List booking
$booking = mysqli_query($conn,
    "SELECT b.*, h.nama_hewan, p.nama AS pemilik, h.jenis 
     FROM tb_booking b
     JOIN tb_hewan h ON b.id_hewan = h.id_hewan
     JOIN tb_pemilik p ON h.id_pemilik = p.id_pemilik
     ORDER BY b.tanggal DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Pet Care</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="../assets/img/logo.png" width="40" class="me-2">
        <span class="brand-text">PET CARE</span>
    </div>

    <a href="#" class="sidebar-link active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="#" class="sidebar-link"><i class="bi bi-calendar-plus"></i> Booking</a>
    <a href="#" class="sidebar-link"><i class="bi bi-clock-history"></i> Reservasi</a>
    <a href="#" class="sidebar-link"><i class="bi bi-hospital"></i> Rawat Inap</a>
    <a href="#" class="sidebar-link"><i class="bi bi-capsule"></i> Stok Obat</a>
    <a href="#" class="sidebar-link"><i class="bi bi-people"></i> Staff</a>
    <a href="#" class="sidebar-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- NAVBAR TOP -->
    <nav class="top-navbar shadow-sm">
    <button class="hamburger-btn" onclick="toggleSidebar()">
        <i class="bi bi-list fs-3"></i>
    </button>

    <span class="fw-semibold">Dashboard</span>

    <i class="bi bi-person-circle fs-4"></i>
</nav>


    <!-- Dashboard Summary -->
    <div class="container mt-4">

        <div class="row g-3">

            <div class="col-md-3 col-6">
                <div class="summary-box">
                    <p class="summary-title">Antrian Hari Ini</p>
                    <h2 class="summary-number"><?= $antrian['total'] ?></h2>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="summary-box">
                    <p class="summary-title">Rawat Inap</p>
                    <h2 class="summary-number"><?= $rawat_inap['total'] ?></h2>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="summary-box">
                    <p class="summary-title">Reservasi</p>
                    <h2 class="summary-number"><?= $reservasi_total['total'] ?></h2>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="summary-box">
                    <p class="summary-title">Selesai</p>
                    <h2 class="summary-number"><?= $selesai_total['total'] ?></h2>
                </div>
            </div>
        </div>

        <!-- Table Booking -->
       <div class="card mt-4 shadow-sm p-3">
    <h5 class="mb-3 fw-semibold">Daftar Booking</h5>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
              <thead>
                    <tr class="table-primary">
                        <th>Tanggal</th>
                        <th>Hewan</th>
                        <th>Pemilik</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($row = mysqli_fetch_assoc($booking)) { ?>
                    <tr>
                        <td><?= date("d M Y", strtotime($row['tanggal'])) ?></td>
                        <td><?= $row['nama_hewan'] ?></td>
                        <td><?= $row['pemilik'] ?></td>
                        <td><?= $row['keluhan'] ?></td>

                        <td>
                            <span class="badge
                                <?= $row['status']=='Selesai' ? 'bg-success' : 
                                   ($row['status']=='Rawat Inap' ? 'bg-warning' : 'bg-info') ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>

                        <td>
                            <a href="detail_booking.php?id=<?= $row['id_booking'] ?>" 
                               class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

<script>
function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("sidebar-open");
}
</script>


</body>
</html>
