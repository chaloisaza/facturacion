<?php
require_once "connection.php";
function loadExcel()
{
    $connection = connectionDB();

    $sql = "SELECT * FROM excelfile  WHERE unidadId = " . (int)$_SESSION["selected"] . " ORDER BY id DESC LIMIT 1";
    $result = $connection->query($sql);
    $obj = $result->fetch_object();
    if (!$obj) {
        return null;
    } else {
        return $obj;
    }
}

function loadLastTwoExcels()
{
    $connection = connectionDB();

    $sql = "SELECT filePath FROM excelfile ORDER BY id DESC LIMIT 2";
    $result = $connection->query($sql);
    $obj = $result->fetch_array();
    if (!$obj) {
        return null;
    } else {
        return $obj;
    }
}


function loadExcelByDate($year, $month)
{
    $connection = connectionDB();

    $sql = "SELECT * FROM excelfile WHERE MONTH(uploadDate) = " . $month . " and  YEAR(uploadDate) =" . $year ."&& unidadId = " . (int)$_SESSION["selected"];
    $result = $connection->query($sql);
    $obj = $result->fetch_object();
    if (!$obj) {
        return null;
    } else {
        return $obj;
    }
}

function loadUnidades()
{
    $connection = connectionDB();

    $sql = "SELECT * FROM unidad WHERE status = 'AC' ORDER BY id ASC";
    $result = $connection->query($sql);
    $obj[] = array();

    while ($entry = $result->fetch_object()) {
        $obj[] = $entry;
    }

    if (count($obj) == 1) {
        return null;
    } else {
        return $obj;
    }
}

function loadUnidadById($id){
    $connection = connectionDB();
    $sql = "SELECT * FROM unidad WHERE id = $id AND status = 'AC'";
    $result = $connection->query($sql);
    $obj = $result->fetch_object();

    while ($entry = $result->fetch_object()) {
        $obj[] = $entry;
    }

    if (!$obj) {
        return null;
    } else {
        return $obj;
    }
}
