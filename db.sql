
CREATE TABLE IF NOT EXISTS solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proveedor VARCHAR(150) NOT NULL,
    contacto VARCHAR(150),
    correo VARCHAR(150),
    telefono VARCHAR(50),
    producto VARCHAR(150) NOT NULL,
    sku VARCHAR(50),
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
    fecha_entrega DATE,
    prioridad VARCHAR(50),
    direccion VARCHAR(255),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
