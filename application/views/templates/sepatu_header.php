<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link href="<?= base_url(); ?>asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/top-nav.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/<?= $css; ?>">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/footer.css">

    <title>Home</title>
</head>

<body>
    <div class="container">

        <div class="top-nav">
            <h1 class="brand">Sepatuku</h1>

            <ul>
                <li><a class="link" href="<?= base_url(); ?>home">Home</a></li>
                <li><a class="link" href="#spec">Spesifikasi</a></li>
                <li><a class="link" href="#">Size chart</a></li>
                <li><a class="link" href="#">About</a></li>
                <li><a class="link" href="#">Contact us</a></li>
            </ul>

            <a class="login" href="<?= base_url(); ?>auth">Login</a>

            <div class="menu-toggle">
                <input type="checkbox">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>