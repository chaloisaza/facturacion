<?php  
session_start();
require_once "php/database/functions/connection.php";

require_once 'php/database/functions/update.php';

if(isset($_POST['id'])) {
    $delete = changeUnidadStatus($_POST['id']);
    $_SESSION["unidadSelected"]->nombre = "";
    return $delete;
    header("Refresh:0");
}

?>


