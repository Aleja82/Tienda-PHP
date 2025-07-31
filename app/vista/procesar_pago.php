<?php
session_start();
require_once "admin/modelo/ProductoDAO.php";
require_once "config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $metodo_pago = $_POST['metodo_pago'] ?? '';
    $tipo_envio = $_POST['tipo_envio'] ?? '';

    if (!$nombre || !$correo || !$metodo_pago || !$tipo_envio) {
        echo "Datos incompletos.";
        exit;
    }

    $envio = 0;
    switch ($tipo_envio) {
        case 'local': $envio = 3; break;
        case 'provincial': $envio = 6; break;
        case 'nacional': $envio = 8; break;
        default: $envio = 3;
    }

    $carrito = $_SESSION['carrito'] ?? [];
    if (empty($carrito)) {
        echo "El carrito está vacío.";
        exit;
    }

    $dao = new ProductoDAO();
    $productos = [];
    $subtotal = 0;

    foreach ($carrito as $id => $cantidad) {
        $producto = $dao->buscarPorId($id);
        if ($producto) {
            $itemSubtotal = $producto['precio'] * $cantidad;
            $subtotal += $itemSubtotal;
            $productos[] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad,
                'subtotal' => $itemSubtotal
            ];
        }
    }

    $iva = $subtotal * 0.12;
    $total = $subtotal + $iva + $envio;

    try {
        $pdo = Conexion::conectar();
        $pdo->beginTransaction();

        // Insertar en ventas
        $stmt = $pdo->prepare("INSERT INTO ventas (nombre_cliente, correo_cliente, metodo_pago, tipo_envio, costo_envio, subtotal, iva, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $metodo_pago, $tipo_envio, $envio, $subtotal, $iva, $total]);

        $ventaId = $pdo->lastInsertId();

        // Insertar detalle_venta
        $stmtDetalle = $pdo->prepare("INSERT INTO detalle_venta (venta_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($productos as $prod) {
            $stmtDetalle->execute([
                $ventaId,
                $prod['id'],
                $prod['nombre'],
                $prod['precio'],
                $prod['cantidad'],
                $prod['subtotal']
            ]);
        }

        $pdo->commit();

        // Vaciar carrito
        unset($_SESSION['carrito']);

        // Redirigir a página de detalle
        header("Location: detalle_venta.php?id=$ventaId");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error al guardar la venta: " . $e->getMessage();
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
