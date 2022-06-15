<?php
//si se desearia editar en  masa se deberia serializar .. obviamente sera necesario usar a $ids como $ids[0]! y modificar alta_mod.php
require '../conexion.php'; //la uso antes
require '../plantilla/numeral.php';
$envi;
$ids;
if ($_GET['v'] == NULL) { //nuevo
  $envi = NUll;
  $ids = NUll;
} else { //tienda
  $envi = (int) getir($con, $_GET['v']); //SOLO ENVIARE UNO
  //$ids = unserialize($_GET['v']); //donde se almacenan los ids
  $ids = $envi;
}
$a; //valores para los input
$tipo = '';
$nombre = '';
if ($ids == NULL) {
  for ($index = 0; $index < 16; $index++) {
    $a[$index] = '';
  }
  $tipo = "Registrar pedido";
  $nombre = "Grabar";
} else {
  $a = mysqli_fetch_array(mysqli_query($con, "CALL `ver_pedido`(" . $ids . ");"));
  mysqli_close($con);
  require '../conexion.php';
  //+-+-solo se añadio esto +-//
  $deu = (int)mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM deuda as d where d.idpredido=" . $ids . ";"))[0];
  if ($deu == 1) {
    $Op = mysqli_query($con, "delete from impresion where idpredido=" . $ids . ";");
    $oP = mysqli_query($con, "delete from deuda where idpredido=" . $ids . ";");
  }
  //+-+-+-+-+-+-+-+-+-+-+-+-//

  $tipo = "Modificar pedido";
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
  <link href="/Maquetacion/css/JHDIII/tallas.css" rel="stylesheet">
  <link href="/Maquetacion/css/JHDIII/border-anim.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php
  include("../cabezera.php");
  ?>
  <div id="wrapper">
    <?php
    $g = 5;
    include("../plantilla/menu.php");
    echo menu(1, $g); //$_SESSION['nivel']
    ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h2><span class="label label-info"><?php echo $tipo ?></span></h2>
            <form onsubmit="return validateForm()" method="post" action='alta_mod.php?v=<?php echo $envi ?>'>
              <fieldset>
                <legend>Datos del evento</legend>
                <div class="form-group row">
                  <div class="col col-md-12">
                    <div class="row">
                      <div class="col col-md-2 col-sm-4">
                        <label>Evento</label>
                        <input type="text" class="form-control" name='en[]' list="evets" autocomplete="off" required="required" value="<?php echo $a[0] ?>">
                        <datalist id="evets">
                          <!--  <option value='1'>ss</option>-->
                          <?php
                          $aint = '';
                          $res = mysqli_query($con, "select nombre from evento where sw=1");
                          while ($reg = mysqli_fetch_array($res)) {
                            $aint .= "<option value='" . $reg[0] . "'></option>";
                          }
                          echo $aint;
                          ?>
                        </datalist>
                      </div>
                      <div class="col col-sm-1">
                        <label for="ch2">Recordar</label>
                        <input class="form-control" id="ch2" style="margin-top: 5px" type='checkbox' name='m' <?php
                                                                                                              if ($a[1] == '1') {
                                                                                                                echo 'checked="checked"';
                                                                                                              }
                                                                                                              ?>>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Datos de cliente</legend>
                <div class="form-group row">
                  <div class="col col-sm-12">
                    <div class="row">
                      <div class="col col-sm-2">
                        <label for="selbox">Cliente</label>
                        <input type="text" class="form-control" name='en[]' list="clos" autocomplete="off" required="required" value="<?php echo $a[2] ?>">
                        <datalist id="clos">
                          <!--  <option value='1'>ss</option>-->
                          <?php
                          $aint = '';
                          $res = mysqli_query($con, "select nombre from cliente where sw=1");
                          while ($reg = mysqli_fetch_array($res)) {
                            $aint .= "<option value='" . $reg[0] . "'></option>";
                          }
                          echo $aint;
                          ?>
                        </datalist>
                      </div>
                      <div class="col col-sm-2">
                        <label for="y">C. I.</label>
                        <input type="text" name="en[]" id="y" class="form-control" required="required" value="<?php echo $a[3] ?>" />
                      </div>
                      <div class="col col-sm-2">
                        <label for="z">Celular</label>
                        <input type="text" name="en[]" id="z" class="form-control" required="required" value="<?php echo $a[4] ?>" />
                      </div>
                      <div class="col col-sm-1">
                        <label for="ch1">Recordar</label>
                        <input class="form-control" id="ch1" style="margin-top: 5px" type='checkbox' name='n' <?php
                                                                                                              if ($a[5] == '1') {
                                                                                                                echo 'checked="checked"';
                                                                                                              }
                                                                                                              ?>>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Poleras escogidas</legend>
                <div class="form-group row">
                  <div class="col col-sm-12" id="incremental">
                    <?php
                    include '../plantilla/modificar.php';
                    echo lapo($con, $ids);
                    ?>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Datos de pedido</legend>
                <div class="form-group row">
                  <div class="col col-sm-12">
                    <div class="row">
                      <div class="col col-sm-2">
                        <label>A cuenta</label>
                        <input required="required" class="form-control" type="number" min="0" name="en[]" id="cuenta" autocomplete="off" value="<?php echo $a[6] ?>" />
                      </div>
                      <div class="col col-sm-2">
                        <label>Saldo</label>
                        <?php
                        $alz = 0;
                        $vs = 0;
                        if ($ids != NULL) {
                          $alz = mysqli_fetch_array(mysqli_query($con, "SELECT `total`(" . $ids . ");"))[0];
                          $vs = (float) $alz - (float) $a[6];
                        }
                        ?>
                        <input class="form-control" type="text" id="saldo" disabled="disabled" value="<?php echo $vs; ?>" />
                      </div>
                      <div class="col col-sm-2">
                        <label>Total</label>

                        <input class="form-control" type="text" id="total" disabled="disabled" value="<?php echo $alz; ?>" />

                      </div>
                      <div class="col col-sm-6">
                        <label>Entidad</label>
                        <div style="font-size: 12.5pt;margin-top: 5px">
                          <?php
                          $txt = "";
                          $res = mysqli_query($con, "select idEntidad, banco from entidad order by idEntidad asc");
                          while ($reg = mysqli_fetch_array($res)) {
                            $txt .= '<label class="radio-inline">'
                              . '<input type="radio" name="a" value="' . $reg[0] . '"';
                            if ($a[7] == $reg[0]) {
                              $txt .= ' checked="checked"';
                            }
                            $txt .= '> ' . $reg[1] . '</label><span style="margin-right:12px"></span>';
                          }
                          echo $txt;
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>Informacion extra</legend>
                <div class="form-group row">
                  <div class="col col-sm-12">
                    <div class="row">
                      <div class="col col-sm-2">
                        <label>Fecha de partida</label>
                        <input required="required" id="fecha" class="form-control" type='date' name='en[]' <?php
                                                                                                            if ($a[8] == '') {
                                                                                                              echo ' readonly="readonly"';
                                                                                                            } else {
                                                                                                              echo ' value="' . $a[8] . '"';
                                                                                                            }
                                                                                                            ?>>
                      </div>
                      <div class="col col-sm-2">
                        <label>Fecha de entrega</label>
                        <input required="required" id="entrega" class="form-control" type="date" name="en[]" <?php
                                                                                                              if ($a[9] != '') {
                                                                                                                echo ' value="' . $a[9] . '"';
                                                                                                              }
                                                                                                              ?> />
                      </div>

                      <?php
                      if ($ids != NULL) {

                        echo '<div class="col col-sm-2">
      <label>Fecha de salida</label>
      <input id="vonly" class="form-control" type ="date" name="ali" value="' . $a[10] . '"/>
      </div>';
                        echo '<div class="col col-sm-1">
      <label>Cancelado</label>
      <div style="font-size: 12.5pt;margin-top: 5px"> <label class="radio-inline">';
                        if ($a[11] == '1') {
                          echo '<input type="radio" name="ftg" value="1" checked="checked"> si';
                        } else {
                          echo '<input type="radio" name="ftg" value="1" >si';
                        }
                        echo '</label><span style="margin-right:12px"></span><label class="radio-inline">';
                        if ($a[11] == '0') {
                          echo '<input type="radio" name="ftg" value="0" checked="checked"> no';
                        } else {
                          echo '<input type="radio" name="ftg" value="0" >no';
                        }
                        echo '</label><span style="margin-right:12px"></span></div></div>';
                      }
                      ?>
                      <div class="col col-sm-2">
                        <label>Destino</label>
                        <input required="required" type="text" class="form-control" name='en[]' list="dis" autocomplete="off" value="<?php echo $a[12] ?>">
                        <label for="ch4">Recordar</label>
                        <input class="form-control" id="ch4" style="margin-top: 5px" type='checkbox' name='o' <?php
                                                                                                              if ($a[13] == '1') {
                                                                                                                echo 'checked="checked"';
                                                                                                              }
                                                                                                              ?>>
                        <datalist id="dis">
                          <!--  <option value='1'>ss</option>-->
                          <?php
                          $aint = '';
                          $res = mysqli_query($con, "select Nombre from destino where sw=1");
                          while ($reg = mysqli_fetch_array($res)) {
                            $aint .= "<option value='" . $reg[0] . "'></option>";
                          }
                          echo $aint;
                          ?>
                        </datalist>
                      </div>
                      <div class="col col-sm-3">
                        <label>Procedencia</label>
                        <div style="font-size: 12.5pt;margin-top: 5px">
                          <?php
                          $txt = "";
                          $res = mysqli_query($con, "select idprocedencia, tipo from procedencia order by idprocedencia asc");
                          while ($reg = mysqli_fetch_array($res)) {
                            $txt .= '<label class="radio-inline">' . '<input type="radio" name="b" value="' . $reg[0] . '"';
                            if ($a[14] == $reg[0]) {
                              $txt .= ' checked="checked"';
                            }
                            $txt .= '> ' . $reg[1] . '</label><span style="margin-right:12px"></span>';
                          }
                          echo $txt;
                          ?>
                        </div>
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col col-sm-6">
                        <label>Comentario</label>
                        <textarea class="form-control" rows="3" name="en[]"><?php echo $a[15] ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                  <input type="submit" class="btn btn-primary" value="<?php echo $nombre ?>">
                </div>
              </div>
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
  //+-+-solo se añadio esto +-//
  if ($deu == 1) {
    echo "<script>alert('Se actualizara como pedido pendiente');</script>";
  }
  //+-+-+-+-+-+-+-+-+-+-+-+-//
  ?>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/Maquetacion/js/bootstrap-add-clear.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="/Maquetacion/js/sb-admin.min.js"></script>
  <script src="/Maquetacion/js/JHDIII/secondpedido.js"></script>
  <script src="/Maquetacion/js/JHDIII/border-anim.js"></script>
</body>

</html>