<div class="content">
    <div class="row1">
        <div class="col col1">
            <h1>Tambah Data Sepatu</h1>
            <form action="<?= base_url(); ?>admin/tambah_sepatu" method="POST" <?= form_open_multipart('admin/tambah_sepatu'); ?>>
                <?php if ($this->session->flashdata('message')) : ?>
                    <?= $this->session->flashdata('message');
                    unset($_SESSION['message']); ?>
                <?php endif; ?>
                <div class="form-grup">
                    <label for="name-sepatu">Nama Produk</label>
                    <input type="text" name="name-sepatu" id="name-sepatu" value="<?= set_value('name-sepatu'); ?>">
                    <?= form_error('name-sepatu', '<small class="color-red">', '</small>'); ?>
                </div>
                <div class="form-grup">
                    <div class="ukuran">
                        <label for="ukuran">Ukuran</label>
                        <?php for ($i = 0; $i < count($ukuran); $i++) : ?>
                            <input type="checkbox" name="size[]" id="size<?= $i + 1 ?>" value="<?= $ukuran[$i]['size']; ?>">
                            <p><?= $ukuran[$i]['size'] ?></p>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="form-grup">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <!-- <input type="text" name="deskripsi" id="deskripsi" value="<?= set_value('deskripsi'); ?>"> -->
                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"><?= set_value('deskripsi'); ?> </textarea>
                    <?= form_error('deskripsi', '<small class="color-red">', '</small>'); ?>
                </div>
                <div class="form-grup">
                    <label for="spesifikasi">Spesifikasi</label>
                    <div class="table-responsive">
                        <table id="dynamic_field" cellspacing="0">
                            <tr>
                                <td><input type="text" name="spesifikasi[]"></td>
                                <td><button type="button" id="add">add more</button></td>
                            </tr>
                        </table>
                    </div>
                    <?= form_error('spesifikasi', '<small class="color-red">', '</small>'); ?>
                </div>
                <div class="form-grup">
                    <label for="price">Harga</label>
                    <input type="text" name="price" id="price" value="<?= set_value('price'); ?>">
                    <?= form_error('price', '<small class="color-red">', '</small>'); ?>
                </div>
                <div class="form-grup">
                    <label for="image">Gambar</label>
                    <input type="file" name="image[]" id="image" class="image" multiple>
                </div>
                <button type="submit" name="submit" id="submit">Tambah Data</button>
            </form>

        </div>
        <div class="col col2">
            <h2>image preview</h2>
            <div id="image-preview">

            </div>
        </div>

    </div>
</div>