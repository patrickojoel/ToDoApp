# 📝 Proyecto ToDo App - Gestión de Tareas con Login Seguro

Este es un sistema de gestión de tareas desarrollado en **PHP, JavaScript (jQuery)** y con estilos en **CSS puro**, orientado a demostrar la implementación completa de un flujo **login + CRUD de tareas**, adecuado para prácticas educativas y proyectos de formación profesional.

## 📌 Descripción General

ToDo App es una aplicación web sencilla pero completa que permite:
- Registrar tareas con título y descripción.
- Visualizar y editar tareas individualmente.
- Eliminar tareas específicas o todas a la vez.
- Gestionar usuarios desde un archivo `usuarios.json`.
- Cerrar sesión de forma segura.

Cuenta con autenticación PHP vía sesiones, persistencia de datos en JSON y una interfaz moderna con soporte de drag & drop.

---

## 🚀 Tecnologías Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript (jQuery + jQuery UI)
- **Backend:** PHP puro
- **Almacenamiento:** Archivos JSON (sin base de datos)
- **Gestión de usuarios:** `usuarios.json`
- **Gestión de tareas:** `tareas.json`

---

## 📂 Estructura del Proyecto

```
todo-app/
├── backend/
│   ├── api.php
│   ├── login.php
│   ├── logout.php
│   ├── usuarios.json
│   ├── tareas.json
│   └── logs/debug.log
├── frontend/
│   ├── index.html
│   ├── tareas.php
│   ├── css/style.css
│   ├── js/login.js
│   ├── js/tareas.js
│   └── img/
│       └── fondo.jpg, login.jpg, usuario.jpg
```

---

## 🔐 Inicio de Sesión (Login)

1. Accede desde `frontend/index.html`.
2. Ingresa un usuario registrado en `backend/usuarios.json`.
3. Si las credenciales coinciden, se inicia sesión y se redirige a `tareas.php`.

Ejemplo de usuario en `usuarios.json`:

```json
[
  {
    "usuario": "blinklearning",
    "password": "blinklearning",
    "nombre": "Blink Learning"
  }
]
```

---

## 🧑‍💼 Gestión de Usuarios

- Para **crear nuevos usuarios**: añade objetos al array de `usuarios.json`.
- Ejemplo:

```json
{
  "usuario": "nuevo.usuario@example.com",
  "password": "123456",
  "nombre": "Nombre del Usuario"
}
```

- El campo `"nombre"` se mostrará en el panel superior derecho.

---

## ✅ Crear una Tarea

1. Escribe un título y una descripción.
2. Presiona el botón [+] para agregarla.
3. La tarea aparece listada a la izquierda.

## ✏️ Editar una Tarea

1. Haz clic sobre una tarea.
2. Se abrirá el panel de detalle.
3. Presiona el botón ✏️ para habilitar la edición.
4. Modifica el título o descripción y guarda.

## 🗑️ Eliminar una Tarea

- Selecciona una tarea y presiona el botón rojo con el ícono 🗑️.

## 🧹 Borrar Todas las Tareas

- Presiona el botón **"Borrar todas"** en el pie del panel izquierdo.

---

## 🔒 Cierre de Sesión

1. Pulsa el ícono 🔓 en la esquina superior derecha.
2. Se cerrará la sesión y volverás a `index.html`.

---

## ⚙️ Personalización

- Estilos en `style.css`, fuente **Source Sans Pro** y colores corporativos definidos.
- Imagen de fondo y avatar ubicados en `frontend/img/`.

Puedes sustituir los estilos, íconos y colores para adaptar a tu marca o empresa.

---

## 🧪 Registro y Depuración

- Los eventos importantes se registran en `backend/logs/debug.log`
- Las sesiones, accesos y errores del login quedan allí registrados.

---

## 📈 Mejoras Futuras

- Reemplazar archivos JSON por base de datos MySQL.
- Añadir protección CSRF.
- Incorporar recuperación de contraseña.
- Soporte multiusuario por roles.
- Exportar tareas a PDF o Excel.

---

## 👨‍💻 Autor

> Proyecto desarrollado por **Patrick Joel Sarmiento** para **Blinklearning**.  
> Entregado el **viernes 6 de mayo de 2025**.

---

## 📦 Requisitos

- PHP 7.4+
- Servidor local como XAMPP, Laragon, etc.
- Navegador moderno con soporte ES6

---

## 🚀 Cómo Ejecutar el Proyecto

1. Clona o descarga este repositorio.
2. Coloca la carpeta `todo-app/` en la carpeta raíz de tu servidor local.
3. Abre `http://localhost/todo-app/frontend/index.html` en tu navegador.
4. Usa usuario y contraseña válidos desde `usuarios.json`.

---

¡Listo! Estás ejecutando tu propia aplicación de tareas con autenticación PHP.