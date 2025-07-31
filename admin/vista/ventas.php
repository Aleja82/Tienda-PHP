<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas Realizadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="text-center text-uppercase mb-4" style="color: #3B060A;">Ventas Registradas</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Fecha</th>
                    <th>Método de Pago</th>
                    <th>Total</th>
                    <th>Ver Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ventas)): ?>
                    <?php foreach ($ventas as $venta): ?>
                        <tr class="text-center">
                            <td><?= $venta['id'] ?></td>
                            <td><?= htmlspecialchars($venta['nombre_cliente']) ?></td>
                            <td><?= htmlspecialchars($venta['correo_cliente']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?></td>
                            <td><?= ucfirst(htmlspecialchars($venta['metodo_pago'])) ?></td>
                            <td><strong>$<?= number_format($venta['total'], 2) ?></strong></td>
                            <td>
                                <a href="../index.php?action=detalleVenta&id=<?= $venta['id'] ?>" class="btn btn-sm btn-primary">
                                    📄 Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay ventas registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="index.php?action=listar" class="btn btn-secondary">← Volver</a>
    </div>
</div>

</body>
</html>
