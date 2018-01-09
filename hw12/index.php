<?php
$db = mysqli_connect('localhost','mysql','mysql','netology') or die ('Could not connect to DB.');
$sqlCommand = "SELECT * FROM books";
$query = mysqli_query($db,$sqlCommand,MYSQLI_USE_RESULT) or die ("Query proomlems, pal!");

echo "<table border='1'>";
echo "<tr><th>Название</th><th>Автор</th><th>Год выпуска</th><th>Жанр</th><th>ISBN</th></tr>";
while ($tablerows = mysqli_fetch_row($query)) {
    echo "<tr><td>$tablerows[1]</td><td>$tablerows[2]</td><td>$tablerows[3]</td><td>$tablerows[5]</td><td>$tablerows[4]</td></tr>";
}
echo "</table>";
?>