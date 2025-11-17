<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "cfp61";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir datos del formulario
    $nombre   = $_POST['nombre'] ?? '';
    $email    = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $mensaje  = $_POST['mensaje'] ?? '';

    // Preparar consulta SQL
    $sql = "INSERT INTO contacto (nombre, email, telefono, mensaje) 
            VALUES ('$nombre', '$email', '$telefono', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        echo "Mensaje enviado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}

// Redirigir a pagina y mostrar mensaje
echo '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mensaje enviado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style> 
    body {
        background: #f7f7f7;
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
    }
    .card {
        padding: 30px;
        max-width: 450px;
        text-align:center;
        border-radius: 15px;
    }
</style>

<script>
    setTimeout(function() {
        window.location.href = "../secciones/contactar.html";
    }, 5000);
</script>
</head>

<body>
<div class="card shadow">
    <h3 class="text-success">¡Mensaje enviado!</h3>
    <p>Gracias por comunicarte. En breve responderemos tu consulta.</p>
    <p class="text-muted">Redirigiendo...</p>
</div>
</body>
</html>
';
exit();
?>