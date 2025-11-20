<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CFP - Trayectos</title>
  <link rel="icon" href="../imagenes/cfp-logo.png" type="image/png">
  <!-- CSS BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- ICONOS BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- CSS PERSONALIZADO -->
  <link rel="stylesheet" href="../css/estilos.css">
  <style>
    /* estilo para imagen placeholder */
    .img-placeholder {
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f1f1f1;
      color: #8a8a8a;
    }

    .card-img-top {
      height: 200px;
      object-fit: cover;
    }
  </style>
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
            <li class="nav-item"><a class="nav-link" href="../index.html">Inicio</a></li>
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="../secciones/trayectos.php">Trayectos</a></li>
            <li class="nav-item"><a class="nav-link" href="../secciones/contactar.html">Contactar</a></li>
          </ul>
          <div class="d-flex align-items-center">
            <button id="modo-toggle" class="btn btn-outline-light" title="Alternar modo oscuro">🌙 Modo oscuro</button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <?php
  require_once __DIR__ . "/../api/config.php";

  // Consulta segura y comprobar errores
  $sql = "SELECT * FROM trayectos ORDER BY created_at DESC";
  if (!$result = $mysqli->query($sql)) {
    echo "<main class='container my-5'><div class='alert alert-danger'>Error al consultar trayectos: " . htmlspecialchars($mysqli->error) . "</div></main>";
    exit;
  }

  // Cargo todos los trayectos en un array para poder recorrerlos dos veces sin re-ejecutar la consulta
  $trayectos = $result->fetch_all(MYSQLI_ASSOC);
  ?>

  <main> <!-- INICIO DEL MAIN -->
    <h1 class="text-center">Trayectos</h1>

    <div class="container my-4">
      <?php if (count($trayectos) === 0): ?>
        <div class="alert alert-info">Aún no hay trayectos publicados. </div>
      <?php else: ?>
        <div class="row g-4" id="lista-trayectos">
          <?php foreach ($trayectos as $t):
            // escapar lo que va al HTML (para mostrar)
            $id          = htmlspecialchars($t['ID']);
            $nombre      = htmlspecialchars($t['nombre']);
            $descripcion = htmlspecialchars($t['descripcion']);
            $horario     = htmlspecialchars($t['horario'] ?? '');

            $rawImg = $t['imagen'] ?? '';

            if ($rawImg === '' || $rawImg === null) {
              $imgWeb  = null;
              $imgPath = null;
            } elseif (strpos($rawImg, 'imagenes/trayectos/') === 0) {
              // la BD ya tiene: "imagenes/trayectos/archivo.jpg"
              $imgWeb  = '../' . $rawImg;
              $imgPath = __DIR__ . '/../' . $rawImg;
            } else {
              // la BD tiene solo el filename: "archivo.jpg"
              $imgWeb  = '../imagenes/trayectos/' . $rawImg;
              $imgPath = __DIR__ . '/../imagenes/trayectos/' . $rawImg;
            }
          ?>

            <div class="col-md-4">
              <div class="card h-100">
                <?php if (!empty($imgWeb) && file_exists($imgPath)): ?>
                  <img src="<?= htmlspecialchars($imgWeb) ?>" class="card-img-top" alt="Imagen del trayecto <?= $nombre ?>">
                <?php else: ?>
                  <div class="img-placeholder card-img-top">Sin imagen</div>
                <?php endif; ?>


                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= $nombre ?></h5>
                  <p class="card-text"><?= nl2br($descripcion) ?></p>

                  <div class="mt-auto">
                    <button class="btn btn-primary"
                      data-bs-toggle="offcanvas"
                      data-bs-target="#oc-<?= $id ?>"
                      aria-controls="oc-<?= $id ?>">
                      Más información
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </main> <!-- FIN DEL MAIN -->

  <!-- Offcanvas (todos como siblings; no anidados) -->
  <?php foreach ($trayectos as $t):
    $id = htmlspecialchars($t['ID']);
    $nombre = htmlspecialchars($t['nombre']);
    $descripcion = htmlspecialchars($t['descripcion']);
    $horario = htmlspecialchars($t['horario'] ?? '');
    // id para aria-labelledby
    $labelId = "oc-{$id}-label";
  ?>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="oc-<?= $id ?>" aria-labelledby="<?= $labelId ?>">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="<?= $labelId ?>"><?= $nombre ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
      </div>
      <div class="offcanvas-body">
        <?php if (!empty($horario)): ?>
          <p><strong>Horario:</strong> <?= $horario ?></p>
        <?php endif; ?>
        <p><?= nl2br($descripcion) ?></p>
      </div>
    </div>
  <?php endforeach; ?>


  <footer> <!-- INICIO DEL FOOTER -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h5>Redes Sociales</h5>
          <ul>
            <li><a href="https://www.facebook.com/cfp61?mibextid=rS40aB7S9Ucbxw6v" target="_blank"><i class="bi bi-facebook"></i> Facebook</a></li>
            <li><a href="https://www.instagram.com/cfp61lacriolla?igsh=eHM4ZGYyZWtuOTlp" target="_blank"><i class="bi bi-instagram"></i> Instagram</a></li>
          </ul>
        </div>
        <div class="col-sm-6">
          <h5>Contacto</h5>
          <p><i class="bi bi-envelope-fill"></i> Email: cfplacriolla@gmail.com</p>
          <p><a href="https://wa.me/54345154123356" target="_blank"><i class="bi bi-whatsapp"></i> Whatsapp: 345 4123 356</a></p>
        </div>
      </div><br>
      <div class="row">
        <div class="col-sm">
          <p class="blockquote-footer">Página diseñada y desarrollada por alumnos de la EET N°2 "Independencia" Cdia. Entre Ríos.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- JS BOOTSTRAP -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script para evitar un conflicto de múltiples offcanvas abiertos a la vez -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.offcanvas').forEach(function(el) {
        el.addEventListener('show.bs.offcanvas', function(event) {
          document.querySelectorAll('.offcanvas.show').forEach(function(openEl) {
            if (openEl !== el) {
              var inst = bootstrap.Offcanvas.getInstance(openEl);
              if (!inst) inst = new bootstrap.Offcanvas(openEl);
              inst.hide();
            }
          });
        });
      });
    });
  </script>

  <!-- JS MODO CLARO/OSCURO -->
  <script src="../javascript/light_dark.js"></script>
</body>

</html>