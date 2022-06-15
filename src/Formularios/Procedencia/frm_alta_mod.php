<?php
$envi = $_GET['v'];
$ids = unserialize($_GET['v']);
$a;
$tipo = '';
$nombre = '';
if ($ids == NULL) {
  for ($index = 0; $index < 1; $index++) {
    $a[$index] = '';
  }
  $tipo = "Nueva procedencia";
  $nombre = "Grabar";
} else {
  require '../conexion.php';
  $a = mysqli_fetch_array(mysqli_query($con, "SELECT t.tipo FROM  `procedencia` AS t WHERE t.idprocedencia=" . $ids[0]));
  $tipo = "Modificar procedencia";
  $nombre = "Modificar";
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
  <title><?php echo $tipo ?></title>
  <link rel="icon" href="/Imagenes/docs.png">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="/Maquetacion/css/sb-admin.css" rel="stylesheet">
  <link href="/Maquetacion/css/JHDIII/border-anim.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php
  include("../cabezera.php");
  ?>
  <div id="wrapper">
    <?php
    $g = 1;
    include("../plantilla/menu.php");
    echo menu(1, $g); //$_SESSION['nivel']
    ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h2><span class="label label-info"><?php echo $tipo ?></span></h2>
            <form method="post" action='alta_mod.php?v=<?php echo $envi ?>'>
              <label>Nombre :</label>
              <input class="form-control" type="text" name="in[]" value="<?php echo $a[0] ?>" />
              <br />
              <br />
              <input type="submit" class="btn btn-primary" value="<?php echo $nombre ?>">
            </form>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="/Maquetacion/js/sb-admin.min.js"></script>
  <script src="/Maquetacion/js/JHDIII/border-anim.js"></script>
</body>

</html>