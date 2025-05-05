**🔧 PROMPT DETALLADO Y OPTIMIZADO:**

Actúa como un arquitecto y desarrollador de software sénior especializado en tecnologías web modernas y seguridad, con experiencia en arquitectura limpia, desarrollo seguro y enfoque en usabilidad y SEO. Necesito que me ayudes a diseñar e implementar un programa completo que incluya la funcionalidad de login con múltiples métodos de autenticación. Detalla paso a paso la solución, cubriendo todos los aspectos relevantes. Los requerimientos específicos son los siguientes:

---

### 🧩 **Funcionalidad principal:**

* Sistema de **login seguro** que permita autenticación con:

  * Cuentas personales (registro/login con email y contraseña).
  * Login con **Google** (OAuth 2.0).
  * Login con **Microsoft** (OAuth 2.0).

---

### 💡 **Tecnologías requeridas:**

* Backend en **PHP** usando buenas prácticas (preferentemente estructura tipo MVC).
* **MySQL** como base de datos relacional, con conexión **MySQLi**.
* **HTML5**, **CSS3** y **JavaScript** para la interfaz.
* **jQuery** para facilitar la manipulación DOM y peticiones AJAX.
* Uso de **AJAX** para envío de datos sin recargar la página.
* Alertas y notificaciones con **SweetAlert**.
* Envío de correos electrónicos con la librería **PHPMailer** (por ejemplo, para confirmación de cuenta o recuperación de contraseña).

---

### 🔐 **Requisitos de seguridad y calidad:**

* Validación **del lado del cliente y del servidor**.
* **Sanitización y escape** de todos los inputs.
* Prevención de **inyecciones SQL** (consultas preparadas).
* Manejo adecuado de **sesiones** y cookies seguras.
* Protección contra ataques de **CSRF y XSS**.
* Almacenamiento de contraseñas usando **hash seguro** (por ejemplo, `password_hash()`).
* Estructura clara que facilite el mantenimiento y escalabilidad del código.
* Aplicación de principios SOLID y patrón MVC si es posible.

---

### 🧱 **Arquitectura del sistema:**

* Describe una arquitectura limpia y modular, incluyendo la estructura de carpetas recomendada.
* Define claramente los roles de cada capa (modelo, controlador, vista, servicios, helpers).
* Implementación RESTful para endpoints del backend si es aplicable.

---

### 📧 **Extras funcionales:**

* Confirmación de correo electrónico en el registro.
* Recuperación de contraseña por correo.
* Notificación al usuario tras login exitoso o fallo.

---

### 🔍 **SEO y accesibilidad:**

* Optimización **SEO friendly** de todas las páginas involucradas:

  * Etiquetas `<title>`, `<meta>` adecuadas.
  * URLs limpias y semánticas.
  * Carga rápida y uso mínimo de librerías externas pesadas.
  * Uso de etiquetas accesibles (`label`, `aria-*`) para compatibilidad con lectores de pantalla.

---

### 📦 **Salidas esperadas:**

* Código de ejemplo funcional y comentado.
* Explicación detallada del flujo de autenticación para cada método.
* Estructura de base de datos recomendada (con diseño de tablas).
* Validaciones en JavaScript y PHP.
* Diagrama de flujo si es posible.

---

🧠 **Recuerda:** Sé extremadamente detallado, no omitas pasos ni detalles críticos. Piensa como si estuvieras entregando esto a un equipo de desarrolladores junior que deben entender y mantener esta solución. Usa ejemplos claros y justifica las decisiones arquitectónicas. Puedes dividir la explicación en secciones temáticas.

---

