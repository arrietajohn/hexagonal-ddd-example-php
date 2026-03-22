# CRUD Usuarios: Arquitectura Hexagonal con DDD y CQRS

Aplicación web PHP para la gestión de usuarios: registro, listado, visualización, edición, eliminación, autenticación con sesión y recuperación de contraseña por correo.

## Tecnologías

- PHP 8.3
- MySQL
- Apache mod_rewrite

---

## Funcionalidades

- Crear, listar, ver, editar y eliminar usuarios
- Autenticación con sesión (login / logout)
- Recuperación de contraseña mediante contraseña temporal enviada por correo
- Protección de rutas según estado de autenticación
- Protección contra acceso directo a archivos y listado de directorios

---

## Conceptos aplicados

### Arquitectura general
- Arquitectura Hexagonal (Ports & Adapters)
- DDD (Domain-Driven Design)
- CQRS
- Capas: Domain / Application / Infrastructure / Entrypoints
- Front Controller · Single Entry Point


### Configuración externalizada (12-Factor App: Factor III)
- Variables de entorno separadas del código fuente
- Credenciales en `.env` (ignorado por git), nunca en se debe publicar en el repo
- `.env.example` como plantilla y documentación de ejemplo para el equipo
- `EnvLoader` con responsabilidad única: leer el entorno
- Las variables reales del servidor tienen prioridad sobre `.env` (environment-over-code)

### Seguridad

- Credenciales fuera del código fuente y del historial de git

