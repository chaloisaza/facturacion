<?php
function disableBill()
{
    $connection = connectionDB();

    $sql = "UPDATE excelfile SET billStatus = 1 where billStatus = 0;";
    $result = $connection->query($sql);
    return $result;
}