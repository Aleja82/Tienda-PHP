<?php
require_once APP_PATH . "/admin/modelo/UsuarioDAO.php";

class AuthController {
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                die("Error: token CSRF inválido.");
            }

            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];

            $dao = new UsuarioDAO();
            $usuario = $dao->autenticar($correo, $contrasena);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['correo'];
                // Opcional: regenerar el token después de login exitoso
                unset($_SESSION['csrf_token']);
                header("Location: index.php?action=listar");
                exit();
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        }

        include "vista/login.php";
    }


    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}
