<?php
header('Content-Type: application/json');
require 'cone.php';
$bol = $_GET['a'];
if ($bol == "1") {
  $ain = "SELECT WEEK(fecharequerida,5) AS sem, ";
} else {
  $ain = "SELECT Month(fecharequerida) as sem, ";
} //al ultimo añado
$query = sprintf($ain
  . "SUM(total(idpedido)) AS tot "
  . "FROM `pedido` "
  . "GROUP BY sem;"); //ordenado ya en ascendente
$result = $mysqli->query($query);
$data = array();
if ($bol != "1") {
  foreach ($result as $row) {
    $data[] = $row;
  }
} else {
  $il = -1; //super sin usar solo use 1 vez
  $aint = 0;
  foreach ($result as $row) {
    $vas = (int) $row['sem']; //semana que entra..
    $il++;
    if ($il == 0) { //una sola vez
      $aint = (int) $row['sem'];
    }
    while ($vas != $aint) {
      $data[] = array("sem" => $aint, "tot" => 0);
      $aint++;
    }
    $data[] = $row;
    $aint++;
  }
}
//print_r($data);
$result->close();
$mysqli->close();
print json_encode($data);
