<?php
session_start();

require_once 'dbconfig.php';

$login = NULL;
$password = NULL;
$count = NULL;

if (!empty($_POST)) {
    if (isset($_POST['sign_in'])) {
        $sqlQuery = "SELECT * FROM user WHERE login=? AND password=?";
        $login = strip_tags($_POST['login']);
        $password = strip_tags($_POST['password']);
        try {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = $db->prepare($sqlQuery);
            $query->execute([$login,$password]);
            $result = $query->fetch();
        }
        catch (PDOException $e) {
             echo $e->getMessage();
        }

        if ($login == $result['login'] and $password = $result['password']) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['login'] = $login;
            header('Location: index.php');
        }
        else {
            echo "Неверный логин или пароль!";
        }

    }
    if (isset($_POST['register'])) {
        $login = strip_tags($_POST['login']);
        $password = strip_tags($_POST['password']);
        $sqlQuery = "SELECT * FROM user WHERE login=?";
        try {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = $db->prepare($sqlQuery);
            $query->execute([$login]);
            $result = $query->fetch();
        }
        catch (PDOException $e) {
             echo $e->getMessage();
        }

        if (isset($result['login'])) {
            echo "Увы, этот логин занят";
        }
        else {
            try {
                $sqlQuery = "INSERT INTO user(id, login, password) VALUES (NULL, ?, ?)";
                $db = new PDO("mysql:host=localhost;dbname=neto;charset=utf8",'mysql','mysql');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->prepare($sqlQuery)->execute([$login,$password]);
                echo "Вы успешно зарегистрировались.";
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title>ToDo LogIn</title>
</head>
<body>
<form method="POST">
    <input type="text" name="login" placeholder="Введите логин...">
    <input type="text" name="password" placeholder="и пароль">
    <input type="submit" name="sign_in" value="Войти">
    <input type="submit" name="register" value="Зарегистрироваться">
</form>
</body>
</html>
