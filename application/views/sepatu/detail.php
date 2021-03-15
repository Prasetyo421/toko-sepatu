<div class="content">
    <div class="image-product">
        <div class="main-image">
            <img src="<?= base_url(); ?>asset/image/sepatu/crop/<?= $sepatu['gambar']->image[0]; ?>" alt="">
        </div>
        <div class="thumb-image">
            <?php foreach ($sepatu['gambar']->thumb as $img) : ?>
                <span><a href="#"></a><img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $img; ?>" alt=""></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="info-product">
        <h2><?= $sepatu['nama'] ?></h2>
        <p>Rp <?= $sepatu['harga'] ?></p>

        <h5>Deskripsi</h5>
        <p><?= $sepatu['deskripsi']; ?></p>
        <h5>Spesifikasi</h5>
        <p><?= $sepatu['spesifikasi']; ?></p>
    </div>
</div>