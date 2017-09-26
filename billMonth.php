<?php
function billMonth()
{
    //load last two files
    $objExcels = loadLastTwoExcels();
    $Array = array();
    foreach ($objExcels as $excel => $value) {
        //read file and return values as two dimension array
        array_push($Array, calculateBill($value));
        sort($Array);
    }



    foreach ($Array as $array => $value) {
        $billFormats = buildBill($value);
    }

    return $billFormats;
    //calculateBill
    //$ultimate = calculateBill($objExcel->filePath);
    //$penultimate = calculateBill($objExcel->filePath);

    /*$total = calcularTotal();
    $interesPendiente = calcularInteresPendiente();
    $valorPendiente = calcularValorPendiente();
    $administracionApagar = calcularAdministracionApagar();
    $interesApagarPorMora = calcularInteresApagarPorMora();
    $administracionPendiente = calcularAdministracionPendiente();
    $totalIntereses = calcularTotalIntereses();
    $otrosConceptos = calcularOtrosConceptos();*/

}


function calculateBill($path)
{
    $inputFileName = 'uploads//' . $path;
    $serverPath = getcwd();
    $fullFilePath = $serverPath . $inputFileName;

    $excelReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
    $excelObj = $excelReader->load($inputFileName);
    $worksheet = $excelObj->getActiveSheet();
    $lastRow = $worksheet->getHighestRow();
    $row = 1;
    $lastColumn = $worksheet->getHighestColumn();
    $lastColumn++;


    $parentArray = array();
    for ($row = 1; $row <= $lastRow; $row++) {
        if ($row > 1) {
            $chidlArray = array();
        }
        else {
            $fieldsArra = array();
        }

        for ($column = 'A'; $column != $lastColumn; $column++) {
            $cell = $worksheet->getCell($column . $row);
            if ($row > 1) {
                array_push($chidlArray, $cell->getValue() != null ? $cell->getValue() : "");
            }
            else {
                array_push($fieldsArra, $cell->getValue());
            }

        }
        if ($row > 1) {
            $resultMerge = array_combine($fieldsArra, $chidlArray);
            array_push($parentArray, $resultMerge);
            unset($chidlArray);
        }
    }
    return $parentArray;
}