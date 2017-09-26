<?php
require 'php/TCPDF/tcpdf.php';
require 'sendEmail.php';
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

    // set font
    $pdf->SetFont('helvetica', '', 9);

    //set class var
    $fullBorder = "border:1px solid #5656ff;";
    $dashedRightBorder = "border-left-style:solid;border-top-style:solid;border-right-style:dashed;border-bottom-style:solid;border-color: #5656ff;";
    $dashedLeftBorder = "border-left-style:dashed;border-top-style:solid;border-right-style:solid;border-bottom-style:solid;border-color: #5656ff;";
    $nonLeftBorder = "border-left-style:none;border-top-style:solid;border-right-style:solid;border-bottom-style:solid;border-color: #5656ff;";
    $solidRightBorder = "border-right-style:solid;border-color: #5656ff;";

    // create some HTML content
    foreach ($bills as $bill => $value) {
        // add a page
        $pdf->AddPage('L', 'LETTER');

        $html = '
        <table style="" cellpadding="2" sytle="border-color:#2536ff">
            <tr nobr="true">
                <td style="' . $fullBorder . '" rowspan="3">Imagen de la unidad1</td>
                <td style="' . $dashedRightBorder . '" colspan="2"><span style="color:#2536ff" >NOMBRE:</span> ' . $value["Nombre"] . '</td>
                <td style="' . $dashedLeftBorder . 'text-align:center;"><span style="color:#2536ff" >UNIDAD O CONJUNTO</span></td>
            </tr>
            <tr nobr="true">
                <td style="' . $dashedLeftBorder . '"><span style="color:#2536ff" >CUENTA DE COBRO </span>' . $value['Factura de cobro'] . ' </td>
                <td style="' . $dashedRightBorder . '"><span style="color:#2536ff" >REFERENCIA:</span> ' . $value['Apartamento/Unidad'] . '</td>
                <td style="' . $dashedLeftBorder . 'text-align:center;">Modelo</td>
            </tr>
            <tr nobr="true" >
                <td style="' . $dashedRightBorder . '" colspan="2"><span style="color:#2536ff" >PERIODO:</span> falta</td>  
                <td style="' . $dashedLeftBorder . 'text-align:center"><span style="color:#2536ff" >NOMBRE</span></td>      
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . '">Nit: 2 </td>
                <td style="' . $fullBorder . 'text-align:center"><span style="color:#2536ff">BANCO/CORPORACION</span> <br>' . $value['Banco'] . '</td>
                <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff;text-align:center">CUENTA RECAUDO</span> <br>Falta</td>
                <td style="' . $dashedLeftBorder . 'text-align:center">' . $value["Nombre"] . '</td>
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . 'background-color:#e5ebf7;text-align:center"><span style="color:#2536ff" >FACTURA ANTERIOR:</span> <br>$ falta</td>
                <td style="' . $fullBorder . 'background-color:#e5ebf7;text-align:center"><span style="color:#2536ff" >PAGO REALIZADO:</span> <br>$ ' . formatcurrency($value['Valor Pagado'], "COP") . '</td>
                <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff" >SALDO PENDIENTE</span><br />$ ' . formatcurrency($value['Saldo Pendiente'], "COP") . '</td>
                <td style="' . $dashedLeftBorder . '">
                    <table>
                        <tr nobr="true">
                            <td><span style="color:#2536ff">CUENTA DE COBRO</span></td>
                            <td>' . $value['Factura de cobro'] . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . 'text-align:center"><span style="color:#2536ff">CUOTA ADMINISTRACION</span><br />$ COLUMN 1</td>
                <td style="' . $fullBorder . 'text-align:center"><span style="color:#2536ff">INTERES DE MORA</span><br />$ COLUMN 2</td>
                <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff">PAGAR SIN OTROS</span><br />$ ' . formatcurrency($value['Valor Pagado'], "COP") . '</td>
                <td style="' . $dashedLeftBorder . '">
                    <table>
                        <tr nobr="true">
                            <td style="color:#2536ff">REFERENCIA</td>
                            <td style="background-color:#e5ebf7;">' . $value['Apartamento/Unidad'] . '</td>
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
                <td style="' . $dashedRightBorder . 'text-align:center"></td>
                <td style="' . $dashedLeftBorder . 'text-align:center"></td>
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . '"></td>
                <td style="' . $fullBorder . '"></td>
                <td style="' . $dashedRightBorder . 'ext-align:center"><span style="color:#2536ff">PÁGUESE SIN RECARGO</span></td>
                <td style="' . $dashedLeftBorder . 'text-align:center"><span style="color:#2536ff">BANCO</span></td>
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . '"></td>
                <td style="' . $fullBorder . '"></td>
                <td style="' . $dashedRightBorder . '">
                    <table>
                        <tr nobr="true">
                            <td><span style="color:#2536ff">D</span></td>
                            <td><span style="color:#2536ff">M</span></td>
                            <td><span style="color:#2536ff">A</span></td>
                        </tr>
                    </table>
                </td>
                <td style="' . $dashedLeftBorder . 'text-align:center">' . $value['Banco'] . '</td>
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . '"></td>
                <td style="' . $fullBorder . '"></td>
                <td style="' . $dashedRightBorder . 'text-align:center"><span style="color:#2536ff">PAGUESE CON RECARGO</span></td>
                <td style="' . $dashedLeftBorder . 'text-align:center"><span style="color:#2536ff">CUENTA RECAUDO</span></td>
            </tr>
            <tr nobr="true">
                <td style="' . $fullBorder . '"></td>
                <td style="' . $fullBorder . '"></td>
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
                <td style="' . $fullBorder . 'text-align:rigth;background-color:#e5ebf8">$ FALTA</td>
                <td style=""></td>
                <td style="' . $dashedLeftBorder . '">
                    <table>
                        <tr nobr="true">
                            <td style="text-align:rigth">TOTAL A PAGAR</td>
                            <td style="text-align:rigth;background-color:#e5ebf8">$ FALTA</td>
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

    ob_clean();

    //Close and output PDF document
    //$pdf->Output('example_021.pdf', 'I');

    //Close and output PDF to var for sending email
    //$fileatt = $pdf->Output('facturacion.pdf', 'E');
    //$data = chunk_split($fileatt);


    //Close and output PDF to var for sending email
    $mydate = getdate(date("U"));


    $filename = getcwd() . "\\billMonth\\" . "$mydate[mon]" . "$mydate[year]" . ".pdf";
    $fileatt = $pdf->Output($filename, 'F');
    if( $fileatt != "")
        sendEmail($filename);
    else{
        return false;
    }
}