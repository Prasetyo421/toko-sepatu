<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/registration-page.css">

    <title>Halaman Registrasi</title>
</head>

<body>
    <div class="container">
        <form action="<?= base_url(); ?>auth/registration" method="post">
            <h1>Create an Account</h1>
            <div class="form-grup">
                <input type="text" name="name" id="name" placeholder="nama pengguna" value="<?= set_value('name'); ?>">
                <?= form_error('name', '<small class="color-red">', '</small>'); ?>
            </div>
            <div class="form-grup">
                <input type="text" name="email" id="email" placeholder="email@example" value="<?= set_value('email'); ?>">
                <?= form_error('email', '<small class="color-red">', '</small>'); ?>
            </div>
            <div class="password">
                <div class="form-grup">
                    <input type="password" name="password1" id="password1" placeholder="password">
                    <?= form_error('password1', '<small class="color-red">', '</small>'); ?>
                </div>
                <div class="form-grup">
                    <input type="password" name="password2" id="password2" placeholder="repeat password">
                </div>
            </div>
            <button type="submit" name="submit">Registrasi</button>
            <a href="<?= base_url(); ?>auth">Already have an account</a>
            <a href="#">forget password?</a>
        </form>
    </div>

</body>

</html>