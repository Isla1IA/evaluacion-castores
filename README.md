# Evaluación Castores

Evaluación Técnica de Programación.

## **¿Qué se utilizó?**
### IDE Usado 
* **Visual Studio Code**
### Framework de PHP usado: 
* **Laravel Version:** 11.48.0
* **Filament Version:** 5.2
### DBMS
* **MySQL Version:** 8.4.3
## Requisitos Previos 
Antes de Iniciar, asegúrese de tener instalado lo Siguiente:
* PHP 8.2 o Superior
* MySQL 8.0 o Superior
* Composer
* Node.js y NPM
* Git

## Pasos de Instalación
* **1. Clonar Repositorio**
  ```
  git clone https://github.com/Isla1IA/evaluacion-castores.git
  ```
   ```
   cd evaluacion-castores
   ```
* **2. Instalar dependencias de PHP**
  ```
  composer install
  ```
* **3. Instalar dependencias de Node**
  ```
  npm Install
  npm run build
  ```
* **4. Configurar Variables de entorno**
  * Copiar el archivo .env
      ```
      cp .env.example .env
      ```
  * Editar el archivo .env y configurar la Bade de Datos
      * **DB_DATABASE=nombre_de_tu_base**
      * **DB_USERNAME=root**
      * **DB_PASSWORD=tu_password**

**Asegúrese de haber creado previamente la Base de Datos en MySQL**
* **5. Generar clave de aplicación**
  ```
  php artisan key:generate
  ```
* **6. Ejecutar Migraciones y Seeders**
  ```
  php artisan migrate --seed
  ```

  * Esto creará las tablas y cargará datos iniciales (usuarios,productos,etc)
* **7. Levantar el Servidor**
  ```
  php artisan serve
  ```
  * Acceder en
    ```
    http://127.0.0.1:8000/admin/login
    ```
##  Usuarios de Pruebas
Ejemplo:
* Admin
  * email:
    ```
    admin@castores.com
    ```
  * password:
    ```
    password
    ```
* Almacenista:
  * email:
    ```
    almacenista@castores.com
    ```
  * password:
    ```
    password
    ```

## Arquitectura del Proyecto
* Laravel 11
* Filament 5
* MySQL 8
* Arquitectura Basada en Resources (Admin Panel)
* Control de Acceso por Roles (Admin/Almacenista)
* Movimientos Bloqueados para Evitar Manipulación Manual

## Consideraciones Técnicas
* El Inventario no se puede modificar manualmente, solo a través de movimientos de entrada y salida
* Los movimientos funcionan como historial inmutable y no puede editarse ni eliminarse
* Se implementó control de acceso por roles (Administrador y Almacenista)
* Las salidas utilizan transacciones para garantizar la integridad de los datos
* Se empleó bloque de fila (**lockForUpdate**) para evitar escenarios concurrentes/inconsistencias de los datos


