<?php
require_once __DIR__ . '/../../config/conexion.php';

class ProductoDAO
    {
        private $conexion;

        public function __construct()
        {
            $this->conexion = Conexion::conectar();
        }

        public function insertar($nombre, $precio, $foto, $categoria_id)
        {
            $sql = "INSERT INTO productos (nombre, precio, foto, categoria_id) VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$nombre, $precio, $foto, $categoria_id]);
        }

        public function listar()
        {
            $sql = "SELECT p.id, p.nombre, p.precio, p.foto, c.nombre AS categoria
                    FROM productos p
                    INNER JOIN categoria c ON p.categoria_id = c.id
                    ORDER BY p.id DESC";
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function eliminar($id)
        {
            $stmt = $this->conexion->prepare("SELECT foto FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            $foto = $stmt->fetchColumn();

            $stmt = $this->conexion->prepare("DELETE FROM productos WHERE id = ?");
            $resultado = $stmt->execute([$id]);

            if ($resultado && $foto && file_exists("imagenes/$foto")) {
                unlink("imagenes/$foto");
            }

            return $resultado;
        }

        public function buscarPorId($id)
        {
            $sql = "SELECT * FROM productos WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function actualizar($id, $nombre, $precio, $foto, $categoria_id)
        {
            try {
                if ($foto) {
                    $stmt = $this->conexion->prepare("SELECT foto FROM productos WHERE id = ?");
                    $stmt->execute([$id]);
                    $fotoAnterior = $stmt->fetchColumn();

                    $sql = "UPDATE productos SET nombre = ?, precio = ?, foto = ?, categoria_id = ? WHERE id = ?";
                    $stmt = $this->conexion->prepare($sql);
                    $resultado = $stmt->execute([$nombre, $precio, $foto, $categoria_id, $id]);

                    if ($resultado && $fotoAnterior && file_exists("imagenes/$fotoAnterior")) {
                        unlink("imagenes/$fotoAnterior");
                    }

                    return $resultado;

                } else {
                    $sql = "UPDATE productos SET nombre = ?, precio = ?, categoria_id = ? WHERE id = ?";
                    $stmt = $this->conexion->prepare($sql);
                    return $stmt->execute([$nombre, $precio, $categoria_id, $id]);
                }

            } catch (PDOException $e) {
                return false;
            }
        }

        public function listarPorCategoria($categoria_id)
        {
            $sql = "SELECT p.id, p.nombre, p.precio, p.foto, c.nombre AS categoria
                    FROM productos p
                    INNER JOIN categoria c ON p.categoria_id = c.id
                    WHERE p.categoria_id = ?
                    ORDER BY p.id DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$categoria_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

