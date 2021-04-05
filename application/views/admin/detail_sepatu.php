<div class="content">
    <div class="image-product">
        <div class="thumb-image">
            <?php for ($i = 0; $i < count($sepatu['gambar']['thumb']); $i++) : ?>
                <span></a><img src="<?= base_url(); ?>asset/image/sepatu/thumb/<?= $sepatu['gambar']['thumb'][$i]; ?>" alt="" data-image="<?= $i ?>" data-id="<?= $sepatu['id']; ?>" class="thumb"></span>
            <?php endfor; ?>
        </div>
        <div class="main-image">
            <div class="image-content">
                <?php for ($i = 0; $i < count($sepatu['gambar']['image']); $i++) : ?>
                    <img src="<?= base_url(); ?>asset/image/sepatu/<?= $sepatu['gambar']['image'][$i]; ?>" alt="">
                <?php endfor; ?>
            </div>
        </div>

    </div>

    <div class="info-product">
        <h1><?= $sepatu['nama'] ?></h1>
        <p class="harga">Rp <?= $sepatu['harga'] ?></p>

        <h2>Deskripsi</h2>
        <p class="deskripsi"><?= $sepatu['deskripsi']; ?></p>
        <h2>Spesifikasi</h2>
        <ol>
            <?php foreach ($sepatu['spesifikasi'] as $spec) : ?>
                <li><?= $spec ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>