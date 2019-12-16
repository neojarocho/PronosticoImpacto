<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];


//// AREA
$sqlArea="SELECT id_area, area, color FROM public.area WHERE id_area= $id_area_Ini;";
$resultArea = pg_query($sqlArea) or die('Query failed: '.pg_last_error());  
while($row = pg_fetch_array($resultArea, null, PGSQL_ASSOC)) {
$Area_Info[] = $row;
} pg_free_result($resultArea);



//// INICIO GRID EN PROCESOS ******************************************************************************************



//// GRID EN VALIDAR
$sqlGridImpactoValidar="SELECT h.id_his_impacto_diario, to_char(h.fecha_historico, 'DD/MM/YYYY') as fecha, to_char(h.fecha_historico, 'HH24:MI') as hora, h.titulo, (SELECT p.periodo FROM public.periodo_impacto p where p.id_periodo=h.id_periodo) as periodo, 
	
	(CASE WHEN (SELECT count (v.id_verificacion)
				FROM public.his_impacto_diario_detalle v
				WHERE v.id_his_impacto_diario=h.id_his_impacto_diario) = 0   THEN 'No'
              ELSE 'Si'
       END) as validado  
	FROM public.his_impacto_diario h
	where h.id_area = ".$id_area_Ini." ORDER BY h.fecha_historico desc";
$resultGridImpactoValidar = pg_query($sqlGridImpactoValidar) or die('Query failed: '.pg_last_error());





?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>


<style type="text/css">
  .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #2e3740!important;
} 



div.bhoechie-tab-menu div.list-group>a.active, div.bhoechie-tab-menu div.list-group>a.active .glyphicon, div.bhoechie-tab-menu div.list-group>a.active .fa {
    background-color: #2e3740;
    background-image: #ffffff;
    color: #ffffff;
}

div.bhoechie-tab-menu div.list-group>a.active:after {
    border-left: 10px solid #2e3740;
}

.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
    border-color: #ffffff;
}

div.bhoechie-tab-menu div.list-group>a .glyphicon, div.bhoechie-tab-menu div.list-group>a .fa {
    color: #2e3740;
}

a {
    color: #2e3740;
}


.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    padding: 5px;

}

</style>

<script>



function b_Validar(id) {

	$("#contenedorprincipal").load("validacion.php",
		{
			id_impacto_diario:id
		}
	);
} 


</script>
   
</head>
<body>



<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->

<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->


<div class="container-fluid">  
   
	<div class="row">
		<div class="col-xs-6" style="text-align: center; background: <?php echo $Area_Info[0]["color"]; ?>; color:#ffffff;">

				<h4 style="text-align:left; text-align:left; margin-top: 7px;margin-bottom: 7px;">Validación de pronósticos</h4>	

		</div>

		<div class="col-xs-6" style="text-align: center; background: <?php echo $Area_Info[0]["color"]; ?>; color:#ffffff;">
				<h4 style="text-align:left; text-align:right; margin-top: 7px;margin-bottom: 7px;"><?php echo $Area_Info[0]["area"]; ?></h4>
			

		</div>

	</div>






	<div class="table-responsive">
		<div id="employee_table">  
			<table class="table table-bordered"> 
				
				<tr style="background:#e5e5e5;"> 
						<th width="3%"></th>

						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th width="55%">Título</th>
						<th style="text-align:center;" width="17%">Período</th>
						<th style="text-align:center;" width="5%">Ok</th>
						

					  
  
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoValidar))  
				{  
				?>  
				<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-success glyphicon glyphicon-ok btn-xs" id="<?php echo $row["id_his_impacto_diario"]; ?>" onclick="b_Validar($(this).attr('id'))";></button>
						</td>
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>  						
						<td><?php echo $row["titulo"]; ?></td> 
						<td style="text-align:center;"><?php echo $row["periodo"]; ?></td> 
						<td style="text-align:center;"><?php echo $row["validado"]; ?></td> 


				</tr>  
				<?php  
				}  
				?>  
			</table>  
		</div>  
	</div> 
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
</div>













<!-- ********************************* -->
</body>
</html>
