<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/template-admin.css">
    <?php for ($i = 0; $i < count($css); $i++) : ?>
        <link rel="stylesheet" href="<?= base_url(); ?>asset/css/<?= $css[$i]; ?>">
    <?php endfor; ?>

    <title>Halaman Admin</title>
</head>

<body>
    <div class="container">