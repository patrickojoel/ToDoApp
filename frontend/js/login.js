$(document).ready(function () {
  $('#login-form').on('submit', function (e) {
    e.preventDefault();


    console.log("HOLA AQUI SIRVE");
    console.log("Entrando en el login.js");

    const usuario = $('#usuario').val();
    const password = $('#password').val();

/*     const usuario2 = $('#login-user').val();
    const password2 = $('#login-pass').val(); */

    console.log("🔐 Enviando datos:", { usuario, password });

    $.ajax({
      url: '../backend/login.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({ usuario, password }),

      success: function (response) {
        console.log("✅ Respuesta del servidor:", response);

        if (response.success) {
          console.log("🟢 Login correcto. Redirigiendo...");
          window.location.href = 'tareas.php';
        } else {
          console.warn("🔴 Error de login:", response.error || "Credenciales no válidas");
          $('#login-error').text(response.error || "Usuario o contraseña incorrectos");
        }

        if (response.debug) {
          console.log("📘 DEBUG:", response.debug);
        }
      },

      error: function (xhr, status, error) {
        console.error("🚫 Error AJAX:", status, error);
        $('#login-error').text('Error al conectar con el servidor.');
      }
    });
  });
});


// Al cargar el formulario de login
/* $('#loginForm').on('submit', function (e) {
  e.preventDefault(); // Evita que se recargue la página

  // Toma los datos del formulario
  const usuario = $('#usuario').val();
  const password = $('#password').val();

  // Envía datos al backend
  $.ajax({
    url: '../backend/login.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ usuario, password }),
    success: function (response) {
      if (response.success) {
        window.location.href = 'tareas.html'; // Redirige si login exitoso
      } else {
        $('#loginError').text('Usuario o contraseña incorrectos.');
      }
    }
  });
});
 */