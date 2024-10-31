<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"> Denuncia</h3>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-2">
                        <button type="button" class="btn btn-success" onclick="NuevoDenuncia()">Nueva Denuncia <i class="fa fa-plus"></i></button>
                    </div>
                    <div class="col-10">
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalDenuncia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Mantenimiento Denuncia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmDenuncia" name="frmDenuncia">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Título</label> <span style="color: red;" >*</span>
                                <input type="text" class="form-control" name="titulo" id="titulo" />
                                <input type="hidden" name="iddenuncia" id="iddenuncia" />
                            </div>
                            <div class="form-group">
                                <label>Descripci&oacute;n</label> <span style="color: red;" >*</span>
                                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Ubicaci&oacute;n</label> <span style="color: red;" >*</span>
                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" />
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ciudadano</label> <span style="color: red;" >*</span>
                                <input type="text" class="form-control" name="ciudadano" id="ciudadano" />
                            </div>
                            <div class="form-group">
                                <label>Tel&eacute;fono Ciudadano</label>
                                <input type="text" class="form-control" name="telefono_ciudadano" id="telefono_ciudadano" />
                            </div>

                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="Pendiente">Pendiente</option>                                    
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Resuelto">Resuelto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="GuardarDenuncia()">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function listarDenuncias() {
        $.ajax({
            method: "POST",
            url: "vista/denuncias_listado.php",
            data: {
                filtro: $("#txtFiltroUsuario").val(),
                estado: $("#cboFiltroEstado").val()
            }
        }).done(function(resultado) {
            $("#divListado").html(resultado);
        })
    }

    listarDenuncias();

    function GuardarDenuncia() {
        if (!ValidarFormulario()) {
            return 0;
        }
        var datos_formulario = $("#frmDenuncia").serializeArray();

        if ($("#iddenuncia").val() != "" && $("#iddenuncia").val() != "0") {
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
            url: "controlador/contDenuncia.php",
            data: datos_formulario
        }).done(function(resultado) {
            if (resultado == 1) {
                toastCorrecto("Registro satisfactorio");
                $("#modalDenuncia").modal('hide');
                $("#frmDenuncia").trigger('reset');
                listarDenuncias();
            } else {
                msjError = resultado == 2 ? "Denuncia existente" : "No se pudo registrar la denuncia."
                toastError(msjError);
            }
        });

    }

    function ValidarFormulario() {
        retorno = true;
        if ($("#titulo").val() == "") {
            toastError('Ingrese el título de la denuncia.');
            retorno = false;
        }
        if ($("#descripcion").val() == "") {
            toastError('Ingrese el descripción de la denuncia.');
            retorno = false;
        }
        if ($("#ubicacion").val() == "") {
            toastError('Ingrese el ubicación de la denuncia.');
            retorno = false;
        }
        if ($("#ciudadano").val() == "") {
            toastError('Ingrese el ciudadano de la denuncia.');
            retorno = false;
        }

       
        return retorno;
    }

    function NuevoDenuncia() {
        $("#frmDenuncia").trigger('reset');
        $("#iddenuncia").val("");
        $("#modalDenuncia").modal('show');
    }
</script>