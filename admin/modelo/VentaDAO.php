<?php
require_once APP_PATH . "/config/conexion.php";

class VentaDAO
{
    public function obtenerVentas()
    {
        $pdo = Conexion::conectar();

        $stmt = $pdo->query("SELECT * FROM ventas ORDER BY fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
