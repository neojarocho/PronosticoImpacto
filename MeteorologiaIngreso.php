<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];
$area_Ini = $_REQUEST['area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];
$fenomeno_Ini = $_REQUEST['fenomeno'];



#--------------------------------------------------------------------------------------------------------
# IVAN MORAN CODE INI
#--------------------------------------------------------------------------------------------------------
include("cnn.php");
function getMuniData($va) {
	$dbconn = my_dbconn4("PronosticoImpacto");
	$sql="
	SELECT i.id_impacto_diario, i.id_area, i.id_fenomeno, 
	i.fecha, i.correlativo, i.titulo, i.descripcion, i.id_periodo, p.periodo, 
	i.id_estado_impacto, es.estado_impacto, m.impacto, i.id_usuario, i.fecha_ini, i.fecha_fin
	FROM public.impacto_diario i
	INNER JOIN periodo_impacto p ON p.id_periodo = i.id_periodo
	INNER JOIN estado_impacto es on es.id_estado_impacto = i.id_estado_impacto
	WHERE i.id_impacto_diario = ".$id_impacto_diario.";
	";
	$result=pg_query($dbconn, $sql);

	while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$ro[] = $row;
	} pg_free_result($result);
	$ro=$ro[0];
	return $ro;
}
// var_dump($ro);

#--------------------------------------------------------------------------------------------------------
# IVAN MORAN CODE FIN
#--------------------------------------------------------------------------------------------------------

//// COMBO PERIODO
$periodo = '';
$SqlPeriodo="SELECT id_periodo, periodo FROM public.periodo_impacto ORDER BY id_periodo;";
$resultPeriodo=pg_query($connect, $SqlPeriodo);
while($row = pg_fetch_array($resultPeriodo, null, PGSQL_ASSOC)) {
	$TipoPeriodo[] = $row;
} pg_free_result($resultPeriodo);

$resultPeriodo=$TipoPeriodo;

foreach($resultPeriodo as $row)
{
	$periodo .= '<option value="'.$row['id_periodo'].'">'.$row['periodo'].'</option>';
}

//// IMPACTO FENOMENO
$ImpactoFenomeno  = '';
$SqlImpactoFenomeno ="SELECT id_impacto, impacto FROM public.impacto;";
$resultImpactoFenomeno =pg_query($connect, $SqlImpactoFenomeno );
while($row = pg_fetch_array($resultImpactoFenomeno , null, PGSQL_ASSOC)) {
	$TipoImpactoFenomeno [] = $row;
} pg_free_result($resultImpactoFenomeno );

$resultImpactoFenomeno = $TipoImpactoFenomeno ;

foreach($resultImpactoFenomeno  as $row) {
	$ImpactoFenomeno  .= '<option value="'.$row['id_impacto'].'">'.$row['impacto'].'</option>';
}

//// COMBO FENOMENO
$sqlFenomeno="SELECT id_fenomeno, fenomeno FROM public.fenomeno order by fenomeno;";
$resultFenomeno = pg_query($sqlFenomeno) or die('Query failed: '.pg_last_error());    
       
//// COMBO IMPACTO
$sqlImpacto="SELECT id_impacto, impacto FROM public.impacto;";
$resultImpacto = pg_query($sqlImpacto) or die('Query failed: '.pg_last_error());     

// //// CHECK CONSECUENCIA
// $sqlConsecuencia="SELECT ci.id_area, ci.id_fenomeno, ci.id_impacto, (SELECT c.consecuencia FROM public.consecuencia c where c.id_consecuencia=ci.id_consecuencia), ci.estado
// FROM public.consecuencia_impacto ci
// where ci.id_fenomeno= $id_area_Ini and ci.id_area=$id_fenomeno_Ini and ci.id_impacto= 1;";
// $resultConsecuencia = pg_query($sqlConsecuencia) or die('Query failed: '.pg_last_error()); 

//// CHECK HORARIO
$sqlHorario="SELECT id_horario, horario	FROM public.horario;";
$resultHorario = pg_query($sqlHorario) or die('Query failed: '.pg_last_error()); 


//// COMBO TIPO DE SELECCIÓN DE ZONA / DPTO
$tipo_zona_dpto = '';

$SqlZonaDpto="SELECT mz.id_tipo_zona_dpto, zd.tipo_zona_dpto FROM public.municipio_zona_dpto as mz 
inner join public.tipo_zona_dpto as zd on zd.id_tipo_zona_dpto =mz.id_tipo_zona_dpto
GROUP BY mz.id_tipo_zona_dpto, zd.tipo_zona_dpto;";
$resultZonaDpto=pg_query($connect, $SqlZonaDpto);
while($row = pg_fetch_array($resultZonaDpto, null, PGSQL_ASSOC)) {
	$TipoSeleccion[] = $row;
} pg_free_result($resultZonaDpto);

$resultZonaDpto=$TipoSeleccion;

foreach($resultZonaDpto as $row) {
	$tipo_zona_dpto .= '<option value="'.$row['tipo_zona_dpto'].'">'.$row['tipo_zona_dpto'].'</option>';
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


// ------------------------ MUNICIPIOS
/// COMBO PROBABILIDAD
$Probabilidad = '';
$SqlProbabilidad="SELECT id_probabilidad, probabilidad || ' - ' || valor_probabilidad as probabilidad, des_probabilidad
	FROM public.probabilidad;";
$resultProbabilidad=pg_query($connect, $SqlProbabilidad);
while($row = pg_fetch_array($resultProbabilidad, null, PGSQL_ASSOC)) {
	$TipoProbabilidad[] = $row;
} pg_free_result($resultProbabilidad);

$resultProbabilidad=$TipoProbabilidad;

foreach($resultProbabilidad as $row)
{
	$Probabilidad .= '<option value="'.$row['id_probabilidad'].'">'.$row['probabilidad'].'</option>';
}

/// NUMERO DE INFORME
$sqlCorrelativo="select coalesce((SELECT correlativo + 1 FROM public.impacto_diario where id_area = $id_area_Ini and id_fenomeno= $id_fenomeno_Ini order by correlativo desc LIMIT 1),1)";
$resultCorrelativo = pg_query($sqlCorrelativo) or die('Query failed: '.pg_last_error());
$correlativo = pg_fetch_all($resultCorrelativo);
$correlativo = $correlativo[0]['coalesce'];

//
// SELECT sc.id_sistema_calificativo, (SELECT s.sistema FROM public.sistema as s where s.id_sistema=sc.id_sistema), sc.calificativo, sc.des_sistema_calificativo
// 	FROM public.sistema_calificativo as sc
// 	where sc.id_sistema= 1;


if(@$id_impacto_diario==''){
	$estado_impacto = 'Nuevo';
	//$fecha_ini = '05/12/2018';
};

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>

	<title>Informe Impacto</title>
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

<style type="text/css">
#mapa_ivan {
    max-width: 100%;
    overflow-x: hidden;
    overflow-y: hidden;
}
.btn-sq {
	width: 100% !important;
	height: 100px !important;
}
.loading-div-background {
		// opacity: 0.8; 
        display:none;
        position:fixed;
        top:0;
        left:0;
        background:rgba(0, 0, 0, 0.2);
        width:100%;
        height:100%;
}
.loading-div {
         width: 300px;
         height: 200px;
         background-color: rgba(255, 255, 255, 0);
         text-align:center;
         position:absolute;
         left: 50%;
         top: 50%;
         margin-left:-150px;
         margin-top: -100px;
}
.loading-div h2 {
	color: black !important;
	font-size: 25px;
}
.loading-div-background-form {
        display:none;
        position:fixed;
		opacity: 1;
        top:0;
        left:0;
        background:rgba(0, 0, 0, 0.2);
        width:100%;
        height:100%;
}
.loading-div-form {
         width: 550px;
         height: auto;
         background-color: rgba(255, 255, 255, 1);
         text-align:center;
         position:absolute;
         top: 50%;
         left: 50%;
		 transform: translate(-50%, -50%);
         // margin-left:-150px;
         // margin-top: -100px;
}
.loading-div-form h2 {
	color: black !important;
	font-size: 25px;
}
.space {
	margin-top:		2.5px;
	margin-bottom:	2.5px;
}
.col-md-12, .col-md-3 {
	padding-top: 5px;
}
iframe {
  overflow: hidden !important;
}
#pnum {
	float: right !important;
}

	#fieldlist {
		margin: 0;
		padding: 0;
	}
	
	#fieldlist li {
		list-style: none;
		padding-bottom: .7em;
		text-align: left;
		display: flex;
		flex-wrap: wrap;
	}
	
	#fieldlist label {
		width: 100%;
		display: block;
		padding-bottom: .3em;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 12px;
		color: #444;
	}
	
	#fieldlist li.status {
		text-align: center;
	}
	
	#fieldlist li .k-widget:not(.k-tooltip),
	#fieldlist li .k-textbox {
		margin: 0 5px 5px 0;
	}
	.confirm {
		padding-top: 1em;
	}
	
	.valid {
		color: green;
	}
	
	.invalid {
		color: red;
	}
	#fieldlist li input[type="checkbox"] {
		margin: 0 5px 0 0;
	}
	
	span.k-widget.k-tooltip-validation {
		display; inline-block;
		width: 160px;
		text-align: left;
		border: 0;
		padding: 0;
		margin: 0;
		background: none;
		box-shadow: none;
		color: red;
	}
	
	.k-tooltip-validation .k-warning {
		display: none;
	}
</style>
<link rel="stylesheet" type="text/css" href="fancybox/dist/jquery.fancybox.css">
</head>

<body>
	

<div class="container-fluid">
	<div class="row" style="background: #485668; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">
					<input type="hidden" id="id_area" name="id_area" value="<?php echo $id_area_Ini; ?>"></input> 	
					<input type="hidden" id="id_fenomeno" name="id_fenomeno" value="<?php echo $id_fenomeno_Ini; ?>"></input> 	
					
			<table style="width:100%" border=0>
			  <tr>	<th></th></tr>
			  <tr>
			  <td><h4 style="text-align:left;"		><?php echo $area_Ini; ?></td>
			  <td><h4 style="text-align:center;"	><?php echo  $fenomeno_Ini; ?></td>
			  <td><h4 style="text-align:right;"		><?php echo @$id_impacto_diario; ?></h4></td>
			  </tr>
			</table>	
			
		</div>
	</div>
</div>

<br>
<div class="container-fluid" >


<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Informe de Impacto</a></li>
    <li><a data-toggle="tab" href="#menu1" onclick="mapaRefresh();">Mapa de Pronóstico</a></li>
	<li id="pnum"><a data-toggle="tab" href="#menu2">Pronóstico Numerico</a></li>
  </ul>

<div class="tab-content">
<div id="home" class="tab-pane fade in active">
<!-- INICIO DE LA FICHA DE INGRESO -->

<!-- ####################################################################################### -->
<!-- DATOS GENERALES DEL INFORME -->
<div id="datosGenerales" class="row" style="background: #ededf0">
      	<div class="col-md-12" style="background:#7D7D7D;">
      		<div class="row" style="text-align: center; color:#FFFFFF;">

			<table style="width:100%" border=0>
			  <tr>	<th></th></tr>
			  <tr>
			  <td><h5 style="margin-left:5px;	text-align:left;font-weight: bold;"	>DATOS GENERALES DEL INFORME			</h5></td>
			  <td><h5 style="margin-left:-5px;	text-align:center;"					>Informe No. <?php echo $correlativo;?>	</h5></td>
			  <td><h5 style="margin-right:5px;	text-align:right;"					>Estado:<span id="estado_impacto"><?php echo $estado_impacto;?></span></h5></td>
			  </tr>
			</table>				

      		</div>
      	</div>
<form id="formGeneral" name="formGeneral" action="MeteorologiaProcesos.php" method="post" enctype="multipart/form-data">

		<div class="col-md-12">
			<label>Titulo</label>  
			<input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ingrese un titulo" required data-required-msg="Ingrese un titulo para los datos generales del informe de impacto"/>
		</div>
 
		<div class="col-md-9">
			<label>Descripción</label>  
			<textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese descripción" required data-required-msg="Ingrese la descripción del informe de impacto"></textarea>  
		</div>
		
		<div class="col-md-3">
			<label>Periodo</label> 
			<select name="periodo" id="periodo" class="form-control" placeholder="Ingrese periodo" required data-required-msg="Ingrese el periodo">
			<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
			<?php echo $periodo; ?>
			</select>
		</div>

	<div class="col-md-12" >
		<div class="col-md-9" id="MensajeGuardado">

		</div> 
		<div class="col-md-3" align="right">
			<input type="hidden" name="id_impacto_diario" id="id_impacto_diario"></input> 
			<input type="hidden" id="registrar" name="registrar" value="registrar"></input> 
			<input type="button" name="GuardarGeneral" id="GuardarGeneral" value="Guardar Datos Generales" class="btn btn-primary" /> </input> 
		</div> 
	</div> 
</form>
</div>
<p></p>



<!-- ####################################################################################### -->
<!-- Información de Municipios y sus Impactos -->
<div id="infoMunicipios" class="row" style="display: none;">
	<div class="row">
		<div class="col-md-12" style="text-align: center; color:#FFFFFF; background:#a7a7a7;">
			<h5 style="font-weight: bold;">Información de Municipios y sus Impactos</h5> 
		</div>
	</div>

<form id="formMunicipios" name="formMunicipios" action="MeteorologiaProcesos.php" method="post" enctype="multipart/form-data">
	<!--<form method="post" id="insert_data">-->
		<div class="col-md-6"><p></p>
			<!-- <label>Tipo de selección</label> -->
			<label>Tipo de selección</label>
			<select name="tipo_zona_dpto" id="tipo_zona_dpto" class="form-control action" placeholder="Ingrese tipo" required data-required-msg="Ingrese el tipo">
				<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
				<?php echo $tipo_zona_dpto; ?>
			</select>
			<p></p>
			
			<label>Departamento / Zona</label>
			<select name="zona_dpto" id="zona_dpto" class="form-control action" placeholder="Ingrese el departamento o la zona" required data-required-msg="Ingrese el departamento o la zona"> 
				
			</select>
			
			<select name="municipio" id="municipio" multiple class="form-control">
			</select>
			<p></p>
		</div>
		<p></p>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
						<label>Impacto</label>    
						<select name="impacto" id="impacto" class="form-control" placeholder="Ingrese el impacto" required data-required-msg="Ingrese el impacto">
						<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
						<?php echo $ImpactoFenomeno; ?>
						</select>
				</div>	
		
				<div class="col-md-6">
						<label>Probabilidad</label>    
						<select name="probabilidad" id="probabilidad" class="form-control" placeholder="Ingrese la probabilidad " required data-required-msg="Ingrese la probabilidad">
						<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
						<?php echo $Probabilidad; ?>
						</select>
				</div>
			</div>
				
			<div class="row"><p></p>
				<div class="col-md-12">
					<input type="hidden" name="filter" id="filter" value="0000" class="form-control k-invalid" data-required-msg="filter" aria-invalid="true" >
					<input type="hidden" name="id_impacto_diario_m" id="id_impacto_diario_m" value="50" class="form-control k-invalid" required="" data-required-msg="id_impacto_diario_m" aria-invalid="true">
					<input type="hidden" name="id_categoria" id="id_categoria" class="form-control k-invalid" required="" data-required-msg="id_categoria" aria-invalid="true">
					<input type="hidden" name="id_color" id="id_color" class="form-control k-invalid" required="" data-required-msg="id_color" aria-invalid="true">
					<input type="hidden" name="id_impacto_probabilidad" id="id_impacto_probabilidad" class="form-control k-invalid" data-required-msg="filter" aria-invalid="true" >					
					<textarea name="categoria" id="categoria" class="form-control" style="font-size: 11pt;font-weight: bold"></textarea>
				</div>	
			</div>	

			<div class="row"><p></p>
				<div class="col-md-8">
					<label>Consecuencias a afectar</label>
			
					<div id="ConteConsecuencias" class="form-check" placeholder="Ingrese" required data-required-msg="Ingrese" style="width: 100%; height: 100%;">
			
					</div>
			
				</div>	
				
				<div class="col-md-4">
					<label>Horario</label> 
					<div id="contenedorHorario" class="form-check" style="background: #FFFFFF" placeholder="Ingrese horario" required data-required-msg="Ingrese horario">
						<label>
						<ul style="color:#4F7C91;">
							<?php                                  
							while ($rowHorario = pg_fetch_array($resultHorario, null, PGSQL_ASSOC)) {
							echo "<div class='checkbox'><input name='datosh[]' type='checkbox' value=".$rowHorario['id_horario']." >".$rowHorario['horario']."</div>";
					
						} 
						pg_free_result($resultHorario);              
						?>    
						<div class='checkbox'><input class='group2' name='datosh[]' type='checkbox' value="5" onClick='todoElDia()'>Todo el día</div>
						</ul>
						</label>
					</div>
					<div>
						<!--<input type="hidden" name="hidden_municipio" id="hidden_municipio" />-->
						<input type="submit" name="insert" id="action" class="btn btn-primary" value="Agregar Municipios" />
					</div>
				</div>	
			</div>			
		</div>
	</form>

	<p></p>

</div>
	<!--<div id="verMunicipios" class="row" style="display: none;">-->
	<div id="verMunicipios" class="row" >
		<div class="col-md-12">
		</div>
	</div>
</div>
<!-- FIN DE LA FICHA DE INGRESO -->
  
    <div id="menu1" class="tab-pane fade">
		<!--
		<div class="row" style="background: #4F7C91;">
			<div class="col-md-12" style="text-align: center; color:white;" >
			<h4>Mapa de Pronóstico de Impacto</h4>
			</div>
		</div>  -->

		<div class="row" class="mi_target" id= "mi_target" style="background: #FFFFFF;">
			<!-- CONTENIDO AQUI -->
		</div>  
    </div>
	
    <div id="menu2" class="tab-pane fade">
		<!--<h3>Apoyo a pronostico</h3>-->
		<div class="row" style="background: #4F7C91;">
			<div class="col-md-12" style="text-align: center; color:white;" >
			<h4>Pronóstico Numerico</h4>
			</div>
		</div>  

		<div class="row" class="mi_target" id= "mi_pronostico" style="background: #FFFFFF;">
			<!-- CONTENIDO AQUI -->
			<iframe id='prono_ivan' width='100%' height='1700px' scrolling='no' frameBorder='0' src='http://srt.marn.gob.sv/web/geotiff/map.php' ></iframe>
			<!-- CONTENIDO AQUI -->
		</div>  
    </div>	

  </div>


<script>


/***************************************/
/* FUNCIONES IVAN MORAN */
/***************************************/
/* getnoMuni(<?php echo $id_impacto_diario; ?>);
// mi_mapa(<?php echo $id_impacto_diario; ?>);
// toggle_visibility('infoMunicipios');
// addContent(<?php echo $id_impacto_diario; ?>);*/

// ConteConsecuencias
// contenedorHorario
function validaCon(name) {

	if($("#err" + name).length != 0) {
		$("#err" + name).remove();
	}	
	if(jQuery("#"+name+" input[type=checkbox]:checked").length >=1) {
		$("#"+name).after("<div id='err"+name+"' style='text-align:center;color:red;'></div>");
		vali = true;
		} 
	else {
		$("#"+name).after("<div id='err"+name+"' style='text-align:center;color:red;'>SELECCIONA UN VALOR</div>");
		vali = false;
		}
	return vali;
}


// Funcion encargada de mostrar el mapa con los municipios seleccionados
function mi_mapa(va){
	var id_impacto_diario = parseInt($('#id_impacto_diario_m').val());
	if (id_impacto_diario != '') {
		var data = "<iframe id='mapa_ivan' width='100%' height='900px' scrolling='no' frameBorder='0' src='mapa_individual_ver.php?id="+va+"' ></iframe>";
		$('#mi_target').html(data);
	}
}

function mapaRefresh(){
	var id_impacto_diario = parseInt($('#id_impacto_diario_m').val());
	if (id_impacto_diario != '') {
		// console.log(id_impacto_diario);
		var data = "<iframe id='mapa_ivan' width='100%' height='900px' scrolling='no' frameBorder='0' src='mapa_individual_ver.php?id="+id_impacto_diario+"' ></iframe>";
		$('#mi_target').html(data);
	}
}

function ediContent(va) {
	//$("#id_idiario_det").val(va);
	var area = $('#id_area').val();
	var midata = {id:va};
    $.ajax({
		async : true,
		method: "GET",
		url: "editCurMuni.php",
		data: midata,
		success: function(msg){
			$("#curMuni").html(msg);
       }
     });	
	// Agregar un ajax que traida todo
	toggle_visibility("loading-div-popup-form");
	// console.log(va);
	// console.log($("#id_idiario_det").val(va));
}

function ShowProgressAnimation() {
	$("#loading-div-background").show();
}

function HideProgressAnimation() {
	$("#loading-div-background").hide();
}

function explode(){
  // ShowProgressAnimation();
  updateMuni($('#zona_dpto').val());
}

function refresh(){
  updateMuni($('#zona_dpto').val());
}
// setTimeout(explode, 1000);

// ------------------------------------------
// ACTUALIZAR LISTA DE MUNICIPIOS SELECCIONADOS //
function addContent(va) {
    $.ajax({
		async : true,
		method: "GET",
		url: "muni.php",
		data: "id="+va,
		success: function(msg){
			$("#verMunicipios").html(msg);
       }
     });	
	 // mi_mapa(va);
	 // refresh();
}

// ------------------------------------------
// ACTUALIZAR LISTA DE MUNICIPIOS YA SELECCIONADOS //	
function getnoMuni(va) {
	$.ajax({
		url:'MeteorologiaProcesos.php',
		method:"POST",
		data: {id:va, opcion:'getnoMuni'},
		success:function(data){
			var obj = jQuery.parseJSON(data);
			$("#filter").val(obj);
			refresh();
			$('#action').prop('disabled', false);
			HideProgressAnimation();
			// console.log(filter);
			}
		});
}

// ------------------------------------------
// ACTUALIZAR LISTA DE MENU DE MUNICIPIOS //	
function updateMuni(query) {
		var action = "zona_dpto";
		if (query == "" ) { query = "Ahuachapán" };
		var resultZonaDpto = 'municipio';
		var nomuni = String($("#filter").val());

		$.ajax({
			url:'MeteorologiaProcesos.php',
			method:"POST",
			data:{action:action, query:query, nomuni:nomuni},
			success:function(data){
				$('#'+resultZonaDpto).html(data);
				if(resultZonaDpto == 'municipio'){
					// console.log("MUNICIPIO"+data);
					$('#municipio').val();
					$('#municipio').data('plugin_lwMultiSelect').updateList();
				}
			}
		});
}

// ------------------------------------------
// BORRAR MUNICIPIOS DE MENU DE MUNICIPIOS //
function delContent(va){
	ShowProgressAnimation();
	// data = {id:va, opcion:'deleteContent'};
	$.ajax({
		url:'MeteorologiaProcesos.php',
		method:"POST",
		data: {id:va, opcion:'deleteContent'},
		success:function(data){
			// alert (categoria);	
			// console.log(JSON.stringify(categoria));
			// console.log(data);
			addContent($('#id_impacto_diario_m').val());
			getnoMuni($('#id_impacto_diario_m').val());
			document.getElementById("msg_text").innerHTML = "Municipio Borrado Correctamente";
			// setTimeout(explode, 500);
			}
		});
}
// ------------------------------------------
// FUNCION PARA OCULTAR Y MOSTRAR ELEMENTOS DIVS
function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(e.style.display == 'none')
		e.style.display = 'block';
	else
		e.style.display = 'none';
}

// ------------------------------------------
// FUNCION PARA INDICAR QUE UNA TAREA SE HIZO CORRECTAMENTE
$(document).ready(function () {
	$(".loading-div-background").css({ opacity: 0.8 });
	
});

/*
function myFunction(va) {
	$("#id_idiario_det").val(va);
	toggle_visibility("loading-div-popup-form");
	// console.log(va);
	// console.log($("#id_idiario_det").val(va));
}
*/

$(document).ready(function(){

window.onbeforeunload = function() {
    return "¿Esta seguro que quiere salir de esta pagina?";
}


/***************************************/
/* FIN FUNCIONES IVAN MORAN */
/***************************************/

//--------------------------------------------------------
//--------------------------------------------------------
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
//--------------------------------------------------------
//--------------------------------------------------------
    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

//*************************************-----------------------------------------------------------------------------------
//*************************************-----------------------------------------------------------------------------------
//*************************************----DATOS GENERALES DEL INFORME ------------------------------------------
//*************************************-----------------------------------------------------------------------------------
//*************************************-----------------------------------------------------------------------------------


$(function() {
	var validator = $("#formGeneral").kendoValidator({
		rules: {
			verifySelect: function(input){
			var ret = true;
				if (input.is("[class=requerido]")) {
					ret = input.val() >=1;
				}
			return ret;
			}
		},
		messages: {
		verifySelect: "Seleccione una opción"
		}
	}).data("kendoValidator"),
	status = $(".status");
                            
                
$("#GuardarGeneral").on("click", function(){
	if (validator.validate()) {
		// alert(document.forms["formGeneral"].submit();
		$.ajax({
			url:'MeteorologiaProcesos.php',
			method:"POST",
			data:{registrar: 'registrar', id_area:<?php echo $id_area_Ini; ?>, id_fenomeno:<?php echo $id_fenomeno_Ini; ?>, correlativo:<?php echo $correlativo; ?>, titulo:$("#titulo").val(), descripcion:$("#descripcion").val(), periodo:$("#periodo").val(), id_estado_impacto:$("#id_estado_impacto").val(), ImpactoFenomeno:$("#ImpactoFenomeno").val(),fecha_ini:$("#fecha_ini").val(),fecha_fin:$("#fecha_fin").val()},
			success:function(data){
				// console.log(data);
				document.getElementById("estado_impacto").innerHTML = "En Proceso";
				document.getElementById("MensajeGuardado").innerHTML = "Los registros fueron guardados correctamente, inicie asignación de municipios pronosticando sus impactos.";

				$('#formGeneral').find('input, textarea, button, select').attr('disabled','disabled');
				toggle_visibility('infoMunicipios');
			}
		}).done(function(con){
			var obj = jQuery.parseJSON(con);
			var id_impacto = obj['currval'];
			$("#id_impacto_diario_m").val(id_impacto);
			$("#id_impacto_diario").val(id_impacto);
			mi_mapa(id_impacto);
			// console.log(id_impacto_diario);
		});
	} 
	else {
		status.text("Los registros a guardar no son validos")
		.removeClass("valid")
		.addClass("invalid");
	}
return false;
});
                
//--------------------------------------------------------
//--------------------------------------------------------
// --- FUNCION FECHA ACTUAL
function setInputDateIni(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
		d = hoy.getDate(),
		m = hoy.getMonth()+1, 
		y = hoy.getFullYear(),
		data;

    if(d < 10){ d = "0"+d; };
    if(m < 10){ m = "0"+m; };

    data = y+"-"+m+"-"+d;
    _dat.value = data;
    // console.log(data);
};

// setInputDateIni("#fecha_ini");

//--------------------------------------------------------
//--------------------------------------------------------
// --- FUNCION FECHA ACTUAL + 1

function setInputDateFin(_id){
	var _dat = document.querySelector(_id);
    var hoy = new Date(),
		d = hoy.getDate()+1,
        m = hoy.getMonth()+1, 
        y = hoy.getFullYear(),
        data;
    if(d < 10){
		d = "0"+d;
    };
    if(m < 10){
		m = "0"+m;
    };

    data = y+"-"+m+"-"+d;
    // console.log(data);
    _dat.value = data;
};

// setInputDateFin("#fecha_fin");

});

//*************************************-----------------------------------------------------------------------------------
//*************************************-----------------------------------------------------------------------------------
//*************************************-----------------------------------------------------------------------------------
//*************************************-----------------------------------------------------------------------------------

// $(function() {
	
var validator = $("#formMunicipios").kendoValidator({
	rules: {
		verifySelect: function(input){
			var ret = true;
				if (input.is("[class=requerido]")) {
					ret = input.val() >=1;
				}
			return ret;
		}
		},
	messages: { verifySelect: "Seleccione una opción" }
}).data("kendoValidator"),
status = $(".status");


// ***************************************************************************
// Seleccionar Menu Municipios
// ***************************************************************************
$('#municipio').lwMultiSelect();
$('.action').change(function(){
	if($(this).val() != ''){
	
		var action = $(this).attr("id");
		var query = $(this).val();
		var resultZonaDpto = '';
		// console.log("action:"+action);
		// console.log("query:"+$(this).val());
		if(action == 'tipo_zona_dpto'){
			resultZonaDpto = 'zona_dpto';
		}
		else {
			resultZonaDpto = 'municipio';
		}
		
		var id_area =  $('#id_area').val();
		// console.log(id_area);
		
		var nomuni = String($("#filter").val());
		getnoMuni($('#id_impacto_diario_m').val());
		addContent($('#id_impacto_diario_m').val());
		/* setTimeout(refresh, 800); */

		// console.log("filter1:"+filter);
		// console.log("filter2:"+nomuni);
		// console.log("resultZonaDpto:"+resultZonaDpto);
		$.ajax({
			url:'MeteorologiaProcesos.php',
			method:"POST",
			data:{action:action, query:query, nomuni:nomuni, id_area:id_area},
			success:function(data){
				$('#'+resultZonaDpto).html(data);
				// console.log($('#'+resultZonaDpto).html(data));
				if(resultZonaDpto == 'municipio'){
					// console.log("MUNICIPIO"+data);
					$('#municipio').val();
					$('#municipio').data('plugin_lwMultiSelect').updateList();
				}
			}
		})
	}
});


/*****************************************************/
// Formulario
/*****************************************************/
	$('#formMunicipios').on('submit', function(event){
	event.preventDefault();
	// ConteConsecuencias
	// contenedorHorario
	if(validaCon('ConteConsecuencias')==false)  { return;}
	if(validaCon('contenedorHorario')==false) 	{ return;}	
	
	$('#action').prop('disabled', true);
	ShowProgressAnimation();
	
		if($('#tipo_zona_dpto').val() == ''){
			alert("Please Select Country");
			$('#action').prop('disabled', false);
			HideProgressAnimation();
			return false;
		}
		else if($('#zona_dpto').val() == ''){
			alert("Please Select State");
			$('#action').prop('disabled', false);
			HideProgressAnimation();
			return false;
		}
		else if($('#municipio').val() == ''){
			alert("Seleccione un Municipio");
			$('#action').prop('disabled', false);
			HideProgressAnimation();
			return false;
		}
		else {
			var AgregarMuni ='AgregarMuni';

			$('#municipio').val($('#municipio').val());
			var formMunicipios = $(this).serialize();
			// console.log(formMunicipios);

			$.ajax({
				url:"MeteorologiaProcesos.php",
				method:"POST",
				data:{formMuni:formMunicipios, opcion:'insertContent'},
				success:function(data) {
				console.log(data);
				var id_imp = $('#id_impacto_diario_m').val();
				addContent(id_imp);
				getnoMuni($('#id_impacto_diario_m').val());
				}
			});
			
			
		}
	});

	// COLOREA POR IMPACTO -----------------------------------
	$('#impacto').change(function() {
		var id_area = $("#id_area").val();
		var id_fenomeno = $("#id_fenomeno").val();
		var probabilidad = $("#probabilidad").val();
		var impacto = $(this).val();
		
		$.ajax({
			url: "MeteorologiaProcesos.php",
			type: "GET",
			data: {id_area:id_area,id_fenomeno:id_fenomeno,impacto:impacto, opt:'consecuencias'},
			}).done(function(con){
				var obj = jQuery.parseJSON(con);
				var size = Object.keys(obj).length;
				var varCons='';
				for (var i = 0; i < size ; i++) {
					varCons +="<div class='checkbox'><input checked='checked' name='datos[]' type='checkbox' value="+obj[i]['id_consecuencia']+" >"+obj[i]['consecuencia']+"</div>";
				}
				if (varCons.length==0){
					varCons +="<div class='checkbox' style='align:center;color:red;'>NO HAY ELEMENTOS ASIGNADOS</div>";
					$('#action').prop('disabled',true);
				}; /******************************************************************************/
				document.getElementById("ConteConsecuencias").innerHTML = varCons;
				if(probabilidad != ''){
					$.ajax({
						url:'MeteorologiaProcesos.php',
						method:"GET",
						data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
						success:function(categoria){
							// console.log(categoria);
							var cat = jQuery.parseJSON(categoria);
							$('#id_color').val(cat['id_color']);
							$('#categoria').val(cat['categoria']);
							$('#id_categoria').val(cat['id_categoria']);
							$('#id_impacto_probabilidad').val(cat['id_impacto_probabilidad']);
							if (cat['id_color'] == 1){ $('#categoria').css("background-color" , "rgba(63, 195, 128, 1)");	/*Verde*/ 		}
							if (cat['id_color'] == 2){ $('#categoria').css("background-color" , "rgba(254, 241, 96, 1)");	/*Amarillo*/	}
							if (cat['id_color'] == 3){	$('#categoria').css("background-color" , "rgba(252, 185, 65, 1)");	/*Anaranjado*/	}
							if (cat['id_color'] == 4){	$('#categoria').css("background-color" , "rgba(240, 52, 52, 1)"); 	/*Rojo*/		}
						}
					});
				}
			
			});
	});
	
	// COLOREA POR PROBABILIDAD -----------------------------------
	$('#probabilidad').change(function() {
		var impacto = $("#impacto").val();
		var probabilidad = $(this).val();
		if(impacto != ''){
			$.ajax({
				url:'MeteorologiaProcesos.php',
				method:"GET",
				data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
				success:function(categoria){
					var cat = jQuery.parseJSON(categoria);
					$('#id_color').val(cat['id_color']);
					$('#categoria').val(cat['categoria']);
					$('#id_categoria').val(cat['id_categoria']);
					$('#id_impacto_probabilidad').val(cat['id_impacto_probabilidad']);
					if (cat['id_color'] == 1){ $('#categoria').css("background-color" , "rgba(63, 195, 128, 1)");	/*Verde*/ 		}
					if (cat['id_color'] == 2){ $('#categoria').css("background-color" , "rgba(254, 241, 96, 1)");	/*Amarillo*/	}
					if (cat['id_color'] == 3){ $('#categoria').css("background-color" , "rgba(252, 185, 65, 1)");	/*Anaranjado*/	}
					if (cat['id_color'] == 4){ $('#categoria').css("background-color" , "rgba(240, 52, 52, 1)"); 	/*Rojo*/		}
				}
			});
		}				  
	});

	// });
});

function todoElDia() {
if($("input.group2").is(":checked") == true){
	$("input.group1").prop("disabled", true);
	// console.log('DESABILITADO');
}
else 
	$("input.group1").prop("disabled", false);
	// console.log('HABILITADO');
}
</script>
<div id="loading-div-background" class="loading-div-background" style="display: none;">
	<div class="ui-corner-all loading-div" id="loading-div" >
		<p><br><br></p>
		<img alt="Loading.." src="Imagenes/loading.gif" style="height: 30px; margin: 30px;">
		<!--<h2 id="msg_text" style="color: white; font-weight: normal;">Municipios Agregados Correctamente</h2>-->
		<!--<button id="Button1" onclick="(HideProgressAnimation(), refresh())">Aceptar</button>-->
	</div>
</div>

<div id="loading-div-popup-form" class="loading-div-background-form" style="display: none;">
	<div class="ui-corner-all loading-div-form" id="loading-div-form" >
	<div><br></div>
	<div id="curMuni">
		<!-- CONTENIDO DE MUNICIPIO SELECCIONADO -->
	</div>
	</div>
</div>

</body>
</html>