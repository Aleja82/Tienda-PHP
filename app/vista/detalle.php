<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($producto['nombre']) ?> | Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css?v=1.3">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">🛒 Tienda Virtual</a>
            <div class="d-flex ms-auto">
                <a class="btn btn-outline-light me-2" href="index.php?action=contacto">Contacto</a>
                <a class="btn btn-outline-light me-2" href="index.php?action=verCarrito">Carrito</a>
                <a class="btn btn-outline-light" href="admin/index.php?action=login">Admin</a>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="container py-5">
        <a href="index.php" class="btn btn-secondary mb-4">← Volver a la tienda</a>

        <div class="card shadow border-0">
            <div class="row g-0">
                <div class="col-md-5">
                    <?php if ($producto['foto']): ?>
                        <img src="imagenes/<?= htmlspecialchars($producto['foto']) ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">Sin imagen</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h3 class="card-title text-uppercase fw-bold" style="color: #8A0000;"><?= htmlspecialchars($producto['nombre']) ?></h3>
                        <p class="text-muted mb-2">Categoría: <?= htmlspecialchars($producto['categoria']) ?></p>
                        <h4 class="text-success mb-3">$<?= number_format($producto['precio'], 2) ?></h4>
                        <p class="card-text mb-4">Este producto es parte del catálogo de nuestra tienda virtual. Puedes contactarnos para más detalles o realizar tu pedido.</p>

                        <div class="d-grid gap-2">
                            <a href="index.php?action=agregarCarrito&id=<?= $producto['id'] ?>" class="btn btn-success">
                                Agregar al carrito
                            </a>
                            <a href="index.php" class="btn btn-outline-primary">
                                Seguir comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-center py-4 mt-5" style="background-color: #3B060A; color: #FFF287;">
        <p class="mb-0">© <?= date('Y') ?> Tienda Virtual - Todos los derechos reservados</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
