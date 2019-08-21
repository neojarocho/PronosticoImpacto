<?php 
session_start();
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

// include('database_connection.php');

$id_unificado = $_REQUEST['id_unificado'];
$nivel = $_REQUEST['nivel'];

// echo $id_unificado.":".$nivel;

if ($id_unificado=="") {$id_unificado=5;}
if ($nivel=="") {$nivel=1;}

#--------------------------------------------------------------------------------------------------------
# IVAN MORAN CODE INI
#--------------------------------------------------------------------------------------------------------
include("cnn.php");



$dbconn = my_dbconn4("PronosticoImpacto");
$sql="SELECT CONCAT(des_categoria,': ',titulo_general) AS titulo FROM public.unificado WHERE id_unificado = $id_unificado;";
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result))  { 
	$mva = $row["titulo"];
}
// print_r($mva);
#--------------------------------------------------------------------------------------------------------
# IVAN MORAN CODE FIN
#--------------------------------------------------------------------------------------------------------

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MARN | Pronostico de Impacto</title>
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
select {
	margin-top: 6px;
	margin-left: -15px !important;
	height: 26px !important;
	padding-top: 0px !important;
	padding-right: 12px !important;
	padding-bottom: 0px !important;
	padding-left: 12px !important;
}
#bPublicar {
	height: 28px;
	margin-top: 4px;
}
#login {
	width: 100%;
	height:25px;
	font-family: arial;
	color: black !important;
	text-shadow: 2px 2px 4px #ffffff !important;
	text-align: right;
	position: absolute;
	right:25px;
	z-index: 99;
	} 
.loading-div-background {
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
</style>
</head>

<body>
	
<div class="container-fluid">
	<div class="row" style="background: #485668; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">
					
			<table style="width:100%" border=0>
				<tr><th></th></tr>
				<tr>
				<td><h4 style="text-align:right;"		><?php echo	"Publicar"; ?>	</h4></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<br>
<div class="container-fluid" >


<div class="container">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#menu1" >Publicar Informe</a></li>
</ul>

<!-- ####################################################################################### -->
<!-- DATOS GENERALES DEL INFORME -->
<div id="datosPublicar" class="row" style="background: #ededf0;margin-bottom: 10px;">
<div class="col-md-12" style="background:#7D7D7D;">
	<div class="row" style="text-align: center; color:#FFFFFF;">
		<table style="width:100%" border=0>
		  <tr>	<th></th></tr>
		  <tr>
		  <td><h5 style="margin-left:5px;	text-align:left;font-weight: bold;"	>OPCIONES				</h5></td>
		  </tr>
		</table>				
	</div>
</div>
<form id="formGeneral" name="formGeneral" action="MeteorologiaProcesos.php" method="post" enctype="multipart/form-data">


 
<div class="col-md-12" >
		<div class="col-md-3">
			<div class="col-md-2" style="margin-top: 6px;">Nivel:</div>
			<div class="col-md-5" style="">
			<select name="nivel" id="nivel" class="form-control" placeholder="Ingrese nivel" required data-required-msg="Ingrese el periodo">
			<option value="1" style="font-style: italic; color: #B2BABB;">Verde</option>
			<option value="2" style="font-style: italic; color: #B2BABB;">Amarillo</option>
			<option value="3" style="font-style: italic; color: #B2BABB;">Naranja</option>
			<option value="4" style="font-style: italic; color: #B2BABB;">Rojo</option>
			</select>
			</div>
		</div>
		<div class="col-md-7">
			<div class='publicar' style="margin-top:5px;margin-bottom: 10px;">
				<span style="margin-left: 5px !important;margin-right: 10px;"><input id='pub_we' name='pub_we' type='checkbox' value="1" > Publicar						</span>
				<span style="margin-left: 5px !important;margin-right: 10px;"><input id='pub_in' name='pub_in' type='checkbox' value="1" > Enviar a Instituciones 		</span>
				<span style="margin-left: 5px !important;margin-right: 10px;"><input id='pub_co' name='pub_co' type='checkbox' value="1" > Enviar a Correos General		</span>
				<span style="margin-left: 5px !important;margin-right: 10px;"><input id='pub_re' name='pub_re' type='checkbox' value="1" > Enviar a Redes				</span>
			</div>
		</div>
		<div class="col-md-2" align="right" >
			<input type="button" name="bPublicar" id="bPublicar" value="Publicar" class="btn btn-primary" /> </input> 
		</div> 
</div> 
		


</form>
</div>

<div class="tab-content">
    <div id="menu1" class="tab-pane fade in active">
		<div class="row" class="mi_target" id= "mi_target" style="background: #FFFFFF;">
			<!-- CONTENIDO AQUI -->
		</div>  
    </div>
</div>



<script>
/***************************************/
/* FUNCIONES IVAN MORAN */
/***************************************/
mi_mapa(<?php echo $id_unificado; ?>, <?php echo $nivel; ?>);

function resizeIframe(obj) {
  obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

// Funcion encargada de mostrar el mapa con los municipios seleccionados
function mi_mapa(va, ni){
	// #var data = "<iframe id='mapa_ivan' width='100%' height='840px' scrolling='no' frameBorder='0' src='mapa_alertas_Consulta.php?id="+va+"&N="+ni+"' onload='$(&#39;#mapa_ivan&#39;).contents().find(&#39;#banner&#39;).hide(),resizeIframe(this)'></iframe>";
	var data = "<iframe id='mapa_ivan' width='100%' height='840px' scrolling='no' frameBorder='0' src='mapa_alertas_Consulta.php?id="+va+"&N="+ni+"' onload='resizeIframe(this)'></iframe>";
	$('#mi_target').html(data);
}

function mapaRefresh(){
	var id_impacto_diario = parseInt($('#id_impacto_diario_m').val());
	if (id_impacto_diario != '') {
		// console.log(id_impacto_diario);
		var data = "<iframe id='mapa_ivan' width='100%' height='840px' scrolling='no' frameBorder='0' src='mapa_alertas.php?id="+id_impacto_diario+"' onload='resizeIframe(this)'></iframe>";
		$('#mi_target').html(data);
	}
}

function ShowProgressAnimation() {
	$("#loading-div-background").show();
}

function HideProgressAnimation() {
	$("#loading-div-background").hide();
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

$("#bPublicar").on("click", function(){
ShowProgressAnimation();

	console.log("you choose Publicar button");
	var mdata = {};
	var op1 = op2 = op3 = op4 ="";
	if($("#pub_we").is(":checked") == true){ mdata['pub_we'] = true; op1="SI";} else { mdata['pub_we']	 = false; op1="NO";}	
	if($("#pub_in").is(":checked") == true){ mdata['pub_in'] = true; op2="SI";} else { mdata['pub_in']	 = false; op2="NO";}	
	if($("#pub_co").is(":checked") == true){ mdata['pub_co'] = true; op3="SI";} else { mdata['pub_co']	 = false; op3="NO";}	
	if($("#pub_re").is(":checked") == true){ mdata['pub_re'] = true; op4="SI";} else { mdata['pub_re']	 = false; op4="NO";}	
	mdata['nivel']	= $("#nivel").val();
	mdata['id_unificado']	= <?php echo $id_unificado; ?>;	
	mdata['titulo']			= '<?php echo $mva; ?>';
	var my_data = "<div>Publicar Contenido:		<span style='color:navy;font-weight: bold;'>"+op1+"</span></div>"+
				  "<div>Correos Instituciones:	<span style='color:navy;font-weight: bold;'>"+op2+"</span></div>"+
				  "<div>Correos General:		<span style='color:navy;font-weight: bold;'>"+op3+"</span></div>"+
				  "<div>Publicar Redes Sociales:<span style='color:navy;font-weight: bold;'>"+op4+"</span></div>";
	
	$("#curMuni").html(my_data);
	// console.log(mdata);
	
    $.ajax({
		async : true,
		method: "POST",
		url:'pronostico_send.php',
		data:{pubData: mdata, opcion:'Publicar'},
		success: function(msg){
			console.log(msg);
       }
     });			

});


// ACTUALIZAR ELEMENTOS POR NIVEL //
$('#nivel').change(function() {
	var nivel = $(this).val();
	var id_unificado = <?php echo $id_unificado; ?>;
	console.log(id_unificado+":"+nivel);
	mi_mapa(id_unificado,nivel);
});


// ------------------------------------------
// FUNCION PARA INDICAR QUE UNA TAREA SE HIZO CORRECTAMENTE
// $(document).ready(function () {
	// $(".loading-div-background").css({ opacity: 0.8 });
	// $('#mapa_ivan').contents().find('#banner').hide();
// });

</script>
<div id="loading-div-background" class="loading-div-background" style="display: none;">
	<div class="ui-corner-all loading-div" id="loading-div" >
		<h4 id="msg_text">Opciones de Publicación Seleccionadas</h4>
		<div id="curMuni">
			<!-- CONTENIDO DE MUNICIPIO SELECCIONADO -->
		</div>
		<!--<div><img alt="Loading.." src="Imagenes/loading.gif" style="height: 30px; margin: 30px;"></div>-->
		<div style="padding-top:5px;"><button id="Button1" onclick="HideProgressAnimation();">Aceptar</button></div>
	</div>
</div>

</body>
</html>