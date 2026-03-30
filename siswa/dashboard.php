<?php
    session_start();
    include "../config/config.php";

    if(!isset($_SESSION['role']) || $_SESSION['role'] != "siswa"){
        header("Location: ../login.php");
        exit;
    }

    $nis = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nis FROM siswa WHERE nis='".$_SESSION['nis']."'"))['nis'];


    $total = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM aspirasi WHERE nis='$nis'"))['total'];

    $menunggu = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM aspirasi 
    WHERE nis='$nis' AND status='Menunggu'"))['total'];

    $proses = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM aspirasi 
    WHERE nis='$nis' AND status='Proses'"))['total'];

    $selesai = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM aspirasi 
    WHERE nis='$nis' AND status='Selesai'"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary shadow">
        <div class="container">
            <span class="navbar-brand">Portal Aspirasi</span>
            <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h4 class="mb-4">Dashboard Siswa</h4>

        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-body">
                        <h6>Total Laporan</h6>
                        <h3><?= $total ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow bg-warning text-white text-center">
                    <div class="card-body">
                        <h6>Menunggu</h6>
                        <h3><?= $menunggu ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow bg-info text-white text-center">
                    <div class="card-body">
                        <h6>Proses</h6>
                        <h3><?= $proses ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow bg-success text-white text-center">
                    <div class="card-body">
                        <h6>Selesai</h6>
                        <h3><?= $selesai ?></h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center">
            <a href="tambah.php" class="btn btn-success me-2">Buat Laporan</a>
            <a href="riwayat.php" class="btn btn-primary">Riwayat Saya</a>
        </div>

    </div>

</body>
</html>