<?php
    session_start();
    include "../../config/config.php";

    if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
        header("Location: ../../login.php");
        exit;
    }

    $data = mysqli_query($conn, "
    SELECT 
        a.id_pelaporan,
        a.status,
        a.feedback,
        a.date_created,
        i.lokasi,
        i.ket,
        k.ket_kategori
    FROM aspirasi a
    JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan
    JOIN kategori k ON i.id_kategori = k.id_kategori
    ORDER BY a.id_pelaporan DESC
    ");
    
?>

<!doctype html>
<html>
<head>
    <title>Kelola Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <h3 class="mb-4">Kelola Aspirasi</h3>

    <a href="../dashboard.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                    <th>No</th>
                    <th>kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($row = mysqli_fetch_assoc($data)){
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
                    <td><?= $row['ket_kategori'] ?></td>
                    <td><?= date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                    <td><?= $badge ?></td>
                    <td>
                    <a href="detail.php?id=<?= $row['id_pelaporan'] ?>" class="btn btn-sm btn-primary">
                    Detail
                    </a>
                    </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>