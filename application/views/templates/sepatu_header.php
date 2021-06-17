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
                <li><a class="link" href="#size-chart">Size chart</a></li>
                <li><a class="link" href="#about">About</a></li>
                <li><a class="link" href="#contact-us">Contact us</a></li>
                <?php if ($isLogin) : ?>
                    <li><a class="login logout" href="<?= base_url(); ?>auth/logout">Logout</a></li>
                <?php else : ?>
                    <li><a class="login" href="<?= base_url(); ?>auth">Login</a></li>
                <?php endif; ?>
            </ul>
            <?php if ($isLogin) : ?>
                <a class="login logout" href="<?= base_url(); ?>user/chart">Chart</a>
            <?php endif; ?>
            <div class="menu-toggle">
                <input type="checkbox">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>