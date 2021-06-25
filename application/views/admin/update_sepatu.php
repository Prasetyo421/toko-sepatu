<div class="content">

    <div class="row">
        <h1>Update Data Sepatu</h1>
        <form action="<?= base_url() ?>admin/update_sepatu/<?= $shoes['id']; ?>" method="post" <?= form_open_multipart('admin/update') ?>>
            <div class="form-grup">
                <label for="name-sepatu">Nama Produk</label>
                <input type="text" name="name-sepatu" id="name-sepatu" value="<?= $shoes['shoes_name']; ?>">
                <?= form_error('name-sepatu', '<small class="color-red">', '</small>'); ?>
            </div>
            <div class="form-grup">
                <div class="ukuran">
                    <label for="ukuran">Ukuran</label>
                    <?php for ($i = 0; $i < count($sizes); $i++) : ?>

                        <?php if (in_array($sizes[$i], $shoes['sizes'])) : ?>
                            <input type="checkbox" name="size[]" id="size<?= $i + 1 ?>" value="<?= $sizes[$i]; ?>" checked>
                            <p><?= $sizes[$i] ?></p>
                        <?php else : ?>
                            <input type="checkbox" name="size[]" id="size<?= $i + 1 ?>" value="<?= $sizes[$i]; ?>">
                            <p><?= $sizes[$i] ?></p>
                        <?php endif; ?>

                    <?php endfor; ?>
                </div>
            </div>
            <div class="form-grup">
                <label for="deskripsi">Deskripsi Produk</label>
                <input type="text" name="deskripsi" id="deskripsi" value="<?= $shoes['description'] ?>">
                <?= form_error('deskripsi', '<small class="color-red">', '</small>'); ?>
            </div>
            <div class="form-grup">
                <label for="spesifikasi">Spesifikasi</label>
                <table id="dynamic_field">
                    <tr id="row0">
                        <td><input type="text" name="spesifikasi[]" value="<?= $shoes['specifications'][0]['spec'] ?>"></td>
                        <td><button type="button" id="add">add more</button></td>
                    </tr>
                    <?php for ($i = 1; $i < count($shoes['specifications']); $i++) : ?>
                        <tr id="row<?= $i ?>">
                            <td><input type="text" name="spesifikasi[]" value="<?= $shoes['specifications'][$i]['spec'] ?>"></td>
                            <td><button type="button" id="<?= $i ?>" class="btn_remove">remove</button></td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
            <?= form_error('spesifikasi', '<small class="color-red">', '</small>'); ?>
            <div class="form-grup">
                <label for="price">Harga</label>
                <input type="text" name="price" id="price" value="<?= $shoes['price'] ?>">
                <?= form_error('price', '<small class="color-red">', '</small>'); ?>
            </div>
            <div class="preview-image">
                <?php foreach ($shoes['images'] as $img) : ?>
                    <img src="<?= base_url() ?>asset/image/sepatu/<?= $img['image_name'] ?>" alt="">
                <?php endforeach; ?>
            </div>
            <div class="form-grup">
                <label for="image">Gambar</label>
                <input type="file" name="image[]" id="image" class="image" multiple>
            </div>
            <div id="image-preview" class="preview-image">
            </div>

            <button type="submit" name="submit" id="submit">Update Data</button>
        </form>
    </div>

</div>