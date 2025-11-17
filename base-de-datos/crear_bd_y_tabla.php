<?php
// install_db.php - crea la BD y las tablas trayectos + contacto
// Úsalo una sola vez y luego bórralo o protégelo.

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "cfp61";

//Conectar al servidor
$conn_server = new mysqli($servername, $username, $password);
if ($conn_server->connect_error) {
    die("Error de conexión al servidor MySQL: " . $conn_server->connect_error);
}

// Crear la Base de Datos si no existe
$sql_db = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn_server->query($sql_db) === TRUE) {
    echo "Base de datos '$dbname' verificada/creada exitosamente.<br>";
} else {
    echo "Error al crear la base de datos: " . $conn_server->error . "<br>";
    $conn_server->close();
    exit;
}
$conn_server->close();

// Conectar a la base creada
$conn_db = new mysqli($servername, $username, $password, $dbname);
if ($conn_db->connect_error) {
    die("Error de conexión a la Base de Datos '$dbname': " . $conn_db->connect_error);
}
$conn_db->set_charset('utf8mb4');

// Crear tabla 'trayectos'
$sql_trayectos = "CREATE TABLE IF NOT EXISTS `trayectos` (
    `ID` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `horario` VARCHAR(50) NOT NULL,
    `descripcion` TEXT,
    `imagen` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn_db->query($sql_trayectos) === TRUE) {
    echo "Tabla 'trayectos' creada/verificada correctamente.<br>";
} else {
    echo "Error creando tabla 'trayectos': " . $conn_db->error . "<br>";
}

// Crear tabla 'contacto' (¡asegurate de ejecutar esta query!)
$sql_contacto = "CREATE TABLE IF NOT EXISTS `contacto` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefono` VARCHAR(30),
    `mensaje` TEXT NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn_db->query($sql_contacto) === TRUE) {
    echo "Tabla 'contacto' creada/verificada correctamente.<br>";
} else {
    echo "Error creando tabla 'contacto': " . $conn_db->error . "<br>";
}

$conn_db->close();

echo "<br><strong>Listo.</strong> Borra o protege este archivo por seguridad.";