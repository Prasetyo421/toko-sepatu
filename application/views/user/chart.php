<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/<?= $css ?>">
    <title>Chart</title>
</head>

<body>
    <div class="container">
        <div class="row detail-sepatu">
            <div class="gambar">
                <img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $shoes['thumb'][0]['thumb_name'] ?>" alt="gambar sepatu">
            </div>
            <div class="info">
                <p><?= $shoes['shoes_name'] ?></p>
                <p><?= $size ?></p>
                <p><?= $shoes['price'] ?></p>
                <p><?= $amount ?></p>
            </div>
        </div>
        <form action="<?= base_url() ?>user/chart" method="POST">
            <div class="row">
                <p>Kota Asal</p>
                <div class="kota-asal">
                    <input type="hidden" name="id-kota-asal" id="id-kota-asal">
                    <?php if (isset($costs)) : ?>
                        <input type="text" name="kota-asal" id="input-kota-asal" class="input-kota" value="<?= $namaKotaAsal ?>">
                    <?php else : ?>
                        <input type="text" name="kota-asal" id="input-kota-asal" class="input-kota">
                    <?php endif; ?>
                </div>
                <?php if (!isset($costs)) : ?>
                    <div class="daftar-kota-asal">
                        <?php for ($i = 0; $i < 10; $i++) : ?>
                            <div class="asal-kota" id="<?= $citys[$i]['city_id'] ?>" data-index="<?= $i ?>" onclick="pilihKotaAsal(this)">
                                <h3><?= $citys[$i]['province']; ?></h3>
                                <p><?= $citys[$i]['city_name']; ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <p>Kota Tujuan</p>
                <div class="kota-tujuan">
                    <input type="hidden" name="id-kota-tujuan" id="id-kota-tujuan">
                    <?php if (isset($costs)) : ?>
                        <input type="text" name="kota-tujuan" id="input-kota-tujuan" class="input-kota" value="<?= $namaKotaTujuan ?>">
                    <?php else : ?>
                        <input type="text" name="kota-tujuan" id="input-kota-tujuan" class="input-kota">
                    <?php endif; ?>
                </div>
                <?php if (!isset($costs)) : ?>
                    <div class="daftar-kota-tujuan">
                        <?php for ($i = 0; $i < 10; $i++) : ?>
                            <div class="tujuan-kota" id="<?= $citys[$i]['city_id'] ?>" data-index="<?= $i ?>" onclick="pilihKotaTujuan(this)">
                                <h3><?= $citys[$i]['province']; ?></h3>
                                <p><?= $citys[$i]['city_name']; ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <button type="submit" name="cek-ongkir" class="cek-ongkir">cek biaya ongkir</button>
            </div>
            <div class="row">
                <p>Harga ongkos kirim /1kg</p>
            </div>
        </form>
        <?php if (isset($costs)) : ?>
            <?php for ($i = 0; $i < count($costs); $i++) : ?>
                <?php foreach ($costs[$i]['costs'] as $cost) : ?>
                    <h2>kurir : <?= strtoupper($costs[$i]['code']) ?></h2>
                    <p>tipe : <?= $cost['service'] ?></p>
                    <p>biaya : <?= $cost['cost'][0]['value'] ?></p>
                    <p>estimasi : <?= $cost['cost'][0]['etd'] ?> hari</p>
                <?php endforeach; ?>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    const citys = <?= json_encode($citys) ?>;
</script>
<script src="<?= base_url(); ?>asset/js/<?= $js ?>"></script>

</html>