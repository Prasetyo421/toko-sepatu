<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/top-nav.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/detail-sepatu.css">

    <title>Halaman Detail Product</title>
</head>

<body>
    <div class="container">
        <div class="top-nav">
            <h1 class="brand">Sepatuku</h1>
            <ul>
                <li><a class="link" href="#">Home</a></li>
                <li><a class="link" href="#">Spesifikasi</a></li>
                <li><a class="link" href="#">Size chart</a></li>
                <li><a class="link" href="#">About</a></li>
                <li><a class="link" href="#">Contact us</a></li>
            </ul>

            <div class="menu-toggle">
                <input type="checkbox">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="content">
            <div class="image-product">
                <div class="main-image">
                    <?php $gambar = json_decode($sepatu['gambar']) ?>
                    <img src="<?= base_url(); ?>asset/image/sepatu/crop/<?= $gambar->image; ?>" alt="">
                </div>
                <div class="thumb-image"></div>
            </div>

            <div class="info-product">
                <h2><?= $sepatu['nama'] ?></h2>
                <p>Rp <?= $sepatu['harga'] ?></p>
            </div>
        </div>
    </div>
</body>

</html>