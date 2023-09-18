<?php

require("../conexion.php");
$vector = unserialize($_GET['v']);
$consult = 'DELETE FROM procedencia WHERE idprocedencia =';
require_once('../plantilla/procedimientos.php');
$sw = bajas($consult, $vector, $con);
$sal = "<script>";
if ($sw) {
  $sal .= "window.alert('registro(s) eliminado(s) con exito');";
} else {
  $sal .= "window.alert('registro(s) no eliminado(s)');window.alert('Imposible, pertenece a algun pedido.');";
}
$sal .= "window.location ='frm_listar.php';</script>";
echo $sal;
