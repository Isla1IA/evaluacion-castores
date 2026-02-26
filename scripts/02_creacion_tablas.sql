-- Evaluacion Castores - Creacion de tablas
-- Ejercicio Practico BD
-- Script para la creacion de tablas necesarias para la evaluacion
-- DBMS: MySQL 8
-- Creado por: Francisco Montenegro
-- Fecha: 25/02/2025

CREATE DATABASE IF NOT EXISTS evaluacion_castores;
USE evaluacion_castores;

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role ENUM('admin', 'almacenista') NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS movimientos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    producto_id BIGINT UNSIGNED NOT NULL,
    tipo ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_movimientos_user
        FOREIGN KEY (user_id) REFERENCES users(id),

    CONSTRAINT fk_movimientos_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
); 