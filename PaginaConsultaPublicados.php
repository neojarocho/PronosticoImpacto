
<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');
//// --------------------------------------- (ULTIMOS PRONOSTICOS DE IMPACTO) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ULTIMOS


//ULTIMO PUBLICADO ACTUAL
$sqlUnificado="SELECT id_unificado, nivel_impacto_publicado
FROM public.unificado u
where  now() <= f_pronosticos_activos (u.fecha_publicado,(SELECT p.horas FROM public.periodo_impacto p where p.periodo=u.periodo))
AND publicar = true order by id_unificado LIMIT 1";
$resultUnificado = pg_query($sqlUnificado) or die('Query failed: '.pg_last_error());
$Unificados = pg_fetch_all($resultUnificado);
$Unificados = $Unificados[0];



// ULTIMO DE LLUVIAS
$sqlUnificadoLluvi="SELECT id_unificado, nivel_impacto_publicado
FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND publicar = TRUE  
order by fecha_publicado desc LIMIT 1";
$resultUnificadoLluvi = pg_query($sqlUnificadoLluvi) or die('Query failed: '.pg_last_error());
$UnificadosLluvi = pg_fetch_all($resultUnificadoLluvi);
$UnificadosLluvi = $UnificadosLluvi[0];


// ULTIMO DE TEMPORAL
$sqlUnificadoTemporal="SELECT id_unificado, nivel_impacto_publicado
FROM public.unificado WHERE fenomeno='Temporal' AND publicar = TRUE  
order by fecha_publicado desc LIMIT 1";
$resultUnificadoTemporal = pg_query($sqlUnificadoTemporal) or die('Query failed: '.pg_last_error());
$UnificadosTemporal = pg_fetch_all($resultUnificadoTemporal);
$UnificadosTemporal = $UnificadosTemporal[0];




//// --------------------------------------- (Lluvias intensas y tormentas eléctricas) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_NOW="SELECT u.id_unificado,u.fenomeno, u.titulo_general, (SELECT p.horas FROM public.periodo_impacto p WHERE p.periodo=u.periodo) as periodo,to_char(u.fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(u.fecha_publicado, 'HH24:MI') as hora , extract(day from  u.fecha_publicado), u.des_categoria, (CASE WHEN u.nivel_impacto_publicado ISNULL THEN '1' 
            ELSE u.nivel_impacto_publicado
       END) as nivel FROM public.unificado u WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND publicar = TRUE AND periodo IN ('Now Casting  (1 hora)','Now Casting  (2 hora)','Now Casting  (3 hora)','Now Casting  (6 horas)','12 horas') order by fecha_publicado desc";
$sqlGridImpactoDiarioHisLLUVIAS_NOW = pg_query($sqlGridImpactoDiarioHisLLUVIAS_NOW) or die('Query failed: '.pg_last_error());
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_24="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(fecha_publicado, 'HH24:MI') as hora , extract(day from  fecha_publicado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND publicar = TRUE AND periodo ='24 horas' order by fecha_publicado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_24 = pg_query($sqlGridImpactoDiarioHisLLUVIAS_24) or die('Query failed: '.pg_last_error());
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_48="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(fecha_publicado, 'HH24:MI') as hora , extract(day from  fecha_publicado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND publicar = TRUE AND periodo ='48 horas' order by fecha_publicado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_48 = pg_query($sqlGridImpactoDiarioHisLLUVIAS_48) or die('Query failed: '.pg_last_error());
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_72="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(fecha_publicado, 'HH24:MI') as hora , extract(day from  fecha_publicado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND publicar = TRUE AND periodo ='72 horas' order by fecha_publicado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_72 = pg_query($sqlGridImpactoDiarioHisLLUVIAS_72) or die('Query failed: '.pg_last_error());




//// --------------------------------------- (Temporal) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- TEMPORAL
//// --------------------------------------- (Lluvias intensas y tormentas eléctricas) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_NOW="SELECT u.id_unificado,u.fenomeno, u.titulo_general, (SELECT p.horas FROM public.periodo_impacto p WHERE p.periodo=u.periodo) as periodo,to_char(u.fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(u.fecha_publicado, 'HH24:MI') as hora , extract(day from  u.fecha_publicado), u.des_categoria, (CASE WHEN u.nivel_impacto_publicado ISNULL THEN '1' 
            ELSE u.nivel_impacto_publicado
       END) as nivel FROM public.unificado u WHERE fenomeno='Temporal' AND publicar = TRUE AND periodo IN ('Now Casting  (1 hora)','Now Casting  (2 hora)','Now Casting  (3 hora)','Now Casting  (6 horas)','12 horas') order by fecha_publicado desc";
$sqlGridImpactoDiarioHisTEMPORAL_NOW = pg_query($sqlGridImpactoDiarioHisTEMPORAL_NOW) or die('Query failed: '.pg_last_error());
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_24="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(fecha_publicado, 'HH24:MI') as hora , extract(day from  fecha_publicado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Temporal' AND publicar = TRUE AND periodo ='24 horas' order by fecha_publicado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_24 = pg_query($sqlGridImpactoDiarioHisTEMPORAL_24) or die('Query failed: '.pg_last_error());

////----------------------------------------------------------------------------------------------------------------
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_48="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(fecha_publicado, 'HH24:MI') as hora , extract(day from  fecha_publicado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Temporal' AND publicar = TRUE AND periodo ='48 horas' order by fecha_publicado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_48 = pg_query($sqlGridImpactoDiarioHisTEMPORAL_48) or die('Query failed: '.pg_last_error());

////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_72="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_publicado, 'DD/MM/YYYY') as fecha, to_char(fecha_publicado, 'HH24:MI') as hora , extract(day from  fecha_publicado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Temporal' AND publicar = TRUE AND periodo ='72 horas' order by fecha_publicado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_72 = pg_query($sqlGridImpactoDiarioHisTEMPORAL_72) or die('Query failed: '.pg_last_error());




?>
<style type="text/css">
  .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #2e3740 !important;
}  

</style>


<script>

function getBotonPublicado(id_unificado, nivel) {
$("#contenedorprincipal").load("mapa_web.php",{id:id_unificado,N:nivel});
//console.log(id_unificado,nivel);
}


function BotonVerPronosticoLluvia(id_unificado, nivel) {
    $("#VerPronosticoLluvia").html('');
var html = "<iframe id='miFrameLluvia' src='http://srt.marn.gob.sv/web/PronosticoImpacto/mapa_web.php?id="+id_unificado+"&N="+nivel+"' width='100%' height='0' scrolling='no' frameborder='0' transparency='transparency' onload='autofitIframe(this);'></iframe>";
$("#VerPronosticoLluvia").html(html);

}


function BotonVerPronosticoTemporal(id_unificado, nivel) {
    $("#VerPronosticoTemporal").html('');
var html = "<iframe id='miFrameTemporal' src='http://srt.marn.gob.sv/web/PronosticoImpacto/mapa_web.php?id="+id_unificado+"&N="+nivel+"' width='100%' height='0' scrolling='no' frameborder='0' transparency='transparency' onload='autofitIframe(this);'></iframe>";
$("#VerPronosticoTemporal").html(html);

}




</script>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<title>Informe Impacto</title>
        <!--
        <link href="css/kendo.common.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/kendo.default.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/site2.css" rel="stylesheet" type="text/css"/>
        <link href="css/site.css" rel="stylesheet" type="text/css"/>  
        <link href="css/kendo.dataviz.default.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/kendo.dataviz.min.css" rel="stylesheet" type="text/css"/> 
        -->



    <script>


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



<div class="container-fluid">
    <br>
<!--   <h2>Pronosticos de Impacto</h2>
  <p>La dirección del Observatorio Ambiental pode a su dispocición la publicación de informes de pronosticos de impactos.</p> -->
  <ul class="nav nav-pills nav-justified" style="color:#2e3740;">
    <li class="active"><a data-toggle="pill" href="#home">Actual Publicado</a></li>
    <li><a data-toggle="pill" href="#menu1" onclick="BotonVerPronosticoLluvia(<?php echo $UnificadosLluvi['id_unificado'];?>,<?php echo $UnificadosLluvi['nivel_impacto_publicado'];?>)">Lluvias Intensas y Tormentas Eléctricas</a></li>
    <li><a data-toggle="pill" href="#menu2"onclick="BotonVerPronosticoTemporal(<?php echo $UnificadosTemporal['id_unificado'];?>,<?php echo $UnificadosTemporal['nivel_impacto_publicado'];?>)">Temporal</a></li>
  </ul>
  

<div class="col-md-12" style="border: 1px solid #2e3740;">
</div>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
 <!-- -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*- ACTUALES  -->
 <div class="row"> 
    <div class="col-md-12">
<br>

   <?php 
   if  (count($Unificados['id_unificado'])>0){
     ?> 


<iframe id="miFrame" src="http://srt.marn.gob.sv/web/PronosticoImpacto/mapa_web.php?id=<?php echo $Unificados['id_unificado'];?>&N=<?php echo $Unificados['nivel_impacto_publicado'];?>" width="100%" height="0" scrolling="no" frameborder="0" transparency="transparency" onload="autofitIframe(this);"></iframe>
 <br>
<div class="row"> 
     <div class="col-md-12" style="text-align: center;">
    

        <button type="button" class="btn btn-secondary glyphicon glyphicon-print" id="" onclick="" style="width: 20%;"> <b>Imprimir</b></button>
 <br>
     </div>   
</div>



<?php 

  }
  else {

 ?>
 <div style="text-align:center;">
 				 <div class="col-md-12" style="text-align: center; font-size: 15px; color:#ffffff; background:#337ab7">
					<p style="margin-top: 5px; margin-bottom: 5px;"><b> Por el momento no se encuentra activo ningún pronóstico de impactos publicado</b></p>
				</div>
 
	<img src="http://srt.marn.gob.sv/InformePronosticoImpacto/Imagenes/No_se_esperan_impactos.jpg" style="width: 80% !important;
	  height: auto !important;">
</div> 

<?php 
}
 ?>  

        </div> 









         </div>
<!-- /*/*/*/*/*/*/*/*/*/*/*/*/*/*/* FIN ACTUALES -->


    </div>
    <div id="menu1" class="tab-pane fade">
<!-- /*/*/*/*/*/*/*/*/*/*/*/*/*/*/* LLUVIAS -->
<div class="row"> 
    <div class="col-md-2">
         <br>
		 
		 
			
			<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/lluvias_u.jpg" width="100%" class="img-responsive" />

      


  <ul class="nav nav-pills nav-justified">
    <li class="active"><a data-toggle="pill" href="#NowCasting_LL">Now</a></li>
		<li><a data-toggle="pill" href="#24horas_LL">24</a></li>
    <li><a data-toggle="pill" href="#48horas_LL">48</a></li>
    <li><a data-toggle="pill" href="#72horas_LL">72</a></li>

 
  </ul>
 <div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>


  <div class="tab-content">

<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO NOW  -->
<div id="NowCasting_LL" class="tab-pane fade in active">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_NOW))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoLluvia(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>
					<td><?php echo $row["periodo"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
</div> 

<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->
	<div id="24horas_LL" class="tab-pane fade">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_24))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoLluvia(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 	
	</div>
<!-- -------------------------------------------------------------------------------------------------------- -->	
 <!-- INICIO 48 HORAS  -->
 <div id="48horas_LL" class="tab-pane fade">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_48))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoLluvia(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
</div>
<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 72 HORAS  -->
<div id="72horas_LL" class="tab-pane fade">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_72))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoLluvia(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
</div>
  
  </div>
			
 
         </div>

        <div class="col-md-10"  style="padding-top: 15px; border-left: 1px solid #2e3740;" id="VerPronosticoLluvia">
           <!-- DATOS CARGADOS POR FUNCIÓN -->
        </div>

 </div>
 </div>

<!-- /*/*/*/*/*/*/*/*/*/*/*/*/*/*/* FIN LLUVIAS -->
    <div id="menu2" class="tab-pane fade">
    <!-- /*/*/*/*/*/*/*/*/*/*/*/*/*/*/* TEMPORAL -->
<div class="row"> 
    <div class="col-md-2">
         <br>
		 
		 
			
			<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/temporal_u.jpg" width="100%" class="img-responsive" />

      


  <ul class="nav nav-pills nav-justified">
    <li class="active"><a data-toggle="pill" href="#NowCasting_T">Now</a></li>
		<li><a data-toggle="pill" href="#24horas_T">24</a></li>
    <li><a data-toggle="pill" href="#48horas_T">48</a></li>
    <li><a data-toggle="pill" href="#72horas_T">72</a></li>

 
  </ul>
 <div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>


  <div class="tab-content">

<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO NOW  -->
<div id="NowCasting_T" class="tab-pane fade in active">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_NOW))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoTemporal(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>		
					<td><?php echo $row["periodo"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
</div> 

<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->

	<div id="24horas_T" class="tab-pane fade">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_24))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoTemporal(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 	
	</div>
<!-- -------------------------------------------------------------------------------------------------------- -->	
 <!-- INICIO 48 HORAS  -->
 <div id="48horas_T" class="tab-pane fade">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_48))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoTemporal(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
</div>
<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 72 HORAS  -->
<div id="72horas_T" class="tab-pane fade">
	<br>
        <div>  
            <table class="table table-bordered"> 
               
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_72))  
                {  
                ?>  
                <tr style="color:#FFFFFF; background-color:#2e3740;">
                    <td align="center"><button type="button" class="btn btn-secondary glyphicon glyphicon-search btn-xs" onClick="BotonVerPronosticoTemporal(<?php echo $row["id_unificado"];?>,<?php echo $row["nivel"]; ?>)">
                        </button></td>
                    <td><?php echo $row["fecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>					
             
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
</div>
  
  </div>
			
 
         </div>

        <div class="col-md-10"  style="padding-top: 15px; border-left: 1px solid #2e3740;" id="VerPronosticoTemporal">
           <!-- DATOS CARGADOS POR FUNCIÓN -->
        </div>

 </div>

    <!-- /*/*/*/*/*/*/*/*/*/*/*/*/*/*/* FIN TEMPORAL -->
    </div>
  </div>
</div>





</body>
</html>







      