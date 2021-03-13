<!-- <?= base_url() ?> -->
<div class="container">

    <div class="row ms-2 mt-5">
        <div class="col-lg-6">
            <?php if ($this->session->flashdata('flash')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data sepatu <strong>berhasil</strong> <?= $this->session->flashdata('flash') ?>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php $this->session->unset_userdata('flash') ?>
            <?php endif; ?>
            <a href="<?= base_url() ?>/sepatu/tambah" class="btn btn-primary mb-2">Tambah Data Sepatu</a>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="masukan kata kunci">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="btn-cari" id="btn-cari">Cari</button>
                    </div>
                </div>
            </form>
            <h3>Daftar Mahasiswa</h3>
            <ul class="list-group">
                <?php foreach ($sepatu as $s) : ?>
                    <li class="list-group-item">
                        <?= $s['nama'] ?>
                        <a href="<?= base_url() ?>mahasiswa/getUbah/<?= $s['id'] ?>" class="badge bg-warning float-end ms-2">ubah</a>
                        <a href="<?= base_url() ?>mahasiswa/hapus/<?= $s['id'] ?>" onclick="return confirm('yakin?');" class="badge bg-danger float-end ms-2">hapus</a>
                        <a href="<?= base_url() ?>mahasiswa/detail/<?= $s['id'] ?>" class="badge bg-primary float-end">detail</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>