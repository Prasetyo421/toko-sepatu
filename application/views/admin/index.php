<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/header-admin.css">

    <title>Halaman Admin</title>
</head>

<body>
    <div class="container">

        <div class="sidebar" id="sidebar">
            <a href="<?= base_url(); ?>sepatu/tambah">tambah data</a>
            <a href="<?= base_url(); ?>auth/logout
            ">logout</a>
        </div>

        <div class="main">
            <div class="top-nav">
                <div class="menu-toggle" id="menu-toggle">
                    <input type="checkbox" id="checkbox-menu-toggle" onclick="checkboxClick()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div class="user-info">
                    <p class="name">Didi Prasetyo</p>
                    <div class="image">
                        <img src="<?= base_url(); ?>asset/img/default.png" alt="">
                    </div>
                </div>
            </div>

            <div class="content">
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
            </div>
        </div>

    </div>

    <script>
        const checkbox = document.getElementById('checkbox-menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');

        function checkboxClick() {
            if (checkbox.checked == true) {
                sidebar.style.width = "200px";
                // sidebar.style.position = "absolute";
            } else {
                sidebar.style.width = "0px";
            }
        }
    </script>
</body>

</html>