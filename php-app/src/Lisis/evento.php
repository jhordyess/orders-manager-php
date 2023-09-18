<?php
header('Content-Type: application/json');
require 'cone.php';
$val = $_GET['x'];
$data = array();
$result;
switch ($val) {
  case "1":
    $query = sprintf("select e.nombre as eve, "
      . "l.k  as num "
      . "from evento as e  "
      . "inner join (select p.idevento as id, "
      . "sum(num) as k "
      . "from pedido as p "
      . "inner join (SELECT count(idpedido) as num, " //
      . "idpedido "
      . "FROM `detalle` "
      . "group by idpedido) as v "
      . "on v.idpedido=p.idpedido "
      . "group by idevento) as l "
      . "on e.idevento=l.id;");
    $result = $mysqli->query($query);
    break;
  case "2":
    $query = sprintf("select e.nombre as eve, "
      . "tb.t as bs "
      . "from evento as e "
      . "inner join (select sum(total(p.idpedido)) as t, "
      . "p.idevento as k "
      . "from pedido as p GROUP by p.idevento) as tb "
      . "on tb.k=e.idevento;");
    $result = $mysqli->query($query);
    break;
  default:
    break;
}
foreach ($result as $row) {
  $data[] = $row;
}
//print_r($data);
$result->close();
$mysqli->close();
print json_encode($data);
