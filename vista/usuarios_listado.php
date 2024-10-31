<?php 
include_once("../modelo/Usuario.php");
$objUsu = new Usuario();
$listado = $objUsu->listar("%%");
?>
<table id="tablaUsuario" class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th hidden>ID</th>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Perfil</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){ 
            $bgclass = $v['estado']==1?"bg-success":"bg-danger";
            $icono = $v['estado']==1?"fa fa-lock":"fa fa-lock-open";
            $texto = $v['estado']==1?"Anular":"Activar";
            $estado = $v['estado']==1?0:1;

            ?>
            <tr class="">
                <td hidden><?= $v['idusuario'] ?></td>
                <td><?= $v['dni'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['usuario'] ?></td>
                <td><?= $v['perfil'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td><button onclick="EditarUsuario(<?= $v['idusuario'] ?>)" class="btn bg-info btn-sm" title="Editar"><span class="fa fa-pencil-alt"></span> </button>
                    <button onclick="CambiarEstadoUsuario(<?= $v['idusuario'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm" title="<?= $texto ?>"><span class="<?= $icono ?>"></span> </button>
                    <button onclick="CambiarEstadoUsuario(<?= $v['idusuario'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm" title="Eliminar"><span class="fa fa-trash"></span> </button>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaUsuario').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "order":[[1,'asc']],
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

function EditarUsuario(idusuario){
    $.ajax({
        method: "POST",
        url: "controlador/contUsuario.php",
        data:{
            'proceso': "CONSULTAR",
            'idusuario': idusuario
        },
        dataType: "json"
    }).done(function(resultado){
        $("#idusuario").val(resultado.idusuario);
        $("#dni").val(resultado.dni);
        $("#nombre").val(resultado.nombre);
        $("#correo").val(resultado.correo);
        $("#usuario").val(resultado.usuario);
        $("#idperfil").val(resultado.idperfil);
        $("#estado").val(resultado.estado);
        $("#modalUsuario").modal('show');
    });
}

function CambiarEstadoUsuario(idusuario, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> usuario <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoUsuario("+idusuario+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoUsuario(idusuario,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contUsuario.php",
        data: {
            'proceso': proceso,
            'idusuario': idusuario
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarUsuarios();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>