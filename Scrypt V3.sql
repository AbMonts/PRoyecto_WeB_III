CREATE DATABASE Inmobiliaria ;
-- drop database Inmobiliaria;
USE Inmobiliaria;


CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo ENUM('Cliente', 'Admin', 'Agente') NOT NULL DEFAULT 'Cliente',
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono CHAR(10) NOT NULL,
    username VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE mensajes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono CHAR(10) NOT NULL,
    mensaje TEXT NOT NULL
);


CREATE TABLE propiedades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo ENUM('Casa', 'Departamento', 'Local', 'Terreno') NOT NULL,
    direccion VARCHAR(250) NOT NULL,
    referencias VARCHAR(300) NULL,
    descripcion VARCHAR(500) NOT NULL,
    precio DECIMAL(12, 2) NOT NULL,
    habitaciones INT NULL,
    banos INT NULL,
    dimensiones FLOAT NOT NULL,
    estado ENUM('Venta', 'Renta') NOT NULL,
    garage BOOLEAN NOT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);




CREATE TABLE imagenes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    propiedad_id INT NOT NULL,
    imagen_url VARCHAR(300) NOT NULL,
    FOREIGN KEY (propiedad_id) REFERENCES propiedades(id) ON DELETE CASCADE
);

INSERT INTO usuarios (tipo, nombre, email, telefono, username, password)
VALUES ('Admin', 'Juan Pérez', 'juan@example.com', '5551234567', 'juanperez', '12345678');



INSERT INTO usuarios (tipo, nombre, email, telefono, username, password)
VALUES ('Cliente', 'Damian Zavala', 'admzL@gmail.com', '4444444444', 'zavala01', '12345678');


INSERT INTO usuarios (tipo, nombre, email, telefono, username, password)
VALUES ('Agente', 'Sebastian M', 'ElSebascorp@gmail.com', '5551234567', 'juanperez', '12345678');

INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Casa', 'Av. Reforma 123', 'Cerca del centro comercial', 'Casa con amplio jardín y piscina', 3500000.00, 3, 2, 120.5, 'Venta', TRUE, 2);

INSERT INTO imagenes (propiedad_id, imagen_url)
VALUES (1, 'imgs/casa1.jpg');

INSERT INTO imagenes (propiedad_id, imagen_url)
VALUES (2, 'imgs/casa2.jpg');

ALTER TABLE usuarios
ADD COLUMN created_at TIMESTAMP null DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

select * from usuarios;

CREATE TABLE destacados (
    usuario_id INT NOT NULL,
    propiedad_id INT NOT NULL,
    PRIMARY KEY (usuario_id, propiedad_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (propiedad_id) REFERENCES propiedades(id) ON DELETE CASCADE
);

ALTER TABLE propiedades ADD COLUMN vistas INT DEFAULT 0;

CREATE TABLE historial_vistas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    propiedad_id INT NOT NULL,
    visto_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (propiedad_id) REFERENCES propiedades(id) ON DELETE CASCADE
);

ALTER TABLE propiedades
ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Propiedad 2
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Casa', 'Calle Aldama 45, San Miguel de Allende, Gto.', 'A dos cuadras del jardín principal', 'Casa colonial restaurada con terraza panorámica', 4800000.00, 4, 3, 200.0, 'Venta', TRUE, 3);

-- Propiedad 3
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Departamento', 'Av. Coba 210, Tulum, Q.Roo', 'Cerca de zona hotelera', 'Departamento moderno con alberca y roof garden', 2300000.00, 2, 2, 95.0, 'Venta', TRUE, 3);

-- Propiedad 4
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Casa', 'Calle 60, Centro Histórico, Mérida, Yuc.', 'Junto al Paseo Montejo', 'Residencia histórica con detalles coloniales', 3900000.00, 3, 2, 180.0, 'Venta', FALSE, 3);

-- Propiedad 5
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Terreno', 'Calle 4, Bacalar, Q.Roo', 'Vista a la laguna', 'Terreno plano ideal para desarrollo turístico', 1500000.00, NULL, NULL, 500.0, 'Venta', FALSE, 3);

-- Propiedad 6
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Departamento', 'Malecón 150, Puerto Vallarta, Jal.', 'Vista al mar', 'Penthouse con jacuzzi y terraza privada', 5200000.00, 3, 3, 130.0, 'Venta', TRUE, 3);

-- Propiedad 7
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Casa', 'Camino Real 85, Valle de Bravo, Edo. Mex.', 'Cerca del lago', 'Casa de campo con chimenea y jardín amplio', 4600000.00, 4, 3, 250.0, 'Venta', TRUE, 3);

-- Propiedad 8
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Local', 'Av. Insurgentes Sur 3000, CDMX', 'Dentro de plaza comercial', 'Local con alto flujo peatonal, ideal para tienda', 1850000.00, NULL, 1, 45.0, 'Renta', FALSE, 3);

-- Propiedad 9
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Casa', 'Blvd. Kukulcán, Zona Hotelera, Cancún, Q.Roo', 'Frente a la playa', 'Residencia de lujo con alberca y acceso al mar', 12500000.00, 5, 4, 350.0, 'Venta', TRUE, 3);

-- Propiedad 10
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Terreno', 'Zona Diamante, Acapulco, Gro.', 'Área exclusiva residencial', 'Terreno con vista al mar, ideal para villa', 2700000.00, NULL, NULL, 600.0, 'Venta', TRUE, 3);

-- Propiedad 11
INSERT INTO propiedades (tipo, direccion, referencias, descripcion, precio, habitaciones, banos, dimensiones, estado, garage, usuario_id)
VALUES ('Casa', 'Barrio del Cerrillo, San Cristóbal de las Casas, Chis.', 'Cerca de la iglesia del Cerrillo', 'Casa con diseño rústico y patio interior', 2100000.00, 3, 2, 110.0, 'Venta', FALSE, 3);
