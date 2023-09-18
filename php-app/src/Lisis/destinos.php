<?php

//setting header to json
header('Content-Type: application/json');

require 'cone.php';

//query to get data from the table
$query = sprintf("SELECT d.nombre as nom, "
  . "mn.fi as can "
  . "FROM destino AS d "
  . "INNER JOIN (SELECT iddestino, "
  . "Count(iddestino) AS fi "
  . "FROM   pedido AS p "
  . "GROUP  BY iddestino) AS mn "
  . "ON mn.iddestino = d.iddestino "
  . "where d.sw=1 "
  . "ORDER  BY mn.fi DESC;");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}
$query = sprintf("SELECT sum(mn.fi) as x "
  . "FROM destino AS d "
  . "INNER JOIN (SELECT iddestino, "
  . "Count(iddestino) AS fi "
  . "FROM   pedido AS p "
  . "GROUP  BY iddestino) AS mn "
  . "ON mn.iddestino = d.iddestino "
  . "where d.sw=0;"); //SELECT sum(mn.fi) as xFROM destino AS d INNER JOIN (SELECT iddestino, Count(iddestino) AS fi FROM pedido AS p GROUP BY iddestino) AS mn ON mn.iddestino = d.iddestino where d.sw=0;
$result = $mysqli->query($query);
foreach ($result as $row) {
  $data[] = [
    "nom" => "Otros",
    "can" => $row['x'],
  ];
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
