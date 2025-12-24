<?php
$menu = $_SESSION['menu'];

$level = $_SESSION['level'];
include("koneksi.php");

// Detect if called from admin/ folder
$imgPath = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../img/medan.png' : 'img/medan.png';
?>

<nav class="navbar navbar-expand-sm bg-success bg-gradient fixed-top">
    <div class="container-fluid">
        <img src="<?php echo $imgPath; ?>" style="width:70px;">
        <a class="navbar-brand fw-bold lh-1 fs-6">Dinas Perpustakaan dan Kearsipan<br>Kota Medan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php $sql = mysqli_query($koneksi1, "SELECT * FROM tb_menu");
                while ($data = mysqli_fetch_assoc($sql)) {
                    if ($data['menu'] == $menu) {
                        $pilihan = "text-white fw-bold";
                    } else {
                        $pilihan = "";
                    } ?>
                    <li class="nav-item">
                        <?php
                        if ($data["id"] == 6 && $level != '1') {

                        ?>

                        <?php } else {

                        ?>
                            <a class="nav-link <?= $pilihan; ?>" href="<?= $data['link']; ?>"><?= $data['tulisan']; ?></a>
                        <?php

                        }
                        ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<br><br><br>