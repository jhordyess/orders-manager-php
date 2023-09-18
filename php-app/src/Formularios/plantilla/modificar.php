<?php

//alerta si se cambia en otros este tambien debe cambiar!!!!!!!!!!!!!!!1

function lapo($con, $id)
{
  $stop = '';
  if ($id == NULL) {
    $stop = '<div class="row myrow">
                        <div class="col col-sm-2">
                          <label>Código</label>
                          <input required="required" type="text" name="w[]" class="form-control"/>
                        </div>
                        <div class="col col-sm-1">
                          <label>Talla</label>
                          <select class="form-control" name="x[]">';

    $stop .= "<option value='-1' selected='disabled' disabled='disabled' >-</option>";
    $res = mysqli_query($con, "SELECT * from tallas order by idtallas ASC;");
    while ($reg = mysqli_fetch_array($res)) {
      $stop .= "<option value='" . $reg[0] . "'>" . $reg[1] . "</option>";
    }
    $stop .= ' </select>
                        </div>
                        <div class="col col-sm-2">
                          <label>Cantidad</label>
                          <input autocomplete="off" required="required" type="number" min="0" step="1" max="100" name="y[]" class="cali form-control"/>
                        </div>
                        <div class="col col-sm-2">
                          <label>Precio unitario</label>
                          <input required="required" type="number" name="z[]" class="preci form-control" autocomplete="off"/>
                        </div>
                        <div class="col col-sm-2">
                          <label>Subtotal</label>
                          <input type="text" class="subi form-control" disabled="disabled"/>
                        </div>
                        <div class="col col-sm-1" id="botob">
                          <button type="button" class="btn btn-default btn-circle" style="margin-top: 35px" id="maspoleras">
                            <i class="fas fa-plus"></i>
                          </button>
                        </div>
                      </div>';
  } else {
    $conqe = "SELECT e.code,d.idtallas,d.cantidad,d.precio_u from detalle as d "
      . " inner join polera as e on e.idpolera=d.idpolera where idpedido=" . $id . ";";
    $r = mysqli_query($con, $conqe);

    if ($r) {
      if (mysqli_num_rows($r) > 0) {
        $rew = mysqli_fetch_array($r);
        $stop = '<div class="row myrow">
        <div class="col col-sm-2">
                          <label>Código</label>
                          <input required="required" type="text" name="w[]" class="form-control" value="' . $rew[0] . '"/>
                        </div>
                        <div class="col col-sm-1">
                          <label>Talla</label>
                          <select class="form-control" name="x[]">';
        $res = mysqli_query($con, "SELECT * from tallas order by idtallas ASC;");
        while ($reg = mysqli_fetch_array($res)) {
          if ($rew[1] == $reg[0]) {
            $stop .= "<option value='" . $reg[0] . "' selected>" . $reg[1] . "</option>";
          } else {
            $stop .= "<option value='" . $reg[0] . "'>" . $reg[1] . "</option>";
          }
        }
        $stop .= '</select>
                        </div>
                        <div class="col col-sm-2">
                          <label>Cantidad</label>
                          <input autocomplete="off" required="required" type="number" min="0" step="1" max="100" name="y[]" class="cali form-control" value="' . $rew[2] . '"/>
                        </div>
                        <div class="col col-sm-2">
                          <label>Precio unitario</label>
                          <input required="required" type="number" name="z[]" class="preci form-control" autocomplete="off" value="' . $rew[3] . '"/>
                        </div>
                        <div class="col col-sm-2">
                          <label>Subtotal</label>';
        $m = (float) $rew[2] * (float) $rew[3];
        $stop .= '<input type="text" class="subi form-control" disabled="disabled" value="' . $m . '"/>
                        </div>';
        if (mysqli_num_rows($r) == 1) {
          $stop .= '<div class="col col-sm-1" id="botob">
                          <button type="button" class="btn btn-default btn-circle" style="margin-top: 35px" id="maspoleras">
                            <i class="fas fa-plus"></i>
                          </button>
                        </div>';
        }

        $stop .= '</div>';

        if (mysqli_num_rows($r) > 1) {
          $jiu = 0;
          $inko = mysqli_num_rows($r) - 1;
          while ($rew = mysqli_fetch_array($r)) {
            $jiu = $jiu + 1;
            $stop .= '<div class="row myrow">
  <div class="col col-sm-2">
  <input required="required" type="text" name="w[]" class="form-control" value="' . $rew[0] . '"/>
  </div>
  <div class="col col-sm-1">
  <select class="form-control" name="x[]">';
            $res = mysqli_query($con, "SELECT * from tallas order by idtallas ASC;");
            while ($reg = mysqli_fetch_array($res)) {
              if ($rew[1] == $reg[0]) {
                $stop .= "<option value='" . $reg[0] . "' selected>" . $reg[1] . "</option>";
              } else {
                $stop .= "<option value='" . $reg[0] . "'>" . $reg[1] . "</option>";
              }
            }
            $stop .= '</select>
  </div>
  <div class="col col-sm-2">
  <input required="required" type="number" min="0" step="1" max="100"  name="y[]" class="cali form-control" value="' . $rew[2] . '"/>
  </div>
  <div class="col col-sm-2">
  <input required="required" type="number" name="z[]" class="preci form-control" value="' . $rew[3] . '"/>
  </div>
  <div class="col col-sm-2">
  <input required="required" type="text" class="subi form-control" disabled="disabled" value="';
            $m = (float) $rew[2] * (float) $rew[3];
            $stop .= $m . '"/></div>';

            if ($jiu == $inko) {
              $stop .= '<div class="col col-sm-1" id="botob">
  <button type="button" class="btn btn-default btn-circle" style="margin-top: 5px" id="maspoleras">
  <i class="fas fa-plus"></i>
  </button><span style="margin-right:12px"></span>
  <button type="button" class="btn btn-default btn-circle" style="margin-top: 5px" id="menpoleras">
  <i class="fas fa-minus"></i>
  </button>
  </div>';
            }
            $stop .= '</div>';
          }
        }
      } else {
        $stop = "Error, el pedido no tiene detalle";
      }
    } else {
      $stop = "Warning the id was -1, not correct id getting from checkbox's value";
    }
  }
  return $stop;
};
