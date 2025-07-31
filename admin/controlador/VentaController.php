<?php
require_once APP_PATH . "/admin/modelo/VentaDAO.php";

class VentaController
{
    public function verVentas()
    {
        $dao = new VentaDAO();
        $ventas = $dao->obtenerVentas();

        include APP_PATH . "/admin/vista/ventas.php";
    }

    public function detalleVenta($id)
    {
        $pdo = Conexion::conectar();

        // Obtener datos de la venta
        $stmt = $pdo->prepare("SELECT * FROM ventas WHERE id = ?");
        $stmt->execute([$id]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtener detalles de los productos vendidos
        $stmt = $pdo->prepare("SELECT * FROM detalle_venta WHERE venta_id = ?");
        $stmt->execute([$id]);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include APP_PATH . "/admin/vista/detalle_venta.php";
    }
}
