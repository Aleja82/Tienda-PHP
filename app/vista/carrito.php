<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css?v=1.1">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">🛒 Tienda Virtual</a>
            <div class="d-flex ms-auto">
                <a class="btn btn-outline-light me-2" href="index.php">Volver a la tienda</a>
                <a class="btn btn-outline-light" href="index.php?action=vaciarCarrito">Vaciar carrito</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5" style="color: #F36F21;">Tu Carrito de Compras</h1>

        <?php if (empty($productosCarrito)): ?>
            <div class="alert alert-info text-center">
                <p class="mb-3">🛒 El carrito está vacío.</p>
                <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $subtotal = 0;
                        foreach ($productosCarrito as $prod):
                            $productoSubtotal = $prod['precio'] * $prod['cantidad'];
                            $subtotal += $productoSubtotal;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                                <td>$<?= number_format($prod['precio'], 2) ?></td>
                                <td><?= $prod['cantidad'] ?></td>
                                <td>$<?= number_format($productoSubtotal, 2) ?></td>
                                <td class="text-center">
                                    <a href="index.php?action=disminuirCantidad&id=<?= $prod['id'] ?>" class="btn btn-sm btn-warning">-</a>
                                    <a href="index.php?action=agregarCarrito&id=<?= $prod['id'] ?>" class="btn btn-sm btn-success">+</a>
                                    <a href="index.php?action=eliminarDelCarrito&id=<?= $prod['id'] ?>" class="btn btn-sm btn-danger ms-2">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php 
                        $iva = $subtotal * 0.15;
                        $totalConIva = $subtotal + $iva;
                        ?>

                        <tr class="table-light">
                            <td colspan="3" class="text-end"><strong>Subtotal (sin IVA):</strong></td>
                            <td><strong>$<?= number_format($subtotal, 2) ?></strong></td>
                            <td></td>
                        </tr>
                        <tr class="table-light">
                            <td colspan="3" class="text-end"><strong>IVA (15%):</strong></td>
                            <td><strong>$<?= number_format($iva, 2) ?></strong></td>
                            <td></td>
                        </tr>
                        <tr class="table-secondary">
                            <td colspan="3" class="text-end"><strong>Total con IVA:</strong></td>
                            <td><strong>$<?= number_format($totalConIva, 2) ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary">Seguir comprando</a>
                <a href="index.php?action=vaciarCarrito" class="btn btn-warning ms-2">Vaciar carrito</a>
                <!-- Cambié el botón deshabilitado por un enlace activo -->
                <a href="index.php?action=pago" class="btn btn-success ms-2">Pagar</a>
            </div>

        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5" style="background-color: #203E5F; color: #F36F21;">
        <p class="mb-0">© <?= date('Y') ?> Tienda Virtual</p>
    </footer>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

