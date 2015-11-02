<?php
$servername = "tsuts.tskoli.is";
$username = "1909942289";
$password = "dicks";

try {
    $connection = new PDO(
    "mysql:host=$servername;dbname=1909942289_gru;mysql:charset=utf8",
    $username,
    $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $connection->exec("SET NAMES utf8");
  }
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
header('Content-Type: text/html; charset=utf-8');
global $_SESSION;
session_start();
