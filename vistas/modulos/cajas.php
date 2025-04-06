<?php

use Controladores\ControladorCaja;
use Controladores\ControladorUsuarios;
?>

<div class="content-wrapper panel-medio-principal">
    <div style="padding:5px"></div>
    <section class="container-fluid">
        <section class="content-header dashboard-header">
            <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
                <div class="col-lg-12 col-xs-12" style="border:0px; margin:0px; padding:0px; border-radius:10px;">

                    <div class="col-md-3 hidden-sm hidden-xs">
                        <button class=""> <i class="fas fa-cash-register"></i> Cajas</button>
                    </div>
                    <div class="col-md-9  col-sm-12 btns-dash">
                        <a href="crear-factura" class="btn pull-right" style="margin-left:10px"><i
                                class="fas fa-file-invoice"></i> Emitir factura</a>
                        <a href="crear-boleta" class="btn pull-right"><i class="fas fa-file-invoice"> </i> Emitir
                            boleta</a>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!-- <section class="content"> -->
    <section class="container-fluid panel-medio">
        <!-- BOX INI -->
        <div class="box rounded">

            <div class="box-header ">
                <h3 class="box-title">Administración de cajas</h3>

                <button class="btn btn-success  pull-right btn-radius" data-toggle="modal"
                    data-target="#modalAgregarCaja"><i class="fas fa-plus-square"></i>Nueva caja <i
                        class="fa fa-th"></i>
                </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-cajas">
            </div>
        </div>
        <!-- BOX FIN -->
        <!-- /.box-footer -->
    </section>
</div>

<!-- MODAL AGREGAR CATEGORIAS-->
<!-- Modal -->
<div id="modalAgregarCaja" class="modal fade modal-forms" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <form role="form" id="formCaja"">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class=" modal-header" style="background:#3c8dbc; color:white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="fas fa-cash-register fa-lg"></i> Agregar caja</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

            <div class="box-body">

                <!-- ENTRADA PARA EL NOMBRE -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">


                            <input type="text" class="form-control" name="nuevonombre" id="nuevonombre"
                                placeholder="Ingresar nombre" required>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">


                            <input type="number" class="form-control" name="nuevonumero" id="nuevonumero"
                                placeholder="Ingresar número" required>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i
                    class="far fa-times-circle fa-lg"></i> Salir</button>

            <button class="btn btn-primary btn-agm" id="guardarCaja">Guardar <i
                    class="fas fa-cash-register"></i></button>

        </div>

        </form>


    </div>
</div>
</div>

<!-- MODAL EDITAR CATEGORIA -->
<div id="modalEditarCaja" class="modal fade modal-forms" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" id="formEditarCaja">
                <input type="hidden" name="idCajae" id="idCajae">
                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title"><i class="fas fa-cash-register fa-lg"></i> Editar caja</h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA EL NOMBRE -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">


                                    <input type="text" class="form-control" name="editarnombre" id="editarnombre"
                                        placeholder="Ingresar nombre" required>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">


                                    <input type="number" class="form-control" name="editarnumero" id="editarnumero"
                                        placeholder="Ingresar número" required>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control" name="cajaactiva" id="cajaactiva">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--=====================================
        PIE DEL MODAL
        ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i
                            class="far fa-times-circle fa-lg"></i> Salir</button>

                    <button class="btn btn-primary btn-agm" id="editarCaja">Modificar <i
                            class="fas fa-cash-register"></i></button>

                </div>



            </form>

        </div>

    </div>

</div>


<div id="modalAsignarUsuario" class="modal fade modal-forms" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form role="form" id="formAsignarUsuario">
                <input type="hidden" name="idCajaa" id="idCajaa">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">
                        <i class="fas fa-user-plus fa-lg"></i> Asignar Usuario
                    </h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php
                                            $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
                                            ?>
                                            <select class="form-control" id="usuarioCaja" name="usuarioCaja">

                                                <option value="">-Seleccionar Usuario-</option>
                                                <?php
                                                foreach ($usuarios as $clave => $valor) {
                                                    if ($valor['perfil'] != 'Administrador') {
                                                        echo '<option value="' . $valor['id'] . '">' . $valor['usuario'] . " (" . $valor['nombre'] . ")" . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-agm" id="btnAisgnarUsuario||| ">
                                            Añadir <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Usuario</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-caja-usuario">
                                                <tr>
                                                    <td colspan="3" class="text-center text-danger">-Datos no
                                                        registrados-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL NOMBRE -->
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">


                                    <input type="number" class="form-control" name="editarnumero" id="editarnumero"
                                        placeholder="Ingresar número" required>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <select class="form-control" name="cajaactiva" id="cajaactiva">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>

                                </div>
                            </div>
                        </div> -->
                    </div>

                </div>

                <!--=====================================
        PIE DEL MODAL
        ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i
                            class="far fa-times-circle fa-lg"></i> Salir</button>
                </div>



            </form>

        </div>

    </div>

</div>
<?php


?>