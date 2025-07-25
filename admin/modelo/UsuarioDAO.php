<?php
require_once APP_PATH . "/config/conexion.php";

class UsuarioDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function autenticar($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario;
        }

        return false;
    }
}
