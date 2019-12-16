<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
include("header.php");
include("database_connection.php");

// Connecting, selecting database
function my_dbconn($db){
	// Connecting, selecting database
	$host 		= "192.168.1.182";
	$database 	= $db;
	$user 		= "imoran";
	$pass 		= "i186#34a";
	$dbconn = pg_connect("host =".$host." dbname=".$database." user=".$user."  password=".$pass) or die('Could not connect: ' . pg_last_error());
	return $dbconn;
}

// include("cnn.php");
// session_start();

$buscar = @$_GET['id'];
$nivel = @$_GET['N'];
//if(strlen (@$buscar)>0){$buscar = @$_GET['id'];} else {$buscar = 2;}
// echo "********************************".$buscar."********************************";


if ($nivel == 4) {
$nivel = "'"."Rojo"."'";
} elseif ($nivel == 3) {
$nivel = "'"."Anaranjado','Rojo"."'";
} elseif ($nivel == 2) {
$nivel = "'"."Amarillo','Anaranjado','Rojo"."'";
} else {
$nivel = "'"."Verde','Amarillo','Anaranjado','Rojo"."'";
}

///----------------------*************************************-------------------------------------------------
/// INFORMACIÓN GENERAL

$sqlUnificado="SELECT u.id_unificado,u.fenomeno, UPPER(u.titulo_general) as titulo_general, u.des_general, u.fecha_publicado as fecha_ingresado, 

CASE WHEN UPPER(u.des_categoria)='ATENCIÓN' THEN '<b style=&#quot;color:#2e3740 !important;&#quot;>'||UPPER(u.periodo)||'</b>'
            ELSE UPPER(u.periodo) END as periodo,


CASE WHEN UPPER(u.des_categoria)='ATENCIÓN' THEN '<b style=&#quot;color:#2e3740 !important;&#quot;>ATENCIÓN</b>'
            ELSE UPPER(u.des_categoria) END as des_categoria,


            	(SELECT c.codigo
	FROM public.impacto_probabilidad ip inner join public.color c on ip.id_color=c.id_color
	where ip.id_impacto_probabilidad=u.id_impacto_probabilidad) as codigo


    FROM public.unificado u
    WHERE u.id_unificado= '$buscar';";
$resultUnificado = pg_query($sqlUnificado) or die('Query failed: '.pg_last_error());

$Unificados = pg_fetch_all($resultUnificado);
$Unificados = $Unificados[0];


//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------


$AreaResumen = '';
$sqlGridAreaResumen="SELECT a.imagen, concat(a.condiciones,' ',idd.descripcion) as condiciones
	FROM public.his_impacto_diario idd inner join public.area a on idd.id_area=a.id_area
	where idd.id_his_impacto_diario in (SELECT i.id_his_impacto_diario FROM public.unificado_informe i where i.id_unificado = '$buscar')";
$resultGridAreaResumen = pg_query($sqlGridAreaResumen) or die('Query failed: '.pg_last_error());
$AreaResumen = pg_num_rows($resultGridAreaResumen);


//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------TOMAR ACCIÓN----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

$sqlTomarAccion="SELECT f_consulta_unificado($buscar,'Tomar acción');";
$resultGridTomarAccion = pg_query($sqlTomarAccion) or die('Query failed: '.pg_last_error());
$TomarAccion = pg_fetch_all($resultGridTomarAccion);
$TomarAccion = $TomarAccion[0]['f_consulta_unificado'];
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------ESTAR PREPARADOS----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

$sqlGridEstarPreparados="SELECT f_consulta_unificado($buscar,'Preparación');";
$resultGridEstarPreparados = pg_query($sqlGridEstarPreparados) or die('Query failed: '.pg_last_error());
$EstarPreparados = pg_fetch_all($resultGridEstarPreparados);
$EstarPreparados = $EstarPreparados[0]['f_consulta_unificado'];
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------ESTAR INFORMADOS----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$sqlGridEstarInformados="SELECT f_consulta_unificado($buscar,'Atención');";
$resultGridEstarInformados = pg_query($sqlGridEstarInformados) or die('Query failed: '.pg_last_error());
$EstarInformados = pg_fetch_all($resultGridEstarInformados);
$EstarInformados = $EstarInformados[0]['f_consulta_unificado'];
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------CONDICIONES NORMALES----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$sqlGridCondicionesNormales="SELECT f_consulta_unificado($buscar,'Vigilancia');";
$resultGridCondicionesNormales = pg_query($sqlGridCondicionesNormales) or die('Query failed: '.pg_last_error());
$CondicionesNormales = pg_fetch_all($resultGridCondicionesNormales);
$CondicionesNormales = $CondicionesNormales[0]['f_consulta_unificado'];
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------




?>

<!--
<meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no">
<title>MARN | Mapa de pronóstico de Impacto</title>
<link rel="stylesheet" href="https://js.arcgis.com/3.20/dijit/themes/tundra/tundra.css">
<link rel="stylesheet" href="https://js.arcgis.com/3.20/esri/css/esri.css">
-->

<style>

@font-face {
    font-family: 'RobotoLight'; /*a name to be used later*/
    src: url('fonts/Roboto-Light.ttf'); /*URL to font*/
}
@font-face {
    font-family: 'BebasBold'; /*a name to be used later*/
    src: url('fonts/BebasNeue Bold.ttf'); /*URL to font*/
}
@font-face {
    font-family: 'BebasLight'; /*a name to be used later*/
    src: url('fonts/BebasNeue Light.ttf'); /*URL to font*/
}
@font-face {
    font-family: 'BebasBook'; /*a name to be used later*/
    src: url('fonts/BebasNeue Book.ttf'); /*URL to font*/
}

#map {
		background: #fff;
		height: 100% !important;
		width: 100%	!important;
		margin: 0;
		padding: 0 !important;
		padding-left: 10px !important;
		padding-right: 10px !important;

}

h3 {
         margin: 0 0 5px 0;
         border-bottom: 1px solid #444;
		 font-size: medium;
}
.shadow {
         box-shadow: 0 0 5px #888;
}
#feedback {
	background: #fff;
	color: #444;
	position: absolute !important;
	font-family: arial;
	width: 165px;
	height: 250px;
	// left: 70px;
	margin-left: 75px;
	margin-top: 5px;
	padding: 0px;
	z-index: 40;
}

#leyenda {
    background: #cccccc;
	color: #444;
	position: absolute;
	font-family: arial;
	font-size: 100%;		 
	margin-left: 5px;
	margin-top: 5px;
	border: 1px solid #bfbfbf;
	z-index: 40;
	text-align:center;
	padding:3px 4px;
	width:79.219px;
	height:22px;
}	
#leyenda a {
    color: rgb(0, 0, 0);
    text-decoration: none;
}  

#info {
	margin-left:10px;
}  
	  
#note,
#hint {
         font-size: 80%;
}
#note {
         font-weight: 700;
         //padding: 0 0 10px 0;
}
	  
#layerList {
         width: 125px;
		 margin-left:0px;
}
.dojoDndItemOver {
         background: #ccc;
}
	
.demographicInfoContent {
      padding-top: 10px;
}
	
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	// background: #42413C;
	margin: 0;
	padding: 0;
	color: #000;
}

.container {
	padding:0px;
	margin: auto;
	width:100% !important;
}

.mapa_marco {
	// width: auto; 
	height: 580px;
	margin: 0px;
}
	
.dojoDndItem {
		padding: 0px;
}	

	table {
    font-size: small;
}


.right-element {
	width:355px;
    display: inline-block;
    position: relative;
    right: -30px;
}	
.left-element {
	// width:355px;
    display: inline-block;
    position: relative;
    left: -30px;
}
#symbology {	  
    background: transparent;
	color: #ffffff !important;
	position: absolute;
	font-family: arial;
	font-size: 100%;		 
	margin-left: 20px;
	margin-top: 445px;
	z-index: 40;
	padding:0px; 	
	// width: 146px; 
	height: 128px;
}
#PuntosCardinales {	  
    background: transparent;
	color: #ffffff !important;
	position: absolute;
	font-family: arial;
	font-size: 100%;		 
	margin-left: 825px;
	margin-top: 15px;
	z-index: 40;
	padding:0px; 	
	// width: 126px; 
	height: 108px;
}
.formTable {
	BORDER: #fff 0px solid;
}

#compass {
	color: #444;
	position: absolute;
	font-family: arial;
	font-size: small;			  
	margin-left:175px;
	padding: 0px;
	top: 485px;
	z-index: 40;	

}
.esriPopupMaximized {
	left: 25px !important;
	margin-top: 25px !important;
}
.headerblock {
	z-index:1;
	position:relative;
	// height: 60px;
	width:100% !important;
	margin-top:0px;
	margin-bottom:0px;
	// margin-left:-14px;
    box-shadow: 1px 1px 4px rgba(0,0,0,0);
    // border: 2px solid rgba(0,0,0,0);
	// border-radius: 10px 10px 10px 10px;	
	text-align:center;
	font-family: BebasBook;
	font-size: 35px;
	// font-weight: 700;
	color: #000000;
    background-color: #c0c3c2 !important;
}

.my_content {
	height:539px !important;
	text-align:center;
	margin-top:5px;
	margin-bottom:5px;
	margin-left: 5px;
	margin-right:5px
	}
	
.my_label {
	border-collapse:separate !important; 
	border-spacing:2px !important; 
    background-color: #485668; !important;
	color:#fff;
	text-align:center;
	margin-top:2px;
	margin-bottom:2px;
	margin-left: 5px;
	margin-right:5px
	}
	
.center {
    margin: auto;
    width: 100% !important;
    padding: 0px;
}
a {
    
    text-decoration: none;
}
.contentPane {
	max-height: 300px !important;
	padding-top: 5px !important;
}
.row {
	margin-right: 0px;
	margin-left: 0px;
}
.color {
	color:black;
	width:160px;
	height:25px;
	font-size: 12px;
    text-align: center;
	display: table-cell; 
	vertical-align: middle;
}
.sep {
	width:140px;
	height:1px;
}
.ficha {
  margin-left: 5px;
  margin-right: 5px;
  margin-bottom: 5px;
  margin-top: 2px;
}
.esriPopup .pointer, .esriPopup .outerPointer {
    background: rgba(87,188,196,.9);
}
/* change size of pop up*/
.esriPopup .sizer {
    position: relative;
    width: 165px !important;
	font-size: 10px !important;
    z-index: 1;
}
.esriPopupMaximized {
	left: 25px !important;
	margin-top: 25px !important;
}
.esriSimpleSlider {
	z-index: 30;
	top: 35px !important;
}

#HomeButton {
	position: absolute;
	// top: 200px;
	// left: 20px;
	margin-left: 20px;
	margin-top: -475px;
	z-index: 50;
}
div.esriPopupWrapper .zoomTo {
  display: none;
}

ul.alin {
  list-style-position: outside;
  padding-left: 20px;
}


.FondoImagen{
    position: relative;
    display: inline-block;
    text-align: center;
}
 
.texto-encima{
    position: absolute;
    top: 10px;
    left: 10px;
}
.centra{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.esriPopup .titleButton.maximize, .titleButton.next, .titleButton.prev, .spinner {
  display: none;
}


a {
    color: #2e3740;
}
</style>




   
<script type="text/javascript">

function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(e.style.display == 'none')
		e.style.display = 'block';
	else
		e.style.display = 'none';
	}
	
// $(document).ready(function () {            
/* your code here */
/* your code here */
// });


$( document ).ready(function() {

<?php
if ($TomarAccion==null){
?>
toggle_visibility ('TomarAccion');

<?php
}
?>

<?php
if ($EstarPreparados==null){
?>
toggle_visibility ('EstarPreparados');
<?php
}
?>

<?php
if ($EstarInformados==null){
?>
toggle_visibility ('EstarInformados');
<?php
}
?>

<?php
if ($CondicionesNormales==null){
?>
toggle_visibility ('CondicionesNormales');
<?php
}
?>


var nivel = <?php echo @$_GET['N'];?>

console.log(nivel);

if (nivel==4){
	nivel = "'Rojo'";

toggle_visibility ('EstarPreparados');
toggle_visibility ('EstarInformados');
toggle_visibility ('CondicionesNormales');	

}

if (nivel==3){
	nivel = "'Anaranjado','Rojo'";
toggle_visibility ('EstarInformados');
toggle_visibility ('CondicionesNormales');		

}

if (nivel==2){
	nivel = "'Amarillo','Anaranjado','Rojo'";
toggle_visibility ('CondicionesNormales');	

}

if (nivel==1){
	nivel = "'Verde','Amarillo','Anaranjado','Rojo'";

}


});



	
</script>
<!--<link rel="stylesheet" type="text/css" href="fancybox/dist/jquery.fancybox.css">-->
</head>


<body class="tundra">
<div class="container" style="background: #fff; width: 98% !important;">



<table style="border: hidden;"> 
                       
<tr> <!--//////////******************************////////////////////////-->
 
<td>


         <div class="row" style="background: <?php echo $Unificados['codigo'];?>;">
			 <div class="col-xs-6" style="border: 1px solid #474747; text-align: center; font-size: 12px; color:#ffffff; height:  background: <?php echo $Unificados['codigo'];?>;">
          		<p style="margin-top: 5px; margin-bottom: 5px;"><?php echo $Unificados['des_categoria'];?></p>
			</div>

			<div class="col-xs-6" style="border: 1px solid #474747; text-align: center; font-size: 12px; color:#ffffff; background: <?php echo $Unificados['codigo'];?>;">
          		<p style="margin-top: 5px; margin-bottom: 5px;"><?php echo $Unificados['periodo'];?></p>
			</div>
		</div>

<div class="row">
			<div class="col-xs-12" style="text-align: center; font-size: 12px; color:#ffffff; background:#2e3740;">
          		<p style="margin-top: 5px; margin-bottom: 5px;"><?php echo $Unificados['titulo_general'];?></p>
			</div>
</div>






	<br>
	<div class="row">
        <div class="col-md-12">
            <div class="row" style="text-align: right; color:#428bca; font-weight: 500; margin-top:-10px;">
                <div class="col-md-12" >
              

                    <input type="hidden" id="fecha_ingresado" name="fecha_ingresado" value="<?php echo $Unificados['fecha_ingresado'];?>" style="display:none"/>


            <laber><h6><b>
                  <a id="diaSemana" class="diaSemana"></a>
                  <a id="dia" class="dia"></a>
                  <a>de</a>
                  <a id="mes" class="mes"></a>
                  <a>del</a>
                  <a id="anio" class="anio"></a>
               <a>-</a>
              
                  <a id="horas" class="horas"></a>
                  <a>:</a>
                  <a id="minutos" class="minutos"></a>
                  <a>:</a>
                    
                    <a id="segundos" class="segundos"></a>
                    <a id="ampm" class="ampm"></a>
            </b></h6></laber>



                </div>
        

            </div>

        </div>
 	</div>


	<div class="row">

		        <div>
		            <h6 id="descripcion" style="line-height: 1.5em; text-align: justify; padding-left: 10px;padding-right: 10px;"><?php echo $Unificados['des_general'];?></h6>
		          
		        </div>



				<div align="center">
						<!-- CONTENIDO MAPA-->

					<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/img_impacto/mapa_unificado_<?php echo $Unificados['id_unificado'];?>.jpg"  style="width:95%; padding-bottom: 10px;"/>


						<!-- CONTENIDO MAPA -->
				</div>

	</div>

</td>
</tr >
<tr >
<td>

	<div>

		<!-- ----------------------------------------------------------------------------------------- --> 
		<!-- ------------------------------------------TOMAR ACCIÓN------------------------------------- --> 
		<!-- ----------------------------------------------------------------------------------------- -->
				<div id="TomarAccion" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20;">
		  
							<table class="table table-bordered" style="border: hidden;"> 
								<caption style="background: #F20505; text-align: left; color: #ffffff ;font-size: 12px !important; padding-left: 10px;"><b>TOMAR ACCIÓN</b></caption>
								<tr style="background:#EEEEEE" align="center"></tr>  
								<?php  
								while($row = pg_fetch_array($resultGridTomarAccion))  
								{  
								?>  
								 <tr>
										<td class="alin" style="padding-top: 0px; padding-bottom: 0px;"><h6 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h6></td>
								</tr>  
								<?php  
								}  
								?>  
							</table>       
				 </div>
		<!-- ----------------------------------------------------------------------------------------- --> 
		<!-- ------------------------------------------ESTAR PREPARADOS------------------------------------- --> 
		<!-- ----------------------------------------------------------------------------------------- -->

				<div  id="EstarPreparados" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20;">

							<table class="table table-bordered" style="border: hidden;"> 
								<caption style="background: #f29e05; color: #ffffff; text-align: left; font-size: 12px !important; padding-left: 10px;"><b>PREPARACIÓN</b></caption>
								<tr style="background:#EEEEEE" align="center"></tr>  
								<?php  
								while($row = pg_fetch_array($resultGridEstarPreparados))  
								{  
								?>  
								<tr>  
										<td class="alin" style="padding-top: 0px; padding-bottom: 0px;"><h6 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h6></td>
								</tr>  
								<?php  
								}  
								?>  
							</table>  
				 </div>

		<!-- ----------------------------------------------------------------------------------------- --> 
		<!-- ------------------------------------------ESTAR INFORMADOS------------------------------------- --> 
		<!-- ----------------------------------------------------------------------------------------- -->

				<div   id="EstarInformados" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20;">
							<table class="table table-bordered" style="border: hidden;"> 
								<caption style="background: #ffef00; color: #585858; text-align: left; font-size: 12px; padding-left: 10px;"><b>ATENCIÓN</b></caption>
								<tr style="background:#EEEEEE" align="center"></tr>  
								<?php  
								while($row = pg_fetch_array($resultGridEstarInformados))  
								{  
								?>  
								 <tr> 
										<td class="alin" style="padding-top: 0px; padding-bottom: 0px;"><h6 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h6></td>
								</tr>  
								<?php  
								}  
								?>  
							</table>     
				 </div>

		<!-- ----------------------------------------------------------------------------------------- --> 
		<!-- ------------------------------------------VIGILANCIA------------------------------------- --> 
		<!-- ----------------------------------------------------------------------------------------- -->

				<div   id="CondicionesNormales" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20;">
							 <table class="table table-bordered" style="border: hidden;"> 
								<caption style="background: #6ab93c; color: #ffffff; text-align: left; font-size: 12px; padding-left: 10px;"><b>VIGILANCIA</b></caption>
								<tr style="background:#EEEEEE" align="center"></tr>  
								<?php  
								while($row = pg_fetch_array($resultGridCondicionesNormales))  
								{  
								?>  
								<tr> 
										<td class="alin" style="padding-top: 0px; padding-bottom: 0px;"><h6 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h6></td>
								</tr>  
								<?php  
								}  
								?>  
							</table>   
				 </div>

	</div>


</td>
</tr>  
  
</table>  




</div>

</body>
</html>
</body>
</html>

<script>

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'none')
        e.style.display = 'block';
    else
        e.style.display = 'none';
}

$(function(){

fecha = new Date(document.getElementById('fecha_ingresado').value);

  var actualizarHora = function(){
    var 
        hora = fecha.getHours(),
        minutos = fecha.getMinutes(),
        segundos = fecha.getSeconds(),
        diaSemana = fecha.getDay(),
        dia = fecha.getDate(),
        mes = fecha.getMonth(),
        anio = fecha.getFullYear(),
        ampm;
    
    var $pHoras = $("#horas"),
        $pSegundos = $("#segundos"),
        $pMinutos = $("#minutos"),
        $pAMPM = $("#ampm"),
        $pDiaSemana = $("#diaSemana"),
        $pDia = $("#dia"),
        $pMes = $("#mes"),
        $pAnio = $("#anio");
    var semana = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    

var Fechita = diaSemana + ' ' + dia;

    $pDiaSemana.text(semana[diaSemana]);
    $pDia.text(dia);
    $pMes.text(meses[mes]);
    $pAnio.text(anio);
    if(hora>=12){
      hora = hora - 12;
      ampm = "PM";
    }else{
      ampm = "AM";
    }
    if(hora == 0){
      hora = 12;
    }
    if(hora<10){$pHoras.text("0"+hora)}else{$pHoras.text(hora)};
    if(minutos<10){$pMinutos.text("0"+minutos)}else{$pMinutos.text(minutos)};
    if(segundos<10){$pSegundos.text("0"+segundos)}else{$pSegundos.text(segundos)};
    $pAMPM.text(ampm);
    
  };
  
  actualizarHora();
  var intervalo = setInterval(actualizarHora,1000);
});
</script>



