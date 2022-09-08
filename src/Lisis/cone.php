<?php
//get connection
$mysqli = new mysqli(
  getenv("DB_HOST"),
  getenv("DB_USER"),
  getenv("DB_PASSWORD"),
  getenv("DB_NAME")
);

if (!$mysqli) {
  die("Coneccion fallida: " . $mysqli->error);
}
