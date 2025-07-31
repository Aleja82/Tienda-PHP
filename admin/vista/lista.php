<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="assets/css/estilos.css?v=1.1">
</head>

<body class="bg-light">

    <div class="container py-5">

        <!-- Encabezado: Título + botones -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-uppercase fw-bold" style="color: #8A0000;">Productos Registrados</h1>
            <div class="d-flex gap-2">
                <a href="index.php?action=registrar" class="btn" style="background-color: #3B060A; color: #FFF287;">
                    + Registrar Nuevo Producto
                </a>
                <a href="index.php?action=verVentas" class="btn btn-outline-dark">
                    Ver Ventas
                </a>
                <a href="index.php?action=logout" class="btn btn-outline-danger">
                    Cerrar Sesión
                </a>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm border">
                <thead style="background-color: #3B060A; color: #FFF287;" class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $prod): ?>
                        <tr class="text-center">
                            <td><?= $prod['id'] ?></td>
                            <td>
                                <?php if ($prod['foto']): ?>
                                    <img src="../imagenes/<?= htmlspecialchars($prod['foto']) ?>" class="img-thumbnail rounded" style="width: 80px;">
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($prod['nombre']) ?></td>
                            <td><strong>$<?= number_format($prod['precio'], 2) ?></strong></td>
                            <td><?= htmlspecialchars($prod['categoria']) ?></td>
                            <td>
                                <a href="index.php?action=editar&id=<?= $prod['id'] ?>" class="btn btn-sm btn-warning me-1">✏️</a>

                                <form method="POST" action="index.php?action=eliminar&id=<?= $prod['id'] ?>" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

