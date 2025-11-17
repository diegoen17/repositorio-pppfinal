<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cfp61";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar que llegó por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST['nombre'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $imagen = null;

    // ----> Manejo de imagen (si se envió)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {

        $rutaDestino = "../imagenes/trayectos/" . basename($_FILES["imagen"]["name"]);

        if (!is_dir("../imagenes/trayectos")) {
            mkdir("../imagenes/trayectos", 0777, true);
        }

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            $imagen = "imagenes/trayectos/" . basename($_FILES["imagen"]["name"]);
        }
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO trayectos (nombre, horario, descripcion, imagen)
            VALUES ('$nombre', '$horario', '$descripcion', '$imagen')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir al panel admin con mensaje
        header("Location: ../admin/dashboard.php?msg=trayecto_creado");
        exit();
    } else {
        echo "Error al crear trayecto: " . $conn->error;
    }
}

$conn->close();
?>
