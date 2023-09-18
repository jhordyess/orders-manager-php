<?php

require '../conexion.php';
require_once('../plantilla/procedimientos.php');
$ids = unserialize($_GET['v']);
$a = $_POST['in'];
if ($ids == NULL) {
  $consult = "CALL new_evento('" . $a[0] . "','" . $a[1] . "');";
  $sw  = mysqli_query($con, $consult);
  if ($sw) {
    echo "<script>
    window.alert('Registro insertado con exito');
    window.location ='frm_listar.php';
    </script>";
  } else {
    echo "<script>
    window.alert('No registrado');
    window.alert('Cuidado, no se admite valores repetidos');
    window.location ='frm_alta_mod.php?v=';
    </script>";
  }
} else {
  $consult = "CALL modceve('" . $a[0] . "','" . $a[1] . "'," . $ids[0] . ");";
  $sw = mysqli_query($con, $consult);
  $strg = '';
  if ($sw) {
    $strg .= "<script>window.alert('Registro modificado con exito');";
  } else {
    $strg .= "<script>window.alert('Registro no modificado');window.alert('Cuidado, no se admite valores repetidos');";
  }
  if (count($ids) == 1) {
    $strg .= "window.location ='frm_listar.php';";
  } else {
    $ids = erasefisrt($ids);
    $strg .= "window.location ='frm_alta_mod.php?v=" . serialize($ids) . "';";
  }
  $strg .= "</script>";
  echo $strg;
}
