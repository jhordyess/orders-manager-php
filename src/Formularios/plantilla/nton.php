<?php

error_reporting(E_ALL);
include_once('../conexion.php');
$string = '<div class="row myrow">
  <div class="col col-sm-2">
  <input required="required" type="text" name="w[]" class="form-control"/>
  </div>
  <div class="col col-sm-1">
  <select class="form-control" name="x[]">';
$txt = "<option value='-1' selected='disabled' disabled='disabled'>-</option>";
$res = mysqli_query($con, "SELECT * from tallas order by idtallas ASC;");
while ($reg = mysqli_fetch_array($res)) {
  $txt .= "<option value='" . $reg[0] . "'>" . $reg[1] . "</option>";
}
$string .= $txt;
$string .= '</select>
  </div>
  <div class="col col-sm-2">
  <input required="required" type="number" min="0" step="1" max="100"  name="y[]" class="cali form-control"/>
  </div>
  <div class="col col-sm-2">
  <input required="required" type="number" name="z[]" class="preci form-control"/>
  </div>
  <div class="col col-sm-2">
  <input required="required" type="text" class="subi form-control" disabled="disabled"/>
  </div>
  <div class="col col-sm-1" id="botob">
  <button type="button" class="btn btn-default btn-circle" style="margin-top: 5px" id="maspoleras">
  <i class="fas fa-plus"></i>
  </button><span style="margin-right:12px"></span>
  <button type="button" class="btn btn-default btn-circle" style="margin-top: 5px" id="menpoleras">
  <i class="fas fa-minus"></i>
  </button>
  </div>
  </div>';
mysqli_close($con);
echo $string;
