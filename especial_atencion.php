<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];



//// AREA
$sqlArea="SELECT id_area, area FROM public.area WHERE id_area= $id_area_Ini;";
$resultArea = pg_query($sqlArea) or die('Query failed: '.pg_last_error());  
while($row = pg_fetch_array($resultArea, null, PGSQL_ASSOC)) {
$Area_Info[] = $row;
} pg_free_result($resultArea);




//// COMBO DEPARTAMENTO

$Departamento  = '';
$SqlDepartamento ="SELECT cod_departamento, departamento	FROM public.departamento;";
$resultDepartamento =pg_query($connect, $SqlDepartamento );
while($row = pg_fetch_array($resultDepartamento , null, PGSQL_ASSOC)) {
	$TipoDepartamento [] = $row;
} pg_free_result($resultDepartamento );

$resultDepartamento = $TipoDepartamento ;

foreach($resultDepartamento  as $row) {
	$Departamento  .= '<option value="'.$row['cod_departamento'].'">'.$row['departamento'].'</option>';
}



//// COMBO MUNICIPIO

$Municipio  = '';
$SqlMunicipio ="SELECT cod_municipio, nombre	FROM public.municipio;";
$resultMunicipio =pg_query($connect, $SqlMunicipio );
while($row = pg_fetch_array($resultMunicipio , null, PGSQL_ASSOC)) {
	$TipoMunicipio [] = $row;
} pg_free_result($resultMunicipio );

$resultMunicipio = $TipoMunicipio ;

foreach($resultMunicipio  as $row) {
	$Municipio  .= '<option value="'.$row['cod_municipio'].'">'.$row['nombre'].'</option>';
}



//var_dump($ImpactoFenomeno);



// GRID ESPECIAL ATENCIÓN
$sqlGridMunicipioAtencion="SELECT ea.id_especial_atencion, ea.id_area, 
	(SELECT d.departamento	FROM public.departamento d where d.cod_departamento=ea.cod_departamento ) as departamento,
	(SELECT m.nombre	FROM public.municipio m where m.cod_municipio=ea.cod_municipio and m.cod_departamento= ea.cod_departamento) as municipio, ea.especial_atencion FROM public.especial_atencion ea";
$resultGridMunicipioAtencion = pg_query($sqlGridMunicipioAtencion) or die('Query failed: '.pg_last_error());




?>



<!DOCTYPE html>

<html lang="en">
<head>
    
<title>Especial Atención</title>
		<!--
		<link href="css/kendo.common.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/kendo.default.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/site2.css" rel="stylesheet" type="text/css"/>
        <link href="css/site.css" rel="stylesheet" type="text/css"/>  
        <link href="css/kendo.dataviz.default.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/kendo.dataviz.min.css" rel="stylesheet" type="text/css"/> 
		-->

		<script src="js/jquery.lwMultiSelect.js"></script>
		<link rel="stylesheet" href="js/jquery.lwMultiSelect.css" />

		<script src="js/kendo.all.min.js" type="text/javascript"></script>
		<script src="js/kendo.aspnetmvc.min.js" type="text/javascript"></script>
		<script src="js/kendo.culture.es-SV.min.js" type="text/javascript"></script>



</head>
<body>



 <div class="container-fluid">




<div class="row" style="background: #485668; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">

			<table style="width:100%" border=0>
			  <tr>	<th></th></tr>
			  <tr>
			  <td><h4 style="text-align:left;">Especial Atención para: <?php echo $Area_Info[0]["area"]; ?></td>
			  </tr>
			</table>		

		</div>
	</div>

<br>

<div class="row">
<div class="col-md-6">
	<div class="row">

		<div class="col-md-12">
			<label>Departamento</label> 
			<select name="Departamento" id="Departamento" class="form-control" placeholder="Selecione departamento" required data-required-msg="Selecione departamento">
			<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
			<?php echo $Departamento;?>
			</select>
			<p></p>
		</div>

		<div class="col-md-12">
			<label>Municipio</label> 
			<select name="Municipio" id="Municipio" class="form-control" placeholder="Selecione municipio" required data-required-msg="Selecione municipio">
			<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
			<?php echo $Municipio;?>
			</select>
			<p></p>
		</div>

</div>

		<div class="row">
			
			<div class="col-md-10">
				<label>Especial Atención</label> 
				<input type="text" name="Especial" id="Especial" class="form-control" placeholder="Ingrese un lugar" required data-required-msg=""/>
			</div>

			<div class="col-md-2">
				<button type="button" id="BotonIngresar" class="btn btn-success">Ingresar</button>
			</div>

		</div>


</div>

<div class="col-md-6">
	<br>
			<div id="especial_atencion">  
			<table class="table table-bordered"> 
				<caption style="background: #7D7D7D; color: #ffffff; text-align: center; font-size: 15px;">Especial Atención</caption>
				<tr style="background:#EEEEEE;">
						<th width="30%" >Especial Atención</th> 
						<th width="30%">Departamento</th>
						<th width="30%">Municipio</th> 

						<th width="10%">Eliminar</th>  
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridMunicipioAtencion))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td><?php echo $row["especial_atencion"]; ?></td> 
						<td><?php echo $row["departamento"]; ?></td>  
						<td><?php echo $row["municipio"]; ?></td> 


						<td align="center" >
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-xs" id="<?php echo $row["id_especial_atencion"]; ?>" onclick="b_del($(this).attr('id'))";></button>
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


</body>
</html>


