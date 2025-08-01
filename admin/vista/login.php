<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Administrativo</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="/tienda/assets/css/estilos.css?v=1.1">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%; border: 1px solid #F36F21;">
        <h2 class="text-center mb-4" style="color: #0A2540;">Acceso Administrativo</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" required placeholder="admin@correo.com">
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required placeholder="••••••••">
            </div>

            <input type="hidden" name="csrf_token" value="<?= $token ?>">

            <div class="d-grid">
                <button type="submit" class="btn" style="background-color: #F36F21; color: #0A2540;">Ingresar</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="../index.php" class="text-decoration-none" style="color: #0A2540;">← Volver a la tienda</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
