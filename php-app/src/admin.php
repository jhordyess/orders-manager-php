<?php
include("Formularios/seguridad.php");
$acse = $_SESSION['nivel'];
if ($acse == 1 || $acse == 2) {
  // header("location:Formularios/Pagina%20principal.php");
  echo "<script>window.location.href='Formularios/Pagina%20principal.php';</script>";
} else {
  //session_destroy();
  // header("location:/index.php?error=4");
  echo "<script>window.location.href='/index.php?error=4';</script>";
}
