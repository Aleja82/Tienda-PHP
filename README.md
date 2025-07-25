# 🛍️ Tienda Virtual MVC (PHP + MySQL + Bootstrap)

Este repositorio contiene una tienda virtual construida con **PHP**, **MySQL**, **Bootstrap** y una arquitectura **MVC simplificada**. Incluye panel administrativo (`/admin`) para gestión de productos, autenticación, y un catálogo público accesible desde la raíz.

## 📁 Estructura del Proyecto

```
/tienda/
├── index.php                 ← Punto de entrada público (MVC público)
├── app/
│   ├── modelo.php            ← Lógica de acceso a datos
│   ├── controlador.php       ← Controlador público
│   └── vista/
│       ├── tienda.php        ← Catálogo público
│       └── detalle.php       ← Detalles del producto
├── admin/
│   ├── index.php             ← Enrutador admin
│   ├── controlador/
│   │   └── ProductoController.php
│   │   └── AuthController.php
│   ├── modelo/
│   │   └── ProductoDAO.php
│   │   └── CategoriaDAO.php
│   │   └── UsuarioDAO.php
│   └── vista/                ← Formularios y listados admin
├── config/
│   └── conexion.php          ← Configuración de la base de datos (PDO)
├── assets/
│   ├── css/estilos.css       ← Estilos personalizados
│   └── js/funciones.js       ← Scripts personalizados
├── imagenes/                 ← Imágenes de productos subidas
└── README.md
```

## ✅ Características

### 🔹 Catálogo público (`/index.php?action=inicio`)
- Muestra productos agrupados por categoría.
- Vista responsiva con **Bootstrap**.
- Enlace a página de detalle por producto (`action=detalle&id=X`).

### 🔐 Panel administrativo (`/admin/index.php`)
- Autenticación con sesiones (`login` / `logout`).
- Gestión completa de productos: **Crear**, **Leer**, **Actualizar**, **Eliminar** (CRUD).
- Incluye subida de imágenes con nombres únicos y manejo de archivos (no deja huérfanos).
- Gestión de categorías y asociación mediante clave foránea.

### 🎨 Recursos adicionales
- Estilos personalizados en `/assets/css/estilos.css`
- Scripts JS en `/assets/js/funciones.js`
- Integración limpia con **Bootstrap 5** vía CDN.

## 🚀 Cómo ejecutar el proyecto en XAMPP

1. **Clona el repositorio** en `C:\xampp\htdocs\tienda`.
2. **Importa la base de datos**:
   - Crea la base `tienda`
   - Ejecuta scripts SQL de tablas `categoria`, `productos`, `usuarios`
3. **Configura `config/conexion.php`** con credenciales (ej. user `root`, sin password).
4. **Iniciar servicios de XAMPP**: Apache y MySQL.
5. **Accede al front-end**:
   - Pública: `http://localhost/tienda/`
   - Admin: `http://localhost/tienda/admin/index.php?action=login`
6. **Usuario de prueba**:
   - Email: `admin@tienda.com`
   - Contraseña: la que hayas definido con `password_hash`.

## 🛠️ Personalización

- Añade nuevas vistas (Ej. contacto, carrito) en `/app/controlador.php` con rutas vía `action=`.
- Modifica estilos o scripts en `/assets/`.
- Mejora seguridad con CSRF tokens o validación del lado del servidor.
- Escala la autenticación o el diseño estructural según sea necesario.

## 💡 Buenas prácticas

- La lógica de presentación está separada del controlador y modelo.
- El administrador y público están en entornos aislados (`/admin/` vs `/`).
- Se generan nombres únicos para las imágenes.
- Se eliminan imágenes antiguas al actualizar o borrar productos.
- Se mantiene una arquitectura clara y mantenible.

## 📝 Próximos pasos

- Implementar página de **detalle del producto** (ya incluida).
- Agregar formularios de **contacto** o sistema de **carrito de compras**.
- Mejorar la seguridad (CSRF, validaciones, permisos).
- Preparar el proyecto para producción (HTTPS, .htaccess, env).

## 📌 Contribuciones

¡Bienvenidas! Si deseas contribuir:

1. Haz un fork.
2. Crea una rama `feature/tu-mejora`.
3. Realiza tus cambios.
4. Envía tu pull request.

---

Codificado con 💙 para mis estudiantes.  
Autor: Rodrigo Tufiño <rtufino@ups.edu.ec>
