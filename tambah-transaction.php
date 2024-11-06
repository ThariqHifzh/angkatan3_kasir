<?php 
session_start();
session_regenerate_id(true);
date_default_timezone_set("Asia/Jakarta");
require_once "config/koneksi.php";

// Waktu
$currentTime = date('d-M-y');

//Jika session nya isi, maka melempar ke dashboard.php
// if(isset($_SESSION['NAMALENGKAPNYA'])){
//     header("Location: kasir.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body style="background-image: url(image/qwerty.png); background-size:cover">
    <nav class="navbar navbar-expand-lg  sticky-top bg-transparent" style="backdrop-filter: blur(10px); z-index: 1000;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAltMarkup"
                aria-controls="navAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                </span>
            </button>

            <div class="collapse navbar-collapse" id="navAltMarkup">
                <div class="navbar-nav mt-2 mb-2">
                    <a href=" index.php" class="nav-link text-white">Dashboard</a>
                    <a href="manageaccounts.php" class="nav-link text-white">Manage Accounts</a>
                    <a href="managebooks.php" class="nav-link text-white">Manage Books</a>
                </div>
            </div>
            <a style="border: 2px;" class="btn btn-outline-primary rounded-button"
                onclick="return confirm('Apakah Anda Yakin untuk Log-Out?')" href="controller/logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Garis vertikal untuk simbol power -->
                    <line x1="12" y1="2" x2="12" y2="12"></line>
                    <!-- Lingkaran di sekitar garis -->
                    <path d="M16.24 7.76a6 6 0 1 1-8.48 0"></path>
                </svg>
            </a>
        </div>
    </nav>
    <div class="container justify-content-center position-absolute" style="margin-top: 200px; margin-left: 570px;">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-8">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label text-white">No. Transaksi</label>
                        <input style="border-radius: 20px;" class="form-control w-50" name="kode_transaksi"
                            id="kode_transaksi" type="text" value="<?php ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-white">Tanggal Transaksi</label>
                        <input style="border-radius: 20px;" class="form-control w-50" name="tanggal_transaksi"
                            id="tanggal_transaksi" type="date" value="<?php echo $currentTime ?>" readonly>
                    </div>
                    <div class="mb-1">
                        <button style="border-radius: 20px;" class="btn btn-outline-light" type="button"
                            id="counterBtn">Tambah</button>
                        <input type="number" class="" style="width:100px; border-radius: 20px;" name="countDisplay"
                            id="countDisplay" readonly>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>

        </div>
    </div>
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>