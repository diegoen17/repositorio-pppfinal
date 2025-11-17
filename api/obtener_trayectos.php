<?php
require_once "config.php";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
$conn->set_charset("utf8mb4");

$sql = "SELECT * FROM trayectos ORDER BY created_at DESC";
$result = $conn->query($sql);

$trayectos = [];

while ($row = $result->fetch_assoc()) {
    $trayectos[] = $row;
}

echo json_encode($trayectos, JSON_UNESCAPED_UNICODE);

$conn->close();
?>
