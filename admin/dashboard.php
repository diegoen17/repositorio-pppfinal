<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}
require __DIR__ . '/../api/config.php';

// Obtener trayectos
$tray = $mysqli->query("SELECT * FROM trayectos ORDER BY ID DESC")->fetch_all(MYSQLI_ASSOC);

// Obtener mensajes
$msgs = $mysqli->query("SELECT * FROM contacto ORDER BY fecha DESC LIMIT 200")->fetch_all(MYSQLI_ASSOC);

// Mensajes de feedback
$flash = $_GET['flash'] ?? '';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Dashboard - CFP</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>.card-img-top{height:140px; object-fit:cover}</style>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Admin - CFP N°61</span>
    <div class="d-flex">
      <span class="text-white me-3"><?=htmlspecialchars($_SESSION['admin_name'] ?? 'Admin')?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
    </div>
  </div>
</nav>

<main class="container py-4">
  <?php if($flash): ?>
    <div class="alert alert-success"><?=htmlspecialchars($flash)?></div>
  <?php endif; ?>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Trayectos</h4>
    <!-- boton crear abre modal -->
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevo">+ Nuevo Trayecto</button>
  </div>

  <div class="row g-3">
    <?php foreach($tray as $t): ?>
      <div class="col-md-4">
        <div class="card h-100">
          <?php if(!empty($t['imagen']) && file_exists(__DIR__.'/../'.$t['imagen'])): ?>
            <img src="../<?=htmlspecialchars($t['imagen'])?>" class="card-img-top" alt="">
          <?php else: ?>
            <div class="card-img-top d-flex align-items-center justify-content-center bg-light text-muted">Sin imagen</div>
          <?php endif; ?>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?=htmlspecialchars($t['nombre'])?></h5>
            <p class="card-text"><?=htmlspecialchars($t['descripcion'] ? substr($t['descripcion'],0,120).'...' : $t['horario'])?></p>
            <div class="mt-auto d-flex justify-content-between">
              <a class="btn btn-sm btn-outline-primary" href="../secciones/trayectos.html#card-<?=htmlspecialchars($t['ID'])?>">Ver</a>
              <form method="post" action="../api/eliminar_trayecto.php" onsubmit="return confirm('Seguro?');">
                <input type="hidden" name="id" value="<?=htmlspecialchars($t['ID'])?>">
                <button class="btn btn-sm btn-danger">Borrar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <hr class="my-4">

  <h4>Mensajes recibidos</h4>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead><tr><th>Fecha</th><th>Nombre</th><th>Email</th><th>Tel</th><th>Mensaje</th></tr></thead>
      <tbody>
        <?php foreach($msgs as $m): ?>
          <tr>
            <td><?=htmlspecialchars($m['fecha'])?></td>
            <td><?=htmlspecialchars($m['nombre'])?></td>
            <td><?=htmlspecialchars($m['email'])?></td>
            <td><?=htmlspecialchars($m['telefono'])?></td>
            <td><?=nl2br(htmlspecialchars($m['mensaje']))?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- Modal Nuevo -->
<div class="modal fade" id="modalNuevo" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="post" action="../api/crear_trayecto.php" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Trayecto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Nombre</label>
          <input name="nombre" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Horario (ej: Lun-Vie 18-21)</label>
          <input name="horario" class="form-control">
        </div>
        <div class="mb-2">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label">Imagen (jpg/png/webp)</label>
          <input name="imagen" type="file" accept="image/*" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary" type="submit">Crear</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
