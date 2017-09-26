<?php
// include 'config.php'
include 'uploadcode.php';

if (isset($_POST['upload_file']))
    {
    $user_file = $_FILES["car_info_file"]["name"];
    upload_files($_FILES["car_info_file"]["name"]);

}

?>
<body>
<form name="uploadfile" action="" method="post" enctype="multipart/form-data">
<div class="upload-box">
    <div style='border-left-width:0px;border-right-width:0px;border-top-width:0px;border-bottom-width:1px;border-color:#C0C0C0;border-style: solid; background-color:#669900;text-align:center; width:'>
        <a href="#">Upload File </a></div>
    </div>
    <div>
        <table class="bodyBg" bgcolor="#333333">
            <tr>
                <td width="94" align><span class="style1">Upload Your Display </span></td>
                  <td width="246"><input type="file" name="car_info_file" id="car_info_file" style="height: 19px; width:100px; font-size:87%;"/></td>
            </tr>
            <tr>
                  <td colspan="2" align><input type="submit" name="upload_file" value="Upload" /></td>
              </tr>
        </table>
    </div>
</div>
</form>
</body>

<div class="content-box-large">
                    <div class="panel-heading">
                        <div class="panel-title"></div>
                    </div>
                    <div class="panel-body">
                    <?php
                    function printExcel($the_url)
                    {
                        echo "hola";
                        echo '<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">';

                        $excel->read(".$the_url."); // set the excel file name here
                        $x = 1;
                        while ($x <= $excel->sheets[0]['numRows']) { // reading row by row
                            if ($x == 1) {
                                echo "\t<thead>\n";
                                echo "\t<tr>\n";
                                $y = 1;
                                while ($y <= $excel->sheets[0]['numCols']) {// reading column by column
                                    $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
                                    echo "\t\t<th>$cell</th>\n";  // get each cells values
                                    $y++;
                                }
                                echo "\t</tr>\n";
                                echo "\t</thead>\n";
                            }
                            else {
                                if ($x & 1) {
                                    echo "\t<tr class='even'>\n";
                                }
                                else {
                                    echo "\t<tr class='odd'>\n";
                                }
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
                        echo '</table>';
                    }
                    if (isset($_POST['the_url'])) {
                        echo printExcel($_POST['the_url']);
                    }

                             //Check valid spreadsheet has been uploaded
                    if (isset($_FILES['spreadsheet'])) {
                        if ($_FILES['spreadsheet']['tmp_name']) {
                            if (!$_FILES['spreadsheet']['error']) {
                                $inputFile = $_FILES['spreadsheet']['tmp_name'];
                                $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
                                if ($extension == 'XLSX' || $extension == 'ODS') {
                                    //Read spreadsheeet workbook
                                    try {
                                        $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                        $objPHPExcel = $objReader->load($inputFile);
                                    } catch (Exception $e) {
                                        die($e->getMessage());
                                    }
                                    
                                    //Get worksheet dimensions
                                    $sheet = $objPHPExcel->getSheet(0);
                                    $highestRow = $sheet->getHighestRow();
                                    $highestColumn = $sheet->getHighestColumn();
                                    
                                    //Loop through each row of the worksheet in turn
                                    for ($row = 1; $row <= $highestRow; $row++) {
                                                //  Read a row of data into an array
                                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                                                //Insert into database



                                    }
                                }
                                else {
                                    echo "Please upload an XLSX or ODS file";
                                }
                            }
                            else {
                                echo $_FILES['spreadsheet']['error'];
                            }
                        }
                    }


                    ?>    

                        
                    </div>
                </div>

