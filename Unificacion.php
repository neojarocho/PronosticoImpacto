<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
<<<<<<< HEAD
include('database_connection.php');
// include("header.php");
=======

include('database_connection.php');
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3


$id_area_Ini = $_REQUEST['id_area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];

// echo "Area: 		".$id_area_Ini.		"<br>";
// echo "Fenomeno_Ini: ".$id_fenomeno_Ini.	"<br>";

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

// echo "<pre>";
// print_r($Area_Info);
// print_r($Fenomeno_Info);
// echo "</pre>";


//// COMBO PERIODO
$periodo = '';
<<<<<<< HEAD
$SqlPeriodo="SELECT id_periodo, periodo FROM public.periodo_impacto ORDER BY id_periodo;";
=======
$SqlPeriodo="SELECT id_periodo, periodo FROM public.periodo_impacto;";
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
$resultPeriodo=pg_query($connect, $SqlPeriodo);
while($row = pg_fetch_array($resultPeriodo, null, PGSQL_ASSOC)) {
    $TipoPeriodo[] = $row;
} pg_free_result($resultPeriodo);

$resultPeriodo=$TipoPeriodo;

foreach($resultPeriodo as $row)
{
    $periodo .= '<option value="'.$row['id_periodo'].'">'.$row['periodo'].'</option>';
}


$sql="SELECT (SELECT a.area FROM public.area a where id.id_area=a.id_area) as area,
    id.titulo,id.fecha::time as hora
  FROM public.impacto_diario id
    where id.id_fenomeno=1 and id.id_periodo=1 and id.fecha::date='2019-05-28';";
// echo $sql;
// exit();
$result = pg_query($sql) or die('Query failed: '.pg_last_error());

?>


<!DOCTYPE html>
<<<<<<< HEAD
=======

>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
<html lang="en">
<head>
    
    <title>Informe Impacto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/ihover.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.min.js"></script>
-->
	
<<<<<<< HEAD
<!--
	<script src="jquery.lwMultiSelect.js"></script>
    <link rel="stylesheet" href="jquery.lwMultiSelect.css" />
-->
=======
    <!--
	<script src="jquery.lwMultiSelect.js"></script>
    <link rel="stylesheet" href="jquery.lwMultiSelect.css" />
	-->
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
	
	<script src="js/kendo.all.min.js" type="text/javascript"></script>
	<script src="js/kendo.aspnetmvc.min.js" type="text/javascript"></script>
	<script src="js/kendo.culture.es-SV.min.js" type="text/javascript"></script>	

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


<title>Informe</title>
    
<style>
<!-- AGREGA TUS ESTILOS AQUI -->
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

<<<<<<< HEAD

.loading-div-background {
		opacity: 1 !important; 
=======
.loading-div-background {
		// opacity: 0.8; 
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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


<!-- TOGGLE MAP DIV-->
.loading-div-background-map {
        display:none;
        position:fixed;
<<<<<<< HEAD
        top:0;
        left:0;
        // background:rgba(0, 0, 0, 1) !important;
=======
		// opacity: 1;
        top:0;
        left:0;
        background:rgba(0, 0, 0, 1);
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
        width:100%;
        height:100%;
}
.loading-div-map {
<<<<<<< HEAD
         width: 75% !important;
         height: 875px !important;
         background-color: rgba(255, 255, 255, 1) !important;
         text-align:center;
         position:absolute;
         top: 50%;
         left: 50%;
		 transform: translate(-50%, -52%);
         // margin-left:-150px;
         // margin-top: -100px;
}
#editMap {
	background-color: rgba(255, 255, 255, 1);
}
<!-- TOGGLE EDIT DIV-->
.loading-div-background-edit {
        display:none;
        position:fixed;
        top:0;
        left:0;
        // background:rgba(0, 0, 0, 1) !important;
        width:100%;
        height:100%;
}
.loading-div-edit {
         width: 75% !important;
         height: 100% !important;
         background-color: rgba(255, 255, 255, 1) !important;
=======
         width: 600px;
         height: auto;
         background-color: rgba(255, 255, 255, 1);
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
         text-align:center;
         position:absolute;
         top: 50%;
         left: 50%;
		 transform: translate(-50%, -50%);
         // margin-left:-150px;
         // margin-top: -100px;
}
<<<<<<< HEAD
#editUni {
	background-color: rgba(255, 255, 255, 1);
}


=======
.loading-div-map h2 {
	color: black !important;
	font-size: 25px;
}
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
.space {
	margin-top:		2.5px;
	margin-bottom:	2.5px;
}
.col-md-12, .col-md-3 {
	// padding-top: 5px;
}
iframe {
  overflow: hidden !important;
}
#pnum {
	float: right !important;
}
#tablaUni {
	height:auto;
}
</style>

<!-- AGREGA TUS ESTILOS AQUI -->
</style>
</head>
<body>
<div class="container-fluid" id="InfoUnificados">
<form id="formUnificado" name="formUnificado" action="MeteorologiaProcesos.php" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header" style="margin-top:-10px; text-align: center;" >
              <h1 id="titulo" style="color: "><small>Unificación y publicación de informes de pronóstico de impactos</small></h1>
            </div>
        </div>
    </div>
      		
	<div class="row" style="background: #485668; padding: 5px;color:#ffffff">
        
        <div class="col-md-6" style="padding: 10px; text-align: center; display: flex; align-items: center;">
            
            <h4 id="fenomeno"><?php echo $Fenomeno_Info[0]["fenomeno"]; ?></h4> 
			<input type="hidden" id="id_fenomeno" name="id_fenomeno" value="<?php echo $id_fenomeno_Ini; ?>">
        </div>

        <div class="col-md-3" style="padding: 10px; text-align: center; display: flex; align-items: center;">
            <div class="row">
                <div class="col-md-3">    
                <label>Fecha:</label> 

                </div>
                <div class="col-md-9"> 
                <input type="date" id="fecha" name="fecha" class="form-control" required data-required-msg="Ingrese fecha">
                </div>
            </div>
        </div>


        <div class="col-md-3" style="padding: 10px; text-align: center; display: flex; align-items: center;">
            <div class="row">
                <div class="col-md-4">    
                <label>Periodo:</label> 

                </div>
                <div class="col-md-8"> 
                    <select name="periodo" id="periodo" class="form-control" placeholder="Ingrese periodo" required data-required-msg="Ingrese el periodo">
                        <option value="" style="font-style: italic; color: #B2BABB;">Seleción</option>
                        <?php echo $periodo; ?>
                    </select>
                </div>
            </div>
        </div>

	</div>
<br>

<div class="panel panel-primary">
<div class="panel-heading" style="background: #3c8293;">Unificación de Pronósticos de Impacto</div>

<div class="panel-body">

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12" style="padding-top: 5px; padding-bottom: 5px">
					
					<div class="row">
						<div class="col-xs-1">
							<label>Título:</label> 
						</div>

						<div class="col-md-11">
							<input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ingrese un titulo" required data-required-msg="Ingrese un titulo para los datos generales del informe de impacto"/>
						</div>
					</div> 

				</div>
			</div>

			<div class="row">
				<div class="col-md-12" style="padding-top: 5px; padding-bottom: 5px">
					<label>Descripción:</label>  
					<textarea name="descripcion" rows="4" id="descripcion" class="form-control" placeholder="Ingrese descripción" required data-required-msg="Ingrese la descripción del informe de impacto"></textarea>  
				</div>
			</div>
					
			<div class="row">
					<div class="col-md-6" style="padding-bottom: 10px;">
						<label>Estado</label> 
						<input type="text" name="estado" id="estado" Readonly class="form-control k-invalid" required data-required-msg="estado" aria-invalid="true">
					</div>
					<div class="col-md-3" style="padding-top: 25px;">
					<button type="button" class="btn btn-success" onclick="trRefresh();">
					  <span class="glyphicon glyphicon-refresh"></span>
					</button>
					</div>
			</div>	
		</div>
	</div>

	<div id="tablaUni" class="row">
<!-- CONTENIDO DE TABLA -->
		<div class="" style="">
<<<<<<< HEAD
<!--
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
					<table class="table table-bordered"> 
					<tr style="background:#EEEEEE;">  
							<th width="20%">Area</th>
							<th width="75%">Título</th>
							<th width="20%">Hora</th> 
							<th width="5%"></th> 
							<th width="5%"></th>  
					</tr>  
					</table>
<<<<<<< HEAD
-->
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3

		</div>
<!-- CONTENIDO DE TABLA -->
	</div>
	
	<div id="msgArea" class="col-md-12" style="top: -30px; color:red;">
	</div>

	<div class="row">
		<div class="col-md-12" style="text-align: center;">
			<div class="row">
<<<<<<< HEAD
<!--
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
				<div class="col-md-3">
					<div class="form-check-inline">
						<label class="form-check-label">
						<input name='opt1' type="checkbox" class="form-check-input" value="1">  Publicar</label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-check-inline">
						<label class="form-check-label" style="zoom: 1;">
						<input name='opt2' type="checkbox" class="form-check-input" value="1">  Envio a Intituciones</label>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-check-inline">
					  <label class="form-check-label" style="zoom: 1;">
						<input name='opt3' type="checkbox" class="form-check-input" value="1">  Envio General
					  </label>
					</div>
				</div>
<<<<<<< HEAD
-->
				<div class="" style="text-align:center;" style="width100%;">
					 <button id="guardarUnificado" type="submit" class="btn btn-success" style="width: 225px;">UNIFICAR</button>
				</div>
			</div>
		</div>
	</div>
=======
				<div class="col-md-3" style="text-align: right;" style="zoom: 1;">
					 <button id="guardarUnificado" type="submit" class="btn btn-success" style="width: 70%">Unificar</button>
				</div>
			</div>
		</div>
	</div> <br>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3

</div>
</div>
</form>

</div>
<script>
// Funciones Ivan Moran //
// ------------------------------------------
<<<<<<< HEAD
// $('#guardarUnificado').attr('disabled',true);

function toggle_visibility(id) {
=======

function toggle_map(id) {
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
	var e = document.getElementById(id);
	if(e.style.display == 'none')
		e.style.display = 'block';
	else
		e.style.display = 'none';
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

<<<<<<< HEAD
function showMyMap(va) {
	miMapaUni(va);
	toggle_visibility('loading-div-background-map');
}

// Funcion encargada de mostrar el mapa con los municipios seleccionados
function miMapaUni(va){
	 
	var data = "<iframe id='mapa_ivan' width='100%' height='860px' scrolling='no' frameBorder='0' src='mapa_alertas_show.php?id="+va+"' ></iframe>";
	$('#editMap').html(data);
}

// Funcion encargada de mostrar el mapa con los municipios seleccionados
function miEditUni(va){
	var midata = {id_area:1,area:'Meteorologia',id_fenomeno:1, fenomeno:'', id_impacto_diario:va };
    $.ajax({
		async : true,
		method: "GET",
		url: "MeteorologiaEdicion.php",
		data: midata,
		success: function(msg){
			$("#editUni").html(msg);
       }
     });	
	
	// var edit = "<iframe id='iframeMapaUni' width='100%' height='800px' scrolling='yes' frameBorder='0' src='MeteorologiaEdicion.php?id_area=1&area=&id_fenomeno=1&fenomeno=&id_impacto_diario="+va+"' ></iframe>";
	// $('#editUni').html(edit);
=======
// Funcion encargada de mostrar el mapa con los municipios seleccionados
function miMapaUni(va){
	var mapa = "<iframe id='iframeMapaUni' width='100%' height='800px' scrolling='yes' frameBorder='0' src='UnificacionReporte.php?id="+va+"' ></iframe>";
	$('#mapaUni').html(mapa);
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
}

// ACTUALIZAR LISTA DE ELEMENTOS POR AREA  CUANDO CAMBIA FECHA O PERIODO//
function validaDup() {
	var msg=''; 
	var b  = 0;
	var c1 = $('input#uni1').length;
	var c2 = $('input#uni2').length;
	var c3 = $('input#uni3').length;
	if(c1>1){ $('div#spa1').css( "backgroundColor", "red" ); console.log('Meteorología'); b=1;}  else { $('div#spa1').css( "backgroundColor", "white" ); }
	if(c2>1){ $('div#spa2').css( "backgroundColor", "red" ); console.log('Hidrología');   b=1;}  else { $('div#spa2').css( "backgroundColor", "white" ); }
	if(c3>1){ $('div#spa3').css( "backgroundColor", "red" ); console.log('Geología');	  b=1;}  else { $('div#spa3').css( "backgroundColor", "white" ); }
<<<<<<< HEAD
	if (b == 1) { msg = 'EL AREA ESTA DUPLICADA'; $('#guardarUnificado').attr('disabled',true); } else { $('#guardarUnificado').attr('disabled',false); }
=======
	if (b == 1) { msg = 'EL AREA ESTA DUPLICADA'; }
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
	$('#msgArea').html(msg);
	return b;
}

function addUni(f,p) {
	var idf = $("#id_fenomeno").val();
    $.ajax({
		async : true,
		method: "GET",
		url: "t_uni.php",
		data: {f:f, p:p, idf:idf},
		success: function(msg){
			$("#tablaUni").html(msg);
			getUnificado();
       }
     });
}

// ACTUALIZAR LISTA DE ELEMENTOS POR FECHA Y PERIODO //
$('#periodo').change(function() {
	var periodo = $(this).val();
	var fecha = $("#fecha").val();
	if (fecha != ""){
		addUni(fecha,periodo);
		console.log(periodo+":"+fecha);
<<<<<<< HEAD
		$("#guardarUnificado").show();
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
		// getUnificado();
	}
});

$('#fecha').change(function() {
	var periodo = $("#periodo").val();
	var fecha = $(this).val();
	if(periodo != ''){
		addUni(fecha,periodo);
		console.log(periodo+":"+fecha);
<<<<<<< HEAD
		$("#guardarUnificado").show();
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
		// getUnificado();
	}
});

function trDetach(id) {
	ShowProgressAnimation();
	$('#'+id).detach();
	validaDup();
	getUnificado();
}

function trRefresh(){
	var fecha 		= $('#fecha').val();
	var periodo 	= $('#periodo').val();
	if (fecha != "" && periodo != ""){
		addUni(fecha,periodo);
	}
<<<<<<< HEAD
	setTimeout(function(){ $("#guardarUnificado").show(); }, 700);
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
}

function getUnificado() {
	var uni1 = $('#uni1').val();
	var uni2 = $('#uni2').val();
	var uni3 = $('#uni3').val();
	// console.log(uni1+'-'+uni2+'-'+uni3);
	$.ajax({
		url:"MeteorologiaProcesos.php",
		method:"POST",
		data:{u1:uni1, u2:uni2, u3:uni3, opcion:'getUnificado'},
		success:function(data) {
			var va = jQuery.parseJSON(data);
			$('#estado').val(va['desc']);
			console.log(va);
			HideProgressAnimation();
		}
	});
	return true;
}

<<<<<<< HEAD
// # 
function verTemplate(uni) {
var template1 =   "<div style='text-align:center;'><h3>LOS PRONÓSTICOS SELECCIONADOS FUERON UNIFICADOS CORRECTAMENTE</h3>"
				+ "<div  style='padding-bottom: 5px; text-align:center; background:rgba(255, 255, 255, 1); width:100%;' >"
				+ 	"<button id='verUni' type='button' class='btn btn-success' style='margin-top:1px; width: 200px;'>VER UNIFICADO</button>"
				+ "</div>"
				+ "</div>";	
$('#tablaUni').html(template1);
$('#verUni').attr('onclick', "window.open('UnificacionReporte.php?id="+uni+"','_blank')");
}

=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
// ------------------------------------------
$(function() {
	
$("#formUnificado").on('submit', function(event){
event.preventDefault();
<<<<<<< HEAD
ShowProgressAnimation();

var periodo_text	= $("#periodo option:selected").text().replace(/\s/g,"%20");
var fenomeno_text	= $('#fenomeno').html().replace(/\s/g,"%20");
var formUnificado	= $(this).serialize();

console.log('********************');
console.log(formUnificado + '&periodo_text=' + periodo_text + '&fenomeno_text=' + fenomeno_text);
console.log('********************');
=======


	var periodo_text	= $("#periodo option:selected").text().replace(/\s/g,"%20");
	var fenomeno_text	= $('#fenomeno').html().replace(/\s/g,"%20");
	var formUnificado	= $(this).serialize();
	
	console.log('********************');
	console.log(formUnificado + '&periodo_text=' + periodo_text + '&fenomeno_text=' + fenomeno_text);
	console.log('********************');
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3

if (validaDup()==0){
		var formUnificado = $(this).serialize();
		formUnificado = formUnificado + '&periodo_text=' + periodo_text + '&fenomeno_text=' + fenomeno_text

<<<<<<< HEAD
=======

>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
		$.ajax({
			url:"MeteorologiaProcesos.php",
			method:"POST",
			data:{formMuni:formUnificado, opcion:'insertUnificado'},
			success:function(data) {
<<<<<<< HEAD
				console.log(data);
				var mva = jQuery.parseJSON(data);
				var uni = mva['uni'];
				$("#guardarUnificado").hide();
				verTemplate(uni);
				HideProgressAnimation();
				
=======
			// $('#action').attr("disabled", "disabled");
			// alert('Entro al boton');
			console.log(data);
			// var id_imp = $('#id_impacto_diario_m').val();
			
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
			}
		});
	}else { console.log('VALIDANDO');}

});	

// --- FUNCION FECHA ACTUAL
function setInputDateIni(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth()+1, 
        y = hoy.getFullYear(),
        data;

    if(d < 10){	d = "0"+d;	};
    if(m < 10){	m = "0"+m;	};

    data = y+"-"+m+"-"+d;
    // console.log(data);
    _dat.value = data;
};
setInputDateIni("#fecha");

//--------------------------------------------------------//--------------------------------------------------------
// --- FUNCION FECHA ACTUAL
function setInputDateIni(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth()+1, 
        y = hoy.getFullYear(),
        data;

    if(d < 10){	d = "0"+d;	};
    if(m < 10){	m = "0"+m;	};

    data = y+"-"+m+"-"+d;
    // console.log(data);
    _dat.value = data;
};	

// setInputDateIni("#fecha_ini");

//--------------------------------------------------------//--------------------------------------------------------

});

</script>

<div id="loading-div-background" class="loading-div-background" style="width:100%; height:100%; display: none;">
	<div id="loading-div" class="ui-corner-all loading-div"  >

		<img alt="Loading.." src="Imagenes/loading.gif" style="height: 30px; margin: 30px;">
		<!--<h2 id="msg_text" style="color: white; font-weight: normal;">Municipios Agregados Correctamente</h2>-->
		<!--<button id="Button1" onclick="(HideProgressAnimation(), refresh())">Aceptar</button>-->
	</div>
</div>

<<<<<<< HEAD
<div id="loading-div-background-map" class="loading-div-background" 	style="display: none; overflow:scroll; overflow-x: hidden;">
	<div id="loading-div-map"	class="ui-corner-all loading-div-map"  style="background:rgba(255, 255, 255, 1); margin-bottom:2px;">
	
	<div id="editMap" class="" >	
	<!-- CONTENIDO DE EDITAR -->
	<!-- CONTENIDO DE EDITAR -->	
	</div>
	<div class="" style="padding-bottom: 5px; text-align:center; background:rgba(255, 255, 255, 1); width:100%;" >
		 <button id="closeMapUni" type="submit" class="btn btn-success" style="margin-top:1px; width: 200px;" onclick="toggle_visibility('loading-div-background-map');">CERRAR</button>
=======
<div id="toggle_map" class="loading-div-background-map" style="display: none;">
	<div id="loading-div" class="ui-corner-all loading-div-map"  >
	<div id="mapaUni" class="row">	
	<!-- CONTENIDO DE MAPA -->
	<!-- CONTENIDO DE MAPA -->	
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
	</div>
	</div>
</div>

<<<<<<< HEAD
<div id="loading-div-background-edit" class="loading-div-background" 	style="display: none; overflow:scroll;">
	<div id="loading-div-edit"	class="ui-corner-all loading-div-edit"  style="background:rgba(255, 255, 255, 1);">
	<div id="editUni" class="" >	
	<!-- CONTENIDO DE EDITAR -->
	<!-- CONTENIDO DE EDITAR -->	
	</div>
	</div>
</div>
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3

</body>
</html>
