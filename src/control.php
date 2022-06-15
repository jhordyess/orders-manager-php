<?php
include("Formularios/conexion.php");
$usr = $_POST['usr'];
$pwd = $_POST['pwd'];
$pwd = md5($pwd);
$qr = "SELECT u.usuario AS 'nombre'
	,u.id_usuario AS 'id'
	,u.nivel AS 'nivel'
	,u.is_active AS 'activo'
      FROM usuario as u
      WHERE (u.usuario = '$usr' AND u.password = '$pwd' );";
$rs = mysqli_query($con, $qr);
//echo "<script>console.log(\"".$qr."\");</script>";
if (mysqli_num_rows($rs) == 1) {
  session_start();
  if ($r = mysqli_fetch_array($rs)) {
    if ($r['activo'] == '1') {
      $_SESSION['nombre'] = $r['nombre'];
      $_SESSION['id'] = $r['id'];
      $_SESSION['nivel'] = $r['nivel'];
      $_SESSION['ingreso'] = 'si';
      //header("location:admin.php");
      echo "<script>window.location.href='admin.php';</script>";
    } else {
      session_destroy();
      //header("location:index.php?error=3");
      echo "<script>window.location.href='index.php?error=3';</script>";
    }
  }
} else {
  session_destroy();
  // header("location:index.php?error=1");
  echo "<script>window.location.href='index.php?error=1';</script>";
}
