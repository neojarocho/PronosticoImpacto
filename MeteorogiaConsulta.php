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

//// GRID EN PROCESOS
$sqlGridImpactoDiario="SELECT id.id_impacto_diario, to_char(id.fecha, 'DD/MM/YYYY - HH:MI:SS') as fecha, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto)
  FROM public.impacto_diario id WHERE id_estado_impacto <> '6' and id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." order by id.fecha desc;";
$resultGridImpactoDiario = pg_query($sqlGridImpactoDiario) or die('Query failed: '.pg_last_error());




//// GRID EN Historicos
$sqlGridImpactoDiarioHis="SELECT id.id_impacto_diario, to_char(id.fecha, 'DD/MM/YYYY - HH:MI:SS') as fecha, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto)
  FROM public.impacto_diario id WHERE id_estado_impacto = '6' and id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." order by id.fecha desc;";
$resultGridImpactoDiarioHis = pg_query($sqlGridImpactoDiarioHis) or die('Query failed: '.pg_last_error());

// echo "<pre>";
// print_r($Fenomeno_Info);
// echo $Fenomeno_Info[0]["fenomeno"];
// echo "</pre>";
// exit();


//// GRID EN HVALIDAR
$sqlGridImpactoValidar="SELECT to_char(h.fecha_historico, 'DD/MM/YYYY - HH:MI:SS') as fecha, h.titulo, (SELECT p.periodo FROM public.periodo_impacto p where p.id_periodo=h.id_periodo) as periodo, 
	(CASE WHEN (SELECT count(v.id_his_impacto_diario)
	FROM public.verificacion_impacto v
	where v.id_his_impacto_diario=h.id_his_impacto_diario) = 0   THEN 'No'
              ELSE 'Si'
       END) as validado
	FROM public.his_impacto_diario h
	where h.id_area = ".$id_area_Ini." AND h.id_fenomeno = ".$id_fenomeno_Ini."";
$resultGridImpactoValidar = pg_query($sqlGridImpactoValidar) or die('Query failed: '.pg_last_error());






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


function b_comp(id) {
	console.log("comparar:"+id);
	$("#contenedorprincipal").load("VistaInformes.php",
		{
			id_area:<?php echo $id_area_Ini; ?>,
			id_fenomeno:<?php echo $id_fenomeno_Ini; ?>,
			area:'<?php echo $Area_Info[0]["area"]; ?>',
			fenomeno:'<?php echo $Fenomeno_Info[0]["fenomeno"]; ?>',
			id_impacto_diario:id
		}
	);
} 





        $(document).ready(function () {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });




</script>
   
</head>
<body>



<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->

<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->


<div class="container-fluid">  
   
	<div class="row" style="background: #323c48; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">

			<table style="width:100%" border=0>
			  <tr>	<th></th></tr>
			  <tr>
			  <td><h4 style="text-align:left;"		><?php echo $Area_Info[0]["area"]; ?></td>
			  <td><h4 style="text-align:center;"	><?php echo $Fenomeno_Info[0]["fenomeno"]; ?></td>
			  <td><h4 style="text-align:right;"		><button type="button" id="BotonNuevoInforme" class="btn btn-success">Nuevo Informe</button></h4></td>
			  </tr>
			</table>		

		</div>
	</div>




        <!--GRID DINAMICOS-->
        <div class="row">
            <div class="bhoechie-tab-container">
                <div class="col-md-1 bhoechie-tab-menu">
                    <div class="list-group">
                        <a href="#" class="list-group-item active text-center">
                            <h2 class="glyphicon glyphicon-pencil"></h2><br />Proceso
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon glyphicon-list-alt"></h2><br />Consultar
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon-book"></h2><br />Historial
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon-ok"></h2><br />Validar
                        </a>
                        <!--<a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon-home"></h2><br />Vólcan San Salvador
                        </a>-->


                    </div>
                </div>


                <div class="col-xs-11 bhoechie-tab">
                    <div class="bhoechie-tab">
                        <!-- flight section -->
                        <div class="bhoechie-tab-content active">
                            <div class="col-md-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<p></p>
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption  style="background: #205e76; color: #ffffff; text-align: center; font-size: 15px;">EN PROCESO</caption>
				<tr style="background:#e5e5e5;"> 
						<th width="5%"></th>   
						<th width="20%">Fecha</th>
						<th width="45%">Título</th>
						<th width="15%">Período</th>
						<th width="10%">Estado</th>   
						<th width="5%"></th>
						<th width="5%"></th>  
						
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-secondary glyphicon glyphicon-pencil btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>  
						<td><?php echo $row["fecha"]; ?></td>   
						<td><?php echo $row["titulo"]; ?></td> 
						<td><?php echo $row["periodo"]; ?></td> 
						<td><?php echo $row["estado_impacto"]; ?></td> 

						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-transfer btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_comp($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td> 
  
					</tr>  
				<?php  
				}  
				?>  
			</table>  
		</div>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                 

							</div>

                        </div>
                        <!-- train section -->
                        
                        <div class="bhoechie-tab-content active">
                            <div class="col-md-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<p></p>
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption  style="background: #205e76; color: #ffffff; text-align: center; font-size: 15px;">VISTA POR PERIODOS</caption>
				<tr style="background:#e5e5e5;">  
						<th width="95%">Fecha</th>
						<th width="5%"></th>  
					 
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridVista))  
				{ 
				?>  
					<tr style="background:#FFFFFF;"> 
						<td><?php echo $row["fecha"]; ?></td>   
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>  
						
					</tr>  
				<?php  
				}  
				?>  
			</table>  
		</div>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                 

							</div>

                        </div>
                        <!-- train section -->
                        <div class="bhoechie-tab-content">
                            <div class="col-md-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

	<div class="table-responsive">
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption  style="background: #205e76; color: #ffffff; text-align: center; font-size: 15px;">HISTORICOS</caption>
				<tr style="background:#e5e5e5;">  
						<th width="20%">Fecha</th>
						<th width="45%">Título</th>
						<th width="15%">Período</th>
						<th width="10%">Estado</th>
						<th width="5%">Ver</th>     
						<th width="5%">Copia</th>  
 
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiarioHis))  
				{ 
				?>  
					<tr style="background:#FFFFFF;"> 
						<td><?php echo $row["fecha"]; ?></td>   
						<td><?php echo $row["titulo"]; ?></td> 
						<td><?php echo $row["periodo"]; ?></td> 
						<td><?php echo $row["estado_impacto"]; ?></td>
						<td align="center">
							<button type="button" class="btn btn-primary glyphicon glyphicon-search btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>   
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-open-file btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  
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
                        </div>


                        <div class="bhoechie-tab-content">
                            <div class="col-md-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


	<div class="table-responsive">
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption style="background: #205e76; color: #ffffff; text-align: center; font-size: 15px;">VALIDAR</caption>
				<tr style="background:#e5e5e5;">  
						
						<th width="20%">Fecha</th>
						<th width="60%">Título</th>
						<th width="10%">Período</th>
						<th width="5%">Validado</th>
						<th width="5%">Verificar</th>    
  
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoValidar))  
				{  
				?>  
				<tr style="background:#FFFFFF;">

						 <td><?php echo $row["fecha"]; ?></td>  
						<td><?php echo $row["titulo"]; ?></td> 
						<td><?php echo $row["periodo"]; ?></td> 
						<td><?php echo $row["validado"]; ?></td>
						<td align="center">
							<button type="button" class="btn btn-success glyphicon glyphicon-ok btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  

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
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>


</div>




<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->
<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->






















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
