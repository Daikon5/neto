<?php
define ('HOST','localhost');
define ('DBNAME','neto');
define ('DBLOGIN','mysql');
define ('DBPASS','mysql');
define ('CHARSET','utf8');

try {
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', HOST, DBNAME);
    $db = new PDO($dsn, DBLOGIN, DBPASS);
}

catch (PDOException $e) {
    echo $e->getMessage();
}