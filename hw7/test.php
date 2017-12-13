<?php
session_start();
$testing = null;
$testid = null;
if (isset($_GET["testid"])) {
    $file = file_get_contents("testlist.json");
    $list = json_decode($file,true);
    $listCount = count($list);
    if ($_GET["testid"] >= $listCount || $_GET["testid"] < 0) {
        http_response_code(404);
        echo "<p style='color:red;'>Неверный id теста!</p>";
        exit;
    }
    $filename = $list[$_GET["testid"]].".json";
    $testEnc = file_get_contents($filename);
    $tests = json_decode($testEnc,true);
    $_SESSION["test"] = $tests;
    $testing = true;
}
elseif (isset($_POST[0])) {
    $name = $_POST["name"];
    $tests = $_SESSION["test"];
    $qCount = 0;
    $ansCount = 0;
    foreach ($tests as $key => $test) {
        $qCount++;
        if ($_POST[$key] == $test["answer"]) {
            $ansCount++;
        }
    }
    $firstLine = "Поздравляем, $name!";
    $secondLine = "Вы дали $ansCount правильных ответов из $qCount.";
    $_SESSION["lines"][0] = $firstLine;
    $_SESSION["lines"][1] = $secondLine;
    echo "<img src='/cert.php'>";
}
else  {
    echo "Похоже вы попали сюда по ошибке, вернитесь к выбору или загрузке теста.";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title>Отвечай!</title>
</head>
<body>
<?if ($testing == true):?>
<?foreach ($tests as $key => $test):?>
<form method="post" action="/test.php">
    <p><?=$test["q"];?></p>
    <input type="radio" name="<?=$key;?>" value="var1"><?=$test["var1"];?><br>
    <input type="radio" name="<?=$key;?>" value="var2"><?=$test["var2"];?><br>
    <input type="radio" name="<?=$key;?>" value="var3"><?=$test["var3"];?><br>
    <input type="radio" name="<?=$key;?>" value="var4"><?=$test["var4"];?><br>
<?endforeach;?>
    <input type="text" name="name" placeholder="Ваше имя">
    <input type="submit">
<?endif;?>
</form>
<p><a href="/list.php">Список загруженных тестов</a></p>
<p></p><a href="/admin.php">Загрузка тестов</a></p>
</body>
</html>
