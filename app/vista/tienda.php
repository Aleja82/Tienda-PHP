<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tienda Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tienda/assets/css/estilos.css?v=1.1">
</head>

<body>
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

    <!-- FILTRO POR CATEGORÍA -->
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-center mb-4">
            <a href="index.php" class="btn btn-outline-dark me-2 mb-2">Todas</a>
            <?php foreach ($categorias as $cat): ?>
                <a href="index.php?action=filtrarCategoria&id=<?= $cat['id'] ?>" class="btn btn-outline-danger me-2 mb-2">
                    <?= htmlspecialchars($cat['nombre']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- PRODUCTOS -->
        <?php foreach ($agrupados as $categoria => $items): ?>
            <h2 class="text-center text-uppercase my-4" style="color: #F36F21;"><?= htmlspecialchars($categoria) ?></h2>
            <div class="row justify-content-center">
                <?php foreach ($items as $item): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <?php if ($item['foto']): ?>
                                <img src="imagenes/<?= $item['foto'] ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($item['nombre']) ?>">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center"><?= htmlspecialchars($item['nombre']) ?></h5>
                                <p class="card-text text-center text-muted mb-2">$<?= number_format($item['precio'], 2) ?></p>
                                <div class="mt-auto d-grid gap-2">
                                    <a href="index.php?action=detalle&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-primary">Ver más</a>
                                    <a href="index.php?action=agregarCarrito&id=<?= $item['id'] ?>" class="btn btn-sm btn-success">Agregar al carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- FOOTER -->
    <footer class="text-center py-4 mt-5" style="background-color: #456882; color: #D2C1B6;">
        <p class="mb-0">© <?= date('Y') ?> Tienda Virtual - Todos los derechos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/funciones.js"></script>
</body>

</html>


