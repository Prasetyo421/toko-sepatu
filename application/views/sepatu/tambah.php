<!-- nama barang
harga
ukuran
deskripsi
spesifikasi
gambar -->

<?php

// var_dump(json_encode($ukuran));
// var_dump($ukuran);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/tambah-sepatu.css">

    <title>Halaman Tambah Data</title>
</head>

<body>
    <div class="container">
        <form action="">
            <label for="name-product">Nama Produk</label>
            <input type="text" name="name-product" id="name-product">
            <label for="ukuran">Ukuran</label>
            <input type="text" name="ukuran" id="ukuran">
            <label for="deskripsi">Deskripsi Produk</label>
            <input type="text" name="deskripsi" id="deskripsi">
            <label for="spesifikasi">Spesifikasi</label>
            <input type="text" name="spesifikasi" id="spesifikasi">
            <label for="image">Gambar</label>
            <input type="text" name="image" id="image">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </form>
    </div>
</body>

</html>