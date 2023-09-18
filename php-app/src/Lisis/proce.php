<?php

//setting header to json
header('Content-Type: application/json');
require 'cone.php';

//query to get data from the table
$query = sprintf("SELECT d.tipo as nom, "
  . "mn.fi as can "
  . "FROM procedencia AS d "
  . "INNER JOIN (SELECT idprocedencia, "
  . "Count(idprocedencia) AS fi "
  . "FROM   pedido AS p "
  . "GROUP  BY idprocedencia) AS mn "
  . "ON mn.idprocedencia = d.idprocedencia "
  . "ORDER  BY mn.fi DESC;");
//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}
//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
