<?php
//database
define('DB_HOST', 'mysql');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'hswE]ktX@_R5t3.');
define('DB_NAME', 'orders-db');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$mysqli) {
  die("Coneccion fallida: " . $mysqli->error);
}
