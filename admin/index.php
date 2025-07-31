<?php
define('APP_PATH', dirname(__DIR__)); // → C:\xampp\htdocs\tienda

session_start();

require_once APP_PATH . "/config/conexion.php";
require_once APP_PATH . "/admin/controlador/AuthController.php";
require_once APP_PATH . "/admin/controlador/ProductoController.php";

$action = $_GET['action'] ?? 'login';
$auth = new AuthController();
$controller = new ProductoController();

// Acciones públicas
$publicas = ['login', 'logout'];

// ✅ SOLO redirigir si NO estás en acción pública Y NO estás autenticado
if (!in_array($action, $publicas) && !isset($_SESSION['usuario'])) {
    header("Location: index.php?action=login");
    exit();
}


switch ($action) {
    case 'login':
        $auth = new AuthController();
        $auth->login();
        break;
    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;
    case 'listar':
        $controller->listar();
        break;
    case 'registrar':
        $controller->registrar();
        break;
    case 'eliminar':
        $controller->eliminar(); 
        break;
    case 'editar':
        $controller->editar();
        break;
        case 'verVentas':
        require_once APP_PATH . "/admin/controlador/VentaController.php";
        $ventaController = new VentaController();
        $ventaController->verVentas();
        break;

    case 'detalleVenta':
        require_once APP_PATH . "/admin/controlador/VentaController.php";
        $ventaController = new VentaController();
        $id = $_GET['id'] ?? null;
        $ventaController->detalleVenta($id);
        break;

    // ...
    default:
        header("Location: index.php?action=login");
        break;
}

