<div class="content">
    <div class="row1">
        <div class="image-product">
            <div class="thumb-image">
                <?php for ($i = 0; $i < count($shoes['thumb']); $i++) : ?>
                    <span>
                        <img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $shoes['thumb'][$i]['thumb_name']; ?>" data-image="<?= $i ?>" data-id="<?= $shoes['id']; ?>" class="thumb" alt="<?= $shoes['shoes_name'] ?>">
                    </span>
                <?php endfor; ?>
            </div>
            <div class="main-image">
                <div class="image-content">
                    <?php for ($i = 0; $i < count($shoes['images']); $i++) : ?>
                        <img src="<?= base_url(); ?>asset/image/sepatu/<?= $shoes['images'][$i]['image_name']; ?>" alt="<?= $shoes['shoes_name'] ?>">
                    <?php endfor; ?>
                </div>
            </div>

        </div>

        <div class="info-product">
            <h1><?= $shoes['shoes_name'] ?></h1>
            <p class="harga">Rp <?= $shoes['price'] ?></p>

            <h2>Deskripsi</h2>
            <p class="deskripsi"><?= $shoes['description']; ?></p>
            <h2>Spesifikasi</h2>
            <ul>
                <?php foreach ($shoes['specifications'] as $spec) : ?>
                    <li><?= $spec['spec'] ?></li>
                <?php endforeach; ?>
            </ul>
            <form action="<?= base_url(); ?>user/chart" method="POST">
                <div class="sizes">
                    <input type="hidden" name="size" id="size">
                    <?php foreach ($shoes['sizes'] as $size) : ?>
                        <span onclick="setSize(this)" class="size" data-size="<?= $size['size'] ?>"><?= $size['size'] ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="shop">
                    <div class="amount">
                        <!-- <span id="amount"></span> -->
                        <input type="text" name="amount" id="amount">
                        <div class="amount-up" onclick="amountUp()">
                            <i class="fas fa-chevron-up"></i>
                        </div>
                        <div class="amount-down" onclick="amountDown()">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <!-- <input hidden name="amount" value="1"> -->
                    <input hidden name="id" value="<?= $shoes['id'] ?>">
                    <button type="submit" name="btn-shop" id="btn-shop" class="shop-now">Shop Now</button>
                </div>
            </form>
        </div>


    </div>

    <div class="related-product">

        <?php for ($i = 0; $i < count($related); $i++) : ?>
            <a href="<?= base_url(); ?>home/detailSepatu/<?= $related[$i]['id'] ?>" class="related">
                <img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $related[$i]['thumb'][0]['thumb_name'] ?>" alt="<?= $related[$i]['thumb'][0]['thumb_name'] ?>">
                <p><?= $related[$i]['shoes_name'] ?></p>
            </a>
        <?php endfor; ?>
    </div>
</div>