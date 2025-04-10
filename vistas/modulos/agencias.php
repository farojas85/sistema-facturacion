<?php

use Controladores\ControladorAgencias;
use Controladores\ControladorGuiasTuristicos;

$item = null;
$valor = null;

$guias_turisticos = ControladorGuiasTuristicos::ctrMostrarGuiasTuristicos($item, $valor);

?>

<div class="content-wrapper panel-medio-principal">
    <div style="padding:5px"></div>
    <section class="container-fluid">
        <section class="content-header dashboard-header">
            <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
                <div class="col-lg-12 col-xs-12" style="border:0px; margin:0px; padding:0px; border-radius:10px;">

                    <div class="col-md-3 hidden-sm hidden-xs">
                        <button class=""><i class="fas fa-file-invoice"></i> Agencia</button>
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
                <h3 class="box-title">Administración de agencias</h3>

                <button class="btn btn-success  pull-right btn-radius" data-toggle="modal"
                    data-target="#modalAgregarAgencia">
                    <i class="fas fa-plus-square"></i>Nueva agencia <i class="fa fa-th"></i>
                </button>


            </div>
            <!-- /.box-header -->
            <div class="box-body table-user">

                <!-- table-bordered table-striped  -->
                <table class="table  dt-responsive tablas tbl-t" width="100%">

                    <thead>
                        <tr>
                            <th style="width:10px;">#</th>
                            <th>Agencia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $agencias = ControladorAgencias::ctrMostrarAgencias($item, $valor);
                        foreach ($agencias as $key => $value):

                        ?>
                        <tr class="id-cat<?php echo $value['id']; ?>">
                            <td class="numeracion"><?php echo ++$key; ?></td>
                            <td class="text-uppercase"><?php echo $value['nombre']; ?></td>
                            <td>
                                <div class="btn-group">

                                    <button class="btn btn-warning btnEditarAgencia"
                                        idAgencia="<?php echo $value['id']; ?>" data-toggle="modal"
                                        data-target="#modalEditarAgencia"><i class="fas fa-user-edit"></i>
                                    </button>

                                    <button class="btn bg-purple btnAsignarGuia" idAgencia="<?php echo $value['id']; ?>"
                                        data-toggle="modal" data-target="#modalAsignarGuia" title="Asignar Guía">
                                        <i class="fas fa-user-tag"></i>
                                    </button>

                                    <?php if ($_SESSION['perfil'] == 'Administrador'): ?>
                                    <button class="btn btn-danger btnEliminarAgencia"
                                        idAgencia="<?php echo $value['id']; ?>"><i
                                            class="fas fa-trash-alt"></i></button>

                                    <?php endif; ?>

                                </div>
                            </td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL AGREGAR CATEGORIAS-->
<!-- Modal -->
<div id="modalAgregarAgencia" class="modal fade modal-forms" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Agregar agencia</h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA EL NOMBRE -->
                        <div id="respuestaAjax"></div>

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                                <input type="text" class="form-control" name="nuevaAgencia" id="nuevaAgencia"
                                    placeholder="Ingresar nombre agencia" required />

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

                    <button type="submit" class="btn btn-primary">Guardar agencia</button>

                </div>

                <?php

                $crearAgencia = new ControladorAgencias();
                $crearAgencia->ctrCrearAgencia();

                ?>

            </form>


        </div>
    </div>
</div>

<!-- MODAL EDITAR CATEGORIA -->
<div id="modalEditarAgencia" class="modal fade modal-forms" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post">

                <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Editar agencia</h4>

                </div>

                <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA EL NOMBRE -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                                <input type="text" class="form-control" id="editarAgencia" name="editarAgencia" value=""
                                    required>
                                <input type="hidden" id="idAgencia" name="idAgencia">

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

                    <button type="submit" class="btn btn-primary">Modificar agencia</button>

                </div>

                <?php

                $editarAgencia = new ControladorAgencias();
                $editarAgencia->ctrEditarAgencia();

                ?>

            </form>

        </div>

    </div>

</div>


<!-- MODAL EDITAR CATEGORIA -->
<div id="modalAsignarGuia" class="modal fade modal-forms" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" id="frmAsignarGuia">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Asignar Guía</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                <input type="text" class="form-control" id="asignarAgencia"
                                                    name="asignarAgencia" value="" required>
                                                <input type="hidden" id="idAgenciaAsignar" name="idAgenciaAsignar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select class="form-control" id="guiaAgencia" name="guiaAgencia">
                                                <option value="">-Seleccionar Guía-</option>
                                                <?php
                                                foreach ($guias_turisticos as $clave => $valor) {
                                                    echo '<option value="' . $valor['id'] . '">' . $valor['nombre'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn btn-primary btn-agm" id="btnAgregarGuia">
                                            Añadir <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-sm table-bordered" id="tabla-agencia-guia">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Guía</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="far fa-times-circle fa-lg"></i> Salir</button>
                    <!-- <button type="submit" class="btn btn-primary">Modificar agencia</button> -->

                </div>

                <?php

                $editarAgencia = new ControladorAgencias();
                $editarAgencia->ctrEditarAgencia();

                ?>

            </form>

        </div>

    </div>

</div>

<?php


?>