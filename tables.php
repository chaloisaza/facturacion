<?php     session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap Admin Theme v3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
    
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">

     <!-- customCss -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables/dataTables.bootstrap.js"></script>

    <!-- customJs -->
    <script src="js/custom.js"></script>
    <script src="js/tables.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script>
        $( document ).ready(function() {
            $("#excelFile").change(function(){
                $("#excelFileUpload").toggleClass("disabled");
            });
        });
    </script>
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
                    <li class="current"><a href="tables.php"><i class="glyphicon glyphicon-circle-arrow-up"></i>Cargar Excel</a></li>
                    <li><a href="forms.php"><i class="glyphicon glyphicon-list"></i>Histórico</a></li>
                </ul>
                </div>
            </div>
            <div class="col-md-10">
                <div class="content-box">
                    <div class="panel-heading">
                        <div class="panel-title">Carga de archivo</div>
                        <div class="panel-options">
                                <span>Cargar archivo de Excel con extensión xls o xlsx <i class="glyphicon glyphicon-info-sign"></i></span>
                        </div>
                        <div class="uploadExcelFields panel-body">
                            <form name="uploadfile" action="" method="post" enctype="multipart/form-data">
                                <div class="upload-box">
                                    <input type="file" name="excelFile" id="excelFile" class="displayBlock btn btn-default" />
                                    <input type="submit" name="upload_file" id="excelFileUpload" value="Cargar" class="displayBlock disabled btn btn-default"/>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


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
</body>

</html>
<?php
include 'uploadcode.php';
require 'alerts.php';
if (isset($_POST['upload_file'])) {
    $resultUpload = upload_files($_FILES["excelFile"]["name"]);

    if ($resultUpload == "Ok") {
        successAlert("Se guardó el archivo correctamente");
    } else {
        errorAlert($resultUpload);
    }
}
?>
