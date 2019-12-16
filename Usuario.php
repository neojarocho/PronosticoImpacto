<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
include("cnn.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Informe Impacto</title>

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
         width: 600px;
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

<script>
$("#infoUsuario").load("userView.php");

function createUser() {
	$("#curMuni").html("");
	$("#curMuni").load("userInsert.php",{action:'insert'});
	ShowProgressAnimation();
}

function ShowProgressAnimation() {
	$(".loading-div-background-form").show();
}

function HideProgressAnimation() {
	$(".loading-div-background-form").hide();
}

function b_dele(val){
	var x = confirm("¿Esta Seguro de Borrar el Usuario?");
	if (x) {
		console.log("BORRADO"+val);
		return true;
	}  
	else {
		return false; 
	}
}

function b_edit(val){
	console.log("EDITAR"+val);
	$("#curMuni").html("");
	$("#curMuni").load("userInsert.php",{action:'update',id:val});
	ShowProgressAnimation();
}

function saUsuario() {
	var cad = {};
	cad["nombre"]	= $("#nombre").val();
	cad["apellido"]	= $("#apellido").val();
	cad["correo"]	= $("#correo").val();
	cad["password"]	= $("#password").val();
	cad["area"]		= $("#area").val();
	cad["cargo"]	= $("#cargo").val();
	var pcad = $.param(cad);
	
	$.ajax({
		async : true,
		method: "POST",
		url: "MeteorologiaProcesos.php",
		data: {cad:pcad, opcion:'saUsuario'},
		success: function(msg){
			console.log(msg);
			$("#curMuni").html(msg);
			top.location="MeteorologiaUsuario.php";
		}
	});
}

function upUsuario(va) {
	var cad = {};
	cad["id_usuario"] 	= $("#id").val();
	cad["nombre"]		= $("#nombre").val();
	cad["apellido"]		= $("#apellido").val();
	cad["correo"]		= $("#correo").val();
	cad["password"]		= $("#password").val();
	cad["area"]			= $("#area").val();
	cad["cargo"]		= $("#cargo").val();
	var pcad = $.param(cad);
	
	$.ajax({
		async : true,
		method: "POST",
		url: "MeteorologiaProcesos.php",
		data: {cad:pcad, opcion:'upUsuario'},
		success: function(msg){
			console.log(msg);
			$("#curMuni").html(msg);
			top.location="MeteorologiaUsuario.php";
		}
	});
}


</script>

</head>

<body>
	

<div class="container-fluid">
	<div class="row" style="background:#1b2020; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">
			<table style="width:100%;color:#fff;" border=0>
			  <tr>
			  <td><h4 style="text-align:right;"	><?php echo  "Actualizar Usuario"; ?></td>
			  <td><h4 style="text-align:right;"><button type="button" id="BotonNuevoInforme" class="btn btn-success" onClick="createUser()" >Agregar Usuario</button></h4></td>
			  </tr>
			</table>	
			
		</div>
	</div>
</div>

<br>
<div class="container-fluid" >


<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Información de Usuario</a></li>
  </ul>

<div class="tab-content">
	<div id="home" class="tab-pane fade in active">
		<div id="infoUsuario" class="row" style="display: true;">
			<!-- Formularios de Usuario -->
			<!--  Formularios de Usuario -->
		</div>
	</div>
</div>


<div id="loading-div-background" class="loading-div-background" style="display: none;">
	<div class="ui-corner-all loading-div" id="loading-div" >
		<p><br><br></p>
		<img alt="Loading.." src="Imagenes/loading.gif" style="height: 30px; margin: 30px;">
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