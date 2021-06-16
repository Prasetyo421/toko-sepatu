<div class="content">
    <form action="<?= base_url() ?>user/chart" method="POST">
        <input type="hidden" name="id" value="<?= $shoes['id'] ?>">
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <input type="hidden" name="size" value="<?= $size ?>">
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