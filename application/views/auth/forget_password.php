<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>

<body>
    <form action="<?= base_url(); ?>auth/changePassword" method="post">
        <input type="hidden" name="email" value="<?= $_GET['email']; ?>">
        <label for="password1">Password</label>
        <input type="password" name="password1" id="password1">
        <label for="password2">Confirmasi password</label>
        <input type="password" name="password2" id="password2">
        <button type="submit" name="submit">change</button>
    </form>
</body>

</html>