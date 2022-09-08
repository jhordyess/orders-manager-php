<?php

$con = mysqli_connect(
  getenv("DB_HOST"),
  getenv("DB_USER"),
  getenv("DB_PASSWORD"),
  getenv("DB_NAME")
);
if (!$con) {
  mysqli_close($con);
  session_destroy();
  //header("location:/index.php?error=5");
  echo "<script>window.location.href='/index.php?error=5';</script>";
}
