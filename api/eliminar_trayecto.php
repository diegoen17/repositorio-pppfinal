<?php
// eliminar_trayecto.php
// Borra un trayecto por ID y su imagen asociada (si existe)

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "cfp61";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/dashboard.php');
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id <= 0) {
    header('Location: ../admin/dashboard.php?msg=error_id');
    exit;
}

// 1) Obtener ruta de la imagen (si la hay)
$stmt = $conn->prepare("SELECT imagen FROM trayectos WHERE ID = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if ($row && !empty($row['imagen'])) {
    // path relativo en DB (ej: "imagenes/trayectos/archivo.jpg")
    $rutaArchivo = __DIR__ . '/../' . $row['imagen'];
    if (file_exists($rutaArchivo)) {
        @unlink($rutaArchivo); // intento borrar (suprime warnings)
    }
}

// 2) Borrar el registro
$stmt2 = $conn->prepare("DELETE FROM trayectos WHERE ID = ?");
$stmt2->bind_param('i', $id);
if ($stmt2->execute()) {
    $stmt2->close();
    $conn->close();
    header('Location: ../admin/dashboard.php?msg=trayecto_borrado');
    exit;
} else {
    $err = urlencode('error_db');
    $stmt2->close();
    $conn->close();
    header("Location: ../admin/dashboard.php?msg={$err}");
    exit;
}
?>
