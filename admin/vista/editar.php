<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="assets/css/estilos.css?v=1.3">
</head>

<body class="bg-light py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <!-- Título -->
                <h2 class="text-center mb-4 fw-bold" style="color: #8A0000;">Editar Producto</h2>

                <!-- Formulario -->
                <form method="POST" action="index.php?action=editar" enctype="multipart/form-data" class="card shadow-lg p-4 border-0">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($producto['nombre']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio ($)</label>
                        <input type="number" name="precio" step="0.01" class="form-control" required value="<?= $producto['precio'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto actual:</label><br>
                        <?php if ($producto['foto']): ?>
                            <img src="../imagenes/<?= htmlspecialchars($producto['foto']) ?>" class="img-thumbnail" style="max-width: 150px;">
                        <?php else: ?>
                            <em class="text-muted">Sin imagen</em>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nueva foto (opcional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Categoría</label>
                        <select name="categoria_id" class="form-select" required>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $producto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?action=listar" class="btn btn-outline-secondary">
                            ← Cancelar
                        </a>
                        <button type="submit" class="btn" style="background-color: #3B060A; color: #FFF287;">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
