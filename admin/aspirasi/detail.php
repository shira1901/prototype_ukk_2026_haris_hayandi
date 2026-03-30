<?php
    session_start();
    include "../../config/config.php";

    if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
        header("Location: ../../login.php");
        exit;
    }

    $id = $_GET['id'];

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
    WHERE a.id_pelaporan='$id'
    ");
    $row = mysqli_fetch_assoc($data);

    if(isset($_POST['update'])){
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE aspirasi SET status='$status' WHERE id_pelaporan='$id'");
        header("Location: index.php");
    }
?>

<!doctype html>
<html>
<head>
    <title>Detail Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="card shadow">
        <div class="card-body">

            <h4><?= $row['ket_kategori'] ?></h4>
            <p class="text-muted">Tanggal: <?= date("d-m-Y H:i", strtotime($row['date_created'])) ?></p>
            <hr>
            <p><strong>Lokasi:</strong> <?= $row['lokasi'] ?></p>
            <p><?= $row['ket'] ?></p>
            <hr>

            <form method="POST">
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="Menunggu" <?= $row['status']=="Menunggu"?"selected":"" ?>>Menunggu</option>
                    <option value="Proses" <?= $row['status']=="Proses"?"selected":"" ?>>Proses</option>
                    <option value="Selesai" <?= $row['status']=="Selesai"?"selected":"" ?>>Selesai</option>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-primary">
            Update Status
            </button>
            </form>

        </div>
    </div>

</div>
</body>
</html>