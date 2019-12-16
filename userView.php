<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
// include("header.php");
include("cnn.php");
session_start();

/// COMBO USER
$user = '';
$dbconn = my_dbconn4("PronosticoImpacto");
$sql="SELECT id_usuario as id, nombre, apellido, usuario, password, id_area, cargo, id_rol FROM public.usuario ORDER BY id_usuario;";
$result=pg_query($dbconn, $sql);

// print_r($area);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
table, .paginate_button, #users_info {
    font-size: 12px;
    border: 0px solid #ddd;
}

tbody tr.odd {
    background-color: #e6e6e6;
}
th {
    background-color: #f9f9f9;
}
table.dataTable thead th, table.dataTable thead td {
    padding: 8px 8px !important;
    border-bottom: 1px solid #ddd;
}
th {
	padding: 8px 8px;
	background-color:#e6e6e6 !important;
}
</style>

<script>
$( document ).ready(function() {
	$('#users').DataTable({
    "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }  
	});
});
</script>	
</head>

<body>
<div class="container" style="width:100%; text-align:center;">
<table id="users" class="table table-bordered" style="width:100%">
<caption style="background: #205e76; color: #ffffff; text-align: center; font-size: 15px;">USUARIOS</caption>	
	<thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Area</th>
                <th>Cargo</th>
                <th>Rol</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
	</thead>
        <tbody>
<?php 
$c=1;
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
?>
            <tr>
                <td><?php echo $c;?></td>
                <td><?php echo $row['nombre'];?></td>
                <td><?php echo $row['apellido'];?></td>
                <td><?php echo $row['usuario'];?></td>
                <td><?php echo $row['id_area'];?></td>
                <td><?php echo $row['cargo'];?></td>
                <td><?php echo $row['id_rol'];?></td>
                <td align="center"><button type="button" id="<?php echo $row['id'];?>" class="btn btn-primary glyphicon glyphicon-pencil btn-xs" onclick="b_edit($(this).attr('id'))"></button></td>
                <td align="center"><button type="button" id="<?php echo $row['id'];?>" class="btn btn-danger glyphicon glyphicon-remove btn-xs"  onclick="b_dele($(this).attr('id'))"></button></td>
            </tr>
<?php	
$c+=1;
} pg_free_result($result);	
?>		
		

            
        </tbody>
<!--		
        <tfoot>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Area</th>
                <th>Cargo</th>
                <th>Rol</th>
            </tr>
        </tfoot>
-->
</table>
</div>

</body>
</html>