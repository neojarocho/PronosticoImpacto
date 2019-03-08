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
if(strlen (@$buscar)>0){$buscar = @$_GET['id'];} else {$buscar = 2;}
// echo "********************************".$buscar."********************************";

$dbconn = my_dbconn("PronosticoImpacto");
$query="SELECT id_impacto_diario_detalle, id_impacto_diario, cod_municipio, municipio, id_impacto, id_probabilidad, id_color, id_categoria, especial_atencion, descripcion, fecha_ingreso, id_usuario_ingreso
	FROM public.impacto_diario_detalle where id_impacto_diario = '$buscar' ORDER BY cod_municipio";
$result=pg_query($dbconn, $query);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$sh[] = $row;
} pg_free_result($result);
pg_close($dbconn);

echo "<pre>";
print_r($sh);
echo "</pre>";


$dbconn = my_dbconn("PronosticoImpacto");
$query="SELECT d.id_impacto_diario, d.id_area, a.area, d.id_fenomeno, d.fecha, d.correlativo, d.titulo, d.descripcion, 
		d.id_periodo, d.id_estado_impacto, d.id_impacto_fenomeno, d.id_usuario, d.fecha_ini, d.fecha_fin
		FROM public.impacto_diario d
		INNER JOIN area a ON a.id_area = d.id_area
		WHERE d.id_impacto_diario = '$buscar'";
$result=pg_query($dbconn, $query);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ti[] = $row;
} pg_free_result($result);
pg_close($dbconn);
// $ti = $ti[0];

echo "<pre>";
print_r($ti);
echo "</pre>";
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
	if		( $sh[$i]['id_color'] == 1) { $cg[$i] = $sh[$i]['cod_municipio']; } 
	elseif	( $sh[$i]['id_color'] == 2) { $cy[$i] = $sh[$i]['cod_municipio']; } 
	elseif	( $sh[$i]['id_color'] == 3) { $co[$i] = $sh[$i]['cod_municipio']; } 
	else	{ $cr[$i] = $sh[$i]['cod_municipio']; } 
}

@$c1 = implode(",", @$cg);
@$c2 = implode(",", @$cy);
@$c3 = implode(",", @$co);
@$c4 = implode(",", @$cr);
$muni = "'".implode("','", $mu)."'";
// var_dump($c2);

?>
    
<meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no">
<title>MARN | Alertas MARN</title>
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
         height: 100%;
         width: auto;
         margin: 0;
         padding: 0 !important;
}
h3 {
         margin: 0 0 5px 0;
         border-bottom: 1px solid #444;
		 font-size: medium;
}
.shadow {
         box-shadow: 0 0 5px #888;
}
#map {
         margin: 0;
         padding: 0;
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
	padding:0px;
	z-index: 40;
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
	width:auto;
}

.mapa_marco {
	width: auto; 
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
	width:auto !important;
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
    background-color: #c0c3c2 !important;
	text-align:center;
	margin-top:0px;
	margin-bottom:5px;
	margin-left: 5px;
	margin-right:5px
	}
	
.center {
    margin: auto;
    width: 100%;
    padding: 0px;
}
a {
    color: rgb(204, 10, 26);
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
	width:140px;
	height:25px;
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
      "esri/map","esri/tasks/FeatureSet","esri/layers/FeatureLayer","esri/request",
	  "esri/dijit/BasemapGallery", 		//ContentPanel
	  "esri/arcgis/utils",	  			//ContentPanel
	  "esri/layers/ArcGISDynamicMapServiceLayer",
      "esri/layers/DynamicLayerInfo", 
	  "esri/layers/LayerDataSource",
      "esri/layers/LayerDrawingOptions", 
	  "esri/layers/TableDataSource",
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
		// "esri/tasks/QueryTask",
		// "esri/tasks/query",	  
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
		Map, FeatureSet, FeatureLayer, esriRequest,
		BasemapGallery, 			//ContentPanel
		arcgisUtils,		 		//ContentPanel
		ArcGISDynamicMapServiceLayer,
		DynamicLayerInfo, 
		LayerDataSource,
		LayerDrawingOptions, 
		TableDataSource,
		Graphic, esriLang,
		Color, 
		number,
		Popup, 					//Create PopUP
		InfoTemplate, 			//Create PopUP	
		SimpleMarkerSymbol,		
		SimpleRenderer,
		SimpleFillSymbol, 
		SimpleLineSymbol,
		// QueryTask, Query, 		
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
		
		var popup = new Popup({
			fillSymbol: sfs,
			lineSymbol: null,
			markerSymbol: null
		}, domConstruct.create("div"));
		 

         map = new Map("map", {
            basemap: "topo",
            center: [-88.90,13.80],
            zoom: 8,
			sliderStyle: "large", // large/small
			infoWindow: popup
         });

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

		MyLayers = new ArcGISDynamicMapServiceLayer("https://geoportal.marn.gob.sv/server/rest/services/imoran/pub_mapa_base/MapServer", {
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
			
			/* my function call to draw selected area */
			my_custom_style(mval);
			
         });
		 

         // only create the layer list the first time update-end fires
         on.once(MyLayers, "update-end", buildLayerList);
         // hide the loading icon when the dynamic layer finishes updating
         MyLayers.on("update-end", hideLoading);
         map.addLayer(MyLayers);
		 
		//Agregar aqui Otras capas		
		/* ----------------------------------------------------------------------------- */

		// var alm = new ArcGISDynamicMapServiceLayer("https://geoportal.marn.gob.sv/server/rest/services/imoran/mapa_base/MapServer/?layers=show:0", {
			// "id": "alm",
			// "opacity": 0.1
			// "useMapImage": true
		// });
		// alm.setInfoTemplates({
			// 0: { infoTemplate: _oilAndGasInfoTemplate }
		// });
		// map.addLayer(alm);

        //close the dialog when the mouse leaves the highlight graphic
        map.on("load", function(){
          map.graphics.enableMouseEvents();
          map.graphics.on("mouse-out", closeDialog);
		  map.disableScrollWheelZoom();
        });
        map.infoWindow.resize(245,125);

        dialog = new TooltipDialog({
          id: "tooltipDialog",
          style: "position: absolute; width: 250px; font: normal normal normal 10pt Helvetica;z-index:100"
        });
        dialog.startup();

/**************************************************************************************/
/**************************************************************************************/

	function my_custom_style(mval) {
	$(".esriControlsBR").remove();	
	$(".actionsPane").remove();	
	
		// Create a custom query funtion
		require(["esri/tasks/query", "esri/tasks/QueryTask"], function(Query, QueryTask){

		var query1 = new Query();
		var queryTask1 = new QueryTask("https://geoportal.marn.gob.sv/server/rest/services/imoran/pub_mapa_base/MapServer/2",{
			id: "mapaMuni",	
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
				
	infoTemplate = new InfoTemplate("(${cod_ofi}) ${munic}","<div class='weekstyle'>" +template1 +"</div>");
	
	// symbol  = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([255,255,255,0.50]), 1 ), new Color([147,208,78,1]) );
	symbol1 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([147,208,78,1]) );
	symbol2 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([255,255,0,1]) );
	symbol3 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([255,192,0,1]) );
	symbol4 = new SimpleFillSymbol( SimpleFillSymbol.STYLE_SOLID, new SimpleLineSymbol( SimpleLineSymbol.STYLE_SOLID, new Color([0,0,165,0.15]), 1 ), new Color([255,0,0,1]) );
	
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
			map.graphics.add(graphic);
			// console.log(resultFeatures[i].attributes.cod_ofi);
		}	
		// console.log(featureSet);
		
		dojo.connect(map.graphics, "onClick", function(evt) {
			var g 	= evt.graphic;
			var at = g.attributes;
			var con	= "<div class='row my_label'>"
					+"<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'><b>Municipio "+va[at.cod_ofi]['municipio']+"</font>"
					+"</div>"
					+"<div class='row' style='text-align:center;'>"
					+"<table style='width:100%' border=1>																"
					+"<!--<tr><th colspan=2></th></tr>-->																"
					+"<tr>																								"
					+"	<td style='vertical-align: top;' width='50%'>													"
					+"		<div class='ficha'><b>Municipio</b>: 	"+va[at.cod_ofi]['municipio']+" </div>				"
					+"		<div class='ficha'><b>Departamento</b>:	<?php echo 'San Salvador'?> </div>					"
					+"		<div class='ficha'><b>Probabilidad</b>:	"+va[at.cod_ofi]['probabilidad']+" </div>			"
					+"		<div class='ficha'><b>Impacto</b>:		"+va[at.cod_ofi]['impacto']+" </div>				"
					+"																									"
					+"		<div class='ficha'><b>Horario</b>:		"+va[at.cod_ofi]['horarios']+"</div>				"
					+"		<div class='ficha'><b>Consecuencias</b>:"+va[at.cod_ofi]['consecuencias']+" </div>			"
					+"	</td>																							"
					+"	<td style='vertical-align: top;' width='50%'>													"
					+"		<div class='ficha'><b>Color</b>:		"+va[at.cod_ofi]['color']+" </div>					"					
					+"		<div class='ficha'><b>Categoria</b>:		"+va[at.cod_ofi]['categoria']+" </div>			"					
					+"		<div class='ficha'><b>Especial Atencion</b>:"+va[at.cod_ofi]['especial_atencion']+" </div>	"
					+"		<div class='ficha'><b>Descripción</b>:		"+va[at.cod_ofi]['descripcion']+" </div>		"
					+"	</td>																							"
					+"																									"
					+"</tr>																								"
					+"</table>																							"
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
		

</script>
   
   
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
	
</script>
<link rel="stylesheet" type="text/css" href="fancybox/dist/jquery.fancybox.css">
</head>

<body class="tundra">
<div class="container" style="background: #fff;">

<div class="center">
<div class="headerblock">- Alertas MARN -</div>
	<div class='row' style='text-align:center;'>
	<table style='width:100%' border=1>																		
	<tr>
		<?php 
			function format_date($fe) {
			$fecha = strtotime($fe); 
			// $fecha = strtotime(substr($fe, 0,10)); 
			$nfecha = date('d/m/Y H:i:s',$fecha);
			return $nfecha;
			}
		
		?>
		<th colspan=2 style="text-align:right;"><div class='ficha'><b>Fecha Publicado</b>:	<?php echo format_date($ti[0]['fecha_ini']); ?>			</div>	</th>
		</tr>																				
	<tr>																								
		<td style='vertical-align: top;' width='50%'>																
			<div class='ficha'><b>Area</b>:					<?php echo $ti[0]['area']; ?>			</div>				
			<div class='ficha'><b>Titulo Pronostico</b>:	<?php echo $ti[0]['titulo']; ?>			</div>				
			<div class='ficha'><b>Descripción</b>:			<?php echo $ti[0]['descripcion']; ?>	</div>					
			<div class='ficha'><b>Impacto fenomeno</b>:		<?php echo $ti[0]['impacto_fenomeno']; ?></div>					
		
		</td>																							
		<td style='vertical-align: top;' width='50%'>																
			<div class='ficha'><b>Fenomeno</b>:			<?php echo $ti[0]['fenomeno']; ?>		</div>										
			<div class='ficha'><b>Correlativo</b>:		<?php echo $ti[0]['correlativo']; ?>	</div>											
			<div class='ficha'><b>Periodo</b>:			<?php echo $ti[0]['periodo']; ?> 		
			<b>Fecha inicial</b>: <?php echo format_date($ti[0]['fecha_ini']); ?> 		<b>Fecha fin</b>: <?php echo format_date($ti[0]['fecha_fin']); ?> 
			</div>											
		</td>																							
																										
	</tr>																								
	</table>	
	</div>
</div>
<div class="row">
		<!-- CONTENIDO MAPA-->
		<div class="mapa_marco">
			<div id="map">
				<!-- Muestra/Oculta Leyenda y Capas--> 
				<div id="leyenda"><a href="javascript:toggle_visibility('feedback')">Ver Leyenda</a></div>
				<div id="symbology">
				<div class="color" style="background:rgb(147,208,78);">Verde: Impacto muy bajo	</div><div class="sep"></div>
				<div class="color" style="background:rgb(255,255,0);">Amarillo: Impacto bajo	</div><div class="sep"></div>
				<div class="color" style="background:rgb(255,192,0);">Naranja; Impacto medio	</div><div class="sep"></div>
				<div class="color" style="background:rgb(255,0,0);">Rojo: Impacto alto			</div><div class="sep"></div>
				<!--
					<iframe id="sym" src="http://www.snet.gob.sv/imoran/load_symbology02.php?mapa=sismograma&id=0" width="100%" height="100%" align="top" scrolling="no" frameborder="0" style='border:none;'></iframe>
				-->
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
				<div id="mapa_base" style="position:absolute; z-Index:999; right: 5px; margin-top: 5px;">
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
		<!-- CONTENIDO MAPA -->
</div>

<div id="my_content" class="row">
	<!-- CONTENIDO DATA -->
	<div class='row my_label'>
	<font face='Verdana, Arial, Helvetica, sans-serif' size='-1'><b>Municipio <?php echo $sh[0]['municipio']; ?></font>
	</div>
	<div class='row' style='text-align:center;'>
	<table style='width:100%' border=1>																		
	<!--<tr><th colspan=2></th></tr>-->																			
	<tr>																								
		<td style='vertical-align: top;' width='50%'>																
			<div class='ficha'><b>Municipio</b>: 	<?php echo $sh[0]['municipio']; ?> 		</div>				
			<div class='ficha'><b>Departamento</b>:	<?php echo 'San Salvador'?>				</div>					
			<div class='ficha'><b>Probabilidad</b>:	<?php echo $sh[0]['probabilidad']; ?>	</div>			
			<div class='ficha'><b>Impacto</b>:		<?php echo $sh[0]['impacto']; ?>		</div>				
			<div class='ficha'><b>Horario</b>:		<?php echo $sh[0]['horarios']; ?>		</div>				
			<div class='ficha'><b>Consecuencias</b>:<?php echo $sh[0]['consecuencias']; ?>	</div>			
		</td>																							
		<td style='vertical-align: top;' width='50%'>																
			<div class='ficha'><b>Color</b>:			<?php echo $sh[0]['color']; ?>			</div>										
			<div class='ficha'><b>Categoria</b>:		<?php echo $sh[0]['categoria']; ?>			</div>										
			<div class='ficha'><b>Especial Atencion</b>:<?php echo $sh[0]['especial_atencion']; ?> 	</div>
			<div class='ficha'><b>Descripción</b>:		<?php echo $sh[0]['descripcion']; ?> 		</div>		
		</td>																							
																										
	</tr>																								
	</table>	
	</div>
	<!-- CONTENIDO DATA -->
</div>

	<!-- CONTENIDO PIE -->
	<div id="footer" class="row" style="text-align:center;"><br>
			<p style="text-align:center;margin-left:5px;margin-right:5px;width:auto;">
				<font size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<br> PIE DE PAGINA <br>
				</font>
			</p>
	</div>
	<!-- CONTENIDO PIE -->

</div>
<script src="fancybox/dist/jquery.fancybox.min.js"></script>
</body>
</html>
</body>
</html>
