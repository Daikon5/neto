<?php
session_start();
function isPost() {
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

function login($login,$password) {
    $user = getUser($login);
    if (!$user) {
        return false;
    }
    if ($user["password"] == $password) {
        $_SESSION["user"] = $user;
        return true;
    }
    return false;
}

function getParamPost($name) {
    return isset($_POST["$name"]) ? $_POST["$name"] : null;
}

function getUsers() {
    $jsonData = file_get_contents('users.json');
    $data = json_decode($jsonData,true);
    if (!$data) {
        return [];
    }
    return $data;
}

function getUser($login) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user["login"] == $login) {
            return $user;
        }
    }
    return null;
}

function isAuth() {
    return !empty($_SESSION["user"]);
}

function isAuthAdmin() {
    return !empty($_SESSION["user"]["login"]);
}

function redirect($page) {
    header("Location: $page.php");
    die;
}

function delTest($filename,$testName) {
    $file = file_get_contents($filename);
    $list = json_decode($file);
    foreach ($list as $key => $item) {
        if ($item == $testName) {
            unset ($list[$key]);
            return "Тест $testName удален.";
        }
    }
    return "Ошибка, нет теста с таким именем.";
    file_put_contents($filename,$list);
}