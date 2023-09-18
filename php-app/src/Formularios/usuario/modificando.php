<?php
include("../seguridad.php");
include('../conexion.php');
$variable = $_SESSION['id'];
$user = $_POST['usuario'];
$pw1 = $_POST['pwd1'];
$pw1 = md5($pw1);
$pw2 = $_POST['pwd2'];
$pw2 = md5($pw2);
$pw3 = $_POST['pwd3'];
$pw3 = md5($pw3);
if ($pw3 == $pw2) {
  $tuplas = mysqli_num_rows(mysqli_query($con, "select * from usuario as u where (u.password='" . $pw1 . "' and u.id_usuario=" . $variable . ")"));
  if ($tuplas == 1) {
    $query = "update usuario set usuario='" . $user . "',password='" . $pw2 . "' where id_usuario=" . $variable;
    $r = mysqli_query($con, $query);
    if ($r) {
      echo '<script type="text/javascript">alert("Se modifico correctamente");</script>';
      session_destroy();
      echo '<script type="text/javascript">location.href="/index.php";</script>';
    } else {
      echo '<script type="text/javascript">alert("No es posible modificar");location.href="modificar.php";</script>';
    }
  } else {
    echo '<script type="text/javascript">alert("La clave actual no es correcta");location.href="modificar.php";</script>';
  }
} else {
  echo '<script type="text/javascript">alert("La clave nueva no coinciden");location.href="modificar.php";</script>';
}
