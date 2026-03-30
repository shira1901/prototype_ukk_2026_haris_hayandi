<?php
session_start();
include "../config/config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "siswa"){
    header("Location: ../login.php");
    exit;
}

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

if(isset($_POST['kirim'])){

    $nis = $_SESSION['nis'];
    $id_pelaporan = rand(10000,99999);
    $date_created = date("Y-m-d H:i:s");
    $status = "Menunggu";
    $feedback = "-";

    $id_kategori = $_POST['id_kategori'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $ket = mysqli_real_escape_string($conn, $_POST['ket']);

    // insert ke aspirasi
    mysqli_query($conn, "INSERT INTO aspirasi 
    (id_pelaporan, nis, status, feedback, date_created)
    VALUES 
    ('$id_pelaporan','$nis','$status','$feedback','$date_created')");

    // insert ke input_aspirasi
    mysqli_query($conn, "INSERT INTO input_aspirasi 
    (id_pelaporan, nis, id_kategori, lokasi, ket)
    VALUES 
    ('$id_pelaporan','$nis','$id_kategori','$lokasi','$ket')");

    echo "<script>
            alert('Aspirasi berhasil dikirim!');
            window.location='riwayat.php';
        </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aspirasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="text-start mb-3">
        <a href="dashboard.php" class="btn btn-secondary btn-sm">
            ← Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">Tambah Aspirasi</h4>
                </div>

                <div class="card-body p-4">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="id_kategori" class="form-select rounded-3" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php while($row = mysqli_fetch_assoc($queryKategori)) { ?>
                                    <option value="<?= $row['id_kategori']; ?>">
                                        <?= $row['ket_kategori']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control rounded-3" placeholder="Contoh: Lantai 2 dekat tangga"required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <textarea name="ket" class="form-control rounded-3" rows="4" placeholder="Tulis detail laporan kamu di sini..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="kirim"
                                    class="btn btn-primary rounded-3 fw-semibold">
                                Kirim Aspirasi
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>