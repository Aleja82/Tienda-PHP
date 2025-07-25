<?php
require_once __DIR__ . '/../../config/conexion.php';

class CategoriaDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }
    public function listar()
    {
        $sql = "SELECT * FROM categoria ORDER BY nombre ASC";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM categoria WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
