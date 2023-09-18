<?php

function menu($nivel, $niv)
{
  $act = [];
  for ($index = 0; $index < 9; $index++) {
    if ($niv == $index) {
      $act[$index] = true;
    } else {
      $act[$index] = false;
    }
  }

  $str = '<ul class="sidebar navbar-nav">';
  //tamaño:3(segun este menu)
  $main = [];

  $main[0] = simple('/Formularios/Pagina%20principal.php', 'Inicio', 'fas fa-home', $act[0]);

  $aux = [
    ['/Formularios/Tallas/frm_listar.php', 'Tallas'],
    ['/Formularios/Procedencia/frm_listar.php', 'Procedencia'],
    ['/Formularios/Entidad/frm_listar.php', 'Entidades']
  ];
  $main[1] = complex($aux, 'Varios', 'fas fa-folder', $act[1]);

  $main[2] = simple('/Formularios/Cliente/frm_listar.php', 'Clientes', 'fas fa-user', $act[2]);

  $aux = [
    ['/Formularios/Polera/frm_listar.php', 'Poleras'],
    ['/Formularios/Destino/frm_listar.php', 'Destinos']
  ];
  $main[3] = complex($aux, 'Extra', 'fas fa-folder-plus', $act[3]);

  $main[4] = simple('/Formularios/Evento/frm_listar.php', 'Evento', 'fas fa-tasks', $act[4]);

  $main[5] = simple('/Formularios/Pedido/frm_listar.php', 'Pedidos', 'fas fa-calendar-plus', $act[5]);

  $main[6] = simple('/Formularios/Pedido/frm_listar_1.php', 'Cancelados', 'fas fa-calendar-minus', $act[6]);

  $main[7] = simple('/Formularios/Pedido/frm_listar_1_1.php', 'Entregados', 'fas fa-calendar-check', $act[7]);

  $main[8] = simple('/Formularios/Pedido/frm_listar_1_1_1.php', 'Deudas de pago', 'fas fa-calendar-times', $act[8]);

  if ($nivel == 1) {
    //$str .= $main[0] . $main[2] . $main[5] . $main[4]  . $main[1] . $main[3].  $main[6] . $main[7] . $main[8];
    $str .= $main[0] . $main[2] . $main[5] . $main[4]  .  $main[6] . $main[7] . $main[8] . $main[1] . $main[3];
  } else if ($nivel == 2) {
  } else {
    //header("location:/salir.php");
    echo "<script>window.location.href='/salir.php";
  }
  $str .= '</ul>';
  return $str;
}

function simple($ruta, $nombre, $icono, $sw)
{
  $my = '';
  if ($sw) {
    $my = '<li class="nav-item active">';
  } else {
    $my = '<li class="nav-item">';
  }
  $my .= '<a class="nav-link" href="' . $ruta . '">'
    . '<i class="' . $icono . '"></i>'
    . '<span> ' . $nombre . '</span></a>'
    . '</li>';

  return $my;
}

function complex($two, $nombre, $icono, $sw)
{
  $my = '';
  if ($sw) {
    $my .= '<li class="nav-item dropdown active">';
  } else {
    $my .= '<li class="nav-item dropdown">';
  }
  $my .= ' <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
    . '<i class="' . $icono . '"></i>'
    . '<span> ' . $nombre . '</span>'
    . '</a>'
    . '<div class="dropdown-menu" aria-labelledby="pagesDropdown">';
  foreach ($two as $val) {
    $my .= '<a class="dropdown-item" href="' . $val[0] . '">' . $val[1] . '</a>';
  }
  $my .= '</div>'
    . '</li>';

  return $my;
}
