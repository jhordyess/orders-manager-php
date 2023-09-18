<?php
include '../conexion.php';
$que = "SELECT COUNT(*) FROM impresion;";
$sta = (int)mysqli_fetch_array(mysqli_query($con, $que))[0];
$aim = "";
if ($sta > 0) {
  $aim = "0";
} elseif ($sta == 0) {
  $aim = "1";
  //}else{
  //  $aim="0";
}
mysqli_close($con);
echo $aim;
