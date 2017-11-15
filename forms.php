<?php
require 'billMonth.php';
require 'billFormat.php';
require 'drawTable.php';
require 'alerts.php';
require 'php/currency/format-currency.php';
require 'php/PHPExcel/Classes/PHPExcel.php';
require_once 'php/PHPExcel/Classes/PHPExcel/IOFactory.php';
include 'php/database/functions/update.php';

/***********************init page***********************/
session_start();
if (!isset($_SESSION["selected"])) {
    header('Location: index.php');
    exit();
}
$objExcel = loadExcel();
$finalTable = "";
$billClass = "hidden";

if ($objExcel == null) {
    header('Location: index.php');
    exit;
} else {
    $path = $objExcel->unidadId . "\\" . $objExcel->filePath;
}
$billStatus = $objExcel->billStatus;
if ($path == null) {
    errorAlert();
} else {
    $finalTable = drawTable($path);
}

/***********************end init page***********************/

//show specific file or bill specific month
if (isset($_POST['billMonth']) != "") {

    $result = billMonth();
    if ($result) {
        //$result = disableBill();
        if ($result) {
            successAlert("Se facturó correctamente");
        } else {
            errorAlert();
        }
    } else {
        errorAlert();
    }

} elseif (isset($_POST['loadFile'])) {
    $dateValue = $_POST['loadFile'];
    
    if ($dateValue == "") {
        loadExcel();
    } else {
        $dateValue = explode("-", $dateValue);
        $objExcel = loadExcelByDate($dateValue[0], $dateValue[1], $_SESSION['selected']);
        if ($objExcel == null) {
            warningAlert("No hay datos");
            $finalTable = "";
            $billStatus = 1;
        } else {
            $finalTable = "";
            $finalTable = drawTable($objExcel->unidadId . "\\" . $objExcel->filePath);
            $billStatus = $objExcel->billStatus;
        }
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap Admin Theme v3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/forms.css" rel="stylesheet">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

    <link href="css/forms.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">
    
    <script src="js/sweetalert.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <!-- Logo -->
        <div class="logo">
        <h1>Administración <?php
        if (isset($_SESSION["unidadSelected"]->nombre)) {
            echo $_SESSION["unidadSelected"]->nombre;
        } else {
        }?></h1>
        </div>
      </div>
    </div>
  </div>
  </div>
    <div class="page-content">
        <div class="row">
          <div class="col-md-2">
            <div class="sidebar content-box" style="display: block;">
            <ul class="nav">
              <!-- Main menu -->
              <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
              <li><a href="tables.php"><i class="glyphicon glyphicon-circle-arrow-up"></i>Cargar Excel</a></li>
              <li class="current"><a href="forms.php"><i class="glyphicon glyphicon-list"></i>Histórico</a></li>
                      </ul>
             </div>
          </div>
        <div class="col-md-10">
                <div class="content-box">
                    <div class="panel-heading">
                        <div class="panel-title">Archivo </div>
                          <div class="panel-options">
                                <span>Busqueda de archivo en base de datos por mes y año <i class="glyphicon glyphicon-info-sign"></i></span>
                        </div>
                        <div class="uploadExcelFields panel-body">
                        <form class="loadLastFile" name="loadLastFile" action="forms.php" method="post" enctype="multipart/form-data">
                        <div class="content-boxupload-box">
                            <!--<input type="file"  class="displayBlock btn btn-default" />-->
                            <!--div name="loadFile" id="loadFile" class="displayBlock bfh-datepicker" data-format="y-m-d" data-date=""></div>-->
                            <input type="date" name="loadFile" id="loadFile" value="Buscar" class="displayBlock btn btn-default"/>
                            <input formaction="forms.php" type="submit" name="loadfileButton" id="loadfileButton" value="Buscar" class="displayBlock btn btn-default"/>
                            <?php
                            if ($billStatus == 0) {
                                echo "<input type='submit' name='billMonth' id='billMonth' value='Facturar' class='pull-right btn btn-default'/>";
                            }
                            ?>
                            </div>
                        </div>
                      </form>
                        <?php
                        echo "<div class='tableContainer  row'>";
                        echo $finalTable;
                        echo "</div>";
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--  Page content -->
          </div>
        </div>
    </div>

    <footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>
            
         </div>
      </footer>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
     <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>

    <script src="vendors/select/bootstrap-select.min.js"></script>

    <script src="vendors/tags/js/bootstrap-tags.min.js"></script>

    <script src="vendors/mask/jquery.maskedinput.min.js"></script>

    <script src="vendors/moment/moment.min.js"></script>

    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

     <!-- bootstrap-datetimepicker -->
     <link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
     <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script> 


    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/forms.js"></script>
  </body>
</html>
