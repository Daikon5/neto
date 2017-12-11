<?php
session_start();
$testing = null;
$testid = null;
if (isset($_GET["testid"])) {
    $file = file_get_contents("testlist.json");
    $list = json_decode($file,true);
    $filename = $list[$_GET["testid"]].".json";
    $testEnc = file_get_contents($filename);
    $tests = json_decode($testEnc,true);
    $_SESSION["test"] = $tests;
    $testing = true;
}
elseif (isset($_POST[0])) {
    $tests = $_SESSION["test"];
    foreach ($tests as $key => $test) {
        $num = $key + 1;
        if ($_POST[$key] == $test["answer"]) {
            echo "Ответ на ".$num." вопрос верен."."\n";
        }
        else {
            echo "Ответ на ".$num." вопрос не верен."."\n";
        }
    }
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
    <input type="submit">
<?endif;?>
</form>
<p><a href="/list.php">Список загруженных тестов</a></p>
<p></p><a href="/admin.php">Загрузка тестов</a></p>
</body>
</html>
