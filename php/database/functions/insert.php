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

function insertUnidad($nameInput, $nitInput, $porcentajeInteresInput, $bancoRecaudoInput, $mensajeInput){
    $connection = connectionDB();
    
    $sql = "INSERT INTO unidad (nombre, nit, porcentajeInteres, bancoRecaudo, mensaje, status)
    VALUES ('".$nameInput."', '".$nitInput."', '$porcentajeInteresInput', '".$bancoRecaudoInput."', '".$mensajeInput."', 'AC');";
    if ($connection->query($sql) === true) {
        $last_id = $connection->insert_id;
        return  $last_id;
    } else {
        return 0;
    }
}
