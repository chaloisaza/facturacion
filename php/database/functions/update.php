<?php
function disableBill()
{
    $connection = connectionDB();

    $sql = "UPDATE excelfile SET billStatus = 1 where billStatus = 0;";
    $result = $connection->query($sql);
    return $result;
}


function updateUnidadById($id, $nombre, $nit, $porcentajeInteresInput, $bancoRecaudoInput, $mensajeInput){

    $connection = connectionDB();

    $sql = "UPDATE unidad SET  nombre = '$nombre', nit = '$nit', porcentajeInteres = '$porcentajeInteresInput', bancoRecaudo = '$bancoRecaudoInput', mensaje = '$mensajeInput' where id = $id";
    $result = $connection->query($sql);
    
    return $result;

}

function changeUnidadStatus($id){

    $connection = connectionDB();
    
    $sql = "UPDATE unidad SET  status = 'IN' where id = $id";
    $result = $connection->query($sql);
    return $result; 
}