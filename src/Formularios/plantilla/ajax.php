<?php

error_reporting(E_ALL);
switch ($_POST['a']) {
  case "1":
    getdats($_POST['id']);
    break;
  case "detalle":
    detalle($_POST['id']);
    break;
  case "2":
    include_once('../conexion.php');
    $conqe = "SELECT sw from evento where nombre='" . $_POST['id'] . "';";
    $r = mysqli_query($con, $conqe);
    if ($r) {
      echo (mysqli_fetch_array($r)[0]);
    } else {
      echo '0';
    }
    mysqli_close($con);
    break;
  case "3":
    include_once('../conexion.php');
    $conqe = "SELECT sw from destino where Nombre='" . $_POST['id'] . "';";
    $r = mysqli_query($con, $conqe);
    if ($r) {
      echo (mysqli_fetch_array($r)[0]);
    } else {
      echo '0';
    }
    mysqli_close($con);
    break;
  default:
    echo mesagge('Error de,servidor');
    break;
}

function getdats($nn)
{
  include_once('../conexion.php');
  $output = ",";
  $qu = "select ci,celular,sw from cliente where (nombre='" . $nn . "' && sw=1);";
  $res = mysqli_query($con, $qu);
  if ($reg = mysqli_fetch_array($res)) {
    $output = $reg[0] . ',' . $reg[1] . ',' . $reg[2];
  }
  mysqli_close($con);
  echo $output;
}

function detalle($air)
{
  require_once "./numeral.php";
  include_once('../conexion.php');
  $id = (int) getir($con, $air);
  $conqe = "SELECT e.code,t.talla,d.cantidad,d.precio_u from detalle as d "
    . " inner join tallas as t on t.idtallas=d.idtallas"
    . " inner join polera as e on e.idpolera=d.idpolera where idpedido=" . $id . ";";
  $r = mysqli_query($con, $conqe);
  $stop = '';
  if ($r) {
    if (mysqli_num_rows($r) > 0) {
      $sum = 0;
      $stop .= "<table style='empty-cells: show;' class='table table-bordered table-sm' ><thead><tr>"
        . "<th style='text-align:center'>Código</th>"
        . "<th style='text-align:center'>Talla</th>"
        . "<th style='text-align:center'>Cant.</th>"
        . "<th style='text-align:center'>P/U</th>";
      $stop .= "<th style='text-align:center'>Subtotal</th>"
        . "</tr></thead><tbody>";

      while ($row = mysqli_fetch_array($r)) {
        $stop .= "<tr>";
        $stop .= "<td align='center'>" . $row[0] . "</td>";
        $stop .= "<td align='center'>" . $row[1] . "</td>";
        $stop .= "<td align='center'>" . $row[2] . "</td>";
        $stop .= "<td align='right'>" . $row[3] . "</td>";
        $c = (float) $row[2] * (float) $row[3];
        $stop .= "<td align='right'>" . $c . "</td>";
        $stop .= "</tr>";
        $sum = (float)$sum + $c;
      }

      //      if(mysqli_num_rows($r)>1){
      //        $XE="select p.acuenta from pedido as p where p.idpedido=".$id.";";
      //        $acuenta = mysqli_fetch_array(mysqli_query($con, $XE))[0];
      //        $stop .= "<tr>";
      //        $stop.="<td style='border-bottom-color:white;border-left-color:white'></td>"
      //                . "<td align='center'><b>A cuenta</b></td>"
      //                . "<td>".$acuenta."</td>"
      //                . "<td align='center'><b>Total</b></td>";
      //        $stop .= "<td align='right' style='font-weight: bold'>" . $sum . "</td>";
      //        $stop .= "</tr>";
      //      }else if(mysqli_num_rows($r)==1){
      $XE = "select p.acuenta from pedido as p where p.idpedido=" . $id . ";";
      $acuenta = mysqli_fetch_array(mysqli_query($con, $XE))[0];
      $saldo = $sum - $acuenta;
      $stop .= "</tbody></table>";

      $stop .= "<table style='empty-cells: show;' class='table table-bordered table-sm' ><thead><tr>"
        . "<th style='text-align:center'>A cuenta</th>"
        . "<th style='text-align:center'>Saldo</th>";
      $stop .= "<th style='text-align:center'>Total</th>"
        . "</tr></thead><tbody>";


      $stop .= "<tr>";
      $stop .= "<td align='center'>" . $acuenta . "</td>";
      $stop .= "<td align='center'>" . $saldo . "</td>";
      $stop .= "<td align='center'>" . $sum . "</td>";
      $stop .= "</tr>";

      $stop .= "</tbody></table>";
    } else {
      $stop = "Error, el pedido no tiene detalle";
    }
  } else {
    $stop = "Warning the id was -1, not correct id getting from checkbox's value";
  }
  mysqli_close($con);
  echo $stop;
}
