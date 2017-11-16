<?php
require 'php/TCPDF/tcpdf.php';
require 'sendEmail.php';
include 'php/database/functions/select.php';
function buildBill($bills)
{
    //traer la informacion de la unidad o enviarla desde billMonth para no hacer varios llamados OJO

    $billPerApartament = "";
    $html = "";
    //$pdf = new TCPDF();
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    /* $pdf->SetCreator('Germán');
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 021');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/

    // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 021', PDF_HEADER_STRING);

    // set header and footer fonts
        /*$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));*/

    // set default monospaced font
        //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
        /*$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);*/

    // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
        //$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    /* if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }*/

    // ---------------------------------------------------------

    //datos de unidad
    $unidad = loadUnidadById(intval($_SESSION['selected']));

    // set font
    $pdf->SetFont('helvetica', '', 9);

    //set class var
    $fullBorder = "border:1px solid #5656ff;";
    $dashedRightBorder = "border-left-style:solid;border-top-style:solid;border-right-style:dashed;border-bottom-style:solid;border-color: #5656ff;";
    $dashedLeftBorder = "border-left-style:dashed;border-top-style:solid;border-right-style:solid;border-bottom-style:solid;border-color: #5656ff;";
    $nonLeftBorder = "border-left-style:none;border-top-style:solid;border-right-style:solid;border-bottom-style:solid;border-color: #5656ff;";
    $solidRightBorder = "border-right-style:solid;border-color: #5656ff;";

    // create some HTML content
    $count = 0;
    foreach ($bills as $bill => $value) {

    if(count($value) > 0){
    //if($count == 1){

            $arrayCalculo = hacerCalculos($value,$unidad); 
            // add a page
            $pdf->AddPage('L', 'LETTER');

            $html = '
            <table style="" cellpadding="2" sytle="border-color:#2536ff">
                <tr nobr="true">
                    <td style="' . $fullBorder . '" rowspan="3">Imagen de la unidad1</td>
                    <td style="' . $dashedRightBorder . '" colspan="2"><span style="color:#2536ff" >NOMBRE:</span> ' . $value[1] . '</td>
                    <td style="' . $dashedLeftBorder . 'text-align:center;"><span style="color:#2536ff" >UNIDAD O CONJUNTO</span></td>
                </tr>
                <tr nobr="true">
                    <td style="' . $dashedLeftBorder . '"><span style="color:#2536ff" >CUENTA DE COBRO </span>' . $value[0] . ' </td>
                    <td style="' . $dashedRightBorder . '"><span style="color:#2536ff" >REFERENCIA:</span> ' . $value[3] . '</td>
                    <td style="' . $dashedLeftBorder . 'text-align:center;">Modelo</td>
                </tr>
                <tr nobr="true" >
                    <td style="' . $dashedRightBorder . '" colspan="2"><span style="color:#2536ff" >PERIODO:</span> '. getActualDate() . '</td>  
                    <td style="' . $dashedLeftBorder . 'text-align:center"><span style="color:#2536ff" >NOMBRE</span></td>      
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . '"><span style="color:#2536ff" >NIT: </span>'.$unidad->nit.'</td>
                    <td style="' . $fullBorder . 'text-align:center"><span style="color:#2536ff">BANCO/CORPORACION</span> <br>' . $value[11] . '</td>
                    <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff;text-align:center">CUENTA RECAUDO</span> <br>'. $unidad->tipoCuenta .' : '.$unidad->numeroCuentaRecudao .'</td>
                    <td style="' . $dashedLeftBorder . 'text-align:center">' . $value[1] . '</td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . 'background-color:#e5ebf7;text-align:center"><span style="color:#2536ff" >FACTURA ANTERIOR:</span> <br>$ '.formatcurrency(intval($value[12]), "COP").'</td>
                    <td style="' . $fullBorder . 'background-color:#e5ebf7;text-align:center"><span style="color:#2536ff" >PAGO REALIZADO:</span> <br>$ ' . formatcurrency(intval($value[9]), "COP") . '</td>
                    <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff" >SALDO PENDIENTE</span><br />$ ' . formatcurrency($arrayCalculo[3], "COP") . '</td>
                    <td style="' . $dashedLeftBorder . '">
                        <table>
                            <tr nobr="true">
                                <td><span style="color:#2536ff">CUENTA DE COBRO</span></td>
                                <td>' . $value[0] . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . 'text-align:center"><span style="color:#2536ff">CUOTA ADMINISTRACIÓN</span><br />$ ' . formatcurrency(intval($value[4]), "COP") . '</td>
                    <td style="' . $fullBorder . 'text-align:center"><span style="color:#2536ff">INTERÉS DE MORA</span><br />$ ' . formatcurrency(($arrayCalculo[18]), "COP") .'</td>
                    <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff">PAGAR SIN OTROS</span><br />$ ' . formatcurrency(intval($arrayCalculo[6]), "COP") . '</td>
                    <td style="' . $dashedLeftBorder . '">
                        <table>
                            <tr nobr="true">
                                <td style="color:#2536ff">REFERENCIA</td>
                                <td style="background-color:#e5ebf7;">' . $value[3] . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . 'text-align:center;background-color:#e5ebf7" colspan="2"><span style="color:#2536ff">OTROS CONCEPTOS</span></td>
                    <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff">CUENTAS VENCIDAS</span></td>
                    <td style="' . $dashedLeftBorder . 'text-align:center">PERIODO</td>
                </tr>
                    <tr nobr="true">
                    <td style="' . $fullBorder . 'text-align:left;background-color:#e5ebf7"><span style="color:#2536ff">CONCEPTO</span></td>
                    <td style="' . $fullBorder . 'text-align:rigth;background-color:#e5ebf7"><span style="color:#2536ff">VALOR</span></td>
                    <td style="' . $dashedRightBorder . 'text-align:center">¿?</td>
                    <td style="' . $dashedLeftBorder . 'text-align:center">'.getActualDate().'</td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . '">NOTA CRÉDITO</td>
                    <td style="' . $fullBorder . 'text-align:rigth">$ '. formatcurrency(intval($arrayCalculo[16])* -1, "COP")  .'</td>
                    <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff">PÁGUESE SIN RECARGO</span></td>
                    <td style="' . $dashedLeftBorder . 'text-align:center"><span style="color:#2536ff">BANCO</span></td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . '">NOTA DÉBITO</td>
                    <td style="text' . $fullBorder . 'text-align:rigth">$ '. formatcurrency(intval($arrayCalculo[17]), "COP").'</td>
                    <td style="' . $dashedRightBorder . '">
                        <table>
                            <tr nobr="true">
                                <td><span style="color:#2536ff">D </span>'.date("t", strtotime("last day of +1 month",strtotime('m'))).'</td>
                                <td><span style="color:#2536ff">M </span>'.date("m",strtotime("last day of +1 month",strtotime('m')))  .'</td>
                                <td><span style="color:#2536ff">Y </span>'.date('Y').'</td>
                            </tr>
                        </table>
                    </td>
                    <td style="' . $dashedLeftBorder . 'text-align:center">' . $value[11] . '</td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . '">'.$arrayCalculo[7].'</td>
                    <td style="' . $fullBorder . 'text-align:rigth">'.formatcurrency(intval($arrayCalculo[8]), "COP").'</td>
                    <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff">PÁGUESE CON RECARGO</span></td>
                    <td style="' . $dashedLeftBorder . 'text-align:center"><span style="color:#2536ff">CUENTA RECAUDO</span></td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . '">'.$arrayCalculo[9].'</td>
                    <td style="' . $fullBorder . 'text-align:rigth">'.formatcurrency(intval($arrayCalculo[10]), "COP").'</td>
                    <td style="' . $dashedRightBorder . '">
                        <table>
                            <tr nobr="true">
                                <td><span style="color:#2536ff">D</span></td>
                                <td><span style="color:#2536ff">M</span></td>
                                <td><span style="color:#2536ff">A</span></td>
                            </tr>
                        </table>
                    </td>
                    <td style="' . $dashedLeftBorder . 'text-align:center">AHORROS: 888888888</td>
                </tr>
                <tr nobr="true">
                    <td style="' . $fullBorder . 'text-align:rigth"><span style="color:#2536ff">TOTAL A PAGAR</span></td>
                    <td style="' . $fullBorder . 'text-align:rigth;background-color:#e5ebf8">$ '. formatcurrency(intval($arrayCalculo[12]), "COP") .'</td>
                    <td style=""></td>
                    <td style="' . $dashedLeftBorder . '">
                        <table>
                            <tr nobr="true">
                                <td style="text-align:rigth">TOTAL A PAGAR</td>
                                <td style="text-align:rigth;background-color:#e5ebf8">$ '. formatcurrency(intval($arrayCalculo[12]), "COP") .'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <P>Recuerde que la referencia para identificar su pago corresponde al numero del apartamento o local. .::. Favor enviar
            copia del pago al correo modelo@modelo.com o dejarla en porteria, gracias.</P>';
            
            // output the HTML content
            $pdf->writeHTML($html, true, false, false, false, '');

            // reset pointer to the last page
            $pdf->lastPage();
         
        }
        $count++;   
    }

    ob_clean();

    //Close and output PDF document
    //$pdf->Output('example_021.pdf', 'I');

    //Close and output PDF to var for sending email
    //$fileatt = $pdf->Output('facturacion.pdf', 'E');
    //$data = chunk_split($fileatt);


    //Close and output PDF to var for sending email
    $mydate = getdate(date("U"));


    $filename = getcwd() . "\\billMonth\\" . "$mydate[mon]" . "$mydate[year]" . ".pdf";
    $fileatt = $pdf->Output($filename, 'I');
    if( $fileatt != "")
        //sendEmail($filename);
        return true;
    else{
        return false;
    }
}

function hacerCalculos($value,$unidad){

    $arrayCalculos = [];
    
    /* Valor Administración */
    $cuotaAdministracion = $value[4];

    /*Valor Pagado*/
    $totalPagado = $value[9]; 
    $totalPagadoAux = $totalPagado;
    /* Valores Facturados */

        //Total Facturado
        $totalFacturado = $value[5];

        //Administración facturada
        $administracionFacturada = $value[6];
    
        //Intereses facturados
        $interesesFacturados = $value[7];
    
        //Otros Conceptos Facturados
        $otrosConceptosFacturados = $value[8] === null ||  $value[8] === "" ? "" : $value[8] ;
        $otrosConceptosDesc1 = $value[15] === null ||  $value[15] === "" ? "" : $value[15] ;
        $otrosConceptosValor1 = $value[16] === null ||  $value[16] === "" ? 0 : $value[16] ;
        $otrosConceptosDesc2 = $value[17] === null ||  $value[17] === "" ? "" : $value[17] ;
        $otrosConceptosValor2 = $value[18] === null ||  $value[18] === "" ? 0 : $value[18] ;
        $otrosConceptosTotalesFacturados =  $otrosConceptosFacturados + $otrosConceptosValor1 + $otrosConceptosValor2;

    /* Valores Facturados */

    /* Valores Pendientes */

        //Intereses pendiente
        $totalPagadoAux = $totalPagadoAux == 0 ? 0 : $totalPagadoAux - $interesesFacturados;
        $interesPendiente = $interesesFacturados == 0 ? 0 : ($totalPagadoAux - $interesesFacturados) * -1;

        //Otros pendientes
        $totalPagadoAux = $totalPagadoAux == 0 ? 0 : $totalPagadoAux - $otrosConceptosTotalesFacturados;
        $otrosConceptosPendientes == 0 ? 0 : $otrosConceptosTotalesFacturados <=  $totalPagadoAux ? 0 : ($totalPagadoAux - $otrosConceptosTotalesFacturados) * -1;

        //Administracion pendiente
        $totalPagadoAux = $totalPagadoAux == 0 ? 0 : $totalPagadoAux - $administracionFacturada;
        $administracionPendiente == 0 ? 0 : ($totalPagadoAux - $administracionFacturada) * -1; 


    /* Valores Pendientes */

    /* Valores Pagados */
    
    /* Valores Pagados */


    $totalPagadoRestado = $value[9]; 

    //factura anterior
    $facturaAnterior = $value[12];
   
    //Saldo Pendiente
    $saldoPendiente =  $facturaAnterior <= $totalPagado ? 0 : $facturaAnterior - $totalPagado ;

    //nota débito
    $notaDebito = $value[14];
        
    //nota crédito
    $notaCredito = $value[13];

    //cuota administracion
    $cuotaAdministracion = $value[4];

    /***************************** Totales ******************************/

    
    //$administracionPendiente = $totalFacturado - $totalPagado;

    //administración facturada
    $administracionFacturada = $cuotaAdministracion + $administracionPendiente;
    $interesFacturado = $administracionPendiente * ((intval($unidad->porcentajeInteres))/100) + $interesPendiente;
    $otrosConceptosFacturados = $notaDebito - $notaCredito + $otrosConceptosPendientes + $otrosConceptosValor1 + $otrosConceptosValor2;
    
    //pagar sin otros
    $pagarSinOtros = $administracionFacturada + $interesFacturado;

    //total a pagar  //administracion          //intereses         //otros
    $totalPagar =  $administracionFacturada + $interesFacturado + $otrosConceptosFacturados;

    array_push(
        $arrayCalculos, 
        $totalFacturado, //0
        $totalPagado, //1
        $totalPagadoRestado,  //2
        $saldoPendiente, //3
        $cuotaAdministracion, //4
        $interesPendiente, //5
        $pagarSinOtros, //6
        $otrosConceptosDesc1 = $value[15], //7
        $otrosConceptosValor1 = $value[16], //8
        $otrosConceptosDesc2 = $value[17], //9
        $otrosConceptosValor2 = $value[18], //10
        $facturaAnterior, //11
        $totalPagar, //12
        $administracionPendiente, //13
        $interesPendiente, //14
        $otrosConceptosPendientes,//15
        $notaCredito, //16
        $notaDebito, //17
        $interesFacturado //18
    );


    return $arrayCalculos;

}



/******************************************************************************************************/

function getActualDate(){
    $today = getdate();

    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"]; 
    
    return  $meses[$today['mon']] ." ".  $today['year'];
}


function getNextDate(){
    $today = getdate();

    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"]; 
    
    return  $meses[$today['mon']] ." ".  $today['year'];
}

function saldoPendiente($total,$pagado){
    return $total-$pagado;
}

function interesPorMora($administracionPendiente, $interes, $interesesPendientes){
    //Los intereses solo se cobrar a la porción de administración que esta pendiente de pago, y para el caso de los ejemplo, se asume que el % de intereses es el 2%
     return ($administracionPendiente * (intval($interes)/100));
}

