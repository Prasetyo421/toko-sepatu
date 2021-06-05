<div class="content">
    <h1>Daftar Sepatu</h1>
    <?= $this->session->flashdata('message');
    unset($_SESSION['message']); ?>
    <table>
        <tr>
            <th>no</th>
            <th>nama sepatu</th>
            <th>aksi</th>
        </tr>
        <?php for ($i = 0; $i < count($shoes); $i++) : ?>
            <?php if ($i % 2 == 1) : ?>
                <tr style="background-color: antiquewhite;">
                    <td><?= $i + 1 ?></td>
                    <td><?= $shoes[$i]['shoes_name']; ?></td>
                    <td class="aksi">
                        <a class="btn btn-detail" href="<?= base_url() ?>admin/detail/<?= $shoes[$i]['id']; ?>">detail</a>
                        <a class="btn btn-update" href="<?= base_url() ?>admin/update_sepatu/<?= $shoes[$i]['id']; ?>">update</a>
                        <a class="btn btn-delete" href="<?= base_url() ?>admin/delete/<?= $shoes[$i]['id']; ?>" onclick="return confirm('yakin?')">delete</a>
                    </td>
                </tr>
            <?php else : ?>
                <tr style="background-color: #fff;">
                    <td><?= $i + 1 ?></td>
                    <td><?= $shoes[$i]['shoes_name']; ?></td>
                    <td class="aksi">
                        <a class="btn btn-detail" href="<?= base_url() ?>admin/detail/<?= $shoes[$i]['id']; ?>">detail</a>
                        <a class="btn btn-update" href="<?= base_url() ?>admin/update_sepatu/<?= $shoes[$i]['id']; ?>">update</a>
                        <a class="btn btn-delete" href="<?= base_url() ?>admin/delete/<?= $shoes[$i]['id']; ?>" onclick="return confirm('yakin?')">delete</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
    </table>
</div>