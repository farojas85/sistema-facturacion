$(document).ready(function () {
  // EDITAR CATEGORIA
  $(document).on("click", ".btnEditarAgencia", function () {
    let idAgencia = $(this).attr("idAgencia");
    let datos = new FormData();
    datos.append("idAgencia", idAgencia);
    $.ajax({
      url: "ajax/agencias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#editarAgencia").val(respuesta["nombre"]);
        $("#idAgencia").val(respuesta["id"]);
      },
    });
  });
  // ELIMINAR CATEGORIA
  $(document).on("click", ".btnEliminarAgencia", function () {
    let idEliminar = $(this).attr("idAgencia");
    let datos = new FormData();
    datos.append("idEliminar", idEliminar);

    Swal.fire({
      title: "¿Estás seguro de eliminar esta agencia?",
      text: "¡Si no lo está puede  cancelar la acción!",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarlo!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "ajax/agencias.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            console.log(respuesta);
            if (respuesta == "success") {
              Swal.fire({
                title: "¡La agencia ha sido eliminada!",
                text: "...",
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cerrar",
              }).then((result) => {
                if (result.isConfirmed) {
                  // window.location = 'categorias';
                  $(".id-cat" + idEliminar).fadeOut(1000, function () {
                    window.location = "agencias";
                  });
                }
              });
            } else {
              Swal.fire({
                title:
                  "¡La agencia no se puede eliminar porque tiene guías turisticos asignados!",
                text: "...",
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cerrar",
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location = "agencias";
                }
              });
            }
          },
        });
      }
    });
  });
  // VALIDAR NO REPETIR USUARIO
  $(document).on("change", "#nuevaAgencia", function () {
    $(".alert").remove();

    let agencia = $(this).val();
    let datos = new FormData();
    datos.append("validarAgencia", agencia);
    $.ajax({
      url: "ajax/agencias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        // //("respuesta", respuesta);
        if (respuesta) {
          $("#nuevaAgencia").val("");
          $("#nuevaAgencia")
            .parent()
            .before(
              '<div class="alert alert-warning" style="display:none;">Esta agencia ya existe!</div>'
            );
          $(".alert").show(500, function () {
            $(this).delay(3000).hide(500);
          });
        }
      },
    });
  });

  $(document).on("click", ".btnAsignarGuia", function () {
    let idAgencia = $(this).attr("idAgencia");
    let datos = new FormData();
    datos.append("idAgencia", idAgencia);
    $.ajax({
      url: "ajax/agencias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#asignarAgencia").val(respuesta["nombre"]);
        $("#idAgenciaAsignar").val(respuesta["id"]);
        loadGuiasTurismosPorAgencia(respuesta["id"]);
      },
    });
  });

  $(document).on("click", "#btnAgregarGuia", function (e) {
    e.preventDefault();

    let datos = $("#frmAsignarGuia").serialize();
    agencia_id = $("#idAgenciaAsignar").val();
    $.ajax({
      url: "ajax/agencias.ajax.php",
      method: "POST",
      data: datos,
      success: function (respuesta) {
        if (respuesta == "success") {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            // width: 600,
            // padding: '3em',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
              loadGuiasTurismosPorAgencia(agencia_id);

              //   $("#modalAgregarAjusteInventario").modal("hide");
              //   $("#idproducto").val("");
              //   $("#cantidadModificar").val("");
            },
          });
          Toast.fire({
            icon: "success",
            title: `<h4>Guía añadido con éxito!!!</h4>`,
            html: ``,
          });
        } else if (respuesta == "found") {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            // width: 600,
            // padding: '3em',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
              //loadGuiasTurismosPorAgencia(agencia_id);

              //   $("#modalAgregarAjusteInventario").modal("hide");
              //   $("#idproducto").val("");
              //   $("#cantidadModificar").val("");
            },
          });
          Toast.fire({
            icon: "warning",
            title: `<h4>El guía ya se encuentra asignado en esta agencia u otra</h4>`,
            html: ``,
          });
        }
      },
    });
  });
  function loadGuiasTurismosPorAgencia(agencia_id) {
    let parametros = {
      idListarAgencia: agencia_id,
    };
    $.ajax({
      url: "ajax/agencias.ajax.php",
      //method: "GET",
      data: parametros,
      // cache: false,
      // contentType: false,
      // processData: false,
      beforeSend: function () {
        //  $("body").append(loadcl);
      },
      success: function (data) {
        //$(".reloadcl").hide();
        let dato = data;

        const tbody = document.querySelector("#tabla-agencia-guia tbody");
        if (tbody) {
          tbody.innerHTML = "";
        }

        if (!dato) {
          const filaVacia = document.createElement("tr");
          filaVacia.innerHTML =
            '<td colspan="4" class="text-center text-danger">-Datos no registrados-</td>';
          tbody.appendChild(filaVacia);
        } else if (dato.length > 0) {
          dato = JSON.parse(dato);
          dato.forEach((guia, index) => {
            const fila = document.createElement("tr");

            fila.id = `id-guia-agencia-${guia.id}`;
            // Columna índice
            const celdaIndice = document.createElement("td");
            celdaIndice.textContent = index + 1;
            fila.appendChild(celdaIndice);

            // Columna nombre guía
            const celdaNombre = document.createElement("td");
            celdaNombre.textContent = guia.guia;
            fila.appendChild(celdaNombre);

            // Columna estado
            const celdaEstado = document.createElement("td");
            celdaEstado.className = "text-center";

            const botonEstado = document.createElement("button");
            botonEstado.innerHTML = guia.estado == 1 ? "Activo" : "Inactivo";
            botonEstado.className =
              guia.estado == 1 ? "activarpro" : "desactivarpro";
            // celdaEstado.className =
            //   guia.estado === 1 ? "activarpro" : "desactivarpro";
            celdaEstado.appendChild(botonEstado);
            fila.appendChild(celdaEstado);

            // Columna acción (botón eliminar)
            const celdaAccion = document.createElement("td");
            const botonEliminar = document.createElement("button");
            botonEliminar.type = "button";
            botonEliminar.innerHTML = "<i class='fas fa-trash-alt'></i>";
            botonEliminar.className =
              "btn btn-xs btn-danger btn-eliminar-guia-agencia";
            botonEliminar.setAttribute("idAgenciaGuiaEliminar", guia.id);
            //botonEliminar.dataset.id = guia.id;
            //botonEliminar.addEventListener("click");
            celdaAccion.appendChild(botonEliminar);
            fila.appendChild(celdaAccion);

            tbody.appendChild(fila);
          });
        }
      },
    });
  }

  $(document).on("click", ".btn-eliminar-guia-agencia", function (e) {
    e.preventDefault();
    let idAgenciaGuiaEliminar = $(this).attr("idagenciaguiaeliminar");
    let datos = new FormData();
    datos.append("idAgenciaGuiaEliminar", idAgenciaGuiaEliminar);

    Swal.fire({
      title: "¿Estás seguro de eliminar el guía de la agencia?",
      text: "¡Si no lo está puede  cancelar la acción!",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarlo!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "ajax/agencias.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta == "success") {
              Swal.fire({
                title: "¡El guía ha sido eliminado de la agencia!",
                text: "...",
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cerrar",
              }).then((result) => {
                if (result.isConfirmed) {
                  // window.location = 'categorias';
                  $("#id-guia-agencia-" + idAgenciaGuiaEliminar).fadeOut(
                    1000,
                    function () {
                      //window.location = "agencias";
                    }
                  );
                }
              });
            } else {
              Swal.fire({
                title:
                  "¡La agencia no se puede eliminar porque tiene guías turisticos asignados!",
                text: "...",
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cerrar",
              }).then((result) => {
                if (result.isConfirmed) {
                  //window.location = "agencias";
                }
              });
            }
          },
        });
      }
    });
  });
});
