<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];

//// AREA
$sqlArea="SELECT id_area, area FROM public.area WHERE id_area= $id_area_Ini;";
$resultArea = pg_query($sqlArea) or die('Query failed: '.pg_last_error());  
while($row = pg_fetch_array($resultArea, null, PGSQL_ASSOC)) {
$Area_Info[] = $row;
} pg_free_result($resultArea);

//// FENOMENO 
$sqlFenomeno="SELECT id_fenomeno, fenomeno FROM public.fenomeno WHERE id_fenomeno= $id_fenomeno_Ini;";
$resultFenomeno = pg_query($sqlFenomeno) or die('Query failed: '.pg_last_error());  
while($row = pg_fetch_array($resultFenomeno, null, PGSQL_ASSOC)) {
$Fenomeno_Info[] = $row;
} pg_free_result($resultFenomeno);

//// IMPACTO
$sqlGridImpactoDiario="SELECT id.id_impacto_diario, id.fecha::date,id.fecha::time as hora, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto)
  FROM public.impacto_diario id WHERE id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." ;";
$resultGridImpactoDiario = pg_query($sqlGridImpactoDiario) or die('Query failed: '.pg_last_error());


// echo "<pre>";
// print_r($Fenomeno_Info);
// echo $Fenomeno_Info[0]["fenomeno"];
// echo "</pre>";
// exit();

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<script>
$(function () {
    $("#BotonNuevoInforme").click(function () {
        $("#contenedorprincipal").load("MeteorologiaIngreso.php",
			{
				id_area:<?php echo $id_area_Ini; ?>,
				id_fenomeno:<?php echo $id_fenomeno_Ini; ?>,
				area:'<?php echo $Area_Info[0]["area"]; ?>',
				fenomeno:'<?php echo $Fenomeno_Info[0]["fenomeno"]; ?>'
			}
		);
    });
 });

$("#BotonNuevoInforme").click(function () {

});

function b_edi(id) {
	console.log("editar:"+id);
	$("#contenedorprincipal").load("MeteorologiaEdicion.php",
		{
			id_area:<?php echo $id_area_Ini; ?>,
			id_fenomeno:<?php echo $id_fenomeno_Ini; ?>,
			area:'<?php echo $Area_Info[0]["area"]; ?>',
			fenomeno:'<?php echo $Fenomeno_Info[0]["fenomeno"]; ?>',
			id_impacto_diario:id
		}
	);
} 
 
function b_del(id) {
	console.log("borrar:"+id);
}


</script>
   
</head>
<body>


<div class="container-fluid">
	<div class="row" style="background: #485668; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">

			<table style="width:100%" border=0>
			  <tr>	<th></th></tr>
			  <tr>
			  <td><h4 style="text-align:left;"		><?php echo $Area_Info[0]["area"]; ?></td>
			  <td><h4 style="text-align:center;"	><?php echo $Fenomeno_Info[0]["fenomeno"]; ?></td>
			  <td><h4 style="text-align:right;"		></h4>&nbsp;</td>
			  </tr>
			</table>		

		</div>
	</div>
</div>



<!-- CONTROL Revisar pasarlo a posgres -->
    
     
<div class="container-fluid">  
<br />  
	<div class="table-responsive"> 
		<div align="right">  
			<!-- BOTON PARA POPPO  -->
			<!-- <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-success">Nuevo Informe</button> -->
			<button type="button" id="BotonNuevoInforme" class="btn btn-success">Nuevo Informe</button>  
		</div> 
		<p></p>
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption style="background: #7D7D7D; color: #ffffff; text-align: center; font-size: 15px;">Informes Pendientes</caption>
				<tr style="background:#EEEEEE;">  
						<th width="10%">Fecha</th>
						<th width="10%">Hora</th> 
						<th width="5%" >No.</th> 
						<th width="45%">Título</th>
						<th width="10%">Período</th>
						<th width="10%">Estado</th>   
						<th width="5%"></th>  
						<th width="5%"></th>  
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario))  
				{ 
				?>  
					<tr style="background:#FFFFFF;"> 
						<td><?php echo $row["fecha"]; ?></td>  
						<td><?php echo $row["hora"]; ?></td> 
						<td><?php echo $row["correlativo"]; ?></td> 
						<td><?php echo $row["titulo"]; ?></td> 
						<td><?php echo $row["periodo"]; ?></td> 
						<td><?php echo $row["estado_impacto"]; ?></td> 
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-pencil btn-sm" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>  
						<td align="center">
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-sm" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>  
		</div>  
	</div>  
</div>  
       
<!-- ********************************* -->    <p></p>    <p></p>

<div class="container-fluid">  
	<!-- <h3 align="center">PHP Ajax Update MySQL Data Through Bootstrap Modal</h3>   -->
	<br />  
	<div class="table-responsive">
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption style="background: #434343; color: #ffffff; text-align: center; font-size: 15px;">Informes Publicados</caption>
				<tr style="background:#EEEEEE;">  
						<th width="10%">Fecha</th>
						<th width="10%">Hora</th> 
						<th width="5%">No.</th> 
						<th width="45%">Título</th>
						<th width="10%">Período</th>
						<th width="10%">Estado</th>   
						<th width="5%">Ver</th>  
						<th width="5%">Verificar</th>  
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario))  
				{  
				?>  
				<tr style="background:#FFFFFF;"> <td><?php echo $row["fecha"]; ?></td>  
						<td><?php echo $row["hora"]; ?></td> 
						<td><?php echo $row["correlativo"]; ?></td> 
						<td><?php echo $row["titulo"]; ?></td> 
						<td><?php echo $row["periodo"]; ?></td> 
						<td><?php echo $row["estado_impacto"]; ?></td> 
						<td><input type="button" name="Edit" value="Ver" id="<?php echo $row["id_impacto_diario"]; ?>" class="btn btn-secondary btn-xs edit_data" /></td>  
						<td><input type="button" name="view" value="Verificar" id="<?php echo $row["id_impacto_diario"]; ?>" class="btn btn-info btn-xs view_data" /></td>  
				</tr>  
				<?php  
				}  
				?>  
			</table>  
		</div>  
	</div>  
</div>  

<!-- CONTROL Revisar pasarlo a posgres -->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Employee Details</h4>  
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 <div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">PHP Ajax Update MySQL Data Through Bootstrap Modal</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="insert_form">  
                          <label>Enter Employee Name</label>  
                          <input type="text" name="name" id="name" class="form-control" />  
                          <br />  
                          <label>Enter Employee Address</label>  
                          <textarea name="address" id="address" class="form-control"></textarea>  
                          <br />  
                          <label>Select Gender</label>  
                          <select name="gender" id="gender" class="form-control">  
                               <option value="Male">Male</option>  
                               <option value="Female">Female</option>  
                          </select>  
                          <br />  
                          <label>Enter Designation</label>  
                          <input type="text" name="designation" id="designation" class="form-control" />  
                          <br />  
                          <label>Enter Age</label>  
                          <input type="text" name="age" id="age" class="form-control" />  
                          <br />  
                          <input type="hidden" name="employee_id" id="employee_id" />  
                          <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />  
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 <script>  
$(document).ready(function(){
	$('#add').click(function(){  
		$('#insert').val("Insert");  
		$('#insert_form')[0].reset();  
      });  
	$(document).on('click', '.edit_data', function(){
		var employee_id = $(this).attr("id");  
		$.ajax({
			url:"fetch.php",  
			method:"POST",  
			data:{employee_id:employee_id},  
			dataType:"json",  
			success:function(data){
				$('#name').val(data.name);  
				$('#address').val(data.address);  
				$('#gender').val(data.gender);  
				$('#designation').val(data.designation);  
				$('#age').val(data.age);  
				$('#employee_id').val(data.id);  
				$('#insert').val("Update");  
				$('#add_data_Modal').modal('show');  
			}  
		});  
	});  
	$('#insert_form').on("submit", function(event){
		event.preventDefault();  
		if($('#name').val() == "") {
			alert("Name is required");  
		}
		else if($('#address').val() == '') {
			alert("Address is required");  
		}  
		else if($('#designation').val() == '') {
			alert("Designation is required");  
		}  
		else if($('#age').val() == '') {
			alert("Age is required");  
		}
		else { 
			$.ajax({  
				url:"insert.php",  
				method:"POST",  
				data:$('#insert_form').serialize(),  
				beforeSend:function(){  
					$('#insert').val("Inserting");  
				},  
				success:function(data){  
					$('#insert_form')[0].reset();  
					$('#add_data_Modal').modal('hide');  
					$('#employee_table').html(data);  
				}  
			});  
		}  
	});  
	$(document).on('click', '.view_data', function(){
	var employee_id = $(this).attr("id");  
	if(employee_id != '')  
		{  
		$.ajax({
			url:"select.php",  
			method:"POST",  
			data:{employee_id:employee_id},  
			success:function(data){  
				$('#employee_detail').html(data);  
				$('#dataModal').modal('show');  
			}  
		});  
		}           
	});  
});  
</script>

<!-- ********************************* -->
</body>
</html>
