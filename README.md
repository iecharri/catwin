# CatWin Net

Sistema de contabilidad y gestión empresarial online, de código abierto, desarrollado con PHP, JavaScript y MySQL.

CatWin Net es la versión online de **CatWin 1.7**, aplicación de contabilidad desarrollada originalmente para Lotus Approach. Está diseñado para funcionar en entornos **Internet/Intranet**.

El proyecto parte de cero como aplicación web y pretende evolucionar desde la gestión contable hacia un sistema global de información, conocimiento y comunicación en la empresa.

---

## Estado del proyecto

CatWin Net es un proyecto de código antiguo, desarrollado originalmente con las tecnologías disponibles en su época. El código se mantiene en este repositorio para conservar, documentar y facilitar la continuidad del proyecto.

No se ha realizado una modernización general del código, por lo que algunas partes pueden utilizar tecnologías, estructuras o prácticas que actualmente se consideran obsoletas.

---

## Funcionalidades

La versión actual incluye:

- Alta, baja y modificación de subcuentas.
- Alta, modificación y gestión de asientos.
- Asientos automáticos de facturas recibidas y emitidas.
- Abonos automáticos al introducir importes negativos.
- Asientos simples.
- Libro Diario.
- Mayor / Extracto de Cuentas.
- Balances de Comprobación.
- Tres niveles de agregación:
  - Subcuenta.
  - Cuenta.
  - Subgrupo.
- Gestión multiempresa.
- Creación automática de las bases de datos MySQL al crear empresas.

El proyecto se encuentra en desarrollo.

---

## Tecnologías

- **PHP** — servidor.
- **JavaScript** — cliente.
- **MySQL** — base de datos.
- **Apache** — servidor web.

---

## Instalación

Copiar todos los ficheros en un subdirectorio `catwin` del directorio base de Apache.

En `config.php` configurar:

- `server`
- `user`
- `password`

con los valores correspondientes al servidor MySQL.

También es necesario configurar `mysqldump` con la ruta adecuada del servidor para permitir la realización de copias de seguridad.

Cuando se crean empresas, CatWin genera automáticamente las bases de datos MySQL.

Si el servidor no permite crear bases de datos desde CatWin, estas deberán crearse mediante otro procedimiento, por ejemplo phpMyAdmin o el panel de control del servidor.

Para la generación de listados es necesario configurar el alias correspondiente en Apache y la variable `PATH` en `config.php`.

Para obtener información detallada sobre la instalación y configuración, consultar `install.txt`.

---

## Historia

CatWin Net es la contrapartida online de **CatWin 1.7**, desarrollada para funcionar en Internet/Intranet.

El proyecto fue iniciado en el año 2000 por:

**Antonio Grandío Botella**

**Inmaculada Echarri San Adrián**

La versión inicial fue desarrollada como una aplicación web desde cero, utilizando PHP, JavaScript y MySQL.

---

## Licencia

CatWin Net se distribuye bajo los términos de la
**GNU General Public License v3.0 (GPL-3.0)**.

Copyright © 2000-2026 Inmaculada Echarri San Adrián  
Copyright © 2000-2026 Antonio Grandío Botella