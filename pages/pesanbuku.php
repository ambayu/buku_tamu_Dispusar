<?php
session_start();
ob_start();
include("../config/koneksi.php");
$sqlsoal = mysqli_query($koneksi1, "SELECT * FROM tb_soal");

$tempat = $_SESSION["tempat"];

if (isset($_SESSION['user'])) {
} else {

    if (isset($_SESSION['tempat'])) {
        header("Location:index2.php?tempat=" . $tempat . "");
    } else {
        header("Location:error.php");
    }
}
if (isset($_POST['logout'])) {

    session_destroy();

    header("Location: index2.php?tempat=" . $tempat . "");
}


//submit




?>


<!DOCTYPE html>
<html lang="en">
<style>
    @media only screen and (max-width: 600px) {
        .textlogo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 70%;

            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .p {
            font-size: 20px !important;
        }

        p {
            font-size: 17px !important;
        }

    }
</style>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <title>Dinas Perpustakaan dan Kearsipan Kota Medan</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/img/medan.png" type="image/png">

    <!-- sweet alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/css/animate.css">
    <link rel="stylesheet" href="vendor/css/LineIcons.css">
    <link rel="stylesheet" href="vendor/css/owl.carousel.css">
    <link rel="stylesheet" href="vendor/css/owl.theme.css">
    <link rel="stylesheet" href="vendor/css/magnific-popup.css">
    <link rel="stylesheet" href="vendor/css/nivo-lightbox.css">
    <link rel="stylesheet" href="vendor/css/main.css">
    <link rel="stylesheet" href="vendor/css/responsive.css">

</head>

<body>


    <!-- Business Plan Section Start -->
    <section id="business-plan">
        <div class="container">

            <div class="row">
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 pl-0 pt-70 pr-5">
                    <div class="business-item-img">
                        <img src="img/contact/01.png" class="img-fluid" alt="">
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 pl-4">
                    <div class="business-item-info">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 pl-0 pr-0">
                                <img class="logo" src="img/medan.png" width="100%" alt="">
                            </div>
                            <div class="textlogo col-lg-8 col-md-8 col-sm-8 pl-0 pr-0">
                                <h3 class="textlogo">Dinas Perpustakaan dan Kearsipan Kota Medan</h3>
                            </div>
                        </div>

                        <p>Selamat datang di layanan pemesanan buku Dinas Perpustakaan dan Kearsipan Kota Medan. Kami menyediakan fasilitas untuk menerima usulan dan permintaan pengadaan buku dari masyarakat. Jika Anda membutuhkan buku tertentu yang belum tersedia di koleksi perpustakaan kami, silakan mengisi formulir pemesanan buku di bawah ini. Tim kami akan mengevaluasi dan mempertimbangkan setiap permintaan untuk meningkatkan koleksi perpustakaan sesuai kebutuhan pembaca. Terima kasih atas partisipasi Anda dalam mengembangkan perpustakaan kami.</p>

                        <a class="btn btn-common" href="/bukutamu/link.php">Home</a>


                    </div>
                </div>
                <!-- End Col -->

            </div>
        </div>
    </section>
    <!-- Business Plan Section End -->
    <!-- Cool Fetatures Section Start -->
    <section id="features" class="section">
        <div class="container">
            <!-- Start Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="features-text section-header text-center">
                        <div>
                            <h2 class="section-title">PESAN BUKU</h2>
                            <div class="desc-text">
                                <p>Kami menyediakan kolom masukan untuk menyediakan buku yang diminati para pembaca, untuk membuat pesanan buku harap isi kolom berikut.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Row -->
            <!-- Start Row -->


            <!-- End Row -->
        </div>
    </section>
    <!-- Cool Fetatures Section End -->


    <div class="col-lg-12 col-md-12 ">
        <div class="container">
            <div class="col-lg-12 col-md-6">
                <form action="" method="post">
                    <div class="row">
                        <di class="col-md-2">
                            <label for="judul">
                                <p class="p" style="font-size: 20px;">Judul Buku</p>
                            </label>
                        </di>
                        <div class="form-group col-md-10">
                            <input type="text" required name="judul" class="form-control form-control-user" id="judul" placeholder="Judul Buku">
                        </div>
                    </div>

                    <div class="row">
                        <di class="col-md-2">
                            <label for="penerbit">
                                <p class="p" style="font-size: 20px;">Penerbit Buku</p>
                            </label>
                        </di>
                        <div class="form-group col-md-10">
                            <input type="text" required name="penerbit" class="form-control form-control-user" id="penerbit" placeholder="Penerbit Buku">
                        </div>
                    </div>

                    <div class="row">
                        <di class="col-md-2">
                            <label for="penulis">
                                <p class="p" style="font-size: 20px;">Penulis Buku</p>
                            </label>
                        </di>
                        <div class="form-group col-md-10">
                            <input type="text" required name="penulis" class="form-control form-control-user" id="penulis" placeholder="Penulis Buku">
                        </div>
                    </div>


                    <div class="form-group">
                        <input class="btn btn-common" style="width: 100%;" type="submit" value="Pesan" name="pesan" class=" btn btn-primary btn-user btn-block"></td>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <?php


    if (isset($_POST['pesan'])) {
        $judul = htmlspecialchars($_POST['judul']);
        $penulis = htmlspecialchars($_POST['penulis']);
        $penerbit = htmlspecialchars($_POST['penerbit']);
        $tanggal = date('Y-m-d');
        $sqlpesan = mysqli_query($koneksi, "INSERT INTO tb_pesanbuku (judul,tanggal,penulis,penerbit) VALUES ('$judul','$tanggal','$penulis','$penerbit')");
        echo '<script>
        Swal.fire(
    
            "Data Berhasil Dikirim",
            "Terimakasih, Pesanan akan kami pertimbangkan",
            "success"
        ).then(function() {
            window.location = "../link.php";
        })
        </script>';
    } ?>




    <!-- Footer Section Start -->
    <footer>
        <!-- Footer Area Start -->
        <section id="footer-Content" style="padding-top: 0;">

            <!-- Copyright Start  -->

            <div class="copyright">
                <div class="container">
                    <!-- Star Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="site-info text-center">
                                <p>Crafted by Dinas Perpustakaan <a href="" rel="nofollow">2023</a></p>
                            </div>

                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- Copyright End -->
        </section>
        <!-- Footer area End -->

    </footer>
    <!-- Footer Section End -->


    <!-- Go To Top Link -->
    <a href="#" class="back-to-top">
        <i class="lni-chevron-up"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="vendor/js/jquery-min.js"></script>
    <script src="vendor/js/popper.min.js"></script>
    <script src="vendor/js/bootstrap.min.js"></script>
    <script src="vendor/js/owl.carousel.js"></script>
    <script src="vendor/js/jquery.nav.js"></script>
    <script src="vendor/js/scrolling-nav.js"></script>
    <script src="vendor/js/jquery.easing.min.js"></script>
    <script src="vendor/js/nivo-lightbox.js"></script>
    <script src="vendor/js/jquery.magnific-popup.min.js"></script>
    <script src="vendor/js/form-validator.min.js"></script>
    <script src="vendor/js/contact-form-script.js"></script>
    <script src="vendor/js/main.js"></script>

</body>

</html>