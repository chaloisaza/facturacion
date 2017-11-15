<?php  
require_once 'php/database/functions/select.php';
require_once 'php/database/functions/update.php';

require_once 'alerts.php';

if(isset($_POST['submitButton'])) {
    $username = $_POST['mensajeInput'];
}
if (isset($_POST['saveChanges'])) {
    $resultUpload = updateUnidadById($_GET['id'], $_POST['nameInput'], $_POST['nitInput'], $_POST['porcentajeInteresInput'],  $_POST['bancoRecaudoInput'], $_POST['mensajeInput']);

    if ((!empty($_FILES["imagenUnidadInput"])) && ($_FILES['imagenUnidadInput']['error'] == 0)) {
        $filename = $resultUpload;
        $pathSave = 'unidadImages\\' . $_GET['id'] . '.png';
        move_uploaded_file($_FILES["imagenUnidadInput"]['tmp_name'], $pathSave);
    }

    alertInformation($resultUpload);
}
session_start(); 
$unityValues = "";

if (isset($_GET['id'])) {
    $unityValues = loadUnidadById(intval($_GET['id']));
}

function loadUnidad(){
    $unityValues = loadUnidadById(intval($_GET['id']));
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

</head>

<body>
<div class="header">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Logo -->
            <div class="logo">
            <h1>Edición de unidad <?php
            if (isset($_SESSION["unidadSelected"]->nombre)) {
                echo $unityValues->nombre;
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
                </ul>
                </div>
            </div>
            <div class="col-md-10">
                <div class="content-box">
                    <div class="panel-heading">
                        <div class="uploadExcelFields panel-body">
                            <!-- <form name="updateUnidad" action="" method="get" enctype="multipart/form-data"> -->


                            <form enctype="multipart/form-data" action="" method="post">

                                <div class"row">
                                    <div class="paddingInput col-sm-1"><label for="nameInput">Nombre:</label></div>
                                    <div class="paddingInput col-sm-11"><input id="nameInput" name="nameInput" type="text" value="<?php echo $unityValues->nombre?>"></div>
                                </div>

                                <div class"row">
                                    <div class="paddingInput col-sm-1"><label for="nitInput">NIT:</label></div>
                                    <div class="paddingInput col-sm-11"><input id="nitInput" name="nitInput" type="text" value="<?php echo $unityValues->nit?>"></div>
                                </div>

                                <div class"row">
                                    <div class="paddingInput col-sm-1"><label for="porcentajeInteresInput">Interés:</label></div>
                                    <div class="paddingInput col-sm-11"><input id="porcentajeInteresInput" name="porcentajeInteresInput" type="text" value="<?php echo $unityValues->porcentajeInteres?>"></div>
                                </div>
                                
                                <div class"row">
                                    <div class="paddingInput col-sm-1"><label for="bancoRecaudoInput">Banco:</label></div>
                                    <div class="paddingInput col-sm-11"><input id="bancoRecaudoInput" name="bancoRecaudoInput" type="text" value="<?php echo $unityValues->bancoRecaudo?>"></div>
                                </div>
                                
                                <div class"row">
                                    <div class="paddingInput col-sm-1"><label for="mensajeInput">Mensaje:</label></div>
                                    <div class="paddingInput col-sm-11"><textarea id="mensajeInput" name="mensajeInput" cols="30" rows="10" ><?php echo $unityValues->mensaje?></textarea></div>
                                </div>


                                <div class"row">
                                    <img id="imagenUnidad" src="<?php $path =  "unidadImages/" .  $unityValues->id . ".png";if(file_exists($path )){echo $path;}else{echo "unidadImages/defaultImage.png";}?>" alt="">
                                    <div class="paddingInput col-sm-1"><label for="imagenUnidadInput">Imagen:</label></div>
                                    <div class="paddingInput col-sm-11"><input id="imagenUnidadInput" name="imagenUnidadInput" type="file" value=""></div>
                                </div>

                                <div class"row">
                                    <div class="col-sm-1"></div>
                                    <div class="paddingInput col-sm-11">
                                        <button name="saveChanges" id="saveChanges" type="submit" class="btn btn-success">
                                            <i class="glyphicon glyphicon-floppy-saved"></i> Guardar
                                        </button>
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
    <?php

function alertInformation($var){

    if ($var == true) {
        loadUnidad(intval($_GET['id']));
        successAlert("Se modificó la unidad correctamente");
    } else {
        errorAlert();
    }
}
?>
    <script src="js/sweetalert.min.js"></script>
</body>

</html>

