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
  <title>Lista de poleras</title>
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
  ?>
  <div id="wrapper">
    <?php
    $g = 3;
    include("../plantilla/menu.php");
    echo menu(1, $g); //$_SESSION['nivel']
    ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../Pagina principal.php">Inicio</a>
          </li>
          <li class="breadcrumb-item active">Extra</li>
          <li class="breadcrumb-item active">Poleras</li>
        </ol>
        <div class="card">
          <div class="card-body">
            <a href="frm_alta_mod.php?v=" class="btn btn-outline-success">
              <i class="fas fa-plus"></i> Nuevo polera</a>
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
                <label for="src0">Código</label>
                <input type="text" class="form-control" id="src0" placeholder="ABC">
                <i id="clr0" class='fas fa-times-circle'></i>
              </div>
              <div class="form-group col-md-4">
                <label for="src1">Descripción</label>
                <input type="text" class="form-control" id="src1" placeholder="ABC">
                <i id="clr1" class='fas fa-times-circle'></i>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Lista de poleras
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
                      <th>Código</th>
                      <th>Descripción</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>Código</th>
                      <th>Descripción</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    require("../conexion.php");
                    $query = "select * from polera";
                    $out = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($out)) {
                      echo "<tr>";
                      echo "<td style='text-align:center'>";
                      echo "<input type='checkbox' name='checked[]' value='" . $row[0] . "'>";
                      echo "</td>";
                      echo "<td>" . $row[1] . "</td>";
                      echo "<td>" . $row[2] . "</td>";
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
            echo fecha('polera', $con);
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
  <script src="/Maquetacion/js/JHDIII/polera.js"></script>
  <script src="/Maquetacion/js/JHDIII/border-anim.js"></script>
</body>

</html>