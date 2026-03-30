<?php
    session_start();
    include "../config/config.php";

    if(!isset($_SESSION['role']) || $_SESSION['role'] != "siswa"){
        header("Location: ../login.php");
        exit;
    }

    $nis = $_SESSION['nis'];

    $query = mysqli_query($conn, "
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
    WHERE a.nis = '$nis'
    ORDER BY a.date_created DESC
    ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between mb-4">
        <h3>📜 Riwayat Aspirasi</h3>
        <a href="dashboard.php" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $no = 1;
                while($row = mysqli_fetch_assoc($query)) {
                ?>

                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $row['ket_kategori']; ?></td>
                        <td><?= $row['lokasi']; ?></td>
                        <td><?= $row['ket']; ?></td>
                        <td>
                            <?php if($row['status'] == "Menunggu") { ?>
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            <?php } else { ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php } ?>
                        </td>
                        <td><?= $row['feedback']; ?></td>
                        <td><?= date("d-m-Y H:i", strtotime($row['date_created'])); ?></td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>