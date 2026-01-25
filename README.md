# 📦 Gestión de Inventario - Powered by Olyxis
**Gestión de Inventario powered by Olyxis** es una solución integral de nivel empresarial diseñada para el control preciso de existencias y la administración eficiente de ventas. Este sistema destaca por su robustez técnica y una interfaz moderna pensada en la productividad.

---

## 🚀 Arquitectura y Seguridad

El proyecto está construido sobre el **[Framework Olyxis](https://github.com/Javierborja09/olyxis)**, un motor personalizado desarrollado en **PHP 8.x** bajo el patrón de diseño **MVC (Modelo-Vista-Controller)**.

### Características de Seguridad

- 🛡️ **Middlewares de Seguridad**: Implementación de capas de control que interceptan las peticiones para validar sesiones y cookies, evitando accesos no autorizados a rutas críticas.
- 🔑 **Gestión de Sesiones**: Control persistente y seguro de usuarios autenticados.
- ⚙️ **Lógica en Base de Datos**: Uso extensivo de Procedimientos Almacenados en MySQL para garantizar transacciones atómicas y un alto rendimiento en el procesamiento de datos.

---

## 🛠️ Funcionalidades Principales

### 📦 Control de Inventario y Catálogos

- **Gestión de Productos**: CRUD completo (Crear, Leer, Actualizar, Eliminar) con control de stock.
- **Gestión de Categorías**: Organización lógica y escalable de todos los insumos del sistema.

### 💰 Módulo de Ventas Avanzado

- **Venta Multi-producto**: Capacidad de procesar múltiples artículos en una sola transacción en tiempo real.
- **Validación de Stock**: El sistema verifica la disponibilidad de existencias antes de confirmar cualquier operación.
- **Generación de Vouchers**: Emisión de comprobantes de venta para cada transacción finalizada.

### 📊 Análisis y Reportes

- **Reportes de Ventas**: Módulo de consulta con filtrado por intervalos de tiempo, permitiendo analizar el rendimiento del negocio en fechas específicas.

---

## 🛡️ Seguridad Probada y Certificada
Para garantizar la integridad de los datos, este sistema ha sido sometido a rigurosas pruebas de penetración (Pentesting) mediante scripts avanzados de Python, superando con éxito cada intento de vulneración:

SQL Injection (SQLi): ❌ Fallido. Bloqueado gracias al uso de Procedimientos Almacenados y consultas parametrizadas.

Cross-Site Scripting (XSS): ❌ Fallido. Los ataques fueron interceptados por el sistema de sanitización y el manejo seguro de sesiones.

Path Traversal: ❌ Fallido. La arquitectura de directorios del framework impide el acceso a archivos sensibles como el .env.

Command Injection: ❌ Fallido. El aislamiento de la lógica de negocio mediante el patrón MVC evita la ejecución de comandos en el sistema operativo.

Fuerza Bruta: ❌ Fallido. El sistema de autenticación resistió intentos automatizados de acceso.

Conclusión: Estas pruebas demuestran que es posible construir aplicaciones web altamente seguras y robustas utilizando el Framework Olyxis, superando los estándares comunes de protección.

---

## 📸 Vista Previa (Screenshots)

### Gestión de Categorías
![Gestión de Categorías](public/images/categorias.png)

### Panel de Inventario
![Panel de Inventario](public/images/inventario.png)

### Módulo de Ventas
![Módulo de Ventas](public/images/ventas.png)

### Reportes Estadísticos
![Reportes Estadísticos](public/images/reportes.png)

---

## 📥 Guía de Instalación y Uso

Para que el sistema funcione correctamente, sigue estos pasos:

### 1. Clonar el repositorio
```bash
git clone https://github.com/Javierborja09/Gestion-Inventario-powered-Olyxis.git
cd Gestion-Inventario-powered-Olyxis
```

### 2. Configurar la Base de Datos

Ejecuta el script SQL incluido en la raíz: `GestionInventario.sql`. Este creará las tablas y todos los Procedimientos Almacenados necesarios.

Crea un archivo llamado `.env` en la raíz del proyecto y configura tus credenciales:
```env
# Configuración de la Base de Datos
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=gestion_inventario
DB_USER=root
DB_PASSWORD=2109
```

### 3. Instalar Dependencias

Es obligatorio instalar las dependencias de Composer para el correcto funcionamiento del Autoload y el Framework:
```bash
composer install
```

### 4. Ejecutar el Servidor (Olyxis CLI)

Para visualizar el proyecto en funcionamiento, utiliza el comando de consola propio del framework:

**Opción rápida:**
```bash
php bin/olyxis serve
```

**Puerto personalizado:**
```bash
php bin/olyxis serve localhost 5000
```

---

## 📄 Licencia

Este proyecto está bajo la licencia especificada en el repositorio.

---

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue o pull request para sugerencias y mejoras.

---

## 👨‍💻 Autor

**Javier Jeanpool Borja Samaniego**

- GitHub: [@JavierBorja09](https://github.com/JavierBorja09)
- Email: javierborjasamaniego@gmail.com
- LinkedIn: [Mi Perfil](https://www.linkedin.com/in/javier-jeanpool-borja-samaniego-a6b8b7300/)

---
