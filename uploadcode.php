<?php
include 'php/database/functions/insert.php';

function upload_files()
{
    if ((!empty($_FILES["excelFile"])) && ($_FILES['excelFile']['error'] == 0)) {
        //get current date
        $mydate = getdate(date("U"));

        //build filename with month and year both numeric
        $filename = "$mydate[mon]$mydate[year].". substr(basename($_FILES['excelFile']['name']), strrpos($_FILES['excelFile']['name'], '.') + 1);
        $fileData = "$mydate[year]-$mydate[mon]-$mydate[mday]";
        //get the file extension
        $ext = substr(basename($filename), strrpos($filename, '.') + 1);

        //init error handler
        $returnValue = "";

        if (!is_dir('uploads\\'.$_SESSION['selected'])) {
            mkdir('uploads\\' . $_SESSION['selected']);
        }



        if (($ext == "xlsx") && ($_FILES["excelFile"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") && ($_FILES["excelFile"]["size"] < 2097152)) {
              //Determine the path to which we want to save this file
            $pathSave = 'uploads\\' . $_SESSION['selected'] . '\\' . $filename;
            // echo $newname;
            //Check if the file with the same name is already exists on the server
           /* if (!file_exists($pathSave)) {*/
                  //Attempt to move the uploaded file to it's new place
            if ((move_uploaded_file($_FILES['excelFile']['tmp_name'], $pathSave))) {
                // echo "It's done! The file has been saved and Uploaded as: ".$newname;
                if (insertInToExcelFileTable($filename, $fileData)) {
                    $returnValue = "Ok";
                } else {
                    unlink($pathSave);
                    $returnValue = "false";
                }
            } else {
                $returnValue = "A problem occurred during file upload!";
            }
            /*} else {
                $returnValue = "File " .  $filename . " already exists";
            }*/
        } else {
            $returnValue = "Only .XLS files under 2mb are accepted for upload";
        }
    } else {
        $returnValue = "No file uploaded";
    }
    return $returnValue;
}
