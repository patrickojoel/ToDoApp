let tareaActivaId = null; // ID de la tarea seleccionada actualmente

// 🔄 Función que carga las tareas desde el backend y las inserta en el DOM
function cargarTareas() {
  console.log("🔁 Cargando tareas...");
  $.get('../backend/api.php?tareas', function (tareas) {
    $('#listaTareas').empty(); // Limpia el contenido anterior
    console.log("📦 Tareas recibidas:", tareas);

    tareas.forEach(tarea => {
      $('#listaTareas').append(`
        <li class="tarea" data-id="${tarea.id}" data-descripcion="${tarea.descripcion}">
          <span><strong>${tarea.id}.</strong> ${tarea.titulo}</span>
          <button class="btn-delete"><i class="fas fa-trash"></i></button>
        </li>
      `);
    });
  });
}

// 🆕 Crear nueva tarea al enviar el formulario
$('#formNuevaTarea').on('submit', function (e) {
  e.preventDefault();
  const titulo = $('#titulo').val();
  const descripcion = $('#descripcion').val();
  console.log("📨 Nueva tarea:", { titulo, descripcion });

  $.ajax({
    url: '../backend/api.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ titulo, descripcion }),
    success: () => {
      console.log("✅ Tarea agregada correctamente");
      cargarTareas();
      $('#titulo').val('');
      $('#descripcion').val('');
    }
  });
});

// 🗑️ Eliminar tarea al hacer clic en el botón
$('#listaTareas').on('click', '.btn-delete', function (e) {
  e.stopPropagation(); // Evita que se active el clic del <li>
  const id = $(this).closest('li').data('id');
  console.log("🗑️ Eliminando tarea ID:", id);

  $.ajax({
    url: `../backend/api.php?id=${id}`,
    method: 'DELETE',
    success: () => {
      console.log("✅ Tarea eliminada correctamente");
      cargarTareas();
      $('#detalle-box').addClass('oculto');
      tareaActivaId = null;
    }
  });
});

// 🧹 Borrar todas las tareas al hacer clic en el botón
$('#btn-clear').on('click', function () {
  if (confirm("¿Estás seguro de que deseas eliminar todas las tareas?")) {
    console.log("🧹 Borrando todas las tareas...");

    $.ajax({
      url: '../backend/api.php?todas=true',
      method: 'DELETE',
      success: () => {
        console.log("✅ Todas las tareas eliminadas correctamente");
        cargarTareas();
        $('#detalle-box').addClass('oculto');
        tareaActivaId = null;
      },
      error: (xhr, status, error) => {
        console.error("❌ Error al borrar todas las tareas:", error);
      }
    });
  } else {
    console.log("🛑 Cancelado por el usuario");
  }
});


// 👁️ Mostrar el panel lateral con el detalle de la tarea
$('#listaTareas').on('click', '.tarea', function () {
  const $tarea = $(this);
  const id = $tarea.data('id');
  const descripcion = $tarea.data('descripcion');
  const textoCompleto = $tarea.find('span').text();
  const titulo = textoCompleto.replace(/^\d+\.\s*/, ''); // Elimina ID

  console.log("🖱️ Clic en tarea ID:", id, "Título:", titulo);

  if (tareaActivaId === id) {
    console.log("↩️ Ocultando detalle porque se hizo clic en la misma tarea");
    $('#detalle-box').addClass('oculto');
    $('#detalle-descripcion').text('');
    $('#detalle-box').removeClass('modo-edicion');
    $('.tarea').removeClass('activa');
    tareaActivaId = null;
    return;
  }

  tareaActivaId = id;
  $('.tarea').removeClass('activa');
  $tarea.addClass('activa');

  $('#detalle-box').removeClass('oculto').removeClass('modo-edicion');
  $('#btn-editar').removeClass('oculto');
  $('#detalle-descripcion').html(`<strong>${titulo}</strong><br/>${descripcion}`);
});

// ✏️ Hacer clic en "Editar" para transformar el panel en modo edición
$('#btn-editar').on('click', function () {
  if (!tareaActivaId) return;

  const $tarea = $(`.tarea[data-id="${tareaActivaId}"]`);
  const textoCompleto = $tarea.find('span').text().trim();
  const titulo = textoCompleto.replace(/^\d+\.\s*/, '');
  const descripcion = $tarea.data('descripcion');

  console.log("✏️ Editando tarea ID:", tareaActivaId);

  $('#detalle-box').addClass('modo-edicion');
  $('#btn-editar').addClass('oculto');

  $('#detalle-descripcion').html(`
    <input type="text" id="editar-titulo" class="input-edit" value="${titulo}">
    <input type="text" id="editar-descripcion" class="input-edit" value="${descripcion}">
    <button id="guardar-cambios" class="btn-save"><i class="fas fa-check"></i></button>
  `);
});

// 💾 Guardar los cambios al hacer clic en "✔"
$('#detalle-descripcion').on('click', '#guardar-cambios', function () {
  const nuevoTitulo = $('#editar-titulo').val();
  const nuevaDescripcion = $('#editar-descripcion').val();

  console.log("💾 Guardando tarea:", {
    id: tareaActivaId,
    titulo: nuevoTitulo,
    descripcion: nuevaDescripcion
  });

  $.ajax({
    url: `../backend/api.php?id=${tareaActivaId}`,
    method: 'PATCH',
    contentType: 'application/json',
    data: JSON.stringify({ titulo: nuevoTitulo, descripcion: nuevaDescripcion }),
    success: () => {
      console.log("✅ Cambios guardados correctamente");
      cargarTareas();
      $('#detalle-box').removeClass('modo-edicion');
      $('#btn-editar').removeClass('oculto');
      $('#detalle-descripcion').html(`<strong>${nuevoTitulo}</strong><br/>${nuevaDescripcion}`);
    }
  });
});

// 🟢 Inicializar aplicación cuando el documento esté listo
$(function () {
  console.log("📦 Iniciando app...");

  // ✅ Corrige el error de sobreescritura del nombre de usuario
  const nombreUsuario = localStorage.getItem('usuario');
  if (nombreUsuario) {
    console.log("👤 Insertando nombre desde localStorage:", nombreUsuario);
    $('#usuario-nombre').text(nombreUsuario);
  } else {
    console.log("⚠️ No se encontró nombre de usuario en localStorage");
    // 👇 Esta línea causaba el conflicto, por eso está comentada:
    // $('#usuario-nombre').text("Usuario");
  }

  // 🚪 Cierre de sesión
  $('#btn-logout').on('click', function () {
    console.log("🚪 Logout clickeado");
    localStorage.removeItem('usuario');
    window.location.href = 'index.html'; // Redirigir a index
  });

  // 🧲 Inicializa la funcionalidad de drag-and-drop si está disponible
  if ($.fn.sortable) {
    $('#listaTareas').sortable();
  }

  cargarTareas(); // 🔄 Mostrar tareas al cargar la página
});
