<?php
require_once "app/controlador.php";

$action = $_GET['action'] ?? 'inicio';

$controller = new Controller(); 

switch ($action) {
    case 'inicio':
        $controller->inicio();
        break;
    case 'detalle':
        $id = $_GET['id'] ?? null;
        $controller->detalle($id);
        break;
    case 'contacto':
        $controller->contacto();
        break;
    case 'agregarCarrito':
        $id = $_GET['id'] ?? null;
        $controller->agregarCarrito($id);
        break;
    case 'verCarrito':
        $controller->verCarrito();
        break;
    case 'eliminarDelCarrito':
        $id = $_GET['id'] ?? null;
        $controller->eliminarDelCarrito($id);
        break;

    case 'vaciarCarrito':
        $controller->vaciarCarrito();
        break;
    case 'disminuirCantidad':
        $id = $_GET['id'] ?? null;
        $controller->disminuirCantidad($id);
        break;
    case 'filtrarCategoria':
        $id = $_GET['id'] ?? null;
        $controller->filtrarCategoria($id);
        break;
    case 'pago':
        $controller->pago();
        break;
    case 'procesarPago':
        $controller->procesarPago();
        break;
    case 'detalleVenta':
        $id = $_GET['id'] ?? null;
        $controller->detalleVenta($id);
        break;
    case 'verVentas':
    $controller->verVentas();
    break;

    default:
        http_response_code(404);
        echo "Página no encontrada.";
        break;
}
