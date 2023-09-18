<?php
if (session_id() == '') {
  session_start();
}
if ($_SESSION['ingreso'] != "si") {
  session_destroy();
  // header("location:/index.php?error=2");
  echo "<script>window.location.href='/index.php?error=2';</script>";
}
