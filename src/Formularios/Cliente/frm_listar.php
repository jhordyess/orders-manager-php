<?php
if (isset($_POST["accion"]) && isset($_POST['checked'])) {
    $posteo = $_POST['accion'];
    if ($posteo == 1) {
        header("location:frm_alta_mod.php?v=" . serialize($_POST['checked']));
    } elseif ($posteo == 2) {
        header("location:eliminar.php?v=" . serialize($_POST['checked']));
    }
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <title>Lista de clientes</title>
    <link rel="icon" href="/Imagenes/docs.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="/Maquetacion/css/sb-admin.css" rel="stylesheet">
    <link href="/Maquetacion/css/JHDIII/tallas.css" rel="stylesheet">
    <link href="/Maquetacion/css/JHDIII/border-anim.css" rel="stylesheet">
</head>

<body id="page-top">
    <?php
    include("../cabezera.php");
    require("../conexion.php");
    ?>
    <div id="wrapper">
        <?php
        $g = 2;
        include("../plantilla/menu.php");
        echo menu(1, $g); //$_SESSION['nivel']
        ?>
        <div id="content-wrapper">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../Pagina principal.php">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">Clientes</li>
                </ol>
                <div class="card">
                    <div class="card-body">
                        <a href="frm_alta_mod.php?v=" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Nuevo cliente</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-search"></i>
                        Filtros
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="src0">Nombre</label>
                                <input type="text" class="form-control" id="src0" placeholder="ABC">
                                <i id="clr0" class='fas fa-times-circle'></i>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="src1">CI</label>
                                <input type="text" class="form-control" id="src1" placeholder="ABC">
                                <i id="clr1" class='fas fa-times-circle'></i>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="src2">Celular</label>
                                <input type="text" class="form-control" id="src2" placeholder="ABC">
                                <i id="clr2" class='fas fa-times-circle'></i>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="src3">Recordar</label>
                                <select class="form-control" id="src3">
                                    <option value="" selected="selected">-</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="src4">Nro. Tarjeta</label>
                                <input type="text" class="form-control" id="src4" placeholder="1234 xxxx xxxx xxxx">
                                <i id="clr3" class='fas fa-times-circle'></i>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="src5">Tarjeta Habilitada</label>
                                <select class="form-control" id="src5">
                                    <option value="" selected="selected">-</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="Null">Null</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Lista de clientes
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="post">
                                <div class="operacion">
                                    <button type="submit" class="btn btn-outline-success" name="accion" value="1">
                                        <i class="fas fa-edit"></i> Edita
                                    </button>
                                    <span style="margin-right:12px"></span>
                                    <button type="submit" class="btn btn-outline-danger" name="accion" value="2">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>

                                <table class="display nowrap table table-bordered table-hover" id="registros" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nombre</th>
                                            <th>CI</th>
                                            <th>Celular</th>
                                            <th>Recordar</th>
                                            <th>Nro. Tarjeta</th>
                                            <th>T. Habilitada</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Nombre</th>
                                            <th>CI</th>
                                            <th>Celular</th>
                                            <th>Recordar</th>
                                            <th>Nro. Tarjeta</th>
                                            <th>T. Habilitada</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $query = "select * from cliente";
                                        $out = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_array($out)) {
                                            echo "<tr>";
                                            echo "<td style='text-align:center'>";
                                            echo "<input type='checkbox' name='checked[]' value='" . $row[0] . "'>";
                                            echo "</td>";
                                            echo "<td>" . $row[1] . "</td>";
                                            echo "<td>" . $row[2] . "</td>";
                                            echo "<td>" . $row[3] . "</td>";
                                            if ($row[4] == '1') {
                                                echo "<td>Si</td>";
                                            } else {
                                                echo "<td>No</td>";
                                            }

                                            $nale = "Null";
                                            $nale2 = "Null";
                                            if (!is_null($row[5])) {
                                                $aris = mysqli_query($con, 'SELECT number,swr FROM codes WHERE id = ' . $row[5] . ";");
                                                while ($fila1 = mysqli_fetch_array($aris)) {
                                                    $nale = $fila1[0];
                                                    $nale2 = $fila1[1];
                                                }
                                            }
                                            echo "<td>" . $nale . "</td>";

                                            if ($nale == "Null") {
                                                echo "<td>Null</td>";
                                            } else {
                                                if ($nale2 == "1") {
                                                    echo "<td>Si</td>";
                                                } else {
                                                    echo "<td>No</td>";
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <?php
                        require_once('../plantilla/procedimientos.php');
                        echo fecha('cliente', $con);
                        ?>
                    </div>
                </div>
            </div>
            <?php
            include("../pie.php");
            ?>
        </div>
    </div>
    <?php
    include("../exitmodal.php");
    ?>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $('button[type="submit"]').prop("disabled", true);
        $('input[type="checkbox"]').click(function() {
            $('button[type="submit"]').prop("disabled", true);
            var x = ($('input[type="checkbox"]').not(":not(:checked)").length > 0);
            if (x) {
                $('button[type="submit"]').prop("disabled", false);
            } else {
                $('button[type="submit"]').prop("disabled", true);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.js"></script>
    <script src="/Maquetacion/js/sb-admin.min.js"></script>
    <script src="/Maquetacion/js/JHDIII/cliente.js"></script>
    <script src="/Maquetacion/js/JHDIII/border-anim.js"></script>
</body>

</html>