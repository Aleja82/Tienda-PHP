<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css?v=1.1">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand fw-bold" href="index.php">📬 Tienda Virtual</a>
            <a href="index.php" class="btn btn-outline-light">Volver a la tienda</a>
        </div>
    </nav>

    <div class="container py-4">
        <h1 class="text-center mb-4" style="color: #8A0000;">Formulario de Contacto</h1>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errores as $e) echo "<li>$e</li>"; ?>
                </ul>
            </div>
        <?php elseif (!empty($exito)): ?>
            <div class="alert alert-success text-center">
                Mensaje enviado correctamente. ¡Gracias por contactarnos! 🙌
            </div>
        <?php endif; ?>

        <form method="POST" action="?action=contacto" class="card p-4 shadow-sm border-0" style="background-color: #fdfdfd;">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required placeholder="Tu nombre completo">
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="correo" required placeholder="ejemplo@correo.com">
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" name="mensaje" rows="5" required placeholder="Escribe tu mensaje..."></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">Enviar</button>
            </div>
        </form>
    </div>

    <footer class="text-center py-4 mt-5" style="background-color: #3B060A; color: #FFF287;">
        <p class="mb-0">© <?= date('Y') ?> Tienda Virtual</p>
    </footer>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
