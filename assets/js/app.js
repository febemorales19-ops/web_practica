$(document).ready(function () {

    // ---------- Cambiar entre pestañas (sin navegar, solo mostrar/ocultar) ----------
    $('#tab-nueva').on('click', function (e) {
        e.preventDefault();
        $('#vista-nueva').removeClass('d-none');
        $('#vista-historial').addClass('d-none');
        $('#titulo-seccion').text('Nueva Solicitud de Compra');
        $('#tab-nueva').addClass('active');
        $('#tab-historial').removeClass('active');
    });

    $('#tab-historial').on('click', function (e) {
        e.preventDefault();
        $('#vista-historial').removeClass('d-none');
        $('#vista-nueva').addClass('d-none');
        $('#titulo-seccion').text('Historial de Solicitudes');
        $('#tab-historial').addClass('active');
        $('#tab-nueva').removeClass('active');
        cargarSolicitudes(); // recarga la tabla cada vez que se entra a esta pestaña
    });

    // ---------- Calcular el subtotal en vivo mientras el usuario escribe ----------
    function calcularSubtotal() {
        const cantidad = parseFloat($('#cantidad').val()) || 0;
        const precio = parseFloat($('#precio_unitario').val()) || 0;
        const subtotal = cantidad * precio;
        $('#subtotal-estimado').val('$ ' + subtotal.toFixed(2));
    }
    $('#cantidad, #precio_unitario').on('input', calcularSubtotal);

    function mostrarAlerta(selector, mensaje, tipo) {
        $(selector)
            .removeClass('d-none alert-success alert-danger')
            .addClass('alert-' + tipo)
            .text(mensaje);
    }

    // ---------- Enviar el formulario por AJAX ----------
    $('#formSolicitud').on('submit', function (e) {
        e.preventDefault();
        const datos = $(this).serialize();

        $.ajax({
            url: '/api/guardar.php',
            method: 'POST',
            data: datos,
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.ok) {
                    mostrarAlerta('#alerta-form', 'Solicitud registrada correctamente (folio #' + respuesta.id + ').', 'success');
                    $('#formSolicitud')[0].reset();
                    $('#subtotal-estimado').val('$ 0.00');
                } else {
                    mostrarAlerta('#alerta-form', respuesta.error || 'Ocurrió un error al registrar.', 'danger');
                }
            },
            error: function (xhr) {
                const respuesta = xhr.responseJSON;
                mostrarAlerta('#alerta-form', respuesta && respuesta.error ? respuesta.error : 'Error de conexión con el servidor.', 'danger');
            }
        });
    });

    // ---------- Cargar la tabla de historial ----------
    function cargarSolicitudes() {
        $.getJSON('/api/listar.php', function (respuesta) {
            const filas = respuesta.data;
            $('#cuerpo-tabla').empty();

            if (filas.length === 0) {
                $('#sin-datos').removeClass('d-none');
                return;
            }
            $('#sin-datos').addClass('d-none');

            filas.forEach(function (item) {
                const fila = `
                    <tr data-id="${item.id}">
                        <td>${item.id}</td>
                        <td>${item.proveedor}</td>
                        <td>${item.producto}</td>
                        <td>${item.cantidad}</td>
                        <td>$${parseFloat(item.subtotal).toFixed(2)}</td>
                        <td>${item.fecha_entrega ?? '—'}</td>
                        <td>${item.prioridad ?? '—'}</td>
                        <td><button class="btn btn-eliminar btn-sm" data-id="${item.id}">Eliminar</button></td>
                    </tr>`;
                $('#cuerpo-tabla').append(fila);
            });
        });
    }

    // ---------- Eliminar una solicitud ----------
    $('#cuerpo-tabla').on('click', '.btn-eliminar', function () {
        const id = $(this).data('id');
        const fila = $(this).closest('tr');

        if (!confirm('¿Seguro que quieres eliminar la solicitud #' + id + '?')) {
            return;
        }

        $.ajax({
            url: '/api/eliminar.php',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (respuesta) {
                if (respuesta.ok) {
                    fila.fadeOut(200, function () { $(this).remove(); });
                    mostrarAlerta('#alerta-historial', 'Solicitud #' + id + ' eliminada.', 'success');
                } else {
                    mostrarAlerta('#alerta-historial', respuesta.error || 'No se pudo eliminar.', 'danger');
                }
            },
            error: function () {
                mostrarAlerta('#alerta-historial', 'Error de conexión con el servidor.', 'danger');
            }
        });
    });

});
