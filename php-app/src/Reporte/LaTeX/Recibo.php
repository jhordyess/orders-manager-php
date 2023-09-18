<?php

//parece dar problemas si usas \n y lo demas no encontre...
//es meter el codigo a renew command la unica diferencia es no chocar con los Escaped characters de php
//puedes ver  lista en http://php.net/manual/es/language.types.string.php
$test = '';
if (isset($_GET['a'])) {
  require '../../Formularios/conexion.php';
  require_once('latexPHP.php');
  require_once '../../Formularios/plantilla/numeral.php';
  $idpedido = (int) getir($con, $_GET['a']);
  // obteniendo serie
  $rc = mysqli_fetch_array(mysqli_query($con, "select nro from nume where ipfedido=" . $idpedido . ""))[0];
  if (is_numeric($rc)) { //cuando del cliente
    $t = (int) $rc + 1000;
    $serie = "00" . $t . "";
  } else { //cuando tienda
    $t = (int) substr($rc, 1) + 1000; //ojito
    $os = $rc[0];
    $serie = "" . $os . "00" . $t . "";
  }
  //obteniendo lo demas
  $qu = "SELECT p.fechaorden,e.nombre,c.nombre,c.celular,p.fecharequerida,p.detalle,p.acuenta
    FROM pedido as p inner join evento as e on e.idevento=p.idevento inner join cliente as c on c.idcliente=p.idcliente where p.idpedido=" . $idpedido . ";";
  $rb = mysqli_query($con, $qu);
  if (mysqli_num_rows($rb) == 1) {
    while ($reg = mysqli_fetch_array($rb)) {
      $x = '' . $reg[0] . '';
      $y = explode("-", $x);
      $fhp = $y[2] . '-' . $y[1] . '-' . $y[0];
      $eve = $reg[1];
      $cli = $reg[2];
      $cel = $reg[3];
      $x = '' . $reg[4] . '';
      $y = explode("-", $x);
      $fhe = $y[2] . '-' . $y[1] . '-' . $y[0];
      if (is_null($reg[5])) {
        $com = "-";
      } else {
        $com = $reg[5];
      }
      $cue = (float) $reg[6];
    }
    $ra = mysqli_query($con, "SELECT `total`(" . $idpedido . ") AS `total`;");
    $tot = (float) mysqli_fetch_array($ra)[0];
    $sal = $tot - $cue;
    //-- generando
    $test = "\\renewcommand{\\arraystretch}{1.7}\n" .
      "\\begin{table}[t!]\n" .
      "\\small\n" .
      "\\resizebox{\\linewidth}{!}{\n" .
      "\\begin{tabular}{P{4cm}|P{1.75cm}|P{2.35cm}|}\n" . //%9.5cm
      "\\multicolumn{1}{c}{}& \\multicolumn{2}{c}{\\tt \\textbf{\\color{red} Nº " . $serie . "}}\\\\\n" .
      "\\cline{2-3}\n" .
      "\\multirow{3}{*}{\n" .
      "\\url{https://jhordyess.com}\n" .
      "}& \\footnotesize\\textbf{RECIBO}& \\footnotesize\\textbf{FECHA} \\\\\n" .
      "\\cline{2-3}\n" .
      "&\\footnotesize\\textbf{EVENTO} & \\tt " . $fhp . "  \\\\ \n" .
      "\\cline{3-3}\n" .
      "&\\multicolumn{2}{c|}{\\tt " . $eve . "}\\\\\n" .
      "\\cline{2-3}\n" .
      "\\end{tabular}\n" .
      "}\n" .
      "\\end{table}\n" .
      "\\begin{table}[t!]\n" .
      "\\small\n" .
      "\\resizebox{\\linewidth}{!}{\n" .
      "\\begin{tabular}{|L{1.3cm}L{2.5cm}L{1.4cm}L{2.5cm}|}\n" .
      "\\hline\n" .
      "\\textbf{Señor:} & \\multicolumn{3}{l|}{\\tt " . $cli . "}\\\\ \n" .
      "\\textbf{Celular:} & \\tt " . $cel . " & \\textbf{Entrega:} &\\tt " . $fhe . "\\\\\n" .
      "\\hline\n" .
      "\\end{tabular}\n" .
      "}\n" .
      "\\end{table}" .
      "\\renewcommand{\\arraystretch}{1.2}\n"
      . "\\begin{table}[t!]\n"
      . "\\small\n"
      . "\\resizebox{\\linewidth}{!}{\n"
      . "\\begin{tabular}{|P{1cm}|P{2.2cm}|P{1cm}|P{1.5cm}|P{1.5cm}|}\n"
      . "\\hline\n"
      . "\\textbf{Cant.} & \\textbf{Código} & \\textbf{Talla} & \\textbf{P/U} & \\textbf{Total} \\\\\n"
      . "\\hline";
    $conqe = "SELECT d.cantidad,e.code,t.talla,d.precio_u from detalle as d "
      . "inner join tallas as t on t.idtallas=d.idtallas "
      . "inner join polera as e on e.idpolera=d.idpolera "
      . "where d.idpedido=" . $idpedido . ";";
    $unn = "&  &  &  &  \\\\\\hline\n";
    $r = mysqli_query($con, $conqe);
    if ($r) {
      if (mysqli_num_rows($r) > 0) {
        $ix = 0;
        $lines = 7;
        while ($row = mysqli_fetch_array($r)) {
          $ix++;
          $c = (float) $row[0] * (float) $row[3];
          $test .= "\\tt " . $row[0] . " & "
            . "\\tt " . $row[1] . " & "
            . "\\tt " . $row[2] . " & "
            . "\\tt " . $row[3] . " & "
            . "\\tt " . $c . " \\\\\n"
            . "\\hline\n";
        }
        for ($index = $ix; $index < $lines; $index++) {
          $test .= $unn;
        }
      } else {
        for ($index = 0; $index < $lines; $index++) {
          $test .= $unn;
        }
      }
    } else {
      for ($index = 0; $index < $lines; $index++) {
        $test .= $unn;
      }
    }
    $test .= "\\end{tabular}\n" .
      "}\n" .
      "\\end{table}\n" .
      "\\renewcommand{\\arraystretch}{1.5}\n" .
      "\\begin{table}[t!]\n" .
      "\\small\n" .
      "\\resizebox{\\linewidth}{!}{\n" .
      "\\begin{tabular}{|P{1.6cm}P{1cm}P{1.5cm}P{1cm}P{1.5cm}P{1cm}|}\n" .
      "\\hline\n" .
      "\\textbf{A cuenta:} & " . $cue . " & \\textbf{Saldo:} & " . $sal . " & \\textbf{Total:} & " . $tot . " \\\\\n" .
      "\\hline \n" .
      "\\multicolumn{6}{|l|}{\n" .
      "\\begin{minipage}[l]{9.5cm}\n" .
      "\\medskip\n" .
      "" . $com . "\n" .
      "\\medskip\n" .
      "\\end{minipage}\n" .
      "}  \\\\\n" .
      "\\hline \n" .
      "\\multicolumn{6}{|c|}{\n" .
      "\\begin{minipage}[c]{8cm}\n" .
      "\\centering\n" .
      "\\medskip\n" .
      "\\url{https://jhordyess.com}\n" .
      "\\medskip\n" .
      "\\end{minipage}\n" .
      "} \\\\\n" .
      "\\hline\n" .
      "\\end{tabular}\n" .
      "}\n" .
      "\\end{table}";

    try {
      LatexTemplate::download(array('test' => $test), 'Recibo.tex', 'Recibo.pdf');
      mysqli_close($con);
    } catch (Exception $e) {
      mysqli_close($con);
      echo '<script>alert("' . $e->getMessage() . '");window.close();</script>';
    }
  } else {
    mysqli_close($con);
    echo '<script>alert("Error con pedido no existe en la db");window.close();</script>';
  }
} else {
  echo '<script>alert("Error con el acceso a la pagina");window.close();</script>';
}
