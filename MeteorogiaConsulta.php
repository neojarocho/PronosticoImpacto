<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];

//// AREA
$sqlArea="SELECT id_area, area, color FROM public.area WHERE id_area= $id_area_Ini;";
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

//// INICIO GRID EN PROCESOS ******************************************************************************************

//// 24 Horas
$sqlGridImpactoDiario24="SELECT id.id_impacto_diario, to_char(id.fecha, 'DD/MM/YYYY') as fecha, to_char(id.fecha, 'HH24:MI:SS') as hora, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto), id.no_impactos as cantidad
  FROM public.impacto_diario id WHERE id.id_periodo = 3 AND id_estado_impacto <> '6' and id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." order by id.fecha desc";
$resultGridImpactoDiario24 = pg_query($sqlGridImpactoDiario24) or die('Query failed: '.pg_last_error());

//// 48 Horas
$sqlGridImpactoDiario48="SELECT id.id_impacto_diario, to_char(id.fecha, 'DD/MM/YYYY') as fecha, to_char(id.fecha, 'HH24:MI:SS') as hora, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto), id.no_impactos as cantidad
  FROM public.impacto_diario id WHERE id.id_periodo = 4 AND id_estado_impacto <> '6' and id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." order by id.fecha desc";
$resultGridImpactoDiario48 = pg_query($sqlGridImpactoDiario48) or die('Query failed: '.pg_last_error());

//// 72 Horas
$sqlGridImpactoDiario72="SELECT id.id_impacto_diario, to_char(id.fecha, 'DD/MM/YYYY') as fecha, to_char(id.fecha, 'HH24:MI:SS') as hora, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto), id.no_impactos as cantidad
  FROM public.impacto_diario id WHERE id.id_periodo = 5 AND id_estado_impacto <> '6' and id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." order by id.fecha desc";
$resultGridImpactoDiario72 = pg_query($sqlGridImpactoDiario72) or die('Query failed: '.pg_last_error());
//// FIN GRID EN PROCESOS ******************************************************************************************

//// NOW CASTING Horas
$sqlGridImpactoDiarioNOW="SELECT id.id_impacto_diario, to_char(id.fecha, 'DD/MM/YYYY') as fecha, to_char(id.fecha, 'HH24:MI:SS') as hora, id.correlativo, id.titulo, id.descripcion, 
(SELECT pi.periodo FROM public.periodo_impacto pi where id.id_periodo=pi.id_periodo), 
(SELECT ei.estado_impacto FROM public.estado_impacto ei where id.id_estado_impacto=ei.id_estado_impacto), id.no_impactos as cantidad
  FROM public.impacto_diario id WHERE id.id_periodo in (6,7,8,1,2) AND id_estado_impacto <> '6' and id.id_area = ".$id_area_Ini." AND id.id_fenomeno = ".$id_fenomeno_Ini." order by id.fecha desc";
$resultGridImpactoDiarioNOW = pg_query($sqlGridImpactoDiarioNOW) or die('Query failed: '.pg_last_error());




//// HISTORICOS ******************************************************************************************
//// 24 Horas
$sqlGridImpactoDiario_his_24="SELECT his.id_his_impacto_diario, to_char(his.fecha_historico, 'DD/MM/YYYY') as fecha, to_char(his.fecha_historico, 'HH24:MI:SS') as hora, his.titulo,
(SELECT count (dd.id_his_impacto_diario_detalle) FROM public.his_impacto_diario_detalle dd where his.id_his_impacto_diario=dd.id_his_impacto_diario) as cantidad
FROM public.his_impacto_diario his
WHERE his.id_periodo = 3 AND his.id_area = ".$id_area_Ini." AND his.id_fenomeno = ".$id_fenomeno_Ini." order by his.fecha_historico desc";
$resultGridImpactoDiario_his_24 = pg_query($sqlGridImpactoDiario_his_24) or die('Query failed: '.pg_last_error());

//// 48 Horas
$sqlGridImpactoDiario_his_48="SELECT his.id_his_impacto_diario, to_char(his.fecha_historico, 'DD/MM/YYYY') as fecha, to_char(his.fecha_historico, 'HH24:MI:SS') as hora, his.titulo,
(SELECT count (dd.id_his_impacto_diario_detalle) FROM public.his_impacto_diario_detalle dd where his.id_his_impacto_diario=dd.id_his_impacto_diario) as cantidad
FROM public.his_impacto_diario his
WHERE his.id_periodo = 4 AND his.id_area = ".$id_area_Ini." AND his.id_fenomeno = ".$id_fenomeno_Ini." order by his.fecha_historico desc";
$resultGridImpactoDiario_his_48 = pg_query($sqlGridImpactoDiario_his_48) or die('Query failed: '.pg_last_error());

//// 72 Horas
$sqlGridImpactoDiario_his_72="SELECT his.id_his_impacto_diario, to_char(his.fecha_historico, 'DD/MM/YYYY') as fecha, to_char(his.fecha_historico, 'HH24:MI:SS') as hora, his.titulo,
(SELECT count (dd.id_his_impacto_diario_detalle) FROM public.his_impacto_diario_detalle dd where his.id_his_impacto_diario=dd.id_his_impacto_diario) as cantidad
FROM public.his_impacto_diario his
WHERE his.id_periodo = 5 AND his.id_area = ".$id_area_Ini." AND his.id_fenomeno = ".$id_fenomeno_Ini." order by his.fecha_historico desc";
$resultGridImpactoDiario_his_72 = pg_query($sqlGridImpactoDiario_his_72) or die('Query failed: '.pg_last_error());
//// FIN GRID EN PROCESOS ******************************************************************************************

//// NOW CASTING Horas
$sqlGridImpactoDiario_his_NOW="SELECT his.id_his_impacto_diario, to_char(his.fecha_historico, 'DD/MM/YYYY') as fecha, to_char(his.fecha_historico, 'HH24:MI:SS') as hora, his.titulo, 
(SELECT pi.periodo FROM public.periodo_impacto pi where his.id_periodo=pi.id_periodo) as periodo,
(SELECT count (dd.id_his_impacto_diario_detalle) FROM public.his_impacto_diario_detalle dd where his.id_his_impacto_diario=dd.id_his_impacto_diario) as cantidad
FROM public.his_impacto_diario his
WHERE his.id_periodo in (6,7,8,1,2) AND his.id_area = ".$id_area_Ini." AND his.id_fenomeno = ".$id_fenomeno_Ini." order by his.fecha_historico desc";
$resultGridImpactoDiario_his_NOW = pg_query($sqlGridImpactoDiario_his_NOW) or die('Query failed: '.pg_last_error());




// echo "<pre>";
// print_r($Fenomeno_Info);
// echo $Fenomeno_Info[0]["fenomeno"];
// echo "</pre>";
// exit();


//// GRID EN HVALIDAR
$sqlGridImpactoValidar="SELECT h.id_his_impacto_diario, to_char(h.fecha_historico, 'DD/MM/YYYY') as fecha, to_char(h.fecha_historico, 'HH24:MI') as hora, h.titulo, (SELECT p.periodo FROM public.periodo_impacto p where p.id_periodo=h.id_periodo) as periodo, 
	
	(CASE WHEN (SELECT count (v.id_verificacion)
				FROM public.his_impacto_diario_detalle v
				WHERE v.id_his_impacto_diario=h.id_his_impacto_diario) = 0   THEN 'No'
              ELSE 'Si'
       END) as validado  
	FROM public.his_impacto_diario h
	where h.id_area = ".$id_area_Ini." AND h.id_fenomeno = ".$id_fenomeno_Ini." ORDER BY h.fecha_historico desc";
$resultGridImpactoValidar = pg_query($sqlGridImpactoValidar) or die('Query failed: '.pg_last_error());





?>

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
$(function () {
    $("#BotonNuevoInforme").click(function () {
        $("#contenedorprincipal").load("MeteorologiaIngreso.php",
			{
				id_area:<?php echo $id_area_Ini; ?>,
				id_fenomeno:<?php echo $id_fenomeno_Ini; ?>,
				area:'<?php echo $Area_Info[0]["area"]; ?>',
				fenomeno:'<?php echo $Fenomeno_Info[0]["fenomeno"]; ?>'
			}
		);
    });
 });

$("#BotonNuevoInforme").click(function () {

});

function b_edi(id) {
	console.log("editar:"+id);
	$("#contenedorprincipal").load("MeteorologiaEdicion.php",
		{
			id_area:<?php echo $id_area_Ini; ?>,
			id_fenomeno:<?php echo $id_fenomeno_Ini; ?>,
			area:'<?php echo $Area_Info[0]["area"]; ?>',
			fenomeno:'<?php echo $Fenomeno_Info[0]["fenomeno"]; ?>',
			id_impacto_diario:id
		}
	);
} 
 




function b_del(id) {
  var txt;
  if (confirm("¿Desea eliminar definitivamente este informe de pronóstico de impactos?")) {
    	var midata = {id:id,opcion:'getDelete'};
    $.ajax({
		async : true,
		method: "POST",
		url: "MeteorologiaProcesos.php",
		data: midata,
		success: function(msg){
			//$("#curMuni").html(msg);
			console.log(msg);
			getBotonImpacto(<?php echo $id_area_Ini; ?>,<?php echo $id_fenomeno_Ini; ?>);
       }
     });	
  } else {
    
  }
  document.getElementById("demo").innerHTML = txt;
}







function b_copy(id) {
  var txt;
  if (confirm("¿Desea duplicar este informe de pronóstico de impactos?")) {
    	var midata = {id:id,opcion:'getCopy'};
    $.ajax({
		async : true,
		method: "POST",
		url: "MeteorologiaProcesos.php",
		data: midata,
		success: function(msg){
			//$("#curMuni").html(msg);
			console.log(msg);
			getBotonImpacto(<?php echo $id_area_Ini; ?>,<?php echo $id_fenomeno_Ini; ?>);
       }
     });
  } else {
    
  }
  document.getElementById("demo").innerHTML = txt;
}










function b_his(id) {
  var txt;
  if (confirm("Este informe será aprobado y enviado al historial para luego poder ser validado. Al hacerlo ya no se podrá utilizar para unificar. ¿Está seguro de esta aprobación?")) {



	var midata = {id:id,opcion:'getHis'};
    $.ajax({
		async : true,
		method: "POST",
		url: "MeteorologiaProcesos.php",
		data: midata,
		success: function(msg){

			console.log(msg);
			getBotonImpacto(<?php echo $id_area_Ini; ?>,<?php echo $id_fenomeno_Ini; ?>);
       }
     });	
	
	
	
	
  } else {
    
	
  }
  document.getElementById("demo").innerHTML = txt;
}





function b_comp(id) {
	console.log("comparar:"+id);
	$("#contenedorprincipal").load("VistaInformes.php",
		{
			id_area:<?php echo $id_area_Ini; ?>,
			id_fenomeno:<?php echo $id_fenomeno_Ini; ?>,
			area:'<?php echo $Area_Info[0]["area"]; ?>',
			fenomeno:'<?php echo $Fenomeno_Info[0]["fenomeno"]; ?>',
			id_impacto_diario:id
		}
	);
} 




        $(document).ready(function () {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });




</script>
   
</head>
<body>



<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->

<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->


<div class="container-fluid">  
   
	<div class="row">
		<div class="col-xs-4" style="text-align: center; background: <?php echo $Area_Info[0]["color"]; ?>; color:#ffffff;">

			<h4 style="text-align:left; text-align:left;margin-top: 7px;margin-bottom: 7px;"><?php echo $Area_Info[0]["area"]; ?></h4>	

		</div>
		<div class="col-xs-6" style="text-align: center; background: <?php echo $Area_Info[0]["color"]; ?>; color:#ffffff;">
			<h4 style="text-align:center; text-align:left;margin-top: 7px;margin-bottom: 7px;"	><?php echo $Fenomeno_Info[0]["fenomeno"]; ?></h4>

		</div>
		<div class="col-xs-2" style="text-align: center">
		<button type="button" id="BotonNuevoInforme" style="width:100% !important; height:100% !important; color:#ffffff; background:<?php echo $Area_Info[0]["color"]; ?>;" class="btn btn-dark">Nuevo</button>
		</div>
	</div>




        <!--GRID DINAMICOS-->
        <div class="row">
            <div class="bhoechie-tab-container">
                <div class="col-xs-1 bhoechie-tab-menu">
                    <div class="list-group">
                        <a href="#" class="list-group-item active text-center">
                            <h2 class="glyphicon glyphicon-pencil"></h2><br />Proceso
                        </a>

                        <a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon-book"></h2><br />Historial
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon-ok"></h2><br />Validar
                        </a>
                        <!--<a href="#" class="list-group-item text-center">
                            <h2 class="glyphicon glyphicon-home"></h2><br />Vólcan San Salvador
                        </a>-->


                    </div>
                </div>


                <div class="col-xs-11 bhoechie-tab">
                    <div class="bhoechie-tab">
                        <!-- flight section -->
                        <div class="bhoechie-tab-content active" style="padding-top: 0px;">
                            <div class="col-xs-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<p></p>
	


  <ul class="nav nav-pills nav-justified" style="color:#2e3740;">
    <li class="active"><a data-toggle="pill" href="#24horas"><b>24 horas</b></a></li>
    <li><a data-toggle="pill" href="#48horas"><b>48 horas</b></a></li>
    <li><a data-toggle="pill" href="#72horas"><b>72 horas</b></a></li>
	<li><a data-toggle="pill" href="#NowCasting"><b>Now Casting</b></a></li>
 
  </ul>

<div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>


  <div class="tab-content">

<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->
	<div id="24horas" class="tab-pane fade in active">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">24 HORAS - ( EN PROCESO )</caption>
				<tr style="background:#e5e5e5; text-align:center !important;"> 
						<th width="3%">Edit</th>
						<th width="3%">View</th>
						<th width="3%">Copy</th>
						<th style="text-align:center;" width="3%">Ok</th> 						
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="62%">Título</th>
						<th width="3%">Delete</th>     		
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario24))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-primary glyphicon glyphicon-pencil btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-success glyphicon glyphicon-header btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_his($(this).attr('id'))";></button>
						</td> 						
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>     
						<td><?php echo $row["titulo"]; ?></td> 
						<td align="center">
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>  	
	</div>
<!-- FIN 24 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 48 HORAS -->
	<div id="48horas" class="tab-pane fade">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">48 HORAS - ( EN PROCESO )</caption>
				<tr style="background:#e5e5e5;"> 
						<th width="3%">Edit</th>
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="65%">Título</th>
						<th width="3%">Delete</th>   	
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario48))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-primary glyphicon glyphicon-pencil btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>   
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>    
						<td><?php echo $row["titulo"]; ?></td> 
						<td align="center">
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>   
	</div>
<!-- FIN 48 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 72 HORAS -->
	<div id="72horas" class="tab-pane fade">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">72 HORAS - ( EN PROCESO )</caption>
				<tr style="background:#e5e5e5;"> 
						<th width="3%">Edit</th>
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="65%">Título</th>
						<th width="3%">Delete</th>      		
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario72))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-primary glyphicon glyphicon-pencil btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>   
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>     
						<td><?php echo $row["titulo"]; ?></td>  
						<td align="center">
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>    
	</div>
<!-- FIN 72 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO NOW CASTING   -->
	<div id="NowCasting" class="tab-pane fade">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">NOW CASTING - ( EN PROCESO )</caption>
				<tr style="background:#e5e5e5;"> 
						<th width="3%">Edit</th>
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="50%">Título</th>
						<th style="text-align:center;" width="15%">Período</th>
						<th width="3%">Delete</th>      		
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiarioNOW))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-primary glyphicon glyphicon-pencil btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_edi($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>   
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>   
						<td><?php echo $row["titulo"]; ?></td>
						<td><?php echo $row["periodo"]; ?></td> 						
						<td align="center">
							<button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_del($(this).attr('id'))";></button>
						</td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>  	
	</div>
<!-- FIN NOW CASTINGS -->
<!-- -------------------------------------------------------------------------------------------------------- --> 
</div>



		
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                 

							</div>

                        </div>
                        <!-- train section -->
    
                        <div class="bhoechie-tab-content" style="padding-top: 0px;">
                            <div class="col-xs-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////HSITORICO///////////////////////////////////////////////////////////////////////////////////// -->

		<p></p>
	


  <ul class="nav nav-pills nav-justified" style="color:#2e3740;">
    <li class="active"><a data-toggle="pill" href="#24horas_his"><b>24 horas</b></a></li>
    <li><a data-toggle="pill" href="#48horas_his"><b>48 horas</b></a></li>
    <li><a data-toggle="pill" href="#72horas_his"><b>72 horas</b></a></li>
	<li><a data-toggle="pill" href="#NowCasting_his"><b>Now Casting</b></a></li>
 
  </ul>

<div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>

  <div class="tab-content">

<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->
	<div id="24horas_his" class="tab-pane fade in active">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">24 HORAS - ( HISTORICO )</caption>
				<tr style="background:#e5e5e5; text-align:center !important;"> 
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="65%">Título</th>
								
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario_his_24))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_his_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_his_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>     
						<td><?php echo $row["titulo"]; ?></td> 
					</tr>  
				<?php  
				}  
				?>  
			</table>  	
	</div>
<!-- FIN 24 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 48 HORAS -->
	<div id="48horas_his" class="tab-pane fade">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">48 HORAS - ( HISTORICO )</caption>
				<tr style="background:#e5e5e5;"> 
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="65%">Título</th>
							
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario_his_48))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_his_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_his_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>   
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>    
						<td><?php echo $row["titulo"]; ?></td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>   
	</div>
<!-- FIN 48 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 72 HORAS -->
	<div id="72horas_his" class="tab-pane fade">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">72 HORAS - ( HISTORICO )</caption>
				<tr style="background:#e5e5e5;"> 
						
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="65%">Título</th>
						     		
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario_his_72))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_his_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_his_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>   
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>     
						<td><?php echo $row["titulo"]; ?></td>  
					</tr>  
				<?php  
				}  
				?>  
			</table>    
	</div>
<!-- FIN 72 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO NOW CASTING   -->
	<div id="NowCasting_his" class="tab-pane fade">
	<br>
				<table class="table table-bordered"> 
				<caption  style="background: <?php echo $Area_Info[0]["color"]; ?>; color: #ffffff; text-align: center;">NOW CASTING - ( HISTORICO )</caption>
				<tr style="background:#e5e5e5;"> 
						
						<th width="3%">View</th>
						<th width="3%">Copy</th>  
						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th style="text-align:center;" width="3%">Cant</th>
						<th style="text-align:center;" width="50%">Título</th>
						<th style="text-align:center;" width="15%">Período</th>
						    		
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoDiario_his_NOW))  
				{ 
				?>  
					<tr style="background:#FFFFFF;">
		
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_individual_ver.php?id=<?php echo $row["id_his_impacto_diario"]; ?>')"></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-warning glyphicon glyphicon-duplicate btn-xs" id="<?php echo $row["id_his_impacto_diario"]; ?>" onclick="b_copy($(this).attr('id'))";></button>
						</td>   
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>
						<td style="text-align: center;"><?php echo $row["cantidad"]; ?></td>   
						<td><?php echo $row["titulo"]; ?></td>
						<td><?php echo $row["periodo"]; ?></td> 						

					</tr>  
				<?php  
				}  
				?>  
			</table>  	
	</div>
<!-- FIN NOW CASTINGS -->
<!-- -------------------------------------------------------------------------------------------------------- --> 
</div>



<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                            </div>
                        </div>


                        <div class="bhoechie-tab-content" style="padding-top: 0px;">
                            <div class="col-xs-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


	<div class="table-responsive">
		<div id="employee_table">  
			<table class="table table-bordered"> 
				<caption style="background: #2e3740; color: #ffffff; text-align: center; font-size: 15px;">VALIDACIÓN</caption>
				<tr style="background:#e5e5e5;">  

						<th style="text-align:center;" width="10%">Fecha</th>
						<th style="text-align:center;" width="10%">Hora</th>
						<th width="55%">Título</th>
						<th style="text-align:center;" width="15%">Período</th>
						<th style="text-align:center;" width="4%">Ok</th>
						<th width="3%"></th>
						<th width="3%"></th>
					  
  
				</tr>  
				<?php  
				while($row = pg_fetch_array($resultGridImpactoValidar))  
				{  
				?>  
				<tr style="background:#FFFFFF;">
						<td style="text-align:center;"><?php echo $row["fecha"]; ?></td>
						<td style="text-align:center;"><?php echo $row["hora"]; ?></td>  						
						<td><?php echo $row["titulo"]; ?></td> 
						<td style="text-align:center;"><?php echo $row["periodo"]; ?></td> 
						<td style="text-align:center;"><?php echo $row["validado"]; ?></td> 
						<td align="center">
							<button type="button" class="btn btn-success glyphicon glyphicon-ok btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" onclick="b_Validar($(this).attr('id'))";></button>
						</td>
						<td align="center">
							<button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>" 	onclick="b_Consultar($(this).attr('id'))";></button>
						</td> 

				</tr>  
				<?php  
				}  
				?>  
			</table>  
		</div>  
	</div> 
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>


</div>




<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->
<!-- ---*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-- -->






















 <script>  
$(document).ready(function(){
	$('#add').click(function(){  
		$('#insert').val("Insert");  
		$('#insert_form')[0].reset();  
      });  
	$(document).on('click', '.edit_data', function(){
		var employee_id = $(this).attr("id");  
		$.ajax({
			url:"fetch.php",  
			method:"POST",  
			data:{employee_id:employee_id},  
			dataType:"json",  
			success:function(data){
				$('#name').val(data.name);  
				$('#address').val(data.address);  
				$('#gender').val(data.gender);  
				$('#designation').val(data.designation);  
				$('#age').val(data.age);  
				$('#employee_id').val(data.id);  
				$('#insert').val("Update");  
				$('#add_data_Modal').modal('show');  
			}  
		});  
	});  
	$('#insert_form').on("submit", function(event){
		event.preventDefault();  
		if($('#name').val() == "") {
			alert("Name is required");  
		}
		else if($('#address').val() == '') {
			alert("Address is required");  
		}  
		else if($('#designation').val() == '') {
			alert("Designation is required");  
		}  
		else if($('#age').val() == '') {
			alert("Age is required");  
		}
		else { 
			$.ajax({  
				url:"insert.php",  
				method:"POST",  
				data:$('#insert_form').serialize(),  
				beforeSend:function(){  
					$('#insert').val("Inserting");  
				},  
				success:function(data){  
					$('#insert_form')[0].reset();  
					$('#add_data_Modal').modal('hide');  
					$('#employee_table').html(data);  
				}  
			});  
		}  
	});  
	$(document).on('click', '.view_data', function(){
	var employee_id = $(this).attr("id");  
	if(employee_id != '')  
		{  
		$.ajax({
			url:"select.php",  
			method:"POST",  
			data:{employee_id:employee_id},  
			success:function(data){  
				$('#employee_detail').html(data);  
				$('#dataModal').modal('show');  
			}  
		});  
		}           
	});  
});  
</script>

<!-- ********************************* -->
</body>
</html>
