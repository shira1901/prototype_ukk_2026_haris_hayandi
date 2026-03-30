<?php
    include "../config/config.php";
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
        header("Location: ../login.php");
        exit;
    }

    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi"))['total'];
    $menunggu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status='Menunggu'"))['total'];
    $proses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status='Proses'"))['total'];
    $selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status='Selesai'"))['total'];

    $latest = mysqli_query($conn, "
    SELECT 
        a.id_pelaporan,
        a.status,
        i.lokasi
    FROM aspirasi a
    JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
    ORDER BY a.id_pelaporan DESC
    LIMIT 5
    ");

    $username = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM admin WHERE admin_id='".$_SESSION['id']."'"))['username'];
    $username = $_SESSION['username'] ?? $username;
?>
<!doctype html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
        }
        </style>
    </head>

<body>

<div class="container-fluid">
    <div class="row"> 

        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white sidebar p-3 h-auto">
            <h4 class="text-center mb-4">Admin Panel</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="#">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="aspirasi/index.php">Kelola Aspirasi</a>
                </li>
                <li class="nav-item mt-4">
                    <a href="../logout.php" class="btn btn-danger w-100">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="col-md-10 p-4">

            <h3 class="mb-4">Selamat Datang, <?= $username ?> </h3>

            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <h6>Total</h6>
                            <h2><?= $total ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 bg-warning text-white">
                        <div class="card-body text-center">
                            <h6>Menunggu</h6>
                            <h2><?= $menunggu ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 bg-info text-white">
                        <div class="card-body text-center">
                            <h6>Proses</h6>
                            <h2><?= $proses ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 bg-success text-white">
                        <div class="card-body text-center">
                            <h6>Selesai</h6>
                            <h2><?= $selesai ?></h2>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Grafik -->
            <div class="card shadow mb-4 max-width 250px">
                <div class="card-body">
                    <h5 class="mb-3">Grafik Status Aspirasi</h5>
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>

            <!-- Tabel terbaru -->
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="mb-3">5 Aspirasi Terbaru</h5>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while($row = mysqli_fetch_assoc($latest)){ 
                                if($row['status'] == "Menunggu"){
                                    $badge = "<span class='badge bg-warning'>Menunggu</span>";
                                }elseif($row['status'] == "Proses"){
                                    $badge = "<span class='badge bg-info'>Proses</span>";
                                }else{
                                    $badge = "<span class='badge bg-success'>Selesai</span>";
                                }
                                ?>
                                <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['lokasi'] ?></td>
                                <td><?= $badge ?></td>
                                <td>
                                    <a href="aspirasi/detail.php?id=<?= $row['id_pelaporan'] ?>" 
                                    class="btn btn-sm btn-primary">Detail</a>       
                                </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('chartStatus');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Menunggu', 'Proses', 'Selesai'],
        datasets: [{
            label: 'Jumlah',
            data: [<?= $menunggu ?>, <?= $proses ?>, <?= $selesai ?>],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
    }
}); 
</script>

</body>
</html>