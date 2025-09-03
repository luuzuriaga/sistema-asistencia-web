# Sistema de Asistencia Web

Este proyecto implementa un **sistema web** para mejorar el **control de asistencia del personal docente y administrativo** en instituciones educativas, reemplazando el registro manual por un sistema automatizado, rápido y seguro.

## 📌 Descripción

El sistema permite que los trabajadores registren su **entrada y salida** mediante un **usuario y contraseña**, almacenando la información en una base de datos y generando **reportes automáticos** para el área de personal.  
Está diseñado para reducir:

- El tiempo de registro de asistencia.
- Los errores y manipulaciones en los datos.
- El tiempo necesario para generar reportes.

## 🛠 Tecnologías utilizadas

- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript  
- **Backend:** PHP  
- **Base de datos:** MySQL  
- **Servidor:** Apache (Laragon para desarrollo)  
- **Herramientas adicionales:** Visual Studio Code, MySQL Workbench  

## ✅ Funcionalidades principales

- Registro de usuarios y empleados.
- Marcado de asistencia (entrada y salida).
- Gestión de cargos del personal.
- Generación de reportes de asistencia.
- Eliminación y actualización de registros.

## 📂 Estructura del proyecto

```bash
/sistema-asistencia-web
├── backup.php                     # Script para realizar copias de seguridad
├── config.php                     # Configuración principal de la aplicación
├── controlador/                   # Lógica de controladores
│   ├── controlador_cargos.php
│   ├── controlador_login.php
│   ├── controlador_logout.php
│   ├── controlador_registrar_asistencia.php
│   ├── controlador_registrar_empleado.php
│   └── controlador_reportes.php
├── index.php                      # Página principal del sistema
├── logs/
│   └── error.log                  # Registro de errores
├── modelo/                        # Modelos de datos (interacción con la BD)
│   ├── asistencia.php
│   ├── cargo.php
│   ├── conexion.php
│   ├── empleado.php
│   └── usuario.php
├── README.md                      # Documentación del proyecto
├── reportes/
│   └── generar_reporte.php        # Generación de reportes
└── vista/                         # Vistas (interfaz de usuario)
    ├── dashboard/
    │   ├── cargos.php
    │   ├── empleados.php
    │   ├── footer.php
    │   ├── header.php
    │   ├── index.php
    │   ├── perfil.php
    │   ├── reportes.php
    │   ├── sidebar.php
    │   └── usuarios.php
    ├── login/
    │   └── login.php              # Vista de inicio de sesión
    └── public/                    # Archivos públicos
        ├── css/
        │   └── estilos.css
        ├── images/
        │   ├── demoweb.png
        │   ├── logo1.png
        │   └── logo2.png
        └── js/
            └── script.js


## 🚀 Instalación y ejecución

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tuusuario/sistema-asistencia-web.git

Configura tu entorno con Laragon o XAMPP.
Importa la base de datos desde la carpeta /db.
Inicia el servidor Apache y MySQL.
Accede desde tu navegador:
http://localhost/sistema-asistencia-web

📜 Licencia
Este proyecto está bajo la licencia Creative Commons Atribución 4.0 Internacional.