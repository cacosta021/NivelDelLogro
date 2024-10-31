<?php
include_once("../modelo/Denuncia.php");
$objUsu = new Denuncia();
$listado = $objUsu->listar("%%");
?>
<table id="tablaDenuncia" class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>T&iacute;tulo</th>
            <th>Ubicaci&oacute;n</th>
            <th>Ciudadano</th>
            <th>Tel&eacute;fono</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listado as $k => $v) {
            $bgclass = $v['estado'] == 'Resuelto' ? "green" : ($v['estado'] == 'En Proceso' ? "orange" : "red");
            $icono = $v['estado'] == 'Pendiente' ? "fa fa-lock" : "fa fa-lock-open";
            $texto = $v['estado'] == 'Pendiente' ? "Anular" : "Activar";

        ?>
            <tr class="" style="color:<?= $bgclass;?>">
                <td  > <?= $v['iddenuncia'] ?></td>
                <td><?= $v['titulo'] ?></td>
                <td><?= $v['ubicacion'] ?></td>
                <td><?= $v['ciudadano'] ?></td>
                <td><?= $v['telefono_ciudadano'] ?></td>
                <td><?= $v['estado']; ?></td>
                <td><button onclick="EditarDenuncia(<?= $v['iddenuncia'] ?>)" class="btn bg-info btn-sm" title="Editar"><span class="fa fa-pencil-alt"></span> </button>

                    <?php if ($v['estado'] == 'Pendiente') { ?>
                       <!--  <button onclick="CambiarEstadoDenuncia('<?= $v['iddenuncia'] ?>','<?= $v['estado'] ?>','<?= $v['titulo'] ?>')" class="btn <?= $bgclass ?> btn-sm" title="<?= $texto ?>"><span class="<?= $icono ?>"></span> </button> -->
                        <button onclick="CambiarEstadoDenuncia(<?= $v['iddenuncia'] ?>,0,'<?= $v['titulo'] ?>')" class="btn bg-danger btn-sm" title="Eliminar"><span class="fa fa-trash"></span> </button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $('#tablaDenuncia').DataTable({
        "pageLength": 3, // Cambia a la cantidad de filas que desees
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "order": [
            [1, 'asc']
        ],
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "info": "Del _START_ al _END_ de _TOTAL_ registros",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#tablaUsuario_wrapper .col-md-6:eq(0)');

    function EditarDenuncia(iddenuncia) {
        $.ajax({
            method: "POST",
            url: "controlador/contDenuncia.php",
            data: {
                'proceso': "CONSULTAR",
                'iddenuncia': iddenuncia
            },
            dataType: "json"
        }).done(function(resultado) {
            $("#iddenuncia").val(resultado.iddenuncia);
            $("#titulo").val(resultado.titulo);
            $("#descripcion").val(resultado.descripcion);
            $("#ubicacion").val(resultado.ubicacion);
            $("#estado").val(resultado.estado);
            $("#ciudadano").val(resultado.ciudadano);
            $("#telefono_ciudadano").val(resultado.telefono_ciudadano);
            $("#modalDenuncia").modal('show');
        });
    }

    function CambiarEstadoDenuncia(iddenuncia, estado, nombre) {
        proceso = estado == 0 ? "ANULAR" : (estado == 1 ? "ACTIVAR" : "ELIMINAR");
        mensaje = "¿Esta seguro de <b>" + proceso + "</B> la Denuncia <b>" + nombre + "</b>?";
        accion = "EjecutarCambiarEstadoDenuncia(" + iddenuncia + ",'" + proceso + "')";
        mostrarModalConfirmacion(mensaje, accion);
    }

    function EjecutarCambiarEstadoDenuncia(iddenuncia, proceso) {
        $.ajax({
            method: "POST",
            url: "controlador/contDenuncia.php",
            data: {
                'proceso': proceso,
                'iddenuncia': iddenuncia
            }
        }).done(function(resultado) {
            if (resultado == 1) {
                toastCorrecto("Cambio de estado satisfactorio.");
                listarDenuncias();
            } else {
                toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
            }
        });
    }
</script>