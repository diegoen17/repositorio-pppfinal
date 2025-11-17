<?php
require __DIR__ . '/../api/config.php'; 

 /*   Obtener mensajes de la tabla 'contacto'  */
$sql = "SELECT * FROM contacto ORDER BY fecha DESC";
$result = $mysqli->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="mb-4">Mensajes Recibidos</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"]) ?></td>
                        <td><?= htmlspecialchars($row["nombre"]) ?></td>
                        <td><?= htmlspecialchars($row["email"]) ?></td>
                        <td><?= htmlspecialchars($row["telefono"]) ?></td>
                        <td><?= nl2br(htmlspecialchars($row["mensaje"])) ?></td>
                        <td><?= htmlspecialchars($row["fecha"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay mensajes todavía.</div>
    <?php endif; ?>
</div>

</body>
</html>
