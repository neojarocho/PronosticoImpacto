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


toggle_visibility ('EstarPreparados');
toggle_visibility ('EstarInformados');
toggle_visibility ('CondicionesNormales');

} elseif ($nivel == 3) {
$nivel = "'"."Anaranjado','Rojo"."'";


toggle_visibility ('EstarInformados');
toggle_visibility ('CondicionesNormales');

} elseif ($nivel == 2) {
$nivel = "'"."Amarillo','Anaranjado','Rojo"."'";

toggle_visibility ('CondicionesNormales');
} else {
$nivel = "'"."Verde','Amarillo','Anaranjado','Rojo"."'";
}










///----------------------*************************************-------------------------------------------------
/// INFORMACIÓN GENERAL
$sqlUnificado="SELECT u.id_unificado,u.fenomeno, u.titulo_general, u.des_general, u.fecha_ingresado, 

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

$sqlGridAreaResumen="SELECT a.id_area, a.imagen, a.condiciones as condicion, idd.descripcion, concat(a.condiciones,' ',idd.descripcion) as condiciones
	FROM public.his_impacto_diario idd inner join public.area a on idd.id_area=a.id_area
	where idd.id_his_impacto_diario in (SELECT i.id_his_impacto_diario FROM public.unificado_informe i where i.id_unificado = '$buscar') ORDER BY a.id_area";
$resultGridAreaResumen = pg_query($sqlGridAreaResumen) or die('Query failed: '.pg_last_error());
// echo "***************".$sqlGridAreaResumen."***************";
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





$dbconn = my_dbconn("PronosticoImpacto");
$query="SELECT hd.id_his_impacto_diario_detalle, hd.id_his_impacto_diario, hd.cod_municipio, hd.municipio, (SELECT departamento FROM public.municipio m inner join public.departamento d on m.cod_departamento=d.cod_departamento and m.cod_municipio = hd.cod_municipio) as departamento, hd.no_matriz, hd.impacto, hd.probabilidad, 
hd.color, (SELECT c.codigo	FROM public.color c where c.color=hd.color) as codigo,(SELECT c.transparencia	FROM public.color c where c.color=hd.color) as transparencia,
(SELECT array_to_string(array(SELECT concat('<ul class=alin2>',hdk.consecuencias,'</ul>','Especial atención en: '||hdk.especial_atencion||'.  ', 'Durante:  '||hdk.horarios)
							  from public.his_impacto_diario_detalle hdk 
							  where  hdk.cod_municipio=hd.cod_municipio and hdk.id_his_impacto_diario in (SELECT id_his_impacto_diario 
																   FROM public.unificado_informe	
																   where id_unificado= '$buscar') 
							  order by no_matriz desc), ''))
						 as lista_conse,
hd.categoria, hd.fecha_ingreso, hd.id_usuario_ingreso,

(CASE WHEN (SELECT c.codigo	FROM public.color c where c.color=hd.color) ='#ffef00' THEN '#2e3740'
ELSE '#ffffff' END) as color_t

FROM public.his_impacto_diario_detalle hd 
where hd.id_his_impacto_diario in (SELECT id_his_impacto_diario FROM public.unificado_informe	where id_unificado= '$buscar')
and hd.color in ($nivel)
and hd.no_matriz= (select max(no_matriz)
							  from public.his_impacto_diario_detalle 
							  where  id_his_impacto_diario in (SELECT id_his_impacto_diario FROM public.unificado_informe	where id_unificado= '$buscar')
								and cod_municipio=hd.cod_municipio
								GROUP BY cod_municipio,municipio)
ORDER BY hd.cod_municipio;";
$result=pg_query($dbconn, $query);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$sh[] = $row;
} pg_free_result($result);
pg_close($dbconn);

if (count(@$sh)==0){
echo "<div style='text-align:center;'>NO HAY MUNICIPIOS INGRESADOS TODAVIA</div>";
exit();
}

// echo "<pre>";
// print_r($sh);
// echo "</pre>";




$dbconn = my_dbconn("PronosticoImpacto");
$query="SELECT u.id_unificado, u.titulo_general, u.des_general, periodo, u.fecha_publicado, u.publicar, u.enviar_instituciones, u.envio_general, u.id_usuario_ingreso, fenomeno, u.id_impacto_probabilidad, u.des_categoria,
	(SELECT c.codigo
	FROM public.impacto_probabilidad ip inner join public.color c on ip.id_color=c.id_color
	where ip.id_impacto_probabilidad=u.id_impacto_probabilidad) as codigo
FROM public.unificado u where u.id_unificado = '$buscar'";
$result=pg_query($dbconn, $query);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ti[] = $row;
} pg_free_result($result);
pg_close($dbconn);
// $ti = $ti[0];

// echo "<pre>";
// print_r($ti);
// echo "</pre>";
// var_dump($sh);

# Colores 
# ------------
# 1 verde
# 2 Amarillo
# 3 Naranja
# 4 Rojo

$mu[]='';
for ($i = 0; $i < count($sh); $i++) {
    $arr[$sh[$i]['cod_municipio']] = $sh[$i];
	$mu[$i] = $sh[$i]['cod_municipio'];
	if		( $sh[$i]['color'] == 'Verde') { $cg[$i] = $sh[$i]['cod_municipio']; } 
	elseif	( $sh[$i]['color'] == 'Amarillo') { $cy[$i] = $sh[$i]['cod_municipio']; } 
	elseif	( $sh[$i]['color'] == 'Anaranjado') { $co[$i] = $sh[$i]['cod_municipio']; } 
	else	{ $cr[$i] = $sh[$i]['cod_municipio']; } 
}

@$c1 = implode(",", @$cg);
@$c2 = implode(",", @$cy);
@$c3 = implode(",", @$co);
@$c4 = implode(",", @$cr);
$muni = "'".implode("','", $mu)."'";

$por = explode(",", $muni);
$con = count($por);

$vr1=$vr2=$vr3=$vr4=$vr5=$vr6=$vr7=$vr8=$vr9=$vr10=$vr11=array();

for ($i=0;$i<=$con;$i++) {
	if($i>=0 	&& $i<=24  ){	$vr1[] =  @$por[$i];}
	if($i>=25 	&& $i<=49  ){	$vr2[] =  @$por[$i];}
	if($i>=50 	&& $i<=74  ){	$vr3[] =  @$por[$i];}
	if($i>=75 	&& $i<=99  ){	$vr4[] =  @$por[$i];}
	if($i>=100 	&& $i<=124 ){	$vr5[] =  @$por[$i];}
	if($i>=125 	&& $i<=149 ){	$vr6[] =  @$por[$i];}
	if($i>=150 	&& $i<=174 ){	$vr7[] =  @$por[$i];}
	if($i>=175 	&& $i<=199 ){	$vr8[] =  @$por[$i];}
	if($i>=200 	&& $i<=224 ){	$vr9[] =  @$por[$i];}
	if($i>=225 	&& $i<=249 ){	$vr10[]=  @$por[$i];}
	if($i>=250 	&& $i<=262 ){	$vr11[]=  @$por[$i];}
}
                          
$m01 = implode(',',@$vr1);
$m02 = implode(',',@$vr2);
$m03 = implode(',',@$vr3);
$m04 = implode(',',@$vr4);
$m05 = implode(',',@$vr5);
$m06 = implode(',',@$vr6);
$m07 = implode(',',@$vr7);
$m08 = implode(',',@$vr8);
$m09 = implode(',',@$vr9);
$m10 = implode(',',@$vr10);
$m11 = implode(',',@$vr11);

$m01 = rtrim($m01,',');
$m02 = rtrim($m02,',');
$m03 = rtrim($m03,',');
$m04 = rtrim($m04,',');
$m05 = rtrim($m05,',');
$m06 = rtrim($m06,',');
$m07 = rtrim($m07,',');
$m08 = rtrim($m08,',');
$m09 = rtrim($m09,',');
$m10 = rtrim($m10,',');
$m11 = rtrim($m11,',');

?>




    
<meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no">
<title>MARN | Mapa de pronóstico de Impacto</title>
<link rel="stylesheet" href="https://js.arcgis.com/3.20/dijit/themes/tundra/tundra.css">
<link rel="stylesheet" href="https://js.arcgis.com/3.20/esri/css/esri.css">

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
		border-style: solid;
		border-width: 1px;
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
	margin-left: 15px;
	margin-top: 400px;
	z-index: 40;
	padding:0px; 	
	// width: 146px; 
	height: 128px;
}	
#mapa_base {
	z-index: 40 !important;
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
  margin-left: 10px;
  margin-right: 5px;


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

ul.alin2 {
  list-style-position: outside;
  padding-left: 20px;
  margin-bottom: 0px;

}

ul.alin {
  list-style-position: outside;
  padding-left: 20px;
}

.stroke {
color: white;
font-family: impact;
letter-spacing: 3;
text-shadow: -0.5px -0.5px 0.5px #000, 0.5px 0.5px 0.5px #000, -0.5px 0.5px 0.5px #000, 0.5px -0.5px 0.5px #000;
-webkit-text-fill-color: white;
-webkit-text-stroke: 1px black;
}


.FondoImagen{
    position: relative;
    display: inline-block;
    text-align: center;
}
.esriPopup .titleButton.maximize, .titleButton.next, .titleButton.prev, .spinner {
  display: none;
}

.loading-div-background {
		opacity: 1 !important; 
        display:none;
        position:fixed;
        top:0;
        left:0;
        background:rgba(0, 0, 0, 0.2);
		z-index:99;
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
         height: auto  !important;
         background-color: rgba(255, 255, 255, 1) !important;
         text-align:center;
         position:absolute;
         top: 50%;
         left: 50%;
		 transform: translate(-50%, -50%);
         // margin-left:-150px;
         // margin-top: -100px;
}
#editUnificado {
	background-color: rgba(255, 255, 255, 1);
}

a {
    color: #2e3740;
}
</style>
<script src="https://js.arcgis.com/3.20/"></script>


<script>
      dojo.require("esri.map");
      dojo.require("esri.tasks.query");
	  
      // the infos object is used to track layer visibility and position
	  var queryTask, query;
	  var symbol, infoTemplate;
      var map, dialog, MyLayers, infos = {};

      require([
      "esri/map",
	  "esri/dijit/HomeButton",
	  "esri/geometry/Extent",
	  "esri/tasks/FeatureSet","esri/layers/FeatureLayer","esri/request",
	  "esri/dijit/BasemapGallery", 		//ContentPanel
	  "esri/arcgis/utils",	  			//ContentPanel
	  "esri/layers/ArcGISDynamicMapServiceLayer",
      "esri/layers/DynamicLayerInfo", 
	  "esri/layers/LayerDataSource",
      "esri/layers/LayerDrawingOptions", 
	  "esri/layers/TableDataSource",
	  "esri/geometry/Point",
      "esri/graphic", 
	  "esri/lang",
      "esri/Color", 					//Create Templates
	  "dojo/number", 
      "esri/dijit/Popup",				//Create PopUP
      "esri/InfoTemplate",	  			//Create Templates
	  "esri/symbols/SimpleMarkerSymbol",	  
	  "esri/renderers/SimpleRenderer",
      "esri/symbols/SimpleFillSymbol", 
	  "esri/symbols/SimpleLineSymbol", 
      "dojo/dom", 
	  "dojo/dom-construct", 			//Create Templates
	  "dojo/dom-style",
	  "dijit/TooltipDialog",
	  "dijit/popup",
      "dojo/query", 
	  "dojo/on",
      "dojo/parser", 
	  "dojo/_base/array", 
	  "dojo/dnd/Source", 
	  "dijit/registry",
	  "dijit/layout/BorderContainer", 	//ContentPanel
	  "dijit/layout/ContentPane", 		//ContentPanel
	  "dijit/TitlePane",				//ContentPanel
      "dijit/form/Button", "dojo/domReady!"
    ], function (
		Map, HomeButton, Extent, FeatureSet, FeatureLayer, esriRequest,
		BasemapGallery, 			//ContentPanel
		arcgisUtils,		 		//ContentPanel
		ArcGISDynamicMapServiceLayer,
		DynamicLayerInfo, 
		LayerDataSource,
		LayerDrawingOptions, 
		TableDataSource,
		Point,
		Graphic, esriLang,
		Color, 
		number,
		Popup, 					//Create PopUP
		InfoTemplate, 			//Create PopUP	
		SimpleMarkerSymbol,		
		SimpleRenderer,
		SimpleFillSymbol, 
		SimpleLineSymbol,	
		dom, domConstruct, 
		domStyle,
		TooltipDialog,
		dijitPopup,
		query, 
		on,
		parser, 
		arrayUtils, 
		Source, 
		registry
      ) {
         parser.parse();

         var dynamicLayerInfos;
		 
		// PopUP
		var sls = new SimpleLineSymbol("solid", new Color("#444444"), 3);
		var sfs = new SimpleFillSymbol("solid", sls, new Color([68, 68, 68, 0.25]));
		
		
		var bbox = new Extent({
			"xmin": -90.133373, 
			"ymin": 13.153889, 
			"xmax": -87.684125, 
			"ymax": 14.449447,
			"spatialReference":{"wkid":4326}
		});
		
		var popup = new Popup({
			pagingControls: false,
			pagingInfo: false,
			fillSymbol: sfs,
			lineSymbol: null,
			markerSymbol: null
		}, domConstruct.create("div"));
		 
            // center: [-90.35,14.00],

		map = new Map("map", {
			basemap: "gray",
			sliderStyle: "small", // large/small
			infoWindow: popup,
			extent: bbox,
			center: [ -88.85,13.75 ],
			zoom: 9
		});
		
		var home = new HomeButton({
		map: map
		}, "HomeButton");
		home.startup();

	/* TEMPLATES */
	var _blockGroupInfoTemplate = new InfoTemplate();
	_blockGroupInfoTemplate.setTitle("<b></b>");	
	
	var _blockGroupInfoContent =
	"<div class=\"GroupInfoContent\">" 	+
	"Municipio: ${munic}<br>" 			+
	"Departamento: ${dpto}<br>" 		+
	"</div>";
	
	// /* DEFINE TEMPLATE */
	_blockGroupInfoTemplate.setContent(_blockGroupInfoContent); 


	// Global vars
	/* ----------------------------------------------------------------------------- */
	var va	= <?php echo json_encode($arr); ?>;		
	var mu  = <?php echo json_encode($muni); ?>;
	// console.log(va[0]['id_impacto_diario_detalle_his']);
	// console.log(va);
	
	// var mval 	 = "'"+value.join("','")+"'";
	var mval	= <?php echo json_encode($muni); ?>;
	var a1 		= <?php echo json_encode($c1); ?>;
	var a2 		= <?php echo json_encode($c2); ?>;
	var a3 		= <?php echo json_encode($c3); ?>;
	var a4 		= <?php echo json_encode($c4); ?>;
	
	function mysplit(a) {
		if (a == null) { a=[]} else {a.split;}
		return a
	}
	
	var array_g  = mysplit(a1); 	// Color verde
	var array_y  = mysplit(a2);		// Color Amarillo
	var array_o  = mysplit(a3);		// Color Naranja
	var array_r  = mysplit(a4);		// rojo		
	

	/* ----------------------------------------------------------------------------- */
	// Add your global templates here
	/* ----------------------------------------------------------------------------- */
	// var tem1 = "Municipio: ${munic} <br/>" +"Departamento: ${dpto} <br />" +"Area: ${km2_munic} <br />";		
	// infoTemplate = new InfoTemplate("(${cod_ofi}) ${munic}","<div class='weekstyle'>" +tem1 +"</div>");
		  
		 
		//add the basemap gallery, in this case we'll display maps from ArcGIS.com including bing maps
		  var basemapGallery = new BasemapGallery({
			showArcGISBasemaps: true,
			map: map
		  }, "basemapGallery");
		  basemapGallery.startup();
		  
		  basemapGallery.on("error", function(msg) {
			console.log("basemap gallery error:  ", msg);
		  });
			 
		 
         var dndSource = new Source("layerList");
         dndSource.on("DndDrop", reorderLayers);
		 
		//Agregar aqui Otras capas		
		/* ----------------------------------------------------------------------------- */
		var alm = new ArcGISDynamicMapServiceLayer("https://geoportal.snet.gob.sv/server/rest/services/imoran/pub_mapa_base/MapServer/?layers=show:2", {
		"id": "alm",
		"opacity": 0.75
		});
		alm.setInfoTemplates({
		2: { infoTemplate: _blockGroupInfoTemplate }
		});
		map.addLayer(alm);		 
		 

		/* ----------------------------------------------------------------------------- */
		MyLayers = new ArcGISDynamicMapServiceLayer("https://geoportal.snet.gob.sv/server/rest/services/imoran/pub_mapa_base/MapServer", {
				"id": "almacenamiento",
				"opacity": 0.75
		});
		
		MyLayers.on("load", function (e) {
            dynamicLayerInfos = e.target.createDynamicLayerInfosFromLayerInfos();
            arrayUtils.forEach(dynamicLayerInfos, function (info) {
               var i = {
                  id: info.id,
                  name: info.name,
                  position: info.id
               };
               if (arrayUtils.indexOf(MyLayers.visibleLayers, info.id) > -1) {
                  i.visible = true;
               } else {
                  i.visible = false;
               }
               infos[info.id] = i;
            });
            infos.total = dynamicLayerInfos.length;
            e.target.setDynamicLayerInfos(dynamicLayerInfos, true);
						
         });

         // only create the layer list the first time update-end fires
         on.once(MyLayers, "update-end", buildLayerList);
         // hide the loading icon when the dynamic layer finishes updating
         MyLayers.on("update-end", hideLoading);
		map.addLayer(MyLayers);
		

        //close the dialog when the mouse leaves the highlight graphic
        map.on("load", function(){
			map.graphics.enableMouseEvents();
			map.graphics.on("mouse-out", closeDialog);
			map.disableScrollWheelZoom();
			
			/* my function call to draw selected area */
			// console.log(mval);
			var mval_01	= <?php echo json_encode($m01); ?>;
			var mval_02	= <?php echo json_encode($m02); ?>;
			var mval_03	= <?php echo json_encode($m03); ?>;
			var mval_04	= <?php echo json_encode($m04); ?>;
			var mval_05	= <?php echo json_encode($m05); ?>;
			var mval_06	= <?php echo json_encode($m06); ?>;
			var mval_07	= <?php echo json_encode($m07); ?>;
			var mval_08	= <?php echo json_encode($m08); ?>;
			var mval_09	= <?php echo json_encode($m09); ?>;
			var mval_10	= <?php echo json_encode($m10); ?>;
			var mval_11	= <?php echo json_encode($m11); ?>;
			// console.log(mval_02.length);
			
			// my_custom_style('0000');
			if (mval_01.length > 0)		{	my_custom_style(mval_01)};
			if (mval_02.length > 0)		{	my_custom_style(mval_02)};
			if (mval_03.length > 0)		{	my_custom_style(mval_03)};
			if (mval_04.length > 0)		{	my_custom_style(mval_04)};
			if (mval_05.length > 0)		{	my_custom_style(mval_05)};
			if (mval_06.length > 0)		{	my_custom_style(mval_06)};
			if (mval_07.length > 0)		{	my_custom_style(mval_07)};
			if (mval_08.length > 0)		{	my_custom_style(mval_08)};
			if (mval_09.length > 0)		{	my_custom_style(mval_09)};
			if (mval_10.length > 0)		{	my_custom_style(mval_10)};
			if (mval_11.length > 0)		{	my_custom_style(mval_11)};			
			my_water();
        });
		
        map.infoWindow.resize(245,125);

        dialog = new TooltipDialog({
          id: "tooltipDialog",
          style: "position: absolute; width: 250px; font: normal normal normal 10pt Helvetica;z-index:100"
        });
        dialog.startup();

/**************************************************************************************/
/**************************************************************************************/
	function my_water() {
		require(["esri/tasks/query", "esri/tasks/QueryTask"], function(Query, QueryTask){
		var query2 = new Query();
		var queryTask2 = new QueryTask("https://geoportal.snet.gob.sv/server/rest/services/imoran/pub_mapa_base/MapServer/0",{ id: "my_water" });
		query2.where = "FID>0";
		query2.returnGeometry = true;
		query2.outFields = ["FID"];
		queryTask2.execute(query2, showResults2);		
		});
	}
	
	function showResults2(featureSet) {
	var resultFeatures = featureSet.features;
	symbol = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([115,178,255,0.15]), 1 ), new Color([115,178,255	,0.80]) );	  
	  for (var i=0, il=resultFeatures.length; i<il; i++) {
		var graphic = resultFeatures[i];
		graphic.setSymbol(symbol);
		graphic.setInfoTemplate(infoTemplate);
		map.graphics.add(graphic);
	  }
	}

	function my_custom_style(mval) {
	$(".esriControlsBR").remove();	
	$(".actionsPane").remove();	
	
		// Create a custom query funtion
		require(["esri/tasks/query", "esri/tasks/QueryTask"], function(Query, QueryTask){

		var query1 = new Query();
		var queryTask1 = new QueryTask("https://geoportal.snet.gob.sv/server/rest/services/imoran/pub_mapa_base/MapServer/2",{
			id: "mapaMuni",	
			usePost:"true"
		});
		query1.where = "cod_ofi IN ("+mval+")";
		query1.returnGeometry = true;
		query1.outFields = ["*"];
		queryTask1.execute(query1, showResults1);		
		});
	}

/*************    TEMPLATES    ***************/
	function showResults1(featureSet) {
	// Define template
	var template1 = "Municipio: ${munic} <br/>		" 
					+"Departamento: ${dpto} <br />	";
					
	var template2 = "<table style='width:100%'>										"
					+"<tr>															"
					+"	<td style='vertical-align: top;'>							"
					+"		<div class='ficha'><b>Municipio</b>: 	${munic}</div>	"
					+"		<div class='ficha'><b>Departamento</b>:	${dpto}	</div>	"
					+"	</td>														"
					+"</tr>															"
					+"</table>														";
				
	infoTemplate = new InfoTemplate("${munic}","<div class='weekstyle'>" +template1 +"</div>");
	
	// symbol  = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([255,255,255,0.50]), 1 ), new Color([147,208,78,1]) );
	symbol1 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([147,208,78	,0.80]) );
	symbol2 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([255,255,0	,0.80]) );
	symbol3 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([255,192,0	,0.80]) );
	symbol4 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([255,0,0	,0.80]) );
	
	var resultFeatures = featureSet.features;
	
		for (var i=0, il=resultFeatures.length; i<il; i++) {
			var graphic = resultFeatures[i];
			v = resultFeatures[i].attributes.cod_ofi
			if (array_g.length > 0){ if (array_g.includes(v)){/*console.log(v+'verde');		*/graphic.setSymbol(symbol1)}; };
			if (array_y.length > 0){ if (array_y.includes(v)){/*console.log(v+'amarillo');	*/graphic.setSymbol(symbol2)}; };
			if (array_o.length > 0){ if (array_o.includes(v)){/*console.log(v+'naranja');	*/graphic.setSymbol(symbol3)}; };
			if (array_r.length > 0){ if (array_r.includes(v)){/*console.log(v+'rojo');		*/graphic.setSymbol(symbol4)}; };	
			// graphic.setSymbol(symbol);
			// resultFeatures[i].attributes['ifm'] = v+" - Ivan_Moran"
			graphic.setInfoTemplate(infoTemplate);
			// setTimeout(map.graphics.add(graphic), 500);
			map.graphics.add(graphic)
			// console.log(resultFeatures[i].attributes.cod_ofi);
		}	
		// console.log(featureSet);
		
		dojo.connect(map.graphics, "onClick", function(evt) {
			var g 	= evt.graphic;
			var at = g.attributes;

var con	="<div class='row my_label' style='background-color: "+va[at.cod_ofi]['codigo']+"; color: "+va[at.cod_ofi]['color_t']+"'>										"
		+"<div class='row'>																																						"
		+"<div class='col-md-2'>																																				"
		+"<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>Código: "+va[at.cod_ofi]['cod_municipio']+"</font>														"
		+"</div>																																								"
		+"<div class='col-md-8'>																																				"
		+"<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'><b>Municipio de "+va[at.cod_ofi]['municipio']+" - "+va[at.cod_ofi]['departamento']+" </b></font>			"
		+"</div>																																								"
		+"<div class='col-md-2'>																																				"
		+"<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'> "+va[at.cod_ofi]['categoria']+" ("+va[at.cod_ofi]['no_matriz']+")</font>								"
		+"</div>																																								"
		+"</div>																																								"
		+"</div>																																								"
		+"<div class='row' style='text-align:center;'>																															"
		+"<table style='width:100%' border=1>																																	"		
		+"<tr>																																									"
		+"	<td style='vertical-align: top; margin-top: 5px; color: #797979;'>																									"
		+"																																										"
		+"		<div class='ficha'><h5>"+va[at.cod_ofi]['lista_conse']+"</h5></div>																									"			
		+"																																										"
		+"																																										"
		+"	</td>																																								"			
		+"																																										"				
		+"</tr>																																									"			
		+"</table>																																								"
		+"<br>																																									"
		+"</div>";


			require(["dojo/dom"], function(dom){ dom.byId("my_content").innerHTML = con; });
			// console.log(g.attributes.cod_ofi);
		});	
	}
	
        function closeDialog() {
          // map.graphics.clear();
          // dijitPopup.close(dialog);
        }
	  
         function buildLayerList() {
            dndSource.clearItems();
            domConstruct.empty(dom.byId("layerList"));

            var layerNames = [];
            for (var info in infos) {
               if (!infos[info].hasOwnProperty("id")) {
                  continue;
               }
               // only want the layer's name, don't need the db name and owner name
               var nameParts = infos[info].name.split(".");
               var layerName = nameParts[nameParts.length - 1];
               var layerDiv = createToggle(layerName, infos[info].visible);
               layerNames[infos[info].position] = layerDiv;
            }

            dndSource.insertNodes(false, layerNames);
         }

         function toggleLayer(e) {
            showLoading();
            for (var info in infos) {
               var i = infos[info];
               if (i.name === e.target.name) {
                  i.visible = !i.visible;
               }
            }
            var visible = getVisibleLayers();
            if (visible.length === 0) {
               MyLayers.setVisibleLayers([-1]);
            } else {
               MyLayers.setDynamicLayerInfos(visible);
            }
         }

         function reorderLayers() {
            showLoading();
            var newOrder = getVisibleLayers();
            MyLayers.setDynamicLayerInfos(newOrder);
         }

         function getVisibleLayers() {
            // get layer name nodes, build an array corresponding to new layer order
            var layerOrder = [];
            query("#layerList .dojoDndItem label").forEach(function (n, idx) {
               for (var info in infos) {
                  var i = infos[info];
                  if (i.name === n.innerHTML) {
                     layerOrder[idx] = i.id;
                     // keep track of a layer's position in the layer list
                     i.position = idx;
                     break;
                  }
               }
            });
            // find the layer IDs for visible layer
            var ids = arrayUtils.filter(layerOrder, function (l) {
               return infos[l].visible;
            });
            // get the dynamicLayerInfos for visible layers
            var visible = arrayUtils.map(ids, function (id) {
               return dynamicLayerInfos[id];
            });
            return visible;
         }

         function createToggle(name, visible) {
            var div = domConstruct.create("div");
            var layerVis = domConstruct.create("input", {
               checked: visible,
               id: name,
               name: name,
               type: "checkbox"
            }, div);
            on(layerVis, "click", toggleLayer);
            var layerSpan = domConstruct.create("label", {
               for: name,
               innerHTML: name
            }, div);
            return div;
         }

         function showLoading() {
            domStyle.set(dom.byId("loading"), "display", "inline-block");
         }

         function hideLoading() {
            domStyle.set(dom.byId("loading"), "display", "none");
         }
		 
      });
	  
		var formatNumber = function(value, key, data) {
		var searchText = "" + value;
		var formattedString = searchText.replace(/(\d)(?=(\d\d\d)+(?!\d))/gm, "$1,");
		return formattedString;
		};
		
    var dojoConfig = {
        async: true
    };
</script>
   
   
<script type="text/javascript">

function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(e.style.display == 'none')
		e.style.display = 'block';
	else
		e.style.display = 'none';
	}
	

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

function editIntegrado() {

var cad = {};

	cad["i_id_uni"]			= <?php echo $buscar; ?>;
	cad["i_titulo"] 		= $("span#i_titulo").text();
	cad["i_descripcion"]	= $("span#i_descripcion").text();
	if($("span#ca_1").length>0) { cad["i_u1"] = $("span#ca_1").text(); }
	if($("span#ca_2").length>0) { cad["i_u2"] = $("span#ca_2").text(); }
	if($("span#ca_3").length>0) { cad["i_u3"] = $("span#ca_3").text(); }
	var pcad = $.param(cad);
	// console.log(cad);
	
	$.ajax({
		async : true,
		method: "POST",
		url: "editUnificado.php",
		data: {cad:pcad, opcion:'editUnificado'},
		success: function(msg){
			$("#editUnificado").html(msg);
			// console.log(msg);
		}
	});
	ShowProgressAnimation();
}


function ShowProgressAnimation() {
	$(".loading-div-background").show();
}

function HideProgressAnimation() {
	$(".loading-div-background").hide();
}

function recargar(){
	top.location="http://srt.marn.gob.sv/web/PronosticoImpacto/mapa_alerta_unificado_ver.php?id=<?php echo $buscar; ?>";
}
</script>
<link rel="stylesheet" type="text/css" href="fancybox/dist/jquery.fancybox.css">
</head>

<body class="tundra">
<div class="container" style="background: #fff;">

<div class="center">
<!--<div class="headerblock">- Mapa de pronóstico de Impacto -</div>-->

</div>

<div class="row">
	    <div id='banner' class="col-md-12">
	        <a>
	            <img src="Imagenes/Banner3.png" width="100%" class="img-responsive"  id="PaginaInicio">
	        </a>
	        <br>
		 </div>

		<div class="row">
			<div class="col-md-1" style=" text-align: center; font-size: 15px; color:#ffffff; background: <?php echo $Unificados['codigo'];?>;">
          		<p style="margin-top: 5px; margin-bottom: 5px;"><b><?php echo $Unificados['des_categoria'];?></b></p>
			</div>

			<div class="col-md-10" style="text-align: center; font-size: 15px; color:#ffffff; background:#2e3740">
          		<p style="margin-top: 5px; margin-bottom: 5px;"><b><span id="i_titulo"><?php echo $Unificados['titulo_general'];?></span></b></p>
			</div>

			<div class="col-md-1" style=" text-align: center; font-size: 15px; color:#ffffff; background: <?php echo $Unificados['codigo'];?>;">
          		<p style="margin-top: 5px; margin-bottom: 5px;"><b><?php echo $Unificados['periodo'];?></b></p>
			</div>
		</div>

</div>
<br>

<div class="row">
	<div class="col-md-6">
	<br>
		<div class="row">
			<div class="col-md-12">
				<div class="row" style="text-align: left; color:#428bca; font-weight: 500; margin-top:-10px;">
					<div class="col-md-12" >
						<input type="hidden" id="fecha_ingresado" name="fecha_ingresado" value="<?php echo $Unificados['fecha_ingresado'];?>" style="display:none"/>
						<laber>
							<h5><b>
							  <a id="diaSemana" class="diaSemana"></a>
							  <a id="dia" class="dia"></a>&nbsp;<a>de</a>&nbsp;<a id="mes" class="mes"></a>&nbsp;<a>del</a>&nbsp;<a id="anio" class="anio"></a>&nbsp;<a>-</a><a id="horas" class="horas"></a>
							  <a>:</a>&nbsp;<a id="minutos" class="minutos"></a><a>&nbsp;:&nbsp;</a><a id="segundos" class="segundos"></a>&nbsp;<a id="ampm" class="ampm"></a>
							</h5></b>
						</laber>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

		    <div class="col-md-12">
		        <laber><h5><p style="text-align: justify; line-height: 1.5em;"><span id="i_descripcion"><?php echo $Unificados['des_general'];?></span></p></h5></laber>
		         <br>
		    </div>

			<div class="col-md-12">
				<!-- CONTENIDO MAPA-->
					<div class="mapa_marco">
						<div id="map">
							<!-- Muestra/Oculta Leyenda y Capas--> 
							<div id="leyenda"><a href="javascript:toggle_visibility('feedback')">Ver Capas</a></div>
							<div id="symbology">
								<img src="Imagenes/l_PaletaImpacto.png" width="150">
							</div>
							<!-- Muestra Capas--> 
							<div id="feedback" class="shadow" style="display: none;">
								<h3 align="center">Alertas MARN</h3>
								<div id="info">
										<div id="note">
											<br>En esta secci&oacute;n se presenta el registro de alertas por Municipio 
										</div>
									   <div id="hint">
										  Selecciona y arrastra una capa para reordenanrla.
									   </div>
									   <!--<strong>Capas de Almacenamiento</strong>-->
									   <img id="loading" src="Imagenes/loading_black.gif">
									   <br>
									   <div id="layerList"></div>
								</div>
							</div>
							<!-- Muestra Mapas base--> 
							<div id="mapa_base" style="position:absolute; right: 20px; margin-top: 5px;">
								<div data-dojo-type="dijit/TitlePane" 
									data-dojo-props="title:'Mapa Base', closable:false, open:false">
									<div data-dojo-type="dijit/layout/ContentPane" style="width:265px; height:280px;">
									<div id="basemapGallery"></div>
									</div>
								</div>
							</div>	 
							<!-- Muestra Leyenda--> 
							<!--
							<div id="compass">
								<img src='theme/compass.png' alt="Smiley face"  width="70px" height="70px">
							</div>		
							-->

						</div>
					</div>
					<div id="HomeButton"></div>
					<!-- CONTENIDO MAPA -->
			</div>

			<div class="col-md-12">
				<div id="my_content" class="row">
					<!-- CONTENIDO DATA -->
					<div class='row my_label' style="background-color: <?php echo @$sh[0]['codigo']; ?>; color: <?php echo @$sh[0]['color_t']; ?>;">
						<div class="row">
							<div class="col-md-2">
								<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>Código: <?php echo @$sh[0]['cod_municipio']; ?></font>
							</div>
							<div class="col-md-8">
								<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'><b>Municipio de <?php echo $sh[0]['municipio']; ?> - <?php echo @$sh[0]['departamento']; ?></b></font>
							</div>
							<div class="col-md-2">
								<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'> <?php echo @$sh[0]['categoria']; ?> (<?php echo @$sh[0]['no_matriz']; ?>)</font>
							</div>
						</div>
					</div>

					<div class='row' style='text-align:center;'>
						<table style='width:100%' border=1>		
							<tr>
								<td style='vertical-align: top; margin-top: 5px; color: #797979;'>
									<div class='ficha'><h5 style="line-height: 1.3em;"><?php echo @$sh[0]['lista_conse']; ?></h5></div>																
								</td>																							
																																
							</tr>																								
						</table>	
					</div>
					<!-- CONTENIDO DATA -->
				</div>
			</div>

		</div>
			<!--	<div  id="i_areas" class="col-md-12">
		        <br>
                    <table class="table table-bordered"> 
                      <tr style="background:#EEEEEE" align="center" >  
                      </tr>  
                      <?php  
                        while($row = pg_fetch_array($resultGridAreaResumen))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF;">
						<td style="vertical-align:middle;"><img src="<?php echo $row["imagen"]; ?>" width="120 px"></td>
								<td style="padding-bottom: 0px; padding-top: 8px;"><h5 style="line-height: 1.5em;"><p><?php echo $row["condicion"].' '; ?><span id="ca_<?php echo $row['id_area']; ?>"><?php echo $row["descripcion"]; ?></span></p></h5></td>
                        </tr>  
                        <?php  
                        }  
                        ?>  

                    </table>  
		</div>-->
	</div>
		
	<div class="col-md-6" style="padding-left: 0px; padding-right: 0px; padding-top: -15px;" >
		<div class="row">

			<!-- ----------------------------------------------------------------------------------------- --> 
			<!-- ------------------------------------------TOMAR ACCIÓN----------------------------------- --> 
			<!-- ----------------------------------------------------------------------------------------- -->
		        <div  class="col-md-12" id="TomarAccion" style="padding-left: 0px; padding-right: 0px; padding-right: 15px; margin-bottom: -20;">
		  
		                    <table class="table table-bordered"> 
		                        <caption style="background: #F20505; text-align: left; color: #ffffff ;font-size: 14px !important; padding-left: 10px;"><b>TOMAR ACCIÓN</b></caption>
		                        <tr style="background:#EEEEEE" align="center"></tr>  
		                        <?php  
		                        while($row = pg_fetch_array($resultGridTomarAccion))  
		                        {  
		                        ?>  
		                         <tr style="background:#2e3740 ; color:#FFFFFF;  font-size: 10px; text-align: justify;">
		                                <td class="alin" style="padding-top: 0px; padding-bottom: 0px; padding-right: 15px;"><h5 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h5></td>
		                        </tr>  
		                        <?php  
		                        }  
		                        ?>  
		                    </table>       
				</div>


			<!-- ----------------------------------------------------------------------------------------- --> 
			<!-- ------------------------------------------ESTAR PREPARADOS------------------------------- --> 
			<!-- ----------------------------------------------------------------------------------------- -->

		        <div  class="col-md-12" id="EstarPreparados" style="padding-left: 0px; padding-right: 0px; padding-right: 15px; margin-bottom: -20;">

		                    <table class="table table-bordered"> 
		                        <caption style="background: #f29e05; color: #ffffff; text-align: left; font-size: 14px !important; padding-left: 10px;"><b>PREPARACIÓN</b></caption>
		                        <tr style="background:#EEEEEE" align="center"></tr>  
		                        <?php  
		                        while($row = pg_fetch_array($resultGridEstarPreparados))  
		                        {  
		                        ?>  
		                        <tr style="background:#2e3740 ; color:#FFFFFF;  font-size: 10px; text-align: justify;">  
		                                <td class="alin" style="padding-top: 0px; padding-bottom: 0px; padding-right: 15px;"><h5 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h5></td>
		                        </tr>  
		                        <?php  
		                        }  
		                        ?>  
		                    </table>  
				</div>


			<!-- ----------------------------------------------------------------------------------------- --> 
			<!-- ------------------------------------------ESTAR INFORMADOS------------------------------- --> 
			<!-- ----------------------------------------------------------------------------------------- -->

		        <div  class="col-md-12" id="EstarInformados" style="padding-left: 0px; padding-right: 0px; padding-right: 15px; margin-bottom: -20;">
		                    <table class="table table-bordered"> 
		                        <caption style="background: #ffef00; color: #7f7f7f; text-align: left; font-size: 14px; padding-left: 10px;"><b>ATENCIÓN</b></caption>
		                        <tr style="background:#EEEEEE" align="center"></tr>  
		                        <?php  
		                        while($row = pg_fetch_array($resultGridEstarInformados))  
		                        {  
		                        ?>  
		                         <tr style="background:#2e3740 ; color:#FFFFFF;  font-size: 10px; text-align: justify;"> 
		                                <td class="alin" style="padding-top: 0px; padding-bottom: 0px; padding-right: 15px;"><h5 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h5></td>
		                        </tr>  
		                        <?php  
		                        }  
		                        ?>  
		                    </table>     
				</div>


			<!-- ----------------------------------------------------------------------------------------- --> 
			<!-- ------------------------------------------ MONITOREO------------------------------------- --> 
			<!-- ----------------------------------------------------------------------------------------- -->

		        <div  class="col-md-12" id="CondicionesNormales" style="padding-left: 0px; padding-right: 0px; padding-right: 15px; margin-bottom: -20;">
							 <table class="table table-bordered"> 
		                        <caption style="background: #6ab93c; color: #ffffff; text-align: left; font-size: 14px; padding-left: 10px;"><b>VIGILANCIA</b></caption>
		                        <tr style="background:#EEEEEE" align="center"></tr>  
		                        <?php  
		                        while($row = pg_fetch_array($resultGridCondicionesNormales))  
		                        {  
		                        ?>  
		                        <tr style="background:#2e3740 ; color:#FFFFFF;  font-size: 10px; text-align: justify;"> 
		                                <td class="alin" style="padding-top: 0px; padding-bottom: 0px; padding-right: 15px;"><h5 style="line-height: 1.3em;"><?php echo $row["f_consulta_unificado"]; ?></h5></td>
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
<div class="center">
							<div style="padding-bottom:10px; padding-top:5px; text-align:center;">
							<input style="margin-top:5px;" type="button" name="update" id="update" class="btn btn-primary" value="Modificar"  onClick="editIntegrado();" />
							</div>
</div>

<div id="loading-div-background-edit" class="loading-div-background" 	style="display: none; overflow:scroll;">
	<div id="loading-div-edit"	class="ui-corner-all loading-div-edit"  style="background:rgba(255, 255, 255, 1);">
	<div id="editUnificado" class="" >	
	<!-- CONTENIDO DE EDITAR -->
	<!-- CONTENIDO DE EDITAR -->	
	</div>
	</div>
</div>


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



