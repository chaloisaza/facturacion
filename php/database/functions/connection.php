<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */


function connectionDB()
{
    $mysqli = new mysqli("localhost", "root", "Colusa0000!", "facturacion");
    // Check connection
    if ($mysqli === false) {
        die("ERROR: Could not connect. " . $mysqli->connect_error);
    }
 
    // Print host information
    return  $mysqli;
}

function closeDB($connection)
{
    // Close connection
    $connection->close();
}
