<?php
function errorAlert($customMessage = "")
{
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("¡Ocurrió un error!","' . $customMessage . '","error");';
    echo '}, 100);</script>';
}

function successAlert($customMessage = "")
{
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("¡Ok!","' . $customMessage . '","success");';
    echo '}, 100);</script>';
}

function warningAlert($customMessage = "")
{
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("¡Alerta!","' . $customMessage . '","warning");';
    echo '}, 100);</script>';
}