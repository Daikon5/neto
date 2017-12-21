<?php
require_once "functions.php";
$errors = [];
if (isPost()) {
    if (!empty($_POST["name"])) {
        $_SESSION["user"]["username"] = $_POST["name"];
        redirect("list");
    }
}
if (isPost()) {
    if (login(getParamPost('login'),getParamPost('password'))) {
        redirect('list');
    }
    $errors[] = "Неверный логин или пароль";
}
?>




<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title>Представьтесь.</title>
</head>
<body>
<ul>
<?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
<?php endforeach; ?>
</ul>
    <form method="post">
        <p>Введите логин и пароль для администрирования. (admin:admin)</p>
        <input type="text" name="login" placeholder="Login"><br/><br/>
        <input type="text" name="password" placeholder="Password"><br/>
        <p>Либо представьтесь для гостевого доступа.</p>
        <input type="text" name="name" placeholder="Ваше имя"><br/><br/>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>