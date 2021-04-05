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
        <form class="form-login" action="<?= base_url(); ?>auth" method="post">
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
            <a id="forget" href="#form-forget-password">forget password?</a>
        </form>
        <div id="form-forget-password">
            <span class="close">
                <p>X</p>
            </span>
            <form action="<?= base_url() ?>auth/forgetPassowrd" method="POST">
                <div class="form-grup">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
                </div>
                <button type="submit" name="forget">send</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>asset/js/login.js"></script>
</body>

</html>