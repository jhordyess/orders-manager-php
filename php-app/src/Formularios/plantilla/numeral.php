<?php

function getir($con, $cc)
{
  $jans = mysqli_query($con, 'SELECT `recibi`("' . $cc . '");');
  if ($jans) {
    $reg = mysqli_fetch_array($jans);
    return $reg[0] . "";
  } else {
    return "-1";
  }
}
