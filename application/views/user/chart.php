<div class="content">
    <div class="chart">
        <form action="<?= base_url() ?>user/cekOngkir" method="post">
            <?php foreach ($products as $product) : ?>
                <div class="row detail-sepatu ">
                    <input type="checkbox" name="select-item[]" class="check-product" data-price="<?= $product['price'] ?>" data-amount="<?= $product['amount'] ?>" onclick="selectItem(this)" value="<?= $product['id'] ?>">
                    <div class="gambar">
                        <a href="<?= base_url(); ?>home/detailSepatu/<?= $product['id_product']; ?>">
                            <img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $product['thumb'][0]['thumb_name'] ?>" alt="gambar sepatu">
                        </a>
                    </div>
                    <div class="info">
                        <a class="shoes-name" href="<?= base_url(); ?>home/detailSepatu/<?= $product['id_product']; ?>"><?= $product['shoes_name'] ?></a>
                        <select name="variant" class="variant" data-id-product="<?= $product['id_product']; ?>">
                            <?php for ($i = 0; $i < count($product['sizes']); $i++) : ?>
                                <?php if ($product['sizes'][$i]['size']  == $product['variant']) : ?>
                                    <option selected value="<?= $product['sizes'][$i]['size'] ?>"><?= $product['sizes'][$i]['size'] ?></option>
                                <?php else : ?>
                                    <option value="<?= $product['sizes'][$i]['size'] ?>"><?= $product['sizes'][$i]['size'] ?></option>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </select>
                        <p class="price"><?= $product['price'] ?></p>
                        <div class="amount">
                            <input type="hidden" name="amount" value="<?= $product['amount'] ?>">
                            <i class="fas fa-arrow-left" onclick="setAmount(this)" data-id-product="<?= $product['id_product'] ?>" data-operation="minus"></i>
                            <p id="<?= $product['id_product'] ?>"><?= $product['amount'] ?></p>
                            <i class="fas fa-arrow-right" onclick="setAmount(this)" data-id-product="<?= $product['id_product'] ?>" data-operation="plus"></i>
                        </div>

                        <a class="delete-produt" href="<?= base_url() ?>user/hapusProductChart/<?= $product['id_chart'] ?>/<?= $product['id_product'] ?>" onclick="return confirm('yakin?')">hapus</a>
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