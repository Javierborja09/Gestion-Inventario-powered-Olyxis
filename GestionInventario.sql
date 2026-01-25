-- =====================================================
-- SCRIPT COMPLETO DE GESTIÓN DE INVENTARIO
-- =====================================================
-- 1. CONFIGURACIÓN INICIAL
CREATE DATABASE gestion_inventario 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE gestion_inventario;

-- 2. ESTRUCTURA DE TABLAS

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_producto_categoria 
        FOREIGN KEY (categoria_id) 
        REFERENCES categorias(id) 
        ON DELETE CASCADE,
    INDEX idx_categoria (categoria_id)
) ENGINE=InnoDB;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_venta_producto 
        FOREIGN KEY (producto_id) 
        REFERENCES productos(id) 
        ON DELETE CASCADE,
    INDEX idx_fecha (fecha),
    INDEX idx_producto (producto_id)
) ENGINE=InnoDB;

-- 3. DATOS DE PRUEBA

-- Insertar usuario administrador
INSERT INTO usuarios (username, password, nombre) 
VALUES ('admin', '$2y$10$q58uA2.Gdof9Kss4BmkaFOW5eG3ANYEzRCW8jW45zLBKvztUKPN/S', 'Administrador');

-- Insertar categorías
INSERT INTO categorias (nombre, descripcion) VALUES
('Electrónica', 'Dispositivos y equipos electrónicos'),
('Alimentos', 'Productos alimenticios y bebidas'),
('Ropa', 'Prendas de vestir y accesorios'),
('Hogar', 'Artículos para el hogar y decoración'),
('Deportes', 'Equipamiento deportivo y fitness'),
('Libros', 'Libros y material educativo'),
('Juguetes', 'Juguetes y entretenimiento infantil'),
('Salud', 'Productos de salud y cuidado personal'),
('Automotriz', 'Accesorios y repuestos para vehículos'),
('Oficina', 'Material y equipamiento de oficina');

-- Insertar productos por categoría

-- ELECTRÓNICA (categoria_id = 1)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(1, 'Laptop HP 15.6"', 'Laptop Intel Core i5, 8GB RAM, 256GB SSD', 899.99, 15),
(1, 'Mouse Inalámbrico Logitech', 'Mouse ergonómico con batería recargable', 29.99, 50),
(1, 'Teclado Mecánico RGB', 'Teclado gaming con switches blue', 79.99, 30),
(1, 'Monitor Samsung 24"', 'Monitor Full HD IPS 75Hz', 189.99, 20),
(1, 'Auriculares Bluetooth', 'Auriculares con cancelación de ruido', 149.99, 25),
(1, 'Webcam HD 1080p', 'Cámara web con micrófono integrado', 59.99, 40),
(1, 'Disco Duro Externo 1TB', 'HDD portátil USB 3.0', 69.99, 35),
(1, 'Cable HDMI 2m', 'Cable HDMI 2.0 alta velocidad', 12.99, 100);

-- ALIMENTOS (categoria_id = 2)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(2, 'Quinua Orgánica 1KG', 'Quinua blanca de origen peruano', 15.50, 80),
(2, 'Aceite de Oliva 500ml', 'Aceite extra virgen importado', 24.99, 45),
(2, 'Arroz Integral 2KG', 'Arroz integral de grano largo', 8.99, 120),
(2, 'Café Molido Premium 250g', 'Café 100% arábica tostado medio', 18.50, 60),
(2, 'Miel de Abeja 500g', 'Miel natural pura', 12.99, 70),
(2, 'Pasta Integral 500g', 'Pasta de trigo integral', 3.99, 150),
(2, 'Almendras 200g', 'Almendras naturales sin sal', 9.99, 55),
(2, 'Chocolate Negro 70% 100g', 'Chocolate artesanal orgánico', 6.50, 90);

-- ROPA (categoria_id = 3)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(3, 'Camiseta Básica Algodón', 'Camiseta unisex 100% algodón', 19.99, 100),
(3, 'Jeans Slim Fit', 'Pantalón denim azul clásico', 49.99, 60),
(3, 'Chaqueta Deportiva', 'Chaqueta con capucha impermeable', 89.99, 40),
(3, 'Zapatillas Running', 'Zapatillas deportivas con amortiguación', 129.99, 35),
(3, 'Gorra Baseball', 'Gorra ajustable de algodón', 15.99, 75),
(3, 'Medias Deportivas Pack x3', 'Medias transpirables', 12.99, 120),
(3, 'Shorts Deportivos', 'Shorts con bolsillos laterales', 29.99, 55),
(3, 'Bufanda de Lana', 'Bufanda tejida suave', 24.99, 45);

-- HOGAR (categoria_id = 4)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(4, 'Lámpara LED Escritorio', 'Lámpara flexible con 3 niveles de luz', 34.99, 50),
(4, 'Cojín Decorativo 45x45cm', 'Cojín con funda lavable', 16.99, 80),
(4, 'Organizador de Escritorio', 'Organizador de madera bambú', 28.99, 40),
(4, 'Espejo de Pared 60x40cm', 'Espejo con marco de aluminio', 45.99, 25),
(4, 'Set de Toallas x3', 'Toallas 100% algodón', 39.99, 60),
(4, 'Reloj de Pared Moderno', 'Reloj silencioso diseño minimalista', 32.99, 35),
(4, 'Cortina Blackout 140x200cm', 'Cortina bloqueadora de luz', 54.99, 30),
(4, 'Alfombra Antideslizante 60x90cm', 'Alfombra de baño absorbente', 22.99, 45);

-- DEPORTES (categoria_id = 5)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(5, 'Pelota de Fútbol Tamaño 5', 'Pelota profesional cosida a mano', 34.99, 40),
(5, 'Mancuernas 5KG Par', 'Mancuernas con recubrimiento de neopreno', 45.99, 30),
(5, 'Colchoneta Yoga 6mm', 'Colchoneta antideslizante con correa', 28.99, 50),
(5, 'Botella Deportiva 750ml', 'Botella térmica de acero inoxidable', 19.99, 80),
(5, 'Cuerda para Saltar', 'Cuerda ajustable con contador', 14.99, 65),
(5, 'Guantes de Boxeo 12oz', 'Guantes acolchados profesionales', 69.99, 20),
(5, 'Banda Elástica Resistencia', 'Set de 5 bandas con diferentes resistencias', 24.99, 55),
(5, 'Rodilleras Deportivas Par', 'Rodilleras con soporte y compresión', 18.99, 45);

-- LIBROS (categoria_id = 6)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(6, 'Cien Años de Soledad', 'Gabriel García Márquez - Tapa blanda', 18.99, 40),
(6, 'El Principito', 'Antoine de Saint-Exupéry - Edición ilustrada', 14.99, 60),
(6, 'Don Quijote de la Mancha', 'Miguel de Cervantes - Edición completa', 24.99, 35),
(6, 'Manual de Python Avanzado', 'Guía completa de programación', 45.99, 25),
(6, 'Atlas Mundial Actualizado', 'Atlas geográfico a color', 32.99, 30),
(6, 'Diccionario Español-Inglés', 'Más de 50,000 entradas', 28.99, 40),
(6, 'Cocina Peruana Moderna', 'Recetas tradicionales y fusión', 38.99, 22),
(6, 'Mindfulness para Principiantes', 'Guía práctica de meditación', 16.99, 50);

-- JUGUETES (categoria_id = 7)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(7, 'Lego Classic 500 Piezas', 'Set de construcción creativa', 49.99, 35),
(7, 'Muñeca Articulada 30cm', 'Muñeca con accesorios y ropa', 34.99, 45),
(7, 'Rompecabezas 1000 Piezas', 'Paisaje europeo de alta calidad', 22.99, 50),
(7, 'Pelota Sensorial Bebé', 'Pelota suave con texturas y colores', 12.99, 70),
(7, 'Auto Control Remoto 4x4', 'Auto recargable con control 2.4GHz', 79.99, 20),
(7, 'Set de Plastilina 12 Colores', 'Plastilina no tóxica con moldes', 15.99, 80),
(7, 'Juego de Mesa Monopoly', 'Versión clásica familiar', 42.99, 30),
(7, 'Peluche Oso 40cm', 'Peluche suave y abrazable', 28.99, 55);

-- SALUD (categoria_id = 8)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(8, 'Vitamina C 1000mg x60 Cáps', 'Suplemento inmunológico', 18.99, 100),
(8, 'Termómetro Digital', 'Termómetro de lectura rápida', 12.99, 60),
(8, 'Alcohol en Gel 500ml', 'Desinfectante de manos 70% alcohol', 8.99, 150),
(8, 'Mascarillas KN95 x20', 'Mascarillas de protección certificadas', 24.99, 80),
(8, 'Tensiómetro Digital', 'Monitor de presión arterial automático', 54.99, 25),
(8, 'Botiquín de Primeros Auxilios', 'Kit completo con 100 piezas', 39.99, 35),
(8, 'Omega 3 1000mg x90 Cáps', 'Aceite de pescado purificado', 29.99, 70),
(8, 'Gel Antibacterial 250ml', 'Gel desinfectante con aloe vera', 6.99, 120);

-- AUTOMOTRIZ (categoria_id = 9)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(9, 'Aceite Motor Sintético 5W-30', 'Aceite premium 4 litros', 45.99, 40),
(9, 'Filtro de Aire Universal', 'Filtro de alto rendimiento', 18.99, 55),
(9, 'Cargador de Batería 12V', 'Cargador inteligente automático', 59.99, 25),
(9, 'Kit de Herramientas 50 Piezas', 'Set completo con estuche', 79.99, 30),
(9, 'Limpiador de Tablero', 'Spray renovador con protección UV', 12.99, 70),
(9, 'Alfombras Universales x4', 'Alfombras de goma antideslizantes', 34.99, 45),
(9, 'Cables de Arranque 3m', 'Cables profesionales calibre 8', 28.99, 35),
(9, 'Soporte de Celular Magnético', 'Soporte para rejilla de ventilación', 14.99, 80);

-- OFICINA (categoria_id = 10)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock) VALUES
(10, 'Resma Papel A4 500 Hojas', 'Papel bond blanco 75g/m²', 8.99, 100),
(10, 'Lapiceros Azul x12', 'Lapiceros punto fino trazo suave', 6.99, 150),
(10, 'Archivador Palanca A4', 'Archivador lomo ancho cartón', 4.99, 120),
(10, 'Calculadora Científica', 'Calculadora con funciones avanzadas', 24.99, 40),
(10, 'Post-it Notas Adhesivas x3', 'Pack de 3 blocks de colores', 9.99, 90),
(10, 'Grapadora Metálica', 'Grapadora de escritorio hasta 25 hojas', 12.99, 65),
(10, 'Perforadora 2 Huecos', 'Perforadora con capacidad 20 hojas', 8.99, 75),
(10, 'Marcadores Permanentes x4', 'Marcadores punta fina colores surtidos', 11.99, 85);

-- 4. PROCEDIMIENTOS ALMACENADOS

DELIMITER //
-- Procedimiento: Listar todas las categorías
CREATE PROCEDURE sp_listar_categorias()
BEGIN
    SELECT 
        id, 
        nombre, 
        descripcion, 
        created_at
    FROM categorias
    ORDER BY nombre ASC;
END //
-- Procedimiento: Listar todos los productos
CREATE PROCEDURE sp_listar_productos()
BEGIN
    SELECT 
        p.id,
        p.nombre,
        p.descripcion,
        p.precio,
        p.stock,
        p.categoria_id,
        c.nombre AS categoria_nombre,
        p.created_at
    FROM productos p
    INNER JOIN categorias c ON p.categoria_id = c.id
    ORDER BY p.id ASC;
END //

-- Procedimiento: Buscar usuario por username
CREATE PROCEDURE sp_buscar_usuario(IN p_username VARCHAR(50))
BEGIN
    SELECT 
        id, 
        username, 
        password, 
        nombre,
        created_at
    FROM usuarios
    WHERE username = p_username;
END //

-- Procedimiento: Registrar una venta
CREATE PROCEDURE sp_registrar_venta(
    IN p_producto_id INT,
    IN p_cantidad INT,
    IN p_precio DECIMAL(10,2)
)
BEGIN
    DECLARE v_stock_actual INT;
    DECLARE v_total DECIMAL(10,2);
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error al procesar la venta';
    END;
    
    START TRANSACTION;
    
    -- Obtener stock actual con bloqueo
    SELECT stock INTO v_stock_actual 
    FROM productos 
    WHERE id = p_producto_id 
    FOR UPDATE;
    
    -- Verificar stock suficiente
    IF v_stock_actual IS NULL THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Producto no encontrado';
    ELSEIF v_stock_actual < p_cantidad THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Stock insuficiente para procesar la venta';
    ELSE
        -- Calcular total
        SET v_total = p_cantidad * p_precio;
        
        -- Registrar venta
        INSERT INTO ventas (producto_id, cantidad, precio_unitario, total)
        VALUES (p_producto_id, p_cantidad, p_precio, v_total);
        
        -- Actualizar stock
        UPDATE productos 
        SET stock = stock - p_cantidad 
        WHERE id = p_producto_id;
        
        COMMIT;
    END IF;
END //

-- Procedimiento: Listar ventas con filtro de fechas
CREATE PROCEDURE sp_listar_ventas_filtrado(
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    SELECT 
        v.id,
        v.fecha,
        p.nombre AS producto_nombre,
        c.nombre AS categoria_nombre,
        v.cantidad,
        v.precio_unitario,
        v.total
    FROM ventas v
    INNER JOIN productos p ON v.producto_id = p.id
    INNER JOIN categorias c ON p.categoria_id = c.id
    WHERE 
        (p_fecha_inicio IS NULL AND p_fecha_fin IS NULL)
        OR (DATE(v.fecha) BETWEEN p_fecha_inicio AND p_fecha_fin)
    ORDER BY v.fecha DESC;
END //

-- Procedimiento: Resumen de ventas con filtro de fechas
CREATE PROCEDURE sp_resumen_ventas_filtrado(
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    SELECT 
        COUNT(*) AS total_ventas,
        IFNULL(SUM(cantidad), 0) AS items_vendidos,
        IFNULL(SUM(total), 0.00) AS ingresos_totales
    FROM ventas
    WHERE 
        (p_fecha_inicio IS NULL AND p_fecha_fin IS NULL)
        OR (DATE(fecha) BETWEEN p_fecha_inicio AND p_fecha_fin);
END //

DELIMITER ;

-- 5. VERIFICACIÓN FINAL
SELECT 'Base de datos creada exitosamente' AS Status;
SELECT COUNT(*) AS Total_Categorias FROM categorias;
SELECT COUNT(*) AS Total_Productos FROM productos;
SELECT COUNT(*) AS Total_Usuarios FROM usuarios;

-- Mostrar resumen por categoría
SELECT 
    c.nombre AS Categoria,
    COUNT(p.id) AS Cantidad_Productos,
    SUM(p.stock) AS Stock_Total
FROM categorias c
LEFT JOIN productos p ON c.id = p.categoria_id
GROUP BY c.id, c.nombre
ORDER BY c.id;