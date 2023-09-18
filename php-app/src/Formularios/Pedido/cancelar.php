<?php

require("../conexion.php");
$vu = $_POST['v']; //donde estan los string de numero
$vector = [];
$vt = []; //copia donde estan los string de numero
require '../plantilla/numeral.php';
for ($index = 0; $index < count($vu); $index++) {
  $vector[$index] = (int)getir($con, $vu[$index]);
  $vt[$index] = $vector[$index];
}
$s = $_POST['s']; //tipo
$sal = "";
if ($s == '0') {
  $consulta = 'DELETE FROM detalle WHERE idpedido =';
  require_once('../plantilla/procedimientos.php');
  $sw = bajas($consulta, $vector, $con);
  if ($sw) {
    $consulta = 'DELETE FROM pedido WHERE idpedido =';
    $sw2 = bajas($consulta, $vt, $con);
    if ($sw2) {
      $sal .= "Registro(s) eliminado(s) correctamente";
    } else {
      $sal .= 'X' . $con->error;
    }
  } else {
    $sal .= 'X' . $con->error;
  }
} elseif ($s == '1') {
  $consulta = "CALL canc(";
  require_once('../plantilla/procedimientos.php');
  $sw = bajr($consulta, $vector, $con);
  if ($sw) {
    $sal .= "Registro(s) cancelado(s) correctamente";
  } else {
    $sal .= 'X' . $con->error;
  }
} elseif ($s == '2') {
  $consulta = "CALL entreg(";
  require_once('../plantilla/procedimientos.php');
  $sw = bajr($consulta, $vector, $con);
  if ($sw) {
    $sal .= "Registro(s) actualizado(s) correctamente";
  } else {
    $sal .= 'X' . $con->error;
  }
} elseif ($s == '3') {
  $consulta = "CALL deudan(";
  require_once('../plantilla/procedimientos.php');
  $sw = bajo($consulta, $vector, $con);
  if ($sw) {
    $sal .= "Registro(s) marcado como deuda";
  } else {
    $sal .= 'X' . $con->error;
  }
}
mysqli_close($con);
echo $sal;
