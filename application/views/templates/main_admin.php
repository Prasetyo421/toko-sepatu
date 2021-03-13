<h1>Daftar Sepatu</h1>
<table>
    <tr>
        <th>no</th>
        <th>nama sepatu</th>
        <th>aksi</th>
    </tr>
    <?php for ($i = 0; $i < count($sepatu); $i++) : ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $sepatu[$i]['nama']; ?></td>
            <td class="aksi">
                <a class="btn btn-detail" href="#">detail</a>
                <a class="btn btn-update" href="#">update</a>
                <a class="btn btn-delete" href="#">delete</a>
            </td>
        </tr>
    <?php endfor; ?>
</table>