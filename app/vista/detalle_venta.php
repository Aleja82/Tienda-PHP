<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta #<?= $venta['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Factura de Compra - Venta #<?= $venta['id'] ?></h4>
        </div>
        <div class="card-body">

            <h5 class="mb-3">Datos del Cliente</h5>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($venta['nombre_cliente']) ?></p>
            <p><strong>Correo:</strong> <?= htmlspecialchars($venta['correo_cliente']) ?></p>
            <p><strong>Método de Pago:</strong> <?= ucfirst($venta['metodo_pago']) ?></p>
            <p><strong>Tipo de Envío:</strong> <?= ucfirst($venta['tipo_envio']) ?> (<?= number_format($venta['costo_envio'], 2) ?> USD)</p>

            <h5 class="mt-4">Productos Comprados</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                                <td><?= number_format($item['precio_unitario'], 2) ?> USD</td>
                                <td><?= $item['cantidad'] ?></td>
                                <td><?= number_format($item['subtotal'], 2) ?> USD</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <p><strong>Subtotal:</strong> <?= number_format($venta['subtotal'], 2) ?> USD</p>
                <p><strong>IVA (12%):</strong> <?= number_format($venta['iva'], 2) ?> USD</p>
                <p><strong>Envío:</strong> <?= number_format($venta['costo_envio'], 2) ?> USD</p>
                <h4><strong>Total:</strong> <?= number_format($venta['total'], 2) ?> USD</h4>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-outline-primary">Volver a la tienda</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
