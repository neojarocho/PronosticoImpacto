<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];
$area_Ini = $_REQUEST['area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];
$fenomeno_Ini = $_REQUEST['fenomeno'];
//var_dump($_REQUEST); echo('algo');
//exit();

//// COMBO PERIODO
$periodo = '';
$SqlPeriodo="SELECT id_periodo, periodo FROM public.periodo_impacto;";
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

foreach($resultImpactoFenomeno  as $row)
{
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

foreach($resultZonaDpto as $row)
{
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

		<script src="jquery.lwMultiSelect.js"></script>
		<link rel="stylesheet" href="jquery.lwMultiSelect.css" />

		<script src="js/kendo.all.min.js" type="text/javascript"></script>
		<script src="js/kendo.aspnetmvc.min.js" type="text/javascript"></script>
		<script src="js/kendo.culture.es-SV.min.js" type="text/javascript"></script>

<style type="text/css">
.btn-sq {
	width: 100% !important;
	height: 100px !important;
}

.loading-div-background {
        display:none;
        position:fixed;
        top:0;
        left:0;
        background:black;
        width:100%;
        height:100%;
}
.loading-div {
         width: 300px;
         height: 200px;
         background-color: rgba(255, 255, 255, 1);
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
        background:rgba(0,0,0,0.5);
        width:100%;
        height:100%;
}

.loading-div-form {
         width: 700px;
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
</style>
<link rel="stylesheet" type="text/css" href="fancybox/dist/jquery.fancybox.css">
</head>

<body>
	

<div class="container-fluid">

	<div class="row" style="background: #5DADE2; color:#ffffff; font: cursive;">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-1" style="text-align: right;">
					<label><h4 class="glyphicon glyphicon-tint"></h4></label>
				</div>
				<div class="col-md-11">
					<input type="hidden" id="id_area" name="id_area" value="<?php echo $id_area_Ini; ?>"></input> 	
					<label id="area"><h4><?php echo $area_Ini; ?></h4></label>
				</div>					
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-1" style="text-align: center;">
					<label><h4 class="glyphicon glyphicon-flash"></h4></label>
				</div>
				<div class="col-md-11" style="text-align: left;">
					<input type="hidden" id="id_fenomeno" name="id_fenomeno" value="<?php echo $id_fenomeno_Ini; ?>"></input> 	
					<label id="fenomeno"><h4><?php echo  $fenomeno_Ini; ?></h4></label>
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

<!-- ####################################################################################### -->
<!-- DATOS GENERALES DEL INFORME -->
<div id="datosGenerales" class="row" style="background: #ededf0">
<form id="formGeneral" name="formGeneral" action="MeteorologiaProcesos.php" method="post" enctype="multipart/form-data">
      	<div class="col-md-12" style="background:#7D7D7D;">
      		<div class="row" style="text-align: center; color:#FFFFFF;">
      			<div class="col-md-4" style="text-align: left;">
      				<h5 style="font-weight: bold;">DATOS GENERALES DEL INFORME</h5> 
      			</div>
      			<div class="col-md-4">
      				<label id="correlativo"><h5>Informe No. <?php echo $correlativo;?></h5></label> 
      			</div>
      			<div class="col-md-4">
      				<label id='estado_impacto'><h5>Estado:<?php echo $estado_impacto;?></h5></label> 
      			</div>
      		</div>
      	</div>

		<div class="col-md-12">
			<label>Titulo</label>  
			<input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ingrese un titulo" required data-required-msg="Ingrese un titulo para los datos generales del informe de impacto"/>
		</div>
 
		<div class="col-md-3">
			<label>Periodo</label> 
			<select name="periodo" id="periodo" class="form-control" placeholder="Ingrese periodo" required data-required-msg="Ingrese el periodo">
			<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
			<?php echo $periodo; ?>
			</select>
		</div>

		<div class="col-md-3">
			<label>Impacto del fenomeno</label> 
			<select name="ImpactoFenomeno" id="ImpactoFenomeno" class="form-control" placeholder="Ingrese impacto" required data-required-msg="Ingrese el impacto del fenomeno">
			<option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
			<?php echo $ImpactoFenomeno; ?>
			</select>
		</div>
	
		<div class="col-md-3">			      			
			<label>Fecha Inicia</label> 
			<input type="date" id="fecha_ini" name="fecha_ini" class="form-control" required data-required-msg="Ingrese fecha de inicio"> </input> 
		</div> 

		<div class="col-md-3">
			<label>Fecha Finaliza</label>
			<input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required data-required-msg="Ingrese fecha de finalización"></input> 
		</div> 

		<div class="col-md-12">
			<label>Descripción</label>  
			<textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese descripción" required data-required-msg="Ingrese la descripción del informe de impacto"></textarea>  
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
					<input type="text" name="filter" id="filter" value="0000" class="form-control k-invalid" data-required-msg="filter" aria-invalid="true" >
					<input type="text" name="id_impacto_diario_m" id="id_impacto_diario_m" value="50" class="form-control k-invalid" required="" data-required-msg="id_impacto_diario_m" aria-invalid="true">
					<input type="hidden" name="id_categoria" id="id_categoria" class="form-control k-invalid" required="" data-required-msg="id_categoria" aria-invalid="true">
					<input type="hidden" name="id_color" id="id_color" class="form-control k-invalid" required="" data-required-msg="id_color" aria-invalid="true">
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
							echo "<div class='checkbox'><input name='datosh[]' type='checkbox' value=".$rowHorario['id_horario'].">".$rowHorario['horario']."</div>";
					
						} 
						pg_free_result($resultHorario);              
						?>    
						</ul>
						</label>
					</div>
					<div>
						<!--<input type="hidden" name="hidden_municipio" id="hidden_municipio" />-->
						<input type="submit" name="insert" id="action" class="btn btn-info" value="Agregar Municipios" />
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
	<h3>Apoyo a pronostico</h3>
	<div class="row" style="background: #4F7C91;">
		<div class="col-md-12" style="text-align: center; color:white;" >
		<h4>Apoyo para diagnostico</h4>
		</div>
	</div>  

	<div class="row" class="mi_target" style="background: #CFDEE2;">
		<div class="col-md-12" style="margin-top: 10px; height:100%;">
		<iframe width="100%" height="622px" src="mapa_alertas.php?id=3"></iframe>
		</div>
	</div>  
    </div>

  </div>


<script>


/***************************************/
/* FUNCIONES IVAN */
/***************************************/

function ShowProgressAnimation() {
	$("#loading-div-background").show();
}

function HideProgressAnimation() {
	$("#loading-div-background").hide();
}

function explode(){
  // alert("Municipios Agregados");
  ShowProgressAnimation();
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
			console.log(filter);
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
function deleteContent(va){
// alert (va);	

	// data = {id:va, opcion:'deleteContent'};
	$.ajax({
		url:'MeteorologiaProcesos.php',
		method:"POST",
		data: {id:va, opcion:'deleteContent'},
		success:function(data){
			//alert (categoria);	
			// console.log(JSON.stringify(categoria));
			console.log(data);
			addContent($('#id_impacto_diario_m').val());
			getnoMuni($('#id_impacto_diario_m').val());
			document.getElementById("msg_text").innerHTML = "Municipio Borrado Correctamente";
			setTimeout(explode, 500);
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


function myFunction(va) {
	$("#id_idiario_det").val(va);
	toggle_visibility("loading-div-popup-form");
	console.log(va);
	console.log($("#id_idiario_det").val(va));
}


$(document).ready(function(){

window.onbeforeunload = function() {
    return "¿Esta seguro que quiere salir de esta pagina?";
}

/***************************************/
/* FIN FUNCIONES IVAN */
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
				$("#id_impacto_diario").val(data);
				document.getElementById("estado_impacto").innerHTML = "En Proceso";
				document.getElementById("MensajeGuardado").innerHTML = "Los registros fueron guardados correctamente, inicie asignación de municipios pronosticando sus impactos.";

				$('#formGeneral').find('input, textarea, button, select').attr('disabled','disabled');
				toggle_visibility('infoMunicipios');
			}
		}).done(function(con){
			var obj = jQuery.parseJSON(con);
			var id_impacto = obj['currval'];
			$("#id_impacto_diario_m").val(id_impacto);
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

setInputDateIni("#fecha_ini");

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

setInputDateFin("#fecha_fin");
	
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
		
		var nomuni = String($("#filter").val());
		getnoMuni($('#id_impacto_diario_m').val());
		addContent($('#id_impacto_diario_m').val());
		setTimeout(refresh, 800);

		// console.log("filter1:"+filter);
		// console.log("filter2:"+nomuni);
		// console.log("resultZonaDpto:"+resultZonaDpto);
		$.ajax({
			url:'MeteorologiaProcesos.php',
			method:"POST",
			data:{action:action, query:query, nomuni:nomuni},
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

		if($('#tipo_zona_dpto').val() == ''){
			alert("Please Select Country");
			return false;
		}
		else if($('#zona_dpto').val() == ''){
			alert("Please Select State");
			return false;
		}
		else if($('#municipio').val() == ''){
			alert("Please Select City");
			return false;
		}
		else {
			// $('#hidden_city').val($('#municipio').val());
			// //$('#action').attr('disabled', 'disabled');
			// var formMunicipios = $('#formMunicipios').serialize();
			var AgregarMuni ='AgregarMuni';


			$('#municipio').val($('#municipio').val());
			//$('#action').attr('disabled', 'disabled');
			var formMunicipios = $(this).serialize();
			// var formMunicipios = $(this);
			// console.log('********************');
			// console.log(formMunicipios);
			// console.log('********************');

			$.ajax({
				url:"MeteorologiaProcesos.php",
				method:"POST",
				data:{formMuni:formMunicipios},
				success:function(data) {
				// $('#action').attr("disabled", "disabled");
				// alert('Entro al boton');
				// console.log(data);
				var id_imp = $('#id_impacto_diario_m').val();
				addContent(id_imp);
				getnoMuni($('#id_impacto_diario_m').val());
				document.getElementById("msg_text").innerHTML = "Municipios Agregados Correctamente";
				setTimeout(explode, 500);
				if(data == 'done') {
					// upContent($('#zona_dpto').val());
					// alert('Data Inserted');
					// $('#municipio').html('');
					// $('#municipio').data('plugin_lwMultiSelect').updateList();
					// $('#municipio').data('plugin_lwMultiSelect').removeAll();
					// $('#insert_data')[0].reset();
				}
				}
			});
		}
	});

	// FUNCION PARA IMPACTO Y PROBABILIDAD QUE COLOREA -----------------------------------
	$('#impacto').change(function() {
	// alert ('Entro en impacto');
	var id_area = $("#id_area").val();
	var id_fenomeno = $("#id_fenomeno").val();
	var probabilidad = $("#probabilidad").val();
	var impacto = $(this).val();
	consecuencias = {id_area:id_area,id_fenomeno:id_fenomeno,impacto:impacto,consecuencias:'consecuencias'};
	$.ajax({
		url: "MeteorologiaProcesos.php",
		type: "POST",
		data: consecuencias
	}).done(function(con){
	//alert (consecuencias);	
	var obj = jQuery.parseJSON(con);
	var id_consecuencia_impacto = obj['id_consecuencia_impacto'];
	var consecuencia = obj[0]['consecuencia'];
	// console.log(obj);

	varCons='';
	var size = Object.keys(obj).length;
	// console.log(size);

	for (var i = 0; i < size ; i++) {
		varCons +="<div class='checkbox'><input checked='checked' name='datos[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+">"+obj[i]['consecuencia']+"</div>";
	}
	// console.log(consecuencia);
	$("#ConteConsecuencias").val(consecuencia);

	document.getElementById("ConteConsecuencias").innerHTML = varCons;

	//CONSULTANDO COLOR SEGUN PROBABILIDAD  -----------------------------------	
	if(probabilidad != ''){
			categoria = {probabilidad:probabilidad,impacto:impacto,categoria:'categoria'};
			$.ajax({
				url: "MeteorologiaProcesos.php",
				type: "POST",
				data: categoria
			}).done(function(categoria){
			//alert (categoria);	
			// console.log(JSON.stringify(categoria));
			var id_color = categoria['id_color'];
			var id_categoria = categoria['id_categoria'];
			var categoria = categoria['categoria'];
			// console.log('**********'+id_categoria+categoria+id_color+'**********');

			$('#categoria').val(categoria);
			$('#id_categoria').val(id_categoria);
			$('#id_color').val(id_color);

			if (id_color == 1){
				$('#categoria').css("background-color" , "rgba(63, 195, 128, 1)");// Verde
			}
			if (id_color == 2){
				$('#categoria').css("background-color" , "rgba(254, 241, 96, 1)");// Amarillo
			}
			if (id_color == 3){
				$('#categoria').css("background-color" , "rgba(252, 185, 65, 1)");// Anaranjado
			}
			if (id_color == 4){
				$('#categoria').css("background-color" , "rgba(240, 52, 52, 1)"); // Rojo
			}
			});
	}
	});

	});
	
	$('#probabilidad').change(function() {
	
	var impacto = $("#impacto").val();
	var probabilidad = $(this).val();
	
	//CONSULTANDO COLOR SEGUN IMPACTO
	if(impacto != ''){

	categoria = {probabilidad:probabilidad,impacto:impacto,categoria:'categoria'};
	$.ajax({
		url: "MeteorologiaProcesos.php",
		type: "POST",
		data: categoria
	}).done(function(categoria){
	//alert (categoria);	
	// console.log(JSON.stringify(categoria));
	var id_color = categoria['id_color'];
	var id_categoria = categoria['id_categoria'];
	var categoria = categoria['categoria'];
	// console.log('**********'+id_categoria+categoria+id_color+'**********');
	
	$('#categoria').val(categoria);
	$('#id_categoria').val(id_categoria);
	$('#id_color').val(id_color);
	
	if (id_color == 1){ 
		$('#categoria').css("background-color" , "rgba(63, 195, 128, 1)");// Verde rgba(123, 239, 178, 1)
	}
	if (id_color == 2){ 		
		$('#categoria').css("background-color" , "rgba(254, 241, 96, 1)");// Amarillo rgba(255, 255, 126, 1)
	}
	if (id_color == 3){
		$('#categoria').css("background-color" , "rgba(252, 185, 65, 1)");// Anaranjado rgba(252, 185, 65, 1)
	}
	if (id_color == 4){
		$('#categoria').css("background-color" , "rgba(240, 52, 52, 1)"); // Rojo rgba(236, 100, 75, 1)
	}
	});
	}
						      
	});


	// });

});

</script>


<div id="loading-div-background" class="loading-div-background" style="opacity: 0.8; display: none;">
	<div class="ui-corner-all loading-div" id="loading-div" >
		<p><br><br></p>
		<!--<img alt="Loading.." src="Imagenes/loading.gif" style="height: 30px; margin: 30px;">-->
		<h2 id="msg_text" style="color: white; font-weight: normal;">Municipios Agregados Correctamente</h2>
		<button id="Button1" onclick="HideProgressAnimation();">Aceptar</button>
	</div>
</div>

<!--
<div id="loading-div-popup-form" class="loading-div-background" style="opacity: 0.8; display: none;">
	<div class="ui-corner-all loading-div" id="loading-div" >
		<p><br><br></p>
		<h2 id="text-popup-form" style="color: white; font-weight: normal;">(Contenido)</h2>
		<button id="Button1" onclick="toggle_visibility('loading-div-popup-form');">Aceptar</button>
	</div>
</div>
-->

<div id="loading-div-popup-form" class="loading-div-background-form" style="display: none;">
	<div class="ui-corner-all loading-div-form" id="loading-div-form" >
	<div><br></div>
	<form id="updateMunicipios" name="updateMunicipios" action="MeteorologiaProcesos.php" method="post" >
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
						<label>Departamnto: <span id="depto" >Ahuachapan</span></label>    
				</div>	
		
				<div class="col-md-6">
						<label>Municipio: Ahuachapan</label>    
				</div>
			</div>
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
			<!-- $("#id_idiario_det").val(va); -->
			<div class="row"><p></p>
				<div class="col-md-12">
					<input type="text" 		name="id_idiario_det"	id="id_idiario_det" 	class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
					<input type="hidden" 	name="id_categoria" 	id="id_categoria_u"		class="form-control k-invalid" required="" data-required-msg="id_categoria" aria-invalid="true">
					<input type="hidden" 	name="id_color" 		id="id_color_u"			class="form-control k-invalid" required="" data-required-msg="id_color" aria-invalid="true">
					<textarea 				name="categoria" 		id="categoria_u"		class="form-control" style="font-size: 11pt;font-weight: bold"></textarea>
				</div>	
			</div>	
			<!------------------------------------>
			<div class="row"><p></p>
				<div class="col-md-8">
					<label>Consecuencias a afectar</label>
					<div id="ConteConsecuencias" class="form-check" placeholder="Ingrese" required data-required-msg="Ingrese" style="width: 100%; height: 100%;">
					</div>
				</div>	
				
				<div class="col-md-4">
					<label>Horario</label> 
					<div id="contenedorHorario" class="form-check" style="background: #FFFFFF" placeholder="Ingrese horario" required data-required-msg="Ingrese horario">
					</div>
				</div>	
			</div>	

			<div>
				<input type="button" name="update" id="update" class="btn btn-info" value="Actualizar" onclick="toggle_visibility('loading-div-popup-form')" />
				<div><br></div>
			</div>
		</div>
	</form>
	</div>
</div>


</body>
</html>

