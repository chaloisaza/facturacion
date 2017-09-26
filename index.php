<?php
include 'php/database/functions/select.php';
include 'php/database/functions/update.php';
include 'php/database/functions/insert.php';
include 'alerts.php';

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

// = 'disable';
if (isset($_POST['unidadApartamento'])) {
    $needle = $_POST['unidadApartamento'];
    $_SESSION["unidadApartamento"] = $_POST['unidadApartamento'];
    $_SESSION["enableButton"] = 'enable';
    $_SESSION['selected'] = $_POST['unidadApartamento'];
    $_SESSION['unidadSelected'] = array_reduce(
        $unidades,
        function ($result, $current_item) use ($needle) {
            //Found the an object that meets criteria? Add it to the the result array
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
    <script src="js/sweetalert.min.js"></script>
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
                    <form method="post" action="index.php">    
                    <?php
                    if ($unidades != null) {
                        foreach ($unidades as $unidad) {
                            ?>  
                                  
                            <div class="row">
                            <div class="col-md-12">
                                <div class="content-box-header">
                                    <div class="panel-title"><?php echo $unidad->nombre ?></div>
                                </div>
                                <div class="content-box-large box-with-header">
                                    <div class="panel-options">

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

                                                <button name="unidadApartamento" type="submit" class="btn btn-warning "><i class="glyphicon glyphicon-edit"></i> Editar</button>
                                                <button name="unidadApartamento" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Eliminar</button>
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