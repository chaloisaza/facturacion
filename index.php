<?php
require_once 'php/database/functions/select.php';
require_once 'php/database/functions/update.php';
//require_once 'php/database/functions/insert.php';
require_once 'alerts.php';

$selected = "";
session_start();
$unidades = loadUnidades();
if (count($unidades) > 0) {
    array_shift($unidades);

    if (!isset($_SESSION['selected'])) {
        $_SESSION['selected'] = "0";
        $_SESSION['enableButton'] = 'disable';
    } else {
        $_SESSION['enableButton'] = 'enabled';
    }
} else {
    $_SESSION['enableButton'] = 'disable';
    $_SESSION['selected'] = "0";
}

if (isset($_POST['unidadApartamento'])) {
    $needle = $_POST['unidadApartamento'];
    $_SESSION["unidadApartamento"] = $_POST['unidadApartamento'];
    $_SESSION["enableButton"] = 'enable';
    $_SESSION['selected'] = $_POST['unidadApartamento'];
    $_SESSION['unidadSelected'] = array_reduce(
        $unidades,
        function ($result, $current_item) use ($needle) {
            if ($current_item->id == $needle) {
                $result= $current_item;
            }
            return $result;
        },
        array()
    );
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
        $( document ).ready(function() {
            $( "button[id*='editUnidadApartamento']" ).click(function() {
                window.location.href = 'editUnidad.php?id='+this.id.split("_")[1]; //relative to domain
            });
            $( "button[id*='deleteUnidadApartamento']" ).click(function() {
                
                var id = this.id.split("_")[1];
                swal({
                    title: "¿Está seguro de que desea eliminar esta unidad?",
                    text: "La unidad quedará inactiva, pero se podrá reactivar posteriormente",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Sí, eliminar",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: 'POST',
                        url: 'deleteUnidad.php',
                        data: { 
                            'id': id
                        },
                        success: function(msg){                            
                            swal("¡Eliminada!", "La unidad se ha eliminado correctamente.", "success");

                            location.reload();
                        },
                        error: function(msg){
                            swal("¡Eliminada!", "La unidad no se ha podido eliminar correctamente.", "error");
                        }
                    });
                });
            });
            $( "button[id*='agregarUnidadApartamento']" ).click(function() {
                window.location.href = 'addUnidad.php';
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
        <div class="row paddingInput">
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar content-box" style="display: block;">
                    <ul class="nav">
                        <!-- Main menu -->
                        <li class="current"><a href="index.php"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
                        <li><a href="
                        <?php
                        if ($_SESSION["enableButton"] == "disable") {
                            echo "#";
                        } else {
                            echo "tables.php";
                        } ?>">
                        <i class="glyphicon glyphicon-circle-arrow-up"></i>Cargar Excel</a></li>
                                                    <li><a href="           
                                                    <?php
                                                    if ($_SESSION["enableButton"] == "disable") {
                                                        echo "#";
                                                    } else {
                                                        echo 'forms.php';
                                                    } ?>">
                                                    <i class="glyphicon glyphicon-list"></i>Histórico</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                    <div class="row">   
                        <div class="col-md-12">
                            <button id="agregarUnidadApartamento" name="unidadApartamento" type="button" class="pull-right btn btn-normal">
                                <i class="glyphicon glyphicon-pencil"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <form method="post" action="index.php">    
                    <?php
                    if ($unidades != null) {
                        foreach ($unidades as $unidad) {
                            ?>  
                                  
                            <div class="row">
                            <div class="col-md-12">
                                <div class="content-box-header">
                                    <div class="panel-title">
                                        <?php echo $unidad->nombre ?>                                
                                    </div>
                                </div>
                                <div class="content-box-large box-with-header">
                                    <div class="panel-options">

                                        <img id="imagenUnidad" src="
                                        <?php 
                                        $path =  "unidadImages/" .  $unidad->id . ".png";
                                        if(file_exists($path )){
                                            echo $path; 
                                        }else{
                                            echo "unidadImages/defaultImage.png";
                                        }
                                            
                                        ?>" alt="">

                                        <button name="unidadApartamento" type="submit" id="<?php echo $unidad->id ?>" class="btn 
                                        <?php
                                        if ($_SESSION['selected'] == $unidad->id) {
                                            echo 'disabled btn-success';
                                        } else {
                                            echo 'btn-default';
                                        } ?>" value="<?php echo $unidad->id ?>">

                                                <i class="
                                                <?php
                                                if ($_SESSION['selected'] == $unidad->id) {
                                                    echo 'glyphicon glyphicon-ok ';
                                                }
                                                ?>
                                                ">
                                                </i> Seleccionar</button>

                                                <button id="editUnidadApartamento_<?php echo $unidad->id ?>" name="unidadApartamento" type="button" class="btn btn-warning ">
                                                    <i class="glyphicon glyphicon-edit"></i> Editar
                                                </button>
                                                <button id="deleteUnidadApartamento_<?php echo $unidad->id ?>" name="unidadApartamento" type="button" class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-remove"></i> Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                        }
                    } else {
                        warningAlert("No hay datos");
                    }
                    ?>  
                    </form>
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