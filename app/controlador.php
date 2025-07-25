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

        foreach ($carrito as $id => $cantidad) {
            $producto = $dao->buscarPorId($id); // ✅ nombre correcto
            if ($producto) {
                $producto['cantidad'] = $cantidad;
                $productosCarrito[] = $producto;
            }
        }

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
}
