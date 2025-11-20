<?php
require __DIR__ . '/config.php';
//Crear tabla users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$mysqli->query($sql)) {
    die("Error creando tabla users: " . $mysqli->error);
}

//Usuario administrador por defecto
$adminUser = "admin";
$adminPass = "admin123";
$hash = password_hash($adminPass, PASSWORD_DEFAULT);

// Verificar si ya existe
$check = $mysqli->prepare("SELECT * FROM users WHERE username=?");
$check->bind_param("s", $adminUser);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    echo "El usuario admin ya existe.";
    exit;
}

// Insertar admin
$stmt = $mysqli->prepare("INSERT INTO users(username, password) VALUES(?, ?)");
$stmt->bind_param("ss", $adminUser, $hash);

if ($stmt->execute()) {
    echo "Administrador creado exitosamente.<br>";
    echo "Usuario: <b>$adminUser</b><br>";
    echo "Contraseña: <b>$adminPass</b>";
} else {
    echo "Error creando admin: " . $mysqli->error;
}
?>