
<?php
if (isset($_POST["fileUpload"])) {
    //$filename=$_FILES["file"]["tmp_name"];
    $excel->read('Book1.xls'); // set the excel file name here   
    $x = 1;
    while ($x <= $excel->sheets[0]['numRows']) { // reading row by row 
        if ($x == 1) {
            echo "\t<thead>\n";
            echo "\t<tr>\n";
            $y = 1;
            while ($y <= $excel->sheets[0]['numCols']) {// reading column by column 
                $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
                echo "\t\t<th>$cell.$x</th>\n";  // get each cells values
                $y++;
            }
            echo "\t</tr>\n";
            echo "\t</thead>\n";
        }
        else {

            echo "\t<tr>\n";
            $y = 1;
            while ($y <= $excel->sheets[0]['numCols']) {// reading column by column 
                $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
                echo "\t\t<td>$cell</td>\n";  // get each cells values
                $y++;
            }
            echo "\t</tr>\n";

        }
        $x++;
    }
    echo "\t</tbody>\n";
}


if (isset($_POST["Import"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "facturacion";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        exit();
    }

    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0)
        {
        $file = fopen($filename, "r");
        $count = 0;
        while ( ($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
            {
            if ($count >= 1) {

                $sql = "INSERT into excel(codigo_factura,nombre,correo,apartamento,cuota_administracion,total_facturado,
                                          administracion_facturado,interes_facturado,otros_conceptos_facturado,fecha_pago_uno,
                                          valor_pago_uno,fecha_pago_dos,valor_pago_dos,fecha_pago_tres,valor_pago_tres,
                                          fecha_pago_cuatro,valor_pago_cuatro,total_pago_periodo,saldo_pendiente,nota_credito,
                                          nota_debito,descripcion_otros_uno,valor_otros_uno,descripcion_otros_dos,valor_otros_dos,
                                          total_sin_interes,observacion) 
                values (' $emapData[0]',' $emapData[1]',' $emapData[2]',' $emapData[3]',' $emapData[4]',' $emapData[5]',
                        ' $emapData[6]',' $emapData[7]', ' $emapData[8]',' $emapData[9]',' $emapData[10]',' $emapData[11]',
                        ' $emapData[12]',' $emapData[13]',' $emapData[14]',' $emapData[15]',' $emapData[16]',' $emapData[17]',
                        ' $emapData[18]',' $emapData[19]',' $emapData[20]',' $emapData[21]',' $emapData[22]',' $emapData[23]',' $emapData[24]',
                        ' $emapData[25]',' $emapData[26]')";
                $conn->query($sql);
            }
            $count++;
        }
        fclose($file);
    }
    $conn->close();
}
?>