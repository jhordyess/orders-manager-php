<!DOCTYPE html>
<html lang='es'>

<head>
  <title>Lista de entregados</title>
  <link
    rel="shortcut icon"
    href="https://res.cloudinary.com/jhordyess/image/upload/v1667836186/global/favicon.svg.svg"
    type="image/x-icon"
  />
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/select/1.2.7/css/select.bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.bootstrap4.min.css" rel="stylesheet">
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
    $g = 7;
    include("../plantilla/menu.php");
    echo menu(1, $g); //$_SESSION['nivel']
    ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../Pagina principal.php">Inicio</a>
          </li>
          <li class="breadcrumb-item active">Pedidos entregados</li>
        </ol>
        <div class="card">
          <div class="card-body">
            <a href="frm_alta_mod.php?v=" class="btn btn-outline-success">
              <i class="fas fa-plus"></i> Nuevo pedido</a>
            <a href="../../Reporte/LaTeX/Itinerario.php" class="btn btn-outline-info" target="_blank">
              <i class="far fa-file-pdf"></i> Itinerario
            </a>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <i class="fas fa-search"></i>
            Filtros
          </div>
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Recibo N<sup>ro</sup></label>
                <input type="text" class="bter form-control" placeholder="1000">
              </div>
              <div class="form-group col-md-3">
                <label>Evento</label>
                <input type="text" class="ml form-control" list="aml" placeholder="ABC">
              </div>
              <datalist id="aml">
                <!--                  <option value='1'>ss</option>-->
                <?php
                require("../conexion.php");
                $res = mysqli_query($con, "select nombre from evento where sw=1");
                while ($reg = mysqli_fetch_array($res)) {
                  echo "<option value='" . $reg[0] . "'></option>";
                }
                ?>
              </datalist>
              <div class="form-group col-md-3">
                <label>Cliente</label>
                <input type="text" class="bter form-control" placeholder="ABC">
              </div>
              <div class="form-group col-md-3">
                <label>CI</label>
                <input type="text" class="bter form-control" placeholder="10000002">
              </div>
              <div class="form-group col-md-3">
                <label>Celular</label>
                <input type="text" class="bter form-control" placeholder="6000020">
              </div>
              <div class="form-group col-md-3">
                <label>Total</label>
                <input type="number" class="bter form-control" placeholder="123">
              </div>
              <div class="form-group col-md-3">
                <label>Destino</label>
                <input type="text" class="ml form-control" list="dtl" placeholder="ABC">
              </div>
              <datalist id="dtl">
                <?php
                $res = mysqli_query($con, "select Nombre from destino where sw=1");
                while ($reg = mysqli_fetch_array($res)) {
                  echo "<option value='" . $reg[0] . "'></option>";
                }
                ?>
              </datalist>
              <div class="form-group col-md-3">
                <label>Entidad</label>
                <select class="lep form-control">
                  <?php
                  $res = mysqli_query($con, "SELECT Banco from entidad;");
                  echo "<option value=''> - </option>";
                  while ($reg = mysqli_fetch_array($res)) {
                    echo "<option value='" . $reg[0] . "'>" . $reg[0] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label>Procedencia</label>
                <select class="lep form-control">
                  <?php
                  $res = mysqli_query($con, "select tipo from procedencia ;");
                  echo "<option value=''> - </option>";
                  while ($reg = mysqli_fetch_array($res)) {
                    echo "<option value='" . $reg[0] . "'>" . $reg[0] . "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Filtro de fechas</label>
                <div class="row">
                  <div class="form-group col-md-3">
                    <input type="date" class="fch1 form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <input type="date" class="fch2 form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="ljk" checked="checked" value="10">por partida</label><span style="margin-right:12px"></span>
                    <label class="radio-inline">
                      <input type="radio" name="ljk" value="11">por entrega</label><span style="margin-right:12px"></span>
                    <label class="radio-inline">
                      <input type="radio" name="ljk" value="12">por salida</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Lista de pedidos
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div class="devlp" style="margin-bottom: 1%">
              </div>
              <table class="display nowrap table table-bordered table-hover" id="registros" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th style="text-align: center">
                      <button type="button" class="todo"><i class="fas fa-plus "></i></button>
                      <button type="button" class="nada"><i class="fas fa-minus"></i></button>
                    </th>
                    <th>N<sup>ro</sup></th>
                    <th>Evento</th>
                    <th>Cliente</th>
                    <th>CI</th>
                    <th>Celular</th>
                    <th>Total [Bs.]</th>
                    <th>Destino</th>
                    <th>Entidad</th>
                    <th>Procedencia</th>
                    <th>Fecha partida</th>
                    <th>Fecha entrega</th>
                    <th>Fecha salida</th>
                    <th>Comentario</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>N<sup>ro</sup></th>
                    <th>Evento</th>
                    <th>Cliente</th>
                    <th>CI</th>
                    <th>Celular</th>
                    <th>Total</th>
                    <th>Destino</th>
                    <th>Entidad</th>
                    <th>Procedencia</th>
                    <th>Fecha partida</th>
                    <th>Fecha entrega</th>
                    <th>Fecha salida</th>
                    <th>Comentario</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $alerta;
                  $query = "call ver_entregados();";
                  $out = mysqli_query($con, $query);
                  while ($row = mysqli_fetch_array($out)) {
                    echo "<tr>";
                    echo "<td></td>";
                    $xc = $row[0];
                    if (is_numeric($xc)) { //cuando del cliente
                      $t = (int) $xc + 1000;
                      echo "<td>" . $t . "</td>";
                    } else { //cuando tienda
                      $t = (int) substr($xc, 1) + 1000; //ojito
                      $os = $xc[0];
                      echo "<td>" . $os . $t . "</td>";
                    }
                    echo "<td>" . $row[1] . "</td>";
                    echo "<td>" . $row[2] . "</td>";
                    echo "<td>" . $row[3] . "</td>";
                    echo "<td>" . $row[4] . "</td>";
                    echo "<td>" . number_format($row[5], 2, '.', '') . "</td>";
                    echo "<td>" . $row[6] . "</td>";
                    echo "<td>" . $row[7] . "</td>";
                    echo "<td>" . $row[8] . "</td>";
                    $test = new DateTime($row[9]);
                    echo "<td data-order=" . $test->getTimestamp() . ">" . $row[9] . "</td>";
                    $test = new DateTime($row[10]);
                    echo "<td data-order=" . $test->getTimestamp() . ">" . $row[10] . "</td>";
                    $test = new DateTime($row[11]);
                    echo "<td data-order=" . $test->getTimestamp() . ">" . $row[11] . "</td>";
                    echo "<td>" . $row[12] . "</td>";
                    echo "</tr>";
                  }
                  mysqli_close($con);
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            <?php
            require("../conexion.php");
            require_once('../plantilla/procedimientos.php');
            echo fecha('pedido', $con);
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
  <div class="modal fade" id="detalla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detalle de pedido</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="editable">No me veas</div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/Maquetacion/js/bootstrap-add-clear.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.js"></script>
  <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.bootstrap4.min.js"></script>
  <!--botones Emergentes-->
  <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.colVis.min.js"></script>
  <script src="/Maquetacion/js/sb-admin.min.js"></script>
  <script src="/Maquetacion/js/JHDIII/pedido_1_1.js"></script>
  <script src="/Maquetacion/js/JHDIII/border-anim.js"></script>
</body>