<!DOCTYPE html>
<html lang="es">

<head>
  <title>Página principal</title>
  <link rel="icon" href="/Imagenes/docs.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="/Maquetacion/css/sb-admin.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php
  include("cabezera.php");
  ?>
  <div id="wrapper">
    <?php
    $g = 0;
    include("plantilla/menu.php");
    echo menu(1, $g); //$_SESSION['nivel']
    ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Inicio</a>
          </li>
          <li class="breadcrumb-item active">Visión general</li>
        </ol>
        <?php
        include './conexion.php';
        $b = mysqli_fetch_array(mysqli_query($con, "select date(fecha) from historia where tabla='backup';"))[0];
        //          $fec = new DateTime($b);
        //          $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        //          $xk = $fec->format('j \d\e ') . $meses[$fec->format('m') - 1];
        //          . $fec->format(' \d\e\l Y \a \l\a\s g:i A');
        $diff = abs(strtotime($b) - strtotime(date("Y-m-d")));
        $xk = floor($diff / (60 * 60 * 24));
        $ox = mysqli_fetch_array(mysqli_query($con, "select count(*) from impresion;"))[0];
        $sd = mysqli_fetch_array(mysqli_query($con, "call contar()"));
        ?>
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-hand-holding-usd"></i>
                </div>
                <div class="mr-5"><?php echo $sd[0] ?> Pedidos por entegar</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="Pedido/frm_listar.php">
                <span class="float-left">Ver pedidos</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-times"></i>
                </div>
                <div class="mr-5"><?php echo $sd[1] ?> Pedidos cancelados</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="Pedido/frm_listar_1.php">
                <span class="float-left">Ver pedidos cancelados</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fas fa-thumbs-up"></i>
                </div>
                <div class="mr-5"><?php echo $sd[2] ?> Pedidos entregados</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="Pedido/frm_listar_1_1.php">
                <span class="float-left">Ver pedidos entregados</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-thumbs-down"></i>
                </div>
                <div class="mr-5"><?php echo $sd[3] ?> Deudas de pago!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="Pedido/frm_listar_1_1_1.php">
                <span class="float-left">Ver deudas de pago</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-secondary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-file-pdf"></i>
                </div>
                <div class="mr-5">Itinerario con <span id="itt"><?php echo $ox ?></span> pedidos en cola</div>
              </div>
              <a id="it" class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Generar itinerario</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-sync"></i>
                </div>
                <div class="mr-5">Ultimo backup: hace <span>1</span> dia</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Descargar backup</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Ingresos totales vs
            <input type="button" id="als" value="mes" style="border: 0px">
          </div>
          <div class="card-body">
            <canvas id="me" width="100%" height="30px"></canvas>
          </div>
          <div class="card-footer small text-muted">
            <b> Nota: </b>Datos calculados con la fecha de entrega, desde el primer pedido al último.
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Porcentaje de <i>destinos</i> más escogidos
              </div>
              <div class="card-body">
                <canvas id="destinos" width="100%"></canvas>
              </div>
              <div class="card-footer small text-muted"><b>Nota:</b> Resultados con todos los pedidos.</div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Porcentaje de <i>procedencias</i> más escogidas
              </div>
              <div class="card-body">
                <canvas id="proce" width="100%"></canvas>
              </div>
              <div class="card-footer small text-muted"><b>Nota:</b> Resultados con todos los pedidos.</div>
            </div>
          </div>
        </div>
      </div>
      <?php include("pie.php"); ?>
    </div>
  </div>
  <?php include("exitmodal.php"); ?>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <script src="/Maquetacion/js/stats/resumen.js"></script>
  <script>
    $(document).ready(function() {
      $('#it').click(function() {
        $('#itt').text("0");
        window.open("../Reporte/LaTeX/Itinerario.php", "_blank");
      });
    });
  </script>
  <script src="/Maquetacion/js/sb-admin.min.js"></script>
</body>

</html>