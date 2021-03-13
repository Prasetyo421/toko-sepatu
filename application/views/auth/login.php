<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/login-page.css">

    <title>Halaman Login</title>
</head>

<body>

    <div class="container">
        <form action="<?= base_url(); ?>auth" method="post">
            <h1>Login Page</h1>
            <?= $this->session->flashdata('message');
            unset($_SESSION['message']); ?>
            <div class="form-grup">
                <input type="text" name="email" id="email" placeholder="email@example" value="<?= set_value('email'); ?>">
                <?= form_error('email', '<small class="color-red">', '</small>') ?>
            </div>
            <div class="form-grup">
                <input type="password" name="password" id="password" placeholder="password">
                <?= form_error('password', '<small class="color-red">', '</small>') ?>
            </div>
            <button type="submit" name="submit">Login</button>
            <a href="<?= base_url(); ?>auth/registration">create an account</a>
            <a href="#">forget password?</a>
        </form>
    </div>


</body>

</html>