<?php
require_once __DIR__ . '/../admin/modelo/ProductoDAO.php';
require_once __DIR__ . '/../admin/modelo/CategoriaDAO.php'; // si también necesitas categorías


class Controller
{
    public function inicio()
    {
        require_once "admin/modelo/CategoriaDAO.php";
        require_once "admin/modelo/ProductoDAO.php";

        $categoriaDAO = new CategoriaDAO();
        $productoDAO = new ProductoDAO();

        $categorias = $categoriaDAO->listar();
        $productos = $productoDAO->listar(); // ✅ método existente

        // Agrupar por categoría
        $agrupados = [];
        foreach ($productos as $p) {
            $agrupados[$p['categoria']][] = $p;
        }

        include "vista/tienda.php";
    }

    public function detalle($id)
    {
        require_once "admin/modelo/ProductoDAO.php";

        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo "ID de producto inválido.";
            return;
        }

        $dao = new ProductoDAO();
        $producto = $dao->buscarPorId($id); // ✅ método correcto según tu DAO

        if (!$producto) {
            http_response_code(404);
            echo "Producto no encontrado.";
            return;
        }

        include "vista/detalle.php";
    }

    public function contacto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $mensaje = trim($_POST['mensaje'] ?? '');

            $errores = [];

            if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Correo inválido.";
            if (empty($mensaje)) $errores[] = "El mensaje no puede estar vacío.";

            if (empty($errores)) {
                $exito = true;

                require_once "config/conexion.php";
                $pdo = Conexion::conectar();
                $stmt = $pdo->prepare("INSERT INTO mensajes (nombre, correo, mensaje) VALUES (?, ?, ?)");
                $stmt->execute([$nombre, $correo, $mensaje]);
            }
        }

        include "vista/contacto.php";
    }

    public function agregarCarrito($id)
    {
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo "ID de producto inválido.";
            return;
        }

        session_start();

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]++;
        } else {
            $_SESSION['carrito'][$id] = 1;
        }

        header("Location: index.php?action=verCarrito");
        exit();
    }

    public function verCarrito()
    {
        session_start();

        $carrito = $_SESSION['carrito'] ?? [];

        require_once "admin/modelo/ProductoDAO.php";
        $dao = new ProductoDAO();

        $productosCarrito = [];
        $subtotal = 0;

        foreach ($carrito as $id => $cantidad) {
            $producto = $dao->buscarPorId($id);
            if ($producto) {
                $producto['cantidad'] = $cantidad;
                $productosCarrito[] = $producto;
                $subtotal += $producto['precio'] * $cantidad;
            }
        }

        // Calcular IVA (15%) y total con IVA
        $iva = $subtotal * 0.15;
        $totalConIva = $subtotal + $iva;

        // Pasar todos los datos necesarios a la vista
        include "vista/carrito.php";
    }


    public function eliminarDelCarrito($id)
    {
        session_start();

        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?action=verCarrito");
        exit();
    }

    public function vaciarCarrito()
    {
        session_start();
        unset($_SESSION['carrito']);
        header("Location: index.php?action=verCarrito");
        exit();
    }

    public function disminuirCantidad($id)
    {
        session_start();

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]--;

            if ($_SESSION['carrito'][$id] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }

        header("Location: index.php?action=verCarrito");
        exit();
    }

    public function filtrarCategoria($id)
    {
        require_once "admin/modelo/CategoriaDAO.php";
        require_once "admin/modelo/ProductoDAO.php";

        $categoriaDAO = new CategoriaDAO();
        $productoDAO = new ProductoDAO();

        $categorias = $categoriaDAO->listar();

        if (!$id || !is_numeric($id)) {
            header("Location: index.php?action=inicio");
            exit;
        }

        $productos = $productoDAO->listarPorCategoria($id); // ✅ método correcto

        $agrupados = [];
        foreach ($productos as $prod) {
            $agrupados[$prod['categoria']][] = $prod;
        }

        include "vista/tienda.php"; // ✅ corregida la ruta
    }
    public function pago()
    {
        session_start();

        $carrito = $_SESSION['carrito'] ?? [];

        if (empty($carrito)) {
            header("Location: index.php");
            exit;
        }

        require_once "admin/modelo/ProductoDAO.php";
        $dao = new ProductoDAO();
        $productosCarrito = [];

        $subtotal = 0;
        foreach ($carrito as $id => $cantidad) {
            $producto = $dao->buscarPorId($id);
            if ($producto) {
                $producto['cantidad'] = $cantidad;
                $producto['subtotal'] = $producto['precio'] * $cantidad;
                $subtotal += $producto['subtotal'];
                $productosCarrito[] = $producto;
            }
        }

        $iva = $subtotal * 0.12;
        $total = $subtotal + $iva;

        include "vista/pago.php";
    }
    public function procesarPago()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
            echo "El carrito está vacío.";
            exit;
        }

        require_once "config/conexion.php";
        require_once "admin/modelo/ProductoDAO.php";

        $pdo = Conexion::conectar();
        $dao = new ProductoDAO();

        // Obtener datos del formulario
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $metodo_pago = $_POST['metodo_pago'];
        $tipo_envio = $_POST['tipo_envio'];

        // Calcular costo de envío
        $costo_envio = 0;
        if ($tipo_envio === 'local') $costo_envio = 3;
        elseif ($tipo_envio === 'provincial') $costo_envio = 6;
        elseif ($tipo_envio === 'nacional') $costo_envio = 8;

        $carrito = $_SESSION['carrito'];
        $productos = [];
        $subtotal = 0;

        // Armar lista de productos y calcular subtotal
        foreach ($carrito as $producto_id => $cantidad) {
            $producto = $dao->buscarPorId($producto_id);
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
        $total = $subtotal + $iva + $costo_envio;

        // Guardar en la tabla ventas
        $stmt = $pdo->prepare("INSERT INTO ventas (nombre_cliente, correo_cliente, metodo_pago, tipo_envio, costo_envio, subtotal, iva, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $metodo_pago, $tipo_envio, $costo_envio, $subtotal, $iva, $total]);

        $venta_id = $pdo->lastInsertId();

        // Guardar en detalle_venta
        $stmt_detalle = $pdo->prepare("INSERT INTO detalle_venta (venta_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES (?, ?, ?, ?, ?, ?)");

        foreach ($productos as $prod) {
            $stmt_detalle->execute([
                $venta_id,
                $prod['id'],
                $prod['nombre'],
                $prod['precio'],
                $prod['cantidad'],
                $prod['subtotal']
            ]);
        }

        // Limpiar carrito
        unset($_SESSION['carrito']);

        // Redirigir a detalle de venta
        header("Location: index.php?action=detalleVenta&id=" . $venta_id);
        exit;
    }


    public function detalleVenta($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once "config/conexion.php";
        $pdo = Conexion::conectar();

        $stmt = $pdo->prepare("SELECT * FROM ventas WHERE id = ?");
        $stmt->execute([$id]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM detalle_venta WHERE venta_id = ?");
        $stmt->execute([$id]);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "vista/detalle_venta.php";
    }



}

