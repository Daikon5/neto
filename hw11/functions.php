<?php
function myAutoload($className) {
    $pathToFile =  $_SERVER["DOCUMENT_ROOT"] . "\\"
        . str_replace('\\',DIRECTORY_SEPARATOR,$className)
        . ".php";
    if (file_exists($pathToFile)) {
        include "$pathToFile";
    }
}