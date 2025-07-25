<?php

require_once APP_PATH . "/admin/modelo/ProductoDAO.php";

class ProductoController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ProductoDAO();
    }

    private function verificarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    public function registrar()
    {
        $this->verificarSesion();

        require_once "modelo/CategoriaDAO.php";
        $categoriaDAO = new CategoriaDAO();
        $categorias = $categoriaDAO->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                die("Token CSRF inválido.");
            }

            $nombre = trim($_POST['nombre']);
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria_id'];

            if (empty($nombre) || !is_numeric($precio)) {
                die("Datos inválidos.");
            }

            // Validar tipo de archivo
            $foto = null;
            $permitidos = ['image/jpeg', 'image/png'];
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                if (!in_array($_FILES['foto']['type'], $permitidos)) {
                    die("Formato de imagen no permitido.");
                }

                $nombreArchivo = uniqid() . "_" . basename($_FILES['foto']['name']);
                $rutaDestino = "../imagenes/" . $nombreArchivo;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                    $foto = $nombreArchivo;
                }
            }

            $this->modelo->insertar($nombre, $precio, $foto, $categoria_id);
            header("Location: index.php?action=listar");
            exit();
        }

        include "vista/formulario.php";
    }

    public function listar()
    {
        $this->verificarSesion();

        $productos = $this->modelo->listar();
        include "vista/lista.php";
    }

    public function eliminar()
    {
        $this->verificarSesion();

        // ✅ Verificar token desde POST
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Token CSRF inválido.");
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->modelo->eliminar($id);
        }

        header("Location: index.php?action=listar");
        exit();
    }


    public function editar()
    {
        $this->verificarSesion();

        require_once "modelo/CategoriaDAO.php";
        $categoriaDAO = new CategoriaDAO();
        $categorias = $categoriaDAO->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                die("Token CSRF inválido.");
            }

            $id = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria_id'];

            if (empty($nombre) || !is_numeric($precio)) {
                die("Datos inválidos.");
            }

            $producto = $this->modelo->buscarPorId($id);

            $foto = null;
            $permitidos = ['image/jpeg', 'image/png'];
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                if (!in_array($_FILES['foto']['type'], $permitidos)) {
                    die("Formato de imagen no permitido.");
                }

                $nombreArchivo = uniqid() . "_" . basename($_FILES['foto']['name']);
                $ruta = "../imagenes/" . $nombreArchivo;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
                    if (!empty($producto['foto']) && file_exists("imagenes/" . $producto['foto'])) {
                        unlink("imagenes/" . $producto['foto']);
                    }
                    $foto = $nombreArchivo;
                }
            }

            $this->modelo->actualizar($id, $nombre, $precio, $foto, $categoria_id);
            header("Location: index.php?action=listar");
            exit();
        } else {
            $id = $_GET['id'];
            $producto = $this->modelo->buscarPorId($id);
            include "vista/editar.php";
        }
    }
}
