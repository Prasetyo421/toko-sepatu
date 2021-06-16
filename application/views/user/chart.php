<div class="content">
    <div class="chart">
        <form action="<?= base_url() ?>user/cekOngkir" method="post">
            <?php foreach ($products as $product) : ?>
                <div class="row detail-sepatu">
                    <input type="checkbox" name="select-item" data-price="<?= $product['price'] ?>" data-amount="<?= $product['amount'] ?>" onclick="selectItem(this)">
                    <div class="gambar">
                        <img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $product['thumb'][0]['thumb_name'] ?>" alt="gambar sepatu">
                    </div>
                    <div class="info">
                        <p><?= $product['shoes_name'] ?></p>
                        <p><?= $product['variant'] ?></p>
                        <p><?= $product['price'] ?></p>
                        <p><?= $product['amount'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="info-checkout">
                <div class="quantity-total-price">
                    <div class="quantity-roduct">Total (0 produk):</div>
                    <div class="total-price">0</div>
                </div>
                <button type="submit" class="btn-checkout">checkout</button>
            </div>
        </form>
    </div>
</div>