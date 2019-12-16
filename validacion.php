<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_impacto_diario = $_REQUEST['id_impacto_diario'];

//// AREA
$sqlArea="SELECT h.id_area, (SELECT  a.color FROM public.area a WHERE a.id_area=h.id_area) as color 
FROM public.his_impacto_diario h WHERE h.id_his_impacto_diario = $id_impacto_diario";
$resultArea = pg_query($sqlArea) or die('Query failed: '.pg_last_error());  
while($row = pg_fetch_array($resultArea, null, PGSQL_ASSOC)) {
$Area_Info[] = $row;
} pg_free_result($resultArea);







?>


<script>




</script>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>


<style type="text/css">
  .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #2e3740!important;
} 



div.bhoechie-tab-menu div.list-group>a.active, div.bhoechie-tab-menu div.list-group>a.active .glyphicon, div.bhoechie-tab-menu div.list-group>a.active .fa {
    background-color: #2e3740;
    background-image: #ffffff;
    color: #ffffff;
}

div.bhoechie-tab-menu div.list-group>a.active:after {
    border-left: 10px solid #2e3740;
}

.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
    border-color: #ffffff;
}

div.bhoechie-tab-menu div.list-group>a .glyphicon, div.bhoechie-tab-menu div.list-group>a .fa {
    color: #2e3740;
}

a {
    color: #2e3740;
}


.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    padding: 5px;

}

</style>

<script>
function getBotonRetornar(id_area) {

	$("#contenedorprincipal").load("ValidacionConsulta.php",
		{
			id_area:<?php echo $Area_Info[0]["id_area"]; ?>
		}
	);
} 



//Ajusta el tamaño de un iframe al de su contenido interior para evitar scroll
function autofitIframe(id){
    console.log(id);
if (!window.opera && document.all && document.getElementById){
id.style.height=id.contentWindow.document.body.scrollHeight;
} else if(document.getElementById) {
id.style.height=id.contentDocument.body.scrollHeight+"px";
}
}


function resizeIframe(obj) {
   obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}



</script>
   
</head>
<body>



<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->

<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->


<div class="container-fluid">  
  	<div class="row">
	
	
	<div class="col-xs-12">
	
	
	<table width="100%" > 
				<tr>
				<td align="center" width="5%"><button type="button" id="BotonRetorno" width="100%" onClick="getBotonRetornar()" style="color:#ffffff; background:<?php echo $Area_Info[0]["color"]; ?>;" class="btn btn-dark glyphicon glyphicon-arrow-left"></button>
	</td>
				<td align="center" style="background: #2e3740; color:#ffffff;" width="95%"><h5>VALIDACIÓN DE PRONÓSTICO DE IMPACTOS</h5></td>
						
				</tr>  
	
	</table>
	
	</div>
	


		<div class="col-xs-12">
		
		<iframe src="http://srt.marn.gob.sv/web/PronosticoImpacto/validacion_mapa.php?id=<?php echo $id_impacto_diario; ?>" width="100%" height="0" scrolling="no" frameborder="0" transparency="transparency" onload="autofitIframe(this);"></iframe>
 	
		</div>

	</div>

	
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
</div>














<!-- ********************************* -->
</body>
</html>
