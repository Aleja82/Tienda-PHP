<?php
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tu estilo personalizado -->
    <link rel="stylesheet" href="assets/css/estilos.css?v=1.3">
</head>

<body class="bg-light py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <!-- Título -->
                <h2 class="text-center mb-4 fw-bold" style="color: #8A0000;">Registrar Nuevo Producto</h2>

                <!-- Formulario -->
                <form method="POST" action="index.php?action=registrar" enctype="multipart/form-data" class="card shadow-lg p-4 border-0">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ej. Camiseta Roja">
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio ($)</label>
                        <input type="number" name="precio" id="precio" step="0.01" class="form-control" required placeholder="Ej. 19.99">
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto del Producto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label for="categoria_id" class="form-label">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-select" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn" style="background-color: #3B060A; color: #FFF287;">
                            Guardar Producto
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?action=listar" class="text-decoration-none text-muted">← Volver al Panel</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
