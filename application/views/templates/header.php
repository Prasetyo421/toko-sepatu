<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/header.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="animation.css">

    <title><?= $judul ?></title>
</head>

<body>
    <div class="container">
        <div class="top-nav">
            <div class="container">
                <h1>KOS</h1>
                <span>
                    <a class="nav-link active" href="#">Home</a>
                    <a class="nav-link" href="#">profil</a>
                    <a class="nav-link" href="#">peraturan</a>
                    <a class="nav-link" href="#">pengingat</a>
                    <a class="nav-link" href="#">Ibu Kos</a>
                    <a class="nav-link" href="#">Pembayaran</a>
                </span>
                <div style="display: inline;" class="clear"></div>
                <div class="burger" id="burger"></div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="top-nav-mobile" id="top-nav-mobile">
            <img id="close-nav" src="image/cancel.svg" alt="">
            <div class="nav">
                <div class="profile">
                    <div class="icon nav-icon"></div>
                    <a href="">profil</a>
                </div>
                <div class="peraturan clear">
                    <div class="icon nav-icon"></div>
                    <a href="">peraturan</a>
                </div>
                <div class="pengingat clear">
                    <div class="icon nav-icon"></div>
                    <a href="">pengingat</a>
                </div>
                <div class="ibu-kos clear">
                    <div class="icon nav-icon"></div>
                    <a href="">Ibu Kos</a>
                </div>
                <div class="pembayaran clear">
                    <div class="icon nav-icon"></div>
                    <a href="">Pembayaran</a>
                </div>
            </div>
            <div class="logout clear">
                <p>Sign out </p>
                <div class="arrow clear"></div>
            </div>
        </div>