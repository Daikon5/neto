<?php
$isbn = NULL;
$name = NULL;
$author = NULL;
$i = NULL;
$c = 1;
$sqlCommand = "SELECT * FROM books";
if (!empty($_GET)) {
    $sqlCommand .= " WHERE";
    $i = count($_GET);
    foreach ($_GET as $key => $item) {
        $sqlCommand .= " $key LIKE '%$item%'";
        if ($c < $i) {
            $sqlCommand .= " AND";
        }
        $c++;
    }
}
?>

    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <link href="" rel="stylesheet" type="text/css">
        <title>Каталог</title>
    </head>
    <body>
    <h1>Каталог:</h1>
    <form method="get">
        <input type="text" name="isbn" placeholder="ISBN" value="<?php if (isset($_GET['isbn'])) {echo $_GET['isbn'];} ?>">
        <input type="text" name="name" placeholder="Название книги" value="<?php if (isset($_GET['name'])) {echo $_GET['name'];} ?>">
        <input type="text" name="author" placeholder="Автор книги" value="<?php if (isset($_GET['author'])) {echo $_GET['author'];} ?>">
        <input type="submit" value="Поиск">
    </form><br><br>

<?php
$db = new mysqli('localhost','mysql','mysql','netology');
$db->set_charset('utf-8');
$query = $db->query($sqlCommand,MYSQLI_USE_RESULT) or die ("Query problems, pal!");

echo "<table border='1'>";
echo "<tr><th>Название</th><th>Автор</th><th>Год выпуска</th><th>Жанр</th><th>ISBN</th></tr>";
while ($tablerows = $query->fetch_row()) {
    echo "<tr><td>$tablerows[1]</td><td>$tablerows[2]</td><td>$tablerows[3]</td><td>$tablerows[5]</td><td>$tablerows[4]</td></tr>";
}
echo "</table>";
?>

    </body>
    </html>
