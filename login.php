<?php
session_start();
include "config/config.php";

if(isset($_POST['login_admin'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if($data && password_verify($password, $data['password'])){
        $_SESSION['role'] = "admin";
        $_SESSION['id'] = $data['admin_id'];
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $error_admin = "Login Admin gagal!";
    }
}

if(isset($_POST['login_siswa'])){

    $nis = $_POST['nis'];

    $query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
    $data = mysqli_fetch_assoc($query);

    if($data){
        $_SESSION['role'] = "siswa";
        $_SESSION['nis'] = $data['nis'];
        header("Location: siswa/dashboard.php");
        exit;
    } else {
        $error_siswa = "NIS tidak ditemukan!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login pengaduan sarana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width:420px;">

    <h4 class="text-center mb-4">Pengaduan Sarana Sekolah</h4>

        <ul class="nav nav-pills nav-justified mb-3">
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#siswa">Siswa</button>
            </li>
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#admin">Admin</button>
            </li>
        </ul>

        <div class="tab-content">

        <!-- TAB ADMIN -->
            <div class="tab-pane fade show active" id="admin">

            <?php if(isset($error_admin)) : ?>
            <div class="alert alert-danger"><?= $error_admin ?></div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" name="login_admin" class="btn btn-primary w-100">
                Login Admin
                </button>

            </form>
        </div>

        <!-- TAB SISWA -->
        <div class="tab-pane fade" id="siswa">

        <?php if(isset($error_siswa)) : ?>
        <div class="alert alert-danger"><?= $error_siswa ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="number" name="nis" class="form-control" required>
            </div>

            <button type="submit" name="login_siswa" class="btn btn-success w-100">
            Login Siswa
            </button>

        </form>
        </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>