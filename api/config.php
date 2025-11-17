<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cfp61';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
  http_response_code(500);
  echo "DB connection failed: " . $mysqli->connect_error;
  exit;
}
$mysqli->set_charset('utf8mb4');

?>