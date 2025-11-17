<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CFP-Inicio</title>
  <link rel="icon" href="../imagenes/cfp-logo.png" type="image/png">
  <!-- CSS BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- ICONOS BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


  <!-- CSS PERSONALIZADO -->
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>

  <header>
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color:#1E3A8A;">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="../index.html">
          <img src="../imagenes/cfp-logo.png" alt="CFP La Criolla" width="50" height="50"
            class="d-inline-block align-text-top">
          <span class="ms-2 navbar-item">CFP "La Criolla"</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" href="../index.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../secciones/trayectos.php">Trayectos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../secciones/contactar.html">Contactar</a>
            </li>
          </ul>

          <!-- Botón modo claro/oscuro -->
          <div class="d-flex align-items-center">
            <button id="modo-toggle" class="btn btn-outline-light" aria-pressed="false" title="Alternar modo oscuro">
              🌙 Modo oscuro
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <?php
  require_once "../api/config.php"; 
  
  $sql = "SELECT * FROM trayectos ORDER BY created_at DESC";
  $result = $mysqli->query($sql);
  ?>

  <main> <!-- INICIO DEL MAIN -->
    <h1 class="text-center">Trayectos</h1>
    <div class="container my-4">
      <div class="row g-4" id="lista-trayectos">
        <?php while ($row = $result->fetch_assoc()): ?> <!-- Inicio del bucle para generar las cards dinamicas -->
          <div class="col-md-4">
            <div class="card h-100">
              <img src="../imagenes/trayectos/<?php echo $row['imagen']; ?>" class="card-img-top" alt="">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                <p class="card-text"><?php echo $row['descripcion']; ?></p>

                <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#oc-<?php echo $row['ID']; ?>">
                  Más información
                </button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </main> <!-- FIN DEL MAIN -->

  <?php
$result2 = $mysqli->query($sql);
?>

<?php while ($row = $result2->fetch_assoc()): ?> <!-- Offcanvas dinamico para cada trayecto -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="oc-<?php echo $row['ID']; ?>">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><?php echo $row['nombre']; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <p><strong>Horario:</strong> <?php echo $row['horario']; ?></p>
            <p><?php echo $row['descripcion']; ?></p>
        </div>
    </div>
<?php endwhile; ?>


  <footer> <!-- INICIO DEL FOOTER -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h5>Redes Sociales</h5>
          <ul>
            <li><a href="https://www.facebook.com/cfp61?mibextid=rS40aB7S9Ucbxw6v" target="_blank"><i
                  class="bi bi-facebook"></i> Facebook</a></li>
            <li><a href="https://www.instagram.com/cfp61lacriolla?igsh=eHM4ZGYyZWtuOTlp" target="_blank"><i
                  class="bi bi-instagram"></i> Instagram</a>
            </li>
          </ul>
        </div>
        <div class="col-sm-6">
          <h5>Contacto</h5>
          <p>
            <i class="bi bi-envelope-fill"></i> Email "cfplacriolla@gmail.com"
          </p>
          <p>
            <a href="https://wa.me/54345154123356" target="_blank">
              <i class="bi bi-whatsapp"></i> Whatsapp: 345 4123 356
            </a>
          </p>
        </div>
      </div><br>
      <div class="row">
        <div class="col-sm">
          <p class="blockquote-footer">Página diseñada y desarrollada por alumnos de la EET N°2 "Independencia" Cdia.
            Entre Ríos.</p>
        </div>
      </div>
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