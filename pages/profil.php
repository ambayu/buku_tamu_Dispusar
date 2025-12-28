<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <!-- Tambahkan tautan ke Bootstrap CSS di sini -->
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Edit Data</h1>
        <?php
        // Ambil data dari database berdasarkan ID atau parameter lain yang sesuai
        $id = $_GET['id']; // Gantilah ini dengan cara Anda mendapatkan ID dari URL atau parameter lainnya
        $query = "SELECT * FROM tb_pengguna WHERE id = $id";
        $result = mysqli_query($koneksi, $query);
        $data = mysqli_fetch_assoc($result);

        // Periksa apakah data ditemukan
        if ($data) {
            $username = $data['username'];
            $password = $data['password'];
            $tanggal = $data['tanggal'];
            $jam = $data['jam'];
            $nama = $data['nama'];
            $umur = $data['umur'];
            $kerja = $data['kerja'];
            $didik = $data['didik'];
            $jk = $data['jk'];
            $alamat = $data['alamat'];

            // Tampilkan formulir edit dengan data yang telah diambil
        ?>
            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                </div>
                <!-- Sisipkan input lainnya sesuai kebutuhan -->
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        <?php
        } else {
            echo "Data tidak ditemukan.";
        }
        ?>
    </div>

    <!-- Tambahkan tautan ke Bootstrap JavaScript di sini jika diperlukan -->
    <script src="path/to/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>