<?php

function bajas($query, $vec, $con)
{
  //puede ser necesario alistar un redo...
  //es decir cuando falle algo volver a su estado
  //normal...esto significa no eliminar?o bien usar un sw en cada tabla
  $it = 0;
  foreach ($vec as $ids) {
    $consulta = $query . " " . $ids . ";";
    $res = mysqli_query($con, $consulta);
    if ($res) {
      $it = $it + 1;
    } //no optimizado para ver erores para el ajax u otro
  }
  return (count($vec) == $it);
}


function bajo($query, $vec, $con)
{ ////NOTA: CUANDO HAY ERROR, ESTA ITERACION CONTINUA...NO SE DETIENE CUANDO HAY UN ERROR, y usando $con->error; es posible ver su ultimo error registrado(siempre se sobreescribe si hay orto error)...dentro esa coneccion.
  //puede ser necesario alistar un redo...
  //es decir cuando falle algo volver a su estado
  //normal...esto significa no eliminar?o bien usar un sw en cada tabla
  $it = 0;
  foreach ($vec as $ids) {
    $consulta = $query . $ids . ");";
    $res = mysqli_query($con, $consulta);
    if ($res) {
      $it = $it + 1;
    }
  }
  return (count($vec) == $it);
}

function bajr($query, $vec, $con)
{
  $it = 0;
  foreach ($vec as $ids) {
    $txs = mysqli_query($con, "delete from impresion where idpredido=" . $ids . ";"); //ibidem
    $txx = mysqli_query($con, "delete from deuda where idpredido=" . $ids . ";"); //entre otras cosas
    //    mysqli_close($con);
    //    require '../conexion.php';
    $consulta = $query . $ids . ");";
    $res = mysqli_query($con, $consulta);
    if ($res) {
      $it = $it + 1;
    }
  }
  return (count($vec) == $it);
}

function erasefisrt($aray)
{
  $x = [];
  for ($index = 1; $index < count($aray); $index++) {
    $x[$index - 1] = $aray[$index];
  }
  return $x;
}

function fecha($tabla, $con)
{
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $qry = "SELECT h.fecha FROM historia AS h WHERE h.tabla =  '" . $tabla . "' ORDER BY h.fecha DESC LIMIT 1";
  $rows = mysqli_fetch_array(mysqli_query($con, $qry));
  if ($rows) {
    $fec = new DateTime($rows['fecha']);
    return $fec->format('\A\c\t\u\a\l\i\z\a\d\o \e\l j \d\e ') . $meses[$fec->format('m') - 1] . $fec->format(' \d\e\l Y \a \l\a\s g:i A');
  } else {
    return "Fecha de actualización desconocida.";
  }
}
