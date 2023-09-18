<?php

//parece dar problemas si usas \n y lo demas no encontre...
//es meter el codigo a renew command la unica diferencia es no chocar con los Escaped characters de php
//puedes ver  lista en http://php.net/manual/es/language.types.string.php
require_once('latexPHP.php');
require '../../Formularios/conexion.php';
$test = '';
$qu = "";
$res;
$ve = false;
if (isset($_GET['v'])) { //uno solo?
  require_once '../../Formularios/plantilla/numeral.php';
  $records = json_decode($_GET['v']); //asta aca es un vector
  $rds = (int) getir($con, $records[0]);
  $optar = "where (";
  $alx = count($records);
  for ($index = 0; $index < $alx; $index++) {
    $rds = (int) getir($con, $records[$index]);
    if ($alx == ($index + 1)) {
      $optar .= "p.idpedido=" . $rds . "";
    } else {
      $optar .= "p.idpedido=" . $rds . " or ";
    }
  }
  $optar .= ");";
  $qu = "SELECT lk.nro,c.nombre,c.ci,c.celular,dd.Nombre,nn.tipo,p.acuenta,p.detalle ";
  $qu .= "FROM pedido as p ";
  $qu .= "inner join nume as lk on lk.ipfedido=p.idpedido ";
  $qu .= "inner join cliente as c on c.idcliente=p.idcliente ";
  $qu .= "inner join destino as dd on dd.iddestino=p.iddestino ";
  $qu .= "inner join procedencia as nn on nn.idprocedencia=p.idprocedencia ";
  $qu .= $optar;
  $res = mysqli_query($con, $qu);
  $ve = false;
} else { //para todo
  $qu = "SELECT lk.nro,c.nombre,c.celular,c.ci,dd.Nombre,nn.tipo,p.acuenta,p.detalle ";
  $qu .= "FROM pedido as p ";
  $qu .= "inner join nume as lk on lk.ipfedido=p.idpedido ";
  $qu .= "inner join cliente as c on c.idcliente=p.idcliente ";
  $qu .= "inner join destino as dd on dd.iddestino=p.iddestino ";
  $qu .= "inner join procedencia as nn on nn.idprocedencia=p.idprocedencia ";
  $qu .= "inner join impresion as il on il.idpredido=p.idpedido "; //para seleccionar solo pendientes
  $qu .= "where (p.sw=0 and p.fechaenviada is null) order by dd.Nombre;";
  $res = mysqli_query($con, $qu);
  $ve = true;
}
$tipl = 0;
if (mysqli_num_rows($res) == 0) {
  $test = "Usted ya imprimio su itinerario";
} else {
  while ($reg = mysqli_fetch_array($res)) {
    require_once '../../Formularios/plantilla/numeral.php';
    $ix = (int) getir($con, $reg[0]);
    $MORA = "";
    $quS = "SELECT MORADO(" . $ix . ");"; //si esta en morita
    $MORA .= mysqli_fetch_array(mysqli_query($con, $quS))[0];
    if ($MORA == '1') {
      $MORA = "! EN MORA";
    } else {
      $MORA = "";
    }
    $tipl = $tipl + 1;
    $nombre = $reg[1];
    $celular = $reg[2];
    $ci = $reg[3];
    $destino = $reg[4];
    $procedencia = $reg[5];
    $acount = $reg[6];
    $comet = $reg[7];

    $compls = $reg[0];
    $vcc;
    if (is_numeric($compls)) { //cuando del cliente
      $t = (int) $compls + 1000;
      $vcc = $t . "";
    } else { //cuando tienda
      $t = (int) substr($compls, 1) + 1000; //ojito
      $os = $compls[0];
      $vcc = "" . $os . $t . "";
    }

    $test .= "\\begin{table}[t!]" .
      "\\resizebox{\\linewidth}{!}{" .
      "\\begin{tabular}{|p{4cm}p{4cm}p{3.4cm}p{3.4cm}|p{3.5cm}|}" .
      "\\hline\n";
    $test .= "\\multicolumn{2}{|l}{\\textbf{Nombre:} " . $nombre . "}& \\textbf{Cel:} " . $celular . " & \\textbf{CI:} " . $ci . "  &\\multirow{5}{*}{" .
      "\\begin{minipage}{3.25cm}" .
      "\\textbf{Nombre:}\\\\" .
      "" . $nombre . "\\\\" .
      "\\textbf{Destino:}\\\\" .
      "" . $destino . "\\\\" .
      "\\textbf{Codigo:}\\\\" .
      "" . $vcc . "\\\\[.15cm]" .
      "\\textbf{Detalle:}\\\\" .
      "" . $comet . "" .
      "\\end{minipage}" .
      "}\\\\" .
      "\\multicolumn{2}{|l}{\\textbf{Destino:} " . $destino . "} &\\multicolumn{2}{l|}{\\textbf{Procedencia:} " . $procedencia . "}&\\\\ \\cline{1-4}" .
      "\\multicolumn{4}{|c|}{";
    $qu = "SELECT d.cantidad,e.code,t.talla from detalle as d "
      . "inner join tallas as t on t.idtallas=d.idtallas "
      . "inner join polera as e on e.idpolera=d.idpolera "
      . "where d.idpedido=" . $ix . ";";
    $ras = mysqli_query($con, $qu);
    $nxs = mysqli_num_rows($ras);
    if ($nxs > 0 && $nxs < 13) { //12 tuplas sin titulo
      $star = 1;
      $test .= "\\begin{tabular}{p{3cm}p{3cm}p{3cm}}" .
        "\\textbf{Código} &\\textbf{Talla}&\\textbf{Cant.}  \\\\ ";
      while ($rag = mysqli_fetch_array($ras)) {
        $test .= "" . $rag[1] . " & " . $rag[2] . " & " . $rag[0] . "\\\\ ";
        $star = $star + 1;
      }
      while ($star < 13) { //max 12 tuplas
        $test .= "& & \\\\ ";
        $star = $star + 1;
      }
      $test .= "\\end{tabular} ";
    } else if ($nxs > 12 && $nxs < 25) { //max 24 tuplas
      $star = 1;
      $test .= "\\begin{tabular}{p{1.5cm}p{1.5cm}p{1.5cm} c p{1.5cm}p{1.5cm}p{1.5cm}}" .
        "\\textbf{Cod.} &\\textbf{Talla} &\\textbf{Cant.} &&\\textbf{Cod.} &\\textbf{Talla} &\\textbf{Cant.}  \\\\ ";
      while ($rag = mysqli_fetch_array($ras)) {
        $test .= "" . $rag[1] . " & " . $rag[2] . " & " . $rag[0];
        $star = $star + 1;
        if ($rag = mysqli_fetch_array($ras)) {
          $test .= "&&" . $rag[1] . " & " . $rag[2] . " & " . $rag[0];
        } else {
          $test .= "&&  &  & ";
        }
        $test .= "\\\\";
      }
      while ($star < 13) { //max 24 tuplas
        $test .= "& & && & &\\\\ ";
        $star = $star + 1;
      }
      $test .= "\\end{tabular} ";
    } else if ($nxs > 24) {
      $test .= "\\begin{tabular}{p{3cm}p{3cm}p{3cm}}"
        . "\\multicolumn{3}{c}{Alerta, se supero los 24 pedidos maximos para imprimir}\\\\"
        . "&& \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\"
        . "\\end{tabular} ";
    } else {
      $test .= "\\begin{tabular}{p{3cm}p{3cm}p{3cm}}"
        . "\\multicolumn{3}{c}{Error, el pedido no tiene poleras asignadas}\\\\"
        . "&& \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\ && \\\\"
        . "\\end{tabular} ";
    }
    $qu = "SELECT total(p.idpedido) from pedido as p where p.idpedido=" . $ix . ";";
    $total = mysqli_fetch_array(mysqli_query($con, $qu))[0];
    $sald = (float) $total - (float) $acount;
    //-+-+-+-+-+-+-
    $MORA = "\\textbf{Codigo: }" . $vcc . "";
    //-+-+-+-+-+-+-
    $test .= "}&\\\\\\cline{1-4}" .
      " \\multicolumn{4}{|l|}{\\textbf{Detalle:} " . $comet . "}&\\\\" .
      "" . $MORA . "& \\textbf{A cuenta:} " . $acount . "  & \\textbf{Saldo:} " . $sald . " & \\textbf{Total:} " . $total . "&\\\\\\hline" .
      " \\end{tabular}}";
    $test .= "\\end{table}";

    if ($tipl % 3 == 0) {
      $test .= "\\clearpage"; //cambiado de \newpage a \clearpage
    }
  }
  if ($tipl % 3 != 0) {
    $test .= "$\\bigtriangledown$"; //esto no tiene el de cliente
  }
}
try {
  LatexTemplate::download(array('test' => $test), 'Itinerario.tex', 'itinerario.pdf', '');
  if ($ve) {
    //$que = "TRUNCATE TABLE impresion;"; //puede no tener permisos, 
    $que = "delete from impresion;";
    $sta = mysqli_query($con, $que);
  }
  mysqli_close($con);
} catch (Exception $e) {
  mysqli_close($con);
  //echo '<script>alert("'.$e->getMessage().'");window.close();</script>';
}
