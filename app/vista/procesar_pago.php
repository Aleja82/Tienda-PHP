<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
            <h4 class="mb-0">Resumen de la Compra</h4>
        </div>
        <div class="card-body">
            <h5 class="text-uppercase" style="color:#3B060A;">Datos del Cliente</h5>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
            <p><strong>Correo:</strong> <?= htmlspecialchars($correo) ?></p>
            <p><strong>Dirección:</strong> <?= htmlspecialchars($direccion) ?></p>

            <hr>

            <h5 class="text-uppercase" style="color:#3B060A;">Detalle del Pedido</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row mt-4">
                <div class="col-md-6">
                    <p><strong>Método de Pago:</strong> <?= ucfirst($metodo_pago) ?></p>
                    <p><strong>Envío:</strong> $<?= number_format($costo_envio, 2) ?></p>
                </div>
                <div class="col-md-6 text-end">
                    <h5>Total a Pagar: <span class="text-success">$<?= number_format($total + $costo_envio, 2) ?></span></h5>
                </div>
            </div>

            <form action="index.php?action=confirmarPago" method="post" class="mt-4 text-center">
                <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                <input type="hidden" name="correo" value="<?= htmlspecialchars($correo) ?>">
                <input type="hidden" name="direccion" value="<?= htmlspecialchars($direccion) ?>">
                <input type="hidden" name="metodo_pago" value="<?= htmlspecialchars($metodo_pago) ?>">
                <input type="hidden" name="costo_envio" value="<?= $costo_envio ?>">
                <input type="hidden" name="total" value="<?= $total ?>">

                <button type="submit" class="btn btn-success px-5">✅ Confirmar Pago</button>
                <a href="index.php?action=verCarrito" class="btn btn-secondary ms-2">🛒 Volver al Carrito</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
