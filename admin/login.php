<?php
session_start();
require __DIR__ . '/../api/config.php';

// Si ya está logueado, ir al dashboard
if (isset($_SESSION['admin_id'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $error = 'Usuario y contraseña son requeridos.';
  } else {
    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
      if (password_verify($password, $row['password'])) {
        // login OK
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_user'] = $username;
        header('Location: dashboard.php');
        exit;
      } else {
        $error = 'Credenciales inválidas.';
      }
    } else {
      $error = 'Credenciales inválidas.';
    }
    $stmt->close();
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login - Admin CFP</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="bg-light">
  <div class="container" style="max-width:480px; margin-top:6rem;">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3">Ingreso Admin</h4>
        <?php if($error): ?>
          <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>
        <form method="post" novalidate>
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input name="password" type="password" class="form-control" required>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary">Ingresar</button>
            <a href="../index.html" class="text-muted">Volver al sitio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
