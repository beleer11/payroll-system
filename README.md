# 📘 Guía de Instalación del Proyecto Sistema de Nomina

<img width="1875" height="966" alt="image" src="https://github.com/user-attachments/assets/a4fe34d2-344e-419e-b32c-4d36acb9d47d" />

<img width="1881" height="989" alt="image" src="https://github.com/user-attachments/assets/330be0a9-77fc-4ae3-91ea-5db984bc0fe4" />

<img width="1878" height="979" alt="image" src="https://github.com/user-attachments/assets/79bba6d8-600a-4ea8-ae2c-66a0794650c0" />

<img width="1872" height="980" alt="image" src="https://github.com/user-attachments/assets/bd3fc9ce-3cc2-4c33-a276-fa615e1e14d5" />

<img width="1582" height="890" alt="image" src="https://github.com/user-attachments/assets/e8f5c37d-24b8-486d-a0fe-3c6519b56458" />

<img width="1893" height="983" alt="image" src="https://github.com/user-attachments/assets/dbcb21a6-85fd-48d7-a0ae-d03f2c8bfcc4" />

<img width="1716" height="937" alt="image" src="https://github.com/user-attachments/assets/45343833-9224-4df4-a682-b56ef556767b" />

<img width="1691" height="919" alt="image" src="https://github.com/user-attachments/assets/b2e06a5d-fe04-424c-a6f0-e75a3a827bf6" />


Este documento explica paso a paso cómo instalar, configurar y ejecutar
el proyecto en un entorno local utilizando Docker. Sigue cada
instrucción en orden para garantizar una instalación correcta.

## ✅ Requisitos Previos

Asegúrate de tener instalados: - Docker - Docker Compose - Node.js
(versión LTS recomendada) - NPM - Git

## 🚀 1. Clonar el repositorio

    git clone https://github.com/beleer11/payroll-system.git
    cd payroll-system

## 🐳 2. Iniciar los contenedores con Docker

    docker compose up -d

## 🔧 3. Instalar dependencias de Laravel

    composer install

## 🔧 4. Instalar dependencias de Node

    npm install

## 🔑 5. Generar clave de la aplicación

    php artisan key:generate

## 🗄️ 6. Ejecutar migraciones

    php artisan migrate

## 🌱 7. Ejecutar seeders

    php artisan db:seed

## 👤 8. Usuario de prueba

Correo:

    admin@alianza.com

Contraseña:

    password123

## ▶️ 9. Compilar assets del frontend

Modo desarrollo cliente:

    npm run dev

Modo desarrollo servidor:

    php artisan serve

### 10. Configurar .env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5032
DB_DATABASE=payrollsystemdb
DB_USERNAME=root
DB_PASSWORD=123456

## 📌 Notas importantes

-   No necesitas configurar Nginx. Todo está integrado en Docker.
-   Para reiniciar contenedores:
