<div class="content">
    <form action="<?= base_url() ?>user/cekOngkir" method="POST">
        <?php foreach ($products as $product) : ?>
            <div class="detail-sepatu">
                <input hidden checked type="checkbox" name="select-item[]" class="check-product" value="<?= $product['id'] ?>">
                <div class="image">
                    <a href="<?= base_url(); ?>home/detailSepatu/<?= $product['id_product']; ?>">
                        <img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $product['thumb'][0]['thumb_name'] ?>" alt="gambar sepatu">
                    </a>
                </div>
                <div class="info">
                    <a class="shoes-name" href="<?= base_url(); ?>home/detailSepatu/<?= $product['id_product']; ?>"><?= $product['shoes_name'] ?></a>
                    <div class="variant"><?= $product['variant']; ?></div>
                    <p class="price"><?= $product['price'] ?></p>
                    <div class="amount"><?= $product['amount']; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        <hr>
        <div class="input-alamat">
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