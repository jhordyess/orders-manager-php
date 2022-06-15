<?php

$con = mysqli_connect("mysql", "root", "hswE]ktX@_R5t3.", "orders-db");
if (!$con) {
  mysqli_close($con);
  session_destroy();
  //header("location:/index.php?error=5");
  echo "<script>window.location.href='/index.php?error=5';</script>";
}
