<?php
session_start();
session_regenerate_id(true);
date_default_timezone_set("Asia/Jakarta");
require_once "config/koneksi.php";



// Waktu :
$currentTime = date('Y-m-d');

// generate function (method)
function generateTransactionCode()
{
    $kode = date('dMyhis');

    return $kode;
}
// click count
if (empty($_SESSION['click_count'])) {
    $_SESSION['click_count'] = 0;
}

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
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card bg-transparent border-white shadow-lg p-3"
            style="width: 70%; max-width: 800px; backdrop-filter: blur(10px);">
            <div class="card-header border-white text-center">
                <h1 class="fw-bold text-light" style="letter-spacing: -4px;">Add Transaction</h1>
            </div>
            <div class="card-body bg-transparent">
                <form action="controller/transaksi-store.php" method="post">
                    <div class="mb-3">
                        <label for="kode_transaksi" class="form-label text-light">No. Transaksi</label>
                        <input style="border-radius: 20px;" class="form-control bg-transparent text-light"
                            name="kode_transaksi" id="kode_transaksi" type="text"
                            value="<?php echo 'TR-' . generateTransactionCode(); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_transaksi" class="form-label text-light">Tanggal Transaksi</label>
                        <input style="border-radius: 20px;" class="form-control bg-transparent text-light"
                            name="tanggal_transaksi" id="tanggal_transaksi" type="date"
                            value="<?php echo $currentTime; ?>" readonly>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <button style="border-radius: 20px;" class="btn btn-primary me-3 " type="button"
                            id="counterBtn">Tambah</button>
                        <input type="number" class="form-control text-light bg-transparent text-light"
                            style="width:50px; border-radius: 20px;" name="countDisplay"
                            value="<?php echo $_SESSION['click_count']; ?>" id="countDisplay" readonly>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-primary">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Sisa Produk</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <!-- Data ditambah disini -->
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th colspan="5">Total Harga</th>
                                    <td><input type="number" id="total_harga_keseluruhan" name="total_harga"
                                            class="form-control border-white bg-transparent" readonly></td>
                                </tr>
                                <tr>
                                    <th colspan="5">Nominal Bayar</th>
                                    <td><input type="number" id="nominal_bayar_keseluruhan" name="nominal_bayar"
                                            class="form-control border-white bg-transparent" required></td>
                                </tr>
                                <tr>
                                    <th colspan="5">Kembalian</th>
                                    <td><input type="number" class="form-control border-white bg-transparent"
                                            id="kembalian_keseluruhan" name="kembalian" readonly></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <input type="submit" class="btn btn-primary" name="simpan" value="Hitung">
                        <a class="btn btn-danger" href="kasir.php">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM kategori_barang");
    $categories = mysqli_fetch_all($query, MYSQLI_ASSOC);
    ?>
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        //Fungsi tambah baris
        const button = document.getElementById('counterBtn');
        const countDisplay = document.getElementById('countDisplay');
        const tbody = document.getElementById('tbody');

        button.addEventListener('click', function() {
            let currentCount = parseInt(countDisplay.value) || 0;
            currentCount++;
            countDisplay.value = currentCount;
            //Fungsi tambah td
            let newRow = "<tr>"
            newRow += "<td>" + currentCount + "</td>";
            newRow +=
                "<td><select class='form-control category-select' name='id_kategori[]' type='number' required>";
            newRow += "<option value=''>--Pilih Kategori--</option>";
            <?php foreach ($categories as $category) { ?>
            newRow +=
                "<option value='<?php echo $category['id'] ?> '><?php echo $category['nama_kategori'] ?></option>";
            <?php
                } ?>
            newRow += "</select></td>";
            newRow +=
                "<td><select class='form-control item-select' name='id_barang[]' type='number' required>";
            newRow += "<option value=''>--Pilih Barang--</option>";
            newRow +=
                "<td><input type='number' name='jumlah[]' class='form-control jumlah-input' value='0' required></td>";
            newRow +=
                "<td><input type='number' name='sisa_produk[]' class='form-control' value='0' readonly></td>";
            newRow += "<td><input type='number' name='harga[]' class='form-control' readonly></td>";

            newRow += "</tr>";

            tbody.insertAdjacentHTML('beforeend', newRow);

            attachCategoryChangeListener();
            attachItemChangeListener();
            attachJumlahChangeListener();
        });

        // fungsi untuk menampilkan barang berdasarkan kategori...
        function attachCategoryChangeListener() {
            const categorySelects = document.querySelectorAll('.category-select');
            categorySelects.forEach(select => {
                select.addEventListener('change', function() {
                    const categoryId = this.value;
                    const itemSelect = this.closest('tr').querySelector('.item-select');

                    if (categoryId) {
                        fetch(
                                `controller/get-product-dari-category.php?id_kategori=${categoryId}`
                            )
                            .then(response => response.json())
                            .then(data => {
                                itemSelect.innerHTML =
                                    "<option value=''>--Pilih Barang--</option>";
                                data.forEach(item => {
                                    itemSelect.innerHTML +=
                                        `<option value='${item.id}'>${item.nama_barang}</option>`;
                                });
                            });
                    } else {
                        itemSelect.innerHTML = "<option value=''>--Pilih Barang--</option>";
                    }
                });


            });
        }

        // untuk menaplikan qty dan harga...
        function attachItemChangeListener() {
            const itemSelects = document.querySelectorAll('.item-select');
            itemSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const itemId = this.value;
                    const row = this.closest('tr');
                    const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                    const hargaInput = row.querySelector('input[name="harga[]"]');

                    if (itemId) {
                        fetch('controller/get-barang-details.php?id_barang=' + itemId)
                            .then(response => response.json())
                            .then(data => {
                                sisaProdukInput.value = data.qty;
                                hargaInput.value = data.harga;
                            })
                    } else {
                        sisaProdukInput.value = '';
                        hargaInput.value = '';
                    }
                });
            });
        }

        const totalHargaKeseluruhan = document.getElementById('total_harga_keseluruhan');
        const nominalBayarKeseluruhanInput = document.getElementById('nominal_bayar_keseluruhan');
        const kembalianKeseluruhanInput = document.getElementById('kembalian_keseluruhan');

        // fungsi untuk membuat alert jumlah > sisaProduk
        function attachJumlahChangeListener() {
            const jumlahInputs = document.querySelectorAll('.jumlah-input');
            jumlahInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const row = this.closest('tr');
                    const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                    const hargaInput = row.querySelector('input[name="harga[]"]');
                    const totaHargaInput = document.getElementById('total_harga_keseluruhan');
                    const nominalBiayaInput = document.getElementById(
                        'nominal_bayar_keseluruhan');
                    const kembalianInput = document.getElementById('kembalian_keseluruhan');

                    const jumlah = parseInt(this.value) || 0;
                    const sisaProduk = parseInt(sisaProdukInput.value) || 0;
                    const harga = parseFloat(hargaInput.value) || 0;

                    if (jumlah > sisaProduk) {
                        alert("Jumlah tidak boleh melebihi sisa produk");
                        this.value = sisaProduk;
                        return;
                    }
                    updateTotalKeseluruhan();
                });
            });
        }

        function updateTotalKeseluruhan() {
            let totalKeseluruhan = 0;
            const jumlahInput = document.querySelectorAll('.jumlah-input');
            jumlahInput.forEach(input => {
                const row = input.closest('tr');
                const hargaInput = row.querySelector('input[name="harga[]"]');
                const harga = parseFloat(hargaInput.value) || 0;
                const jumlah = parseInt(input.value) || 0;
                totalKeseluruhan += jumlah * harga;
            });
            totalHargaKeseluruhan.value = totalKeseluruhan;
        }

        // mencari kembalian ...
        nominalBayarKeseluruhanInput.addEventListener('input', function() {
            const nominalBayar = parseFloat(this.value) || 0;
            const totalHarga = parseFloat(totalHargaKeseluruhan.value) || 0;
            kembalianKeseluruhanInput.value = nominalBayar - totalHarga;
        })
    });
    </script>
</body>

</html>