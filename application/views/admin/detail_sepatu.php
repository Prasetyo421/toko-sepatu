<div class="content">
    <div class="image-product">
        <div class="thumb-image">
            <?php for ($i = 0; $i < count($shoes['thumb']); $i++) : ?>
                <span></a><img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $shoes['thumb'][$i]['thumb_name']; ?>" alt="<?= $shoes['thumb'][$i]['thumb_name']; ?>" data-image="<?= $i ?>" data-id="<?= $shoes['id']; ?>" class="thumb"></span>
            <?php endfor; ?>
        </div>
        <div class="main-image">
            <div class="image-content">
                <?php for ($i = 0; $i < count($shoes['images']); $i++) : ?>
                    <img src="<?= base_url(); ?>asset/image/sepatu/<?= $shoes['images'][$i]['image_name']; ?>" alt="<?= $shoes['images'][$i]['image_name']; ?>">
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
        <ol>
            <?php foreach ($shoes['specifications'] as $spec) : ?>
                <li><?= $spec['spec'] ?></li>
            <?php endforeach; ?>
        </ol>
        <ol>
            <?php foreach ($shoes['sizes'] as $size) : ?>
                <li><?= $size['size'] ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>