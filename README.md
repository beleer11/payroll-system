# 📘 Guía de Instalación del Proyecto Sistema de Nomina

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

## 📌 Notas importantes

-   No necesitas configurar Nginx. Todo está integrado en Docker.
-   Para reiniciar contenedores:
