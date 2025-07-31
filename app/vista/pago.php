<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago | Tienda Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="text-center mb-4" style="color: #8A0000;">💳 Confirmar Compra</h1>

    <form action="index.php?action=procesarPago" method="POST">

        <!-- Datos del Cliente -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">👤 Datos del Cliente</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico:</label>
                    <input type="email" name="correo" id="correo" class="form-control" required>
                </div>
            </div>
        </div>

        <!-- Envío -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">🚚 Tipo de Envío</div>
            <div class="card-body">
                <select name="tipo_envio" id="tipo_envio" class="form-select" required>
                    <option value="local">Envío local (+$3.00)</option>
                    <option value="provincial">Envío dentro de la provincia (+$6.00)</option>
                    <option value="nacional">Envío nacional (+$8.00)</option>
                </select>
            </div>
        </div>

        <!-- Método de Pago -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">💰 Método de Pago</div>
            <div class="card-body">
                <select name="metodo_pago" class="form-select" required>
                    <option value="transferencia">Transferencia bancaria</option>
                    <option value="debito">Tarjeta de débito</option>
                    <option value="contra_entrega">Pago contra entrega</option>
                </select>
            </div>
        </div>

        <!-- Factura -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">🧾 Factura</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosCarrito as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nombre']) ?></td>
                                <td>$<?= number_format($item['precio'], 2) ?></td>
                                <td><?= $item['cantidad'] ?></td>
                                <td>$<?= number_format($item['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end">Subtotal:</td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">IVA (12%):</td>
                            <td>$<?= number_format($iva, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Envío: <span id="envio-texto">$3.00</span></td>
                            <td id="envio-total">$3.00</td>
                        </tr>
                        <tr class="table-secondary">
                            <td colspan="3" class="text-end fw-bold">Total Final:</td>
                            <td id="total-final" class="fw-bold">$<?= number_format($total + 3, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Confirmar pago -->
        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">💾 Confirmar y Pagar</button>
        </div>
    </form>
</div>

<script>
document.getElementById('tipo_envio').addEventListener('change', function() {
    let envioCostos = {
        'local': 3,
        'provincial': 6,
        'nacional': 8
    };
    let envio = envioCostos[this.value] || 3;

    const subtotal = <?= json_encode($subtotal) ?>;
    const iva = <?= json_encode($iva) ?>;
    const totalFinal = subtotal + iva + envio;

    document.getElementById('envio-total').textContent = `$${envio.toFixed(2)}`;
    document.getElementById('envio-texto').textContent = `+$${envio.toFixed(2)}`;
    document.getElementById('total-final').textContent = `$${totalFinal.toFixed(2)}`;
});
</script>

</body>
</html>
