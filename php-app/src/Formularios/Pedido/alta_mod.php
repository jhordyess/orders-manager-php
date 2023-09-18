<?php

require '../conexion.php';
//$ids = unserialize($_GET['v']);
$ids = $_GET['v'];
$quer = '';
for ($index = 0; $index < count($_POST['en']); $index++) {
  if ($index === 4) {
    $quer .= $_POST['en'][$index] . ",";
  } else {
    if ($index === 8 && $_POST['en'][$index] === '') {
      $quer .= "NULL,";
    } else {
      $quer .= "'" . $_POST['en'][$index] . "',";
    }
  }
}
$quer .= $_POST['a'] . "," . $_POST['b'] . ",";
if (!isset($_POST['m'])) {
  $quer .= 0;
} else {
  $quer .= 1;
}
$quer .= ',';
if (!isset($_POST['n'])) {
  $quer .= 0;
} else {
  $quer .= 1;
}
$quer .= ',';
if (!isset($_POST['o'])) {
  $quer .= 0;
} else {
  $quer .= 1;
}

if ($ids == NULL) {
  $quer = "call new_pedi(" . $quer . ');';
  $verif = '';
  $sw = mysqli_query($con, $quer);
  if ($sw) {
    while ($reg = mysqli_fetch_array($sw)) {
      $idpedido = $reg[0];
    }
    mysqli_close($con);
    require '../conexion.php';
    $jans = mysqli_query($con, "insert into nume values(" . $idpedido . ",'" . $idpedido . "')"); ///aca se cambia si se deseea//--puedo ser procedimineto pero no estoy seguro
    mysqli_close($con);
    for ($index = 0; $index < count($_POST['w']); $index++) {
      require '../conexion.php';
      $quer = "call detaller(" . $idpedido . ",'" . $_POST['w'][$index] . "'," . $_POST['x'][$index] . ",'" . $_POST['y'][$index] . "','" . $_POST['z'][$index] . "');";
      if (!mysqli_query($con, $quer)) {
        $verif = 'Error insertando detalle: ' . $con->error . '. La iteracion: ' . $index;
        mysqli_close($con);
        break;
      } else {
        mysqli_close($con);
      }
    }
  } else {
    $verif = 'Error insertando pedido: ' . $con->error;
  }
  if ($verif === '') {
    echo "<script>";
    echo "window.alert('Registro insertado con exito');";
    echo "window.location ='frm_listar.php';";
    echo "</script>";
  } else {
    echo "<script>";
    echo "window.alert('No se registro correctamente');";
    echo "window.location ='frm_alta_mod.php?v=';";
    echo "</script>";
    //echo $verif;
  }
} else {
  $ols = true;
  $urls = "";
  $boli = !($_POST['ali'] == '');
  $oli = ($_POST['ftg'] == '1');
  if (!$boli && !$oli) { //edita como no esta cancelado ni entregado
    $quer = "call mod_pedi(" . $ids . "," . $quer . ",NULL,0);";
    $urls = "frm_listar.php";
    $txsf = mysqli_query($con, "call prins(" . $ids . ");"); //si ya existe no inserta si no existe no inserta
    mysqli_close($con);
    require '../conexion.php';
  } else if (!$boli && $oli) { //edita como cancelado
    $quer = "call mod_pedi(" . $ids . "," . $quer . ",NULL,1);";
    $urls = "frm_listar_1.php";
    $txsf = mysqli_query($con, "call prino(" . $ids . ");"); //si ya existe lo elimina...si no existe no hace nada
    mysqli_close($con);
    require '../conexion.php';
  } else if ($boli && !$oli) { //edita como entregado
    $quer = "call mod_pedi(" . $ids . "," . $quer . ",'" . $_POST['ali'] . "',0);";
    $urls = "frm_listar_1_1.php";
    $txsf = mysqli_query($con, "call prino(" . $ids . ");"); //ibidem
    mysqli_close($con);
    require '../conexion.php';
  } else if ($boli && $oli) {
    $ols = false;
  }
  if ($ols) {
    $verif = '';
    $ss = mysqli_query($con, "DELETE FROM detalle WHERE idpedido =" . $ids . ";");
    $sw = mysqli_query($con, $quer);
    if ($sw) {
      mysqli_close($con);
      require '../conexion.php';
      for ($index = 0; $index < count($_POST['w']); $index++) {
        require '../conexion.php';
        $quer = "call detaller(" . $ids . ",'" . $_POST['w'][$index] . "'," . $_POST['x'][$index] . ",'" . $_POST['y'][$index] . "','" . $_POST['z'][$index] . "');";
        if (!mysqli_query($con, $quer)) {
          $verif = 'Error modificando detalle: ' . $con->error . '. La iteracion: ' . $index;
          mysqli_close($con);
          break;
        } else {
          mysqli_close($con);
        }
      }
    } else {
      $verif = 'Error modificando pedido: ' . $con->error;
    }
    if ($verif === '') {
      echo "<script>";
      echo "window.alert('Registro modificado con exito');";
      echo "window.location ='" . $urls . "';"; /////////////////////
      echo "</script>";
    } else {
      echo "<script>";
      echo "window.alert('No se pudo editar');";
      echo "window.location ='frm_alta_mod.php?v=" . $ids . "';";
      echo "</script>";
      //echo $verif;
    }
  } else {
    echo "<script>";
    echo "window.alert('No puede cancelarse un pedido que tiene fecha de envio');";
    echo "window.location ='frm_alta_mod.php?v=" . $ids . "';";
    echo "</script>";
  }
}
