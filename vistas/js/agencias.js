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
});
