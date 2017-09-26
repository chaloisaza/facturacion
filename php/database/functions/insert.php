<?php
require_once "connection.php";
function insertInToExcelFileTable($filePath,$fileData)
{
    $connection = connectionDB();

    $sql = "INSERT INTO excelFile (filePath, uploadDate, unidadId)
    VALUES ('".$filePath."', '".$fileData."', ".(int)$_SESSION['selected'].");";

    if ($connection->query($sql) === true) {
        return true;
    } else {
        return false;
    }
}
