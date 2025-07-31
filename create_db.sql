-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

-- Tabla de categorías
CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de productos con clave foránea y campo para imagen
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    foto VARCHAR(255),
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

--Tabla de mensajes
CREATE TABLE mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100),
    mensaje TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    correo_cliente VARCHAR(100) NOT NULL,
    metodo_pago VARCHAR(50),
    tipo_envio VARCHAR(50),
    costo_envio DECIMAL(10,2),
    subtotal DECIMAL(10,2),
    iva DECIMAL(10,2),
    total DECIMAL(10,2),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla detalle_venta
CREATE TABLE detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT,
    producto_id INT,
    nombre_producto VARCHAR(100),
    precio_unitario DECIMAL(10,2),
    cantidad INT,
    subtotal DECIMAL(10,2),
    FOREIGN KEY (venta_id) REFERENCES ventas(id)
);
-- Poblado inciial de categorías
INSERT INTO categoria (nombre) VALUES
('Tecnología'),
('Moda'),
('Hogar'),
('Libros');

--poblado inicial de porductos
INSERT INTO productos (nombre, precio, foto, categoria_id) VALUES
('Laptop HP 15"', 799.99, 'laptop-hp.jpg', 1),
('Smartphone Galaxy A15', 299.99, 'galaxy-a15.jpg', 1),
('Vestido de verano', 45.00, 'vestido-verano.jpg', 2),
('Sofá 3 puestos', 399.99, 'sofa.jpg', 3),
('Harry Potter y la Piedra Filosofal', 20.50, 'harry-potter.jpg', 4),
('Audífonos Bluetooth', 25.00, 'audifonos.jpg', 1),
('Chaqueta de cuero', 120.00, 'chaqueta-cuero.jpg', 2);


-- Contraseña: 123456 (usaremos https://onlinephp.io/password-hash)
INSERT INTO usuarios (correo, contrasena)
VALUES ('admin@tienda.com', '$2y$10$LVy/4OipnchmJfiGD5DMiOUiQblfwt.Xv2cjvKSHYVa4j.Nj.T6eu');
