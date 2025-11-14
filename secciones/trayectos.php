<?php
  session_start();

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cfp61';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
  http_response_code(500);
  die("Fallo conexión DB: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

// ---------- Manejo de logout ----------
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  session_unset();
  session_destroy();
  header('Location: cursos.php'); 
  exit;
}

// ---------- Procesar login si llegó POST ----------
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $login_error = 'Faltan credenciales.';
  } else {
    $stmt = $mysqli->prepare("SELECT id, username, password_hash, name FROM users WHERE username = ?");
    if ($stmt) {
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($user = $res->fetch_assoc()) {
        if (password_verify($password, $user['password_hash'])) {
          // Login OK
          session_regenerate_id(true);
          $_SESSION['admin_id'] = $user['id'];
          $_SESSION['admin_username'] = $user['username'];
          $_SESSION['admin_name'] = $user['name'];
          header('Location: cursos.php');
          exit;
        } else {
          $login_error = 'Credenciales inválidas.';
        }
      } else {
        $login_error = 'Credenciales inválidas.';
      }
      $stmt->close();
    } else {
      $login_error = 'Error interno (prepare).';
    }
  }
}

// ---------- Función para escapar salida (XSS) ----------
function e($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFP-Cursos</title>
    <link rel="icon" href="../imagenes/cfp-logo.png" type="image/png">
    <!-- CSS BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- CSS PERSONALIZADO -->
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

<header>
  <nav class="navbar navbar-expand-md navbar-dark" style="background-color:#1E3A8A;">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="../index.html">
        <img src="../imagenes/cfp-logo.png" alt="CFP La Criolla" width="50" height="50" class="d-inline-block align-text-top">
        <span class="ms-2 navbar-item">CFP "La Criolla"</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../secciones/cursos.php">Cursos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../secciones/contactar.php">Contactar</a>
          </li>
        </ul>

        <!-- Botón modo claro/oscuro (afuera del <ul>) -->
        <div class="d-flex align-items-center">
          <button id="modo-toggle" class="btn btn-outline-light" aria-pressed="false" title="Alternar modo oscuro">
            🌙 Modo oscuro
          </button>
        </div>
      </div>
    </div>
  </nav>
</header>

    <main> <!-- INICIO DEL MAIN -->
        <h1>HACER MAIN</h1>
    </main>

    <footer> <!-- INICIO DEL FOOTER -->
        <div class="container-fluid">
            <h1>HACER FOOTER</h1>
        <h5>Redes Sociales</h5>
        <ul>
            <li><a href="https://www.facebook.com/cfp61?mibextid=rS40aB7S9Ucbxw6v">Facebook</a></li>
            <li><a href="https://www.instagram.com/cfp61lacriolla?igsh=eHM4ZGYyZWtuOTlp">Instagram</a></li>
        </ul>
        </div>
    </footer>
    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- JS MODO CLARO/OSCURO -->
    <script src="../javascript/light_dark.js"></script>
</body>

</html>