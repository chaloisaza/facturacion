<?php
function billMonth()
{
    //load last file
    $objExcel = loadExcel();

    //create html bils
    $bills = createBills($objExcel);

    //create PDF
    $pdfBill = createPDF($bills);
   
}

function createBills($objExcel)
{
    //init vars
    $excelObject = "";
    $excelObjectArray = array();

    $inputFileName = 'uploads//' . $objExcel->unidadId . "//" . $objExcel->filePath ;
    
        //open excel file
        $excelReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
        $excelObj = $excelReader->load($inputFileName);
        $worksheet = $excelObj->getActiveSheet();
        $lastRow = $worksheet->getHighestRow();
        $row = 1;
        $lastColumn = $worksheet->getHighestColumn();
        $lastColumn++;
    
    
    for ($row = 1; $row <= $lastRow; $row++) {
        $table .= "<table class='tableDecoration'><tr>";
        for ($column = 'A'; $column != $lastColumn; $column++) {
            $cell = $worksheet->getCell($column . $row);
            if ($cell->getDataType() == "n" && $column != "A" && $column != "D" && $column != "F" && $column != "T") {
                $table .= "<td style='text-align: center !important;font-size: 11px !important;'>";
                $table .= formatcurrency($cell->getValue(), "COP");
            } elseif ($cell->getDataType() == "n" && ($column == "F" || $column == "T")) {
                $table .= "<td style='font-weight: bolder !important;font-size: 12px !important;text-align: center !important;'>";
                $table .= formatcurrency($cell->getValue(), "COP");
            } else {
                $table .= "<td>";
                $table .= $cell->getValue();
            }
            $table .= "</td>";
        }
        $table .= "</tr></table>";
        array_push($tableArray, $table);
        $table = "";
    }
        echo $tableArray;
        return $tableArray;
}


function createPDF($bills){

} 
