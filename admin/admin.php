<?php
require_once __DIR__ . '/../includes/init.php';

// Check admin authentication
requireAdminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="dispusar">
    <title>Buku Tamu</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="../img/medan.png" type="image/png">

    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/css/animate.css">
    <link rel="stylesheet" href="../vendor/css/LineIcons.css">
    <link rel="stylesheet" href="../vendor/css/owl.carousel.css">
    <link rel="stylesheet" href="../vendor/css/owl.theme.css">
    <link rel="stylesheet" href="../vendor/css/magnific-popup.css">
    <link rel="stylesheet" href="../vendor/css/nivo-lightbox.css">
    <link rel="stylesheet" href="../vendor/css/main.css">
    <link rel="stylesheet" href="../vendor/css/responsive.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


</head>
<style>

</style>

<body>
    <div class="header">
        <?php $_SESSION['menu'] = "bukutamu";
        include("../menu.php");
        ?>
    </div>
    <div class="container" style="max-width: 90%; margin-bottom:100px; margin-top:100px;">
        <?php

        $no = 1; ?>

        <h5 class="fw-bold">DATA KUNJUNGAN PERPUSTAKAAN</h5>
        <form action="" method="POST">
            <?php echo getCSRFField(); ?>
            <select name="posisi">
                <option value="Semua">--------Semua--------</option>
                <?php
                $tempat = mysqli_query($koneksi, "SELECT * FROM tb_lokasi");
                while ($datatempat = mysqli_fetch_assoc($tempat)) { ?>
                    <option value="<?= cleanOutput($datatempat['lokasi']); ?>"><?= cleanOutput($datatempat['lokasi']); ?></option><?php
                                                                                                                                } ?>
            </select>
            Tanggal : <input type="date" name="tgl_awal" required> sampai
            <input type="date" name="tgl_akhir" required>
            <input type="submit" name="proses" value="Proses" class="btn btn-info">
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <?php if (isset($_POST['proses'])) {
            // Validate CSRF token
            if (!validateCSRF()) {
                echo "<div class='alert alert-danger'>Invalid request</div>";
                exit;
            }

            // Sanitize and validate inputs
            $posisi = sanitizeInput($_POST['posisi']);
            $tgl_awal = sanitizeInput($_POST['tgl_awal']);
            $tgl_akhir = sanitizeInput($_POST['tgl_akhir']);

            // Validate dates
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl_awal) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl_akhir)) {
                echo "<div class='alert alert-danger'>Format tanggal tidak valid</div>";
                exit;
            }

            $_SESSION['posisi'] = $posisi;
            $_SESSION['tgl_awal'] = $tgl_awal;
            $_SESSION['tgl_akhir'] = $tgl_akhir;

            echo "Lokasi : " . cleanOutput($posisi) . ", Tanggal : " . date('d-m-Y', strtotime($tgl_awal)) . " sampai " . date('d-m-Y', strtotime($tgl_akhir));

            // Use prepared statements
            $db = getDB();
            if ($posisi == "Semua") {
                $datakunjungan = $db->select(
                    "SELECT * FROM tb_kunjungan WHERE tanggal >= ? AND tanggal <= ?",
                    "ss",
                    [$tgl_awal, $tgl_akhir]
                );
            } else {
                $datakunjungan = $db->select(
                    "SELECT * FROM tb_kunjungan WHERE lokasi = ? AND tanggal >= ? AND tanggal <= ?",
                    "sss",
                    [$posisi, $tgl_awal, $tgl_akhir]
                );
            } ?>
            <table id="data_kunjungan" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Pekerjaan</th>
                        <th>Pendidikan</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($datakunjungan as $row) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= cleanOutput(date('d-m-Y', strtotime($row['tanggal']))); ?></td>
                            <td><?= cleanOutput(date('H:i', strtotime($row['jam']))); ?></td>
                            <td><?= cleanOutput($row['nama']); ?></td>
                            <td><?= cleanOutput($row['umur']); ?></td>
                            <td><?= cleanOutput($row['kerja']); ?></td>
                            <td><?= cleanOutput($row['didik']); ?></td>
                            <td><?= cleanOutput($row['jk']); ?></td>
                            <td><?= cleanOutput($row['alamat']); ?></td>
                            <td><?= cleanOutput($row['lokasi']); ?></td>
                            <td>
                                <form method="POST" action="aksi.php?aksi=hapus&id=<?= cleanOutput($row['id']); ?>" style="display:inline;">
                                    <?php echo getCSRFField(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


            <strong>
                <?php
                $totalKunjungan = count($datakunjungan);
                echo "Jumlah Pengunjung : " . $totalKunjungan . " orang <br>";

                // Count by gender - Laki-laki
                if ($posisi == "Semua") {
                    $lakiData = $db->select(
                        "SELECT COUNT(*) as total FROM tb_kunjungan WHERE tanggal >= ? AND tanggal <= ? AND jk = 'Laki-laki'",
                        "ss",
                        [$tgl_awal, $tgl_akhir]
                    );
                } else {
                    $lakiData = $db->select(
                        "SELECT COUNT(*) as total FROM tb_kunjungan WHERE lokasi = ? AND tanggal >= ? AND tanggal <= ? AND jk = 'Laki-laki'",
                        "sss",
                        [$posisi, $tgl_awal, $tgl_akhir]
                    );
                }
                echo "Laki-laki : " . (isset($lakiData[0]['total']) ? $lakiData[0]['total'] : 0) . " orang <br>";

                // Count by gender - Perempuan
                if ($posisi == "Semua") {
                    $perempuanData = $db->select(
                        "SELECT COUNT(*) as total FROM tb_kunjungan WHERE tanggal >= ? AND tanggal <= ? AND jk = 'Perempuan'",
                        "ss",
                        [$tgl_awal, $tgl_akhir]
                    );
                } else {
                    $perempuanData = $db->select(
                        "SELECT COUNT(*) as total FROM tb_kunjungan WHERE lokasi = ? AND tanggal >= ? AND tanggal <= ? AND jk = 'Perempuan'",
                        "sss",
                        [$posisi, $tgl_awal, $tgl_akhir]
                    );
                }
                echo "Perempuan : " . (isset($perempuanData[0]['total']) ? $perempuanData[0]['total'] : 0) . " orang <br>";

                // Education levels
                $educationLevels = ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'];
                foreach ($educationLevels as $level) {
                    if ($posisi == "Semua") {
                        $eduData = $db->select(
                            "SELECT COUNT(*) as total FROM tb_kunjungan WHERE tanggal >= ? AND tanggal <= ? AND didik = ?",
                            "sss",
                            [$tgl_awal, $tgl_akhir, $level]
                        );
                    } else {
                        $eduData = $db->select(
                            "SELECT COUNT(*) as total FROM tb_kunjungan WHERE lokasi = ? AND tanggal >= ? AND tanggal <= ? AND didik = ?",
                            "ssss",
                            [$posisi, $tgl_awal, $tgl_akhir, $level]
                        );
                    }
                    echo $level . " : " . (isset($eduData[0]['total']) ? $eduData[0]['total'] : 0) . " orang <br>";
                }

                // Occupations
                $occupations = ['Guru', 'Dosen', 'Pegawai Negeri'];
                foreach ($occupations as $job) {
                    if ($posisi == "Semua") {
                        $jobData = $db->select(
                            "SELECT COUNT(*) as total FROM tb_kunjungan WHERE tanggal >= ? AND tanggal <= ? AND kerja = ?",
                            "sss",
                            [$tgl_awal, $tgl_akhir, $job]
                        );
                    } else {
                        $jobData = $db->select(
                            "SELECT COUNT(*) as total FROM tb_kunjungan WHERE lokasi = ? AND tanggal >= ? AND tanggal <= ? AND kerja = ?",
                            "ssss",
                            [$posisi, $tgl_awal, $tgl_akhir, $job]
                        );
                    }
                    echo $job . " : " . (isset($jobData[0]['total']) ? $jobData[0]['total'] : 0) . " orang <br>";
                }
                ?>
            </strong>





        <?php

        } ?>
    </div>


</body>

<script src="../vendor/js/jquery-min.js"></script>
<script src="../vendor/js/popper.min.js"></script>
<script src="../vendor/js/bootstrap.min.js"></script>
<script src="../vendor/js/owl.carousel.js"></script>
<script src="../vendor/js/jquery.nav.js"></script>
<script src="../vendor/js/scrolling-nav.js"></script>
<script src="../vendor/js/jquery.easing.min.js"></script>
<script src="../vendor/js/nivo-lightbox.js"></script>
<script src="../vendor/js/jquery.magnific-popup.min.js"></script>


<script src="../vendor/js/main.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#data_kunjungan').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>



</html>