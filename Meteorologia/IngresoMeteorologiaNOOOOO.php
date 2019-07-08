<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
?>



<?php

include('../database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];
$area_Ini = $_REQUEST['area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];
$fenomeno_Ini = $_REQUEST['fenomeno'];
//var_dump($_REQUEST); echo('algo');
//exit();



//// COMBO PERIODO
$sqlPeriodo="SELECT id_periodo, periodo FROM public.periodo_impacto;";
$resultPeriodo = pg_query($sqlPeriodo) or die('Query failed: '.pg_last_error());   








//// COMBO FENOMENO
$sqlFenomeno="SELECT id_fenomeno, fenomeno FROM public.fenomeno order by fenomeno;";
$resultFenomeno = pg_query($sqlFenomeno) or die('Query failed: '.pg_last_error());    
       

//// COMBO IMPACTO
$sqlImpacto="SELECT id_impacto, impacto FROM public.impacto;";
$resultImpacto = pg_query($sqlImpacto) or die('Query failed: '.pg_last_error());     

//// CHECK CONSECUENCIA
$sqlConsecuencia="SELECT ci.id_area, ci.id_fenomeno, ci.id_impacto, (SELECT c.consecuencia FROM public.consecuencia c where c.id_consecuencia=ci.id_consecuencia), ci.estado
FROM public.consecuencia_impacto ci
where ci.id_fenomeno= $id_area_Ini and ci.id_area=$id_fenomeno_Ini and ci.id_impacto= 1;";
$resultConsecuencia = pg_query($sqlConsecuencia) or die('Query failed: '.pg_last_error()); 







//// COMBO TIPO DE SELECCIÓN
$tipo_zona_dpto = '';

$SqlZonaDpto="SELECT zd.tipo_zona_dpto FROM public.municipio_zona_dpto as mz 
inner join public.tipo_zona_dpto as zd on zd.id_tipo_zona_dpto =mz.id_tipo_zona_dpto
GROUP BY zd.tipo_zona_dpto;";
$resultZonaDpto=pg_query($connect, $SqlZonaDpto);
while($row = pg_fetch_array($resultZonaDpto, null, PGSQL_ASSOC)) {
	$TipoSeleccion[] = $row;
} pg_free_result($resultZonaDpto);

$resultZonaDpto=$TipoSeleccion;

foreach($resultZonaDpto as $row)
{
	$tipo_zona_dpto .= '<option value="'.$row['tipo_zona_dpto'].'">'.$row['tipo_zona_dpto'].'</option>';

	$id_tipo_zona_dpto .= '<option value="'.$row['id_tipo_zona_dpto'].'">'.$row['id_tipo_zona_dpto'].'</option>';
}







/// RELACION DE SISTEMAS
$sqlGridRelacionSistemas="SELECT 
sr.id_sistema_relacion, 
sr.id_impacto_diario, 
(SELECT (s.sistema || ' - ' ||   sc.calificativo) FROM public.sistema_calificativo as sc inner join public.sistema as s on sc.id_sistema=s.id_sistema where sc.id_sistema_calificativo=sr.id_sistema_calificativo_s1) as sistema_1, 
(SELECT r.relacion	FROM public.relacion as r where r.id_relacion=sr.id_relacion), 
(SELECT (s.sistema || ' - ' ||   sc.calificativo) FROM public.sistema_calificativo as sc inner join public.sistema as s on sc.id_sistema=s.id_sistema where sc.id_sistema_calificativo=sr.id_sistema_calificativo_s2) as sistema_2, 
sr.prioridad
FROM public.sistema_relacion as sr;";
$resultGridRelacionSistemas = pg_query($sqlGridRelacionSistemas) or die('Query failed: '.pg_last_error());


// NUMERO DE INFORME

$sqlCorrelativo="select coalesce((SELECT correlativo + 1 FROM public.impacto_diario where id_area = 1 and id_fenomeno=1 and fecha = NOW() order by correlativo desc LIMIT 1),1)";
$resultCorrelativo = pg_query($sqlCorrelativo) or die('Query failed: '.pg_last_error());
$correlativo = pg_fetch_all($resultCorrelativo);
$correlativo = $correlativo[0]['coalesce'];

//
// SELECT sc.id_sistema_calificativo, (SELECT s.sistema FROM public.sistema as s where s.id_sistema=sc.id_sistema), sc.calificativo, sc.des_sistema_calificativo
// 	FROM public.sistema_calificativo as sc
// 	where sc.id_sistema= 1;






?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>

	<title>Informe Impacto</title>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


	

		<script src="js/jquery.lwMultiSelect.js"></script>
		<link rel="stylesheet" href="js/jquery.lwMultiSelect.css" />
</head>




	

<body>
	

	<div class="container-fluid">




  <div class="row" style="background: #5DADE2; color:#ffffff; font: cursive;">

    <div class="col-md-6">

<div class="row">
<div class="col-md-1" style="text-align: right;">
<laber><h4 class="glyphicon glyphicon-tint"></h4></laber>
</div>
<div class="col-md-11">
<laber id="id_area"><h4><?php echo $area_Ini; ?></h4></laber>
</div>

            
    </div>
    </div>
    <div class="col-md-6">
           

<div class="row">
  <div class="col-md-1" style="text-align: center;">
<img class="img-responsive" width="100%" src="//192.168.6.204/PronosticoImpacto/Imagenes/Fenomenos/tormentas_lluvias2.png">
</div>

<div class="col-md-11" style="text-align: left;">
<laber id="id_fenomeno"><h4><?php echo  $fenomeno_Ini; ?></h4></laber>
</div>

    </div>
</div>

    </div>

</div>

<br>
<div class="container-fluid" >


<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Informe de Impacto</a></li>
    <li><a data-toggle="tab" href="#menu1">Pronostico</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
<!-- INICIO DE LA FICHA DE INGRESO -->
<p></p>
       <div class="row">
      	<div class="col-md-12" style="background:#7D7D7D;">

      		<div class="row" style="text-align: center; color:#FFFFFF;">
      			<div class="col-md-4" style="text-align: left;">
      				<h5 style="font-weight: bold;">DATOS GENERALES DEL INFORME</h5> 
      			</div>

      			<div class="col-md-4">
      				<label id="correlativo"><h5>Informe No. <?php echo $correlativo; ?></h5></label> 
      			</div>
      			<div class="col-md-4" style="text-align: right;">
      				<label><h5>Estado: Nuevo</h5></label> 
      			</div>
      		</div>



      	</div>

      	<div class="col-md-12" style="background: #ededf0">


      		<div class="row">













      			<br /> 
      			<div class="col-md-12">
      				<label>Titulo</label>  
      				<input type="text" name="titulo" id="titulo" class="form-control" />
      			</div>


      		</div>  



      		<div class="row">
      			<p></p>
      			<div class="col-md-6">

      				<div class="row">
      					<div class="col-md-6">
      						<label>Periodo</label> 

      					<select name="periodo" id="periodo" class="form-control">
						<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
						<?php echo $resultPeriodo; ?>
						</select>

      					</div>
      					<div class="col-md-6">
      						<label>Probabilidad o Impacto? del fenomeno</label>    
      						<select name="id_impacto_fenomeno" id="id_impacto_fenomeno" class="form-control">  
      							<option value="Male">Muy bajo</option>  
      							<option value="Female">Bajo</option> 
      							<option value="Female1">Medio</option>
      							<option value="Female1">Alto</option>  
      						</select>
      					</div>
      				</div>

      				<p></p>

      				<label>Descripción</label>  
      				<textarea name="descripcion" id="descripcion" class="form-control"></textarea>  

      				<p></p>
      				<div style="text-align: right;">
      				<input type="hidden" name="employee_id" id="employee_id" />  
      				<input type="submit" name="insert" id="GuardarGeneral" value="Guardar" class="btn btn-success"/> 
      				</div>
      			</div>


      			<div class="col-md-6">


      				<div id="employee_table">  
      					<table class="table table-bordered"> 
      						<caption style="text-align: center; background:	#7D7D7D; color: #ffffff; font-size: 12px;">
      							<label>Sistemas Relacionados</label>  
      						</caption>

      						<tr style="background:	#f7f7f9;">  
      							<th width="40%" style="text-align: center;">1° Sistema</th>
      							<th width="15%" style="text-align: center;">Relación</th> 
      							<th width="40%" style="text-align: center;">2° Sistema</th> 
      							<th width="5%">
      								<th width="5%" align="center">  <button type="button" name="insert" id="insert" class="btn btn-success glyphicon glyphicon-plus btn-sm"></button> </th>  

      							</tr>  
      							<?php  
      							while($row = pg_fetch_array($resultGridRelacionSistemas))  
      							{  
      								?>  
      								<tr style="background:#FFFFFF;"> <td><?php echo $row["sistema_1"]; ?></td>  
      									<td><?php echo $row["relacion"]; ?></td> 
      									<td><?php echo $row["sistema_2"]; ?></td> 

      									<td align="center">


      										<button type="button" class="btn btn-info glyphicon glyphicon-pencil btn-sm" id="<?php echo $row["id_impacto_diario"]; ?>"></button>
      									</td>
      									<td align="center">
      										<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-sm" id="<?php echo $row["id_impacto_diario"]; ?>"></button>
      									</td>  
      								</tr>  
      								<?php  
      							}  
      							?>  
      						</table>  
      					</div> 

      				</div> 




      			</div> 

      		</div>
      	</div>


<p></p>

		<div class="row">
			<div class="col-md-12" style="text-align: center; color:#FFFFFF; background:#a7a7a7;">

				<h5 style="font-weight: bold;">Información de Municipios y sus Impactos</h5> 
			</div>

		</div>



		<div class="row">
			<div class="col-md-6">
				
				<p></p>

				<form method="post" id="insert_data">
					<!-- <label>Tipo de selección</label> -->
					<label>Tipo de selección</label>
					<select name="tipo_zona_dpto" id="tipo_zona_dpto" class="form-control action">
						<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
						<?php echo $tipo_zona_dpto; ?>
					</select>
					<p></p>
			
					<label>Departamento / Zona</label>
					<select name="zona_dpto" id="zona_dpto" class="form-control action"> 
						
					</select>

					<select name="municipio" id="municipio" multiple class="form-control">
					</select>
					<p></p>
					<input type="hidden" name="hidden_municipio" id="hidden_municipio" />
					<input type="submit" name="insert" id="action" class="btn btn-info" value="Agregar Municipios" />
					<button type="button" class="btn btn-info btn-circle btn-sx"><i class="glyphicon glyphicon-ok"></i></button>
				</form>

			</div>
			<p></p>

			<div class="col-md-6">
				
				<div class="row">
					<div class="col-md-4">
						
						<label>Probabilidad</label>    
						<select name="gender" id="gender" class="form-control">  
							<option value="Male">Muy bajo - 10%</option>  
							<option value="Female">Bajo - 30%</option> 
							<option value="Female1">Medio - 60%</option>
							<option value="Female1">Alto - 80%</option>  
						</select>
					</div>		
					<div class="col-md-3">
						<label>Impacto</label>    
						<select name="gender" id="gender" class="form-control">  
							<option value="Male">Muy bajo</option>  
							<option value="Female">Bajo</option> 
							<option value="Female1">Medio</option>
							<option value="Female1">Alto</option>  
						</select>

					</div>
					<div class="col-md-2">
						<label>Color</label>
						<div class="p-3 mb-2 bg-success text-white" style="text-align: center;">Verde</div> 	
					</div>

					<div class="col-md-3">	
						<label>Horario</label> 
						
						<form>
							<input type="checkbox" name="vehicle" value="Bike" checked>Madrugada<br>
							<input type="checkbox" name="vehicle" value="Car1" checked>Mañana<br>
							<input type="checkbox" name="vehicle" value="Car2" checked>Tarde<br>
							<input type="checkbox" name="vehicle" value="Ca3r" checked>Noche<br>

						</form>
					</div>	
				</div>
				<p></p>
				<label>Consecuencias a afectar</label>
				<div id="contenedorConsecuencias" class="form-check" style="background: #FFFFFF">
					<label>
						<ul style="color:#4F7C91;">
							<?php                                  
							while ($rowConsecuencia = pg_fetch_array($resultConsecuencia, null, PGSQL_ASSOC)) {
							echo "<div class='checkbox'><input checked='checked' name='datos[]' type='checkbox' value=".$rowConsecuencia['id_fenomeno_impacto'].">".$rowConsecuencia['consecuencia']."</div>";

						} 
						pg_free_result($resultConsecuencia);              
						?>    
					</ul>
				</label>
			</div>
		</div>

	</div>





		<p></p>


	<div class="row">

		<div class="col-md-12">


			<table class="table table-bordered"> 
				<!-- <caption style="background: #d8d8d8; color: #ffffff; text-align: center; font-size: 12px;">Municipios con impactos</caption> -->
				<tr style="background:#f2f2f2;">  
					<th width="20%">Departamento</th>
					<th width="20%">Municipio</th> 
					<th width="10%">Impacto</th> 
					<th width="10%">Probabilidad</th>  
					<th width="5%">Color</th>
					<th width="5%"></th>  
				</tr>  

					<tr> <td>San Salvador</td>  
						<td>San Salvador</td> 
						<td>Bajo</td> 
						<td>Muy bajo - 10%</td>
						<td></td>
						<td></td>
					</tr>
					<tr> <td>San Salvador</td>  
						<td>San Marcos</td> 
						<td>Medio</td> 
						<td>Medio - 60%</td>
						<td></td>
						<td></td>
					</tr> 
					<tr> <td>La Libertad</td>  
						<td>Santa Tecla</td> 
						<td>Alto</td> 
						<td>Alto - 80%</td>
						<td></td>
						<td></td>
					</tr> 
				
				</table>  
								<br /> 
								<input type="hidden" name="hidden_municipio" id="hidden_municipio" />
								<input type="submit" name="insert" id="action" class="btn btn-primary" value="Generar Mapa" />
		</div>
	</div>




<!-- FIN DE LA FICHA DE INGRESO -->
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Apoyo a pronostico</h3>
      <div class="row" style="background: #4F7C91;">
										<div class="col-md-12" style="text-align: center; color:white;" >
											<h4>Apoyo para diagnostico</h4>
										</div>
									</div>  

									<div class="row" style="background: #CFDEE2;">
										<div class="col-md-12" style="margin-top: 10px; height:100%;">
											<iframe width="100%" height="622px" src="http://www.snet.gob.sv/googlemaps/radares/radarSmallAll.php"></iframe>
										</div>
									</div>  
    </div>

  </div>
</div>











<script>
				$(document).ready(function(){

					$('#municipio').lwMultiSelect();
					$('.action').change(function(){
	//alert($(this).val());
	if($(this).val() != '')
	{		
			//alert($(this).attr("id_muni_zona_dpto"));
			//alert($(this).val());
			
			var action = $(this).attr("id");
			var query = $(this).val();
			var resultZonaDpto = '';
			//alert(action);
			//alert(query);
			//alert(resultZonaDpto);
			if(action == 'tipo_zona_dpto')
			{

				resultZonaDpto = 'zona_dpto';
			}
			else
			{
				resultZonaDpto = 'municipio';
			}




			$.ajax({
				url:'ProcesoSeleccionMunicios.php',
				method:"POST",
				data:{action:action, query:query},
				success:function(data)
				{

//alert(data);

					$('#'+resultZonaDpto).html(data);
					console.log($('#'+resultZonaDpto).html(data));
	//alert(data);
					 if(resultZonaDpto == 'municipio')
					 {
					 	$('#municipio').data('plugin_lwMultiSelect').updateList();
					 	alert(data);

					 }
					}
				})
		}
	});

					$('#insert_data').on('submit', function(event){
						event.preventDefault();

						if($('#tipo_zona_dpto').val() == '')
						{
							alert("Please Select Country");
							return false;
						}
						else if($('#zona_dpto').val() == '')
						{
							alert("Please Select State");
							return false;
						}
						else if($('#municipio').val() == '')
						{
							alert("Please Select City");
							return false;
						}
						else
						{
							$('#hidden_city').val($('#municipio').val());
							$('#action').attr('disabled', 'disabled');
							var form_data = $(this).serialize();



							$.ajax({
								url:"Procesos.php",
								method:"POST",
								data:form_data,
								success:function(data)
								{
					//alert(data);

					
					$('#action').attr("disabled", "disabled");
					if(data == 'done')
					{

						$('#municipio').html('');
						$('#municipio').data('plugin_lwMultiSelect').updateList();
						$('#municipio').data('plugin_lwMultiSelect').removeAll();
						$('#insert_data')[0].reset();
						alert('Data Inserted');
					}
				}
			});
						}
					});

				});
			</script>
















			</body>
			</html>







			


















