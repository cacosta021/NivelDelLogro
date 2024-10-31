<?php
$perfiles = ['1' => 'admin', '2' => 'medico', '3' => 'tecnico'];
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"> Usuario</h3>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-2">
                        <button type="button" class="btn btn-success" onclick="NuevoUsuario()">Nuevo <i class="fa fa-plus"></i></button>
                    </div>
                    <div class="col-10">
                    </div>
                </div>
                <br>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalUsuario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Mantenimiento Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmUsuario" name="frmUsuario">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Documento</label>
                                <input type="text" class="form-control" name="dni" id="dni" />
                                <input type="hidden" name="idusuario" id="idusuario" />
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" />
                            </div>

                            <div class="form-group">
                                <label>Correo</label>
                                <input type="text" class="form-control" name="correo" id="correo" />
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" />
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="clave" id="clave" />
                            </div>

                            <div class="form-group">
                                <label>Tipo Usuario</label>
                                <select class="form-control" id="idperfil" name="idperfil">
                                    <option value="0">Seleccione uno</option>
                                    <?php foreach ($perfiles  as $k => $v) { ?>
                                        <option value="<?= $k ?>"><?= $v; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="GuardarUsuario()">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function listarUsuarios() {
        $.ajax({
            method: "POST",
            url: "vista/usuarios_listado.php",
            data: {
                filtro: $("#txtFiltroUsuario").val(),
                estado: $("#cboFiltroEstado").val()
            }
        }).done(function(resultado) {
            $("#divListado").html(resultado);
        })
    }

    listarUsuarios();

    function GuardarUsuario() {
        if (!ValidarFormulario()) {
            return 0;
        }
        var datos_formulario = $("#frmUsuario").serializeArray();

        if ($("#idusuario").val() != "" && $("#idusuario").val() != "0") {
            datos_formulario.push({
                name: "proceso",
                value: "ACTUALIZAR"
            });
        } else {
            datos_formulario.push({
                name: "proceso",
                value: "NUEVO"
            });
        }
        $.ajax({
            method: "POST",
            url: "controlador/contUsuario.php",
            data: datos_formulario
        }).done(function(resultado) {
            if (resultado == 1) {
                toastCorrecto("Registro satisfactorio");
                $("#modalUsuario").modal('hide');
                $("#frmUsuario").trigger('reset');
                listarUsuarios();
            } else {
                msjError = resultado == 2 ? "Usuario duplicado" : "No se pudo registrar el usuario."
                toastError(msjError);
            }
        });

    }

    function ValidarFormulario() {
        retorno = true;
        if ($("#nombre").val() == "") {
            toastError('Ingrese el nombre del usuario.');
            retorno = false;
        }
        if ($("#usuario").val() == "") {
            toastError('Ingrese el usuario.');
            retorno = false;
        }
        return retorno;
    }

    function NuevoUsuario() {
        $("#frmUsuario").trigger('reset');
        $("#idusuario").val("");
        $("#modalUsuario").modal('show');
    }
</script>