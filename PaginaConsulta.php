<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

//// --------------------------------------- (ULTIMOS PRONOSTICOS DE IMPACTO 24) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ULTIMOS
$sqlGridImpactoDiarioHisULTIMOS_24="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fecha_ingresado > (CURRENT_DATE - interval '2 week') AND periodo = '24 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisULTIMOS_24 = pg_query($sqlGridImpactoDiarioHisULTIMOS_24) or die('Query failed: '.pg_last_error());


//// --------------------------------------- (ULTIMOS PRONOSTICOS DE IMPACTO 48) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ULTIMOS
$sqlGridImpactoDiarioHisULTIMOS_48="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fecha_ingresado > (CURRENT_DATE - interval '2 week') AND periodo = '48 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisULTIMOS_48 = pg_query($sqlGridImpactoDiarioHisULTIMOS_48) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (ULTIMOS PRONOSTICOS DE IMPACTO 72) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ULTIMOS
$sqlGridImpactoDiarioHisULTIMOS_72="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fecha_ingresado > (CURRENT_DATE - interval '2 week') AND periodo = '72 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisULTIMOS_72 = pg_query($sqlGridImpactoDiarioHisULTIMOS_72) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (ULTIMOS PRONOSTICOS DE IMPACTO NOW) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ULTIMOS
$sqlGridImpactoDiarioHisULTIMOS_N="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fecha_ingresado > (CURRENT_DATE - interval '2 week') AND periodo in ('12 horas','Now Casting  (1 hora)','Now Casting  (2 hora)','Now Casting  (3 hora)','Now Casting  (6 horas)') order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisULTIMOS_N = pg_query($sqlGridImpactoDiarioHisULTIMOS_N) or die('Query failed: '.pg_last_error());










//// --------------------------------------- (Lluvias intensas y tormentas eléctricas 24) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_24="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND periodo = '24 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_24 = pg_query($sqlGridImpactoDiarioHisLLUVIAS_24) or die('Query failed: '.pg_last_error());

//// --------------------------------------- (Lluvias intensas y tormentas eléctricas 48) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_48="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND periodo = '48 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_48 = pg_query($sqlGridImpactoDiarioHisLLUVIAS_48) or die('Query failed: '.pg_last_error());

//// --------------------------------------- (Lluvias intensas y tormentas eléctricas 72) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_72="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel, (CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas' AND periodo = '72 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_72 = pg_query($sqlGridImpactoDiarioHisLLUVIAS_72) or die('Query failed: '.pg_last_error());

//// --------------------------------------- (Lluvias intensas y tormentas eléctricas NOW) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS_N="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas'  AND periodo in ('12 horas','Now Casting  (1 hora)','Now Casting  (2 hora)','Now Casting  (3 hora)','Now Casting  (6 horas)') order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisLLUVIAS_N = pg_query($sqlGridImpactoDiarioHisLLUVIAS_N) or die('Query failed: '.pg_last_error());








//// --------------------------------------- (Temporal 24) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_24="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Temporal' AND periodo = '24 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_24 = pg_query($sqlGridImpactoDiarioHisTEMPORAL_24) or die('Query failed: '.pg_last_error());

//// --------------------------------------- (Temporal 48) -------------------------------------- TEMPORAL
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_48="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Temporal' AND periodo = '48 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_48 = pg_query($sqlGridImpactoDiarioHisTEMPORAL_48) or die('Query failed: '.pg_last_error());

//// --------------------------------------- (Temporal 72) -------------------------------------- TEMPORAL
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_72="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Temporal' AND periodo = '72 horas' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_72 = pg_query($sqlGridImpactoDiarioHisTEMPORAL_72) or die('Query failed: '.pg_last_error());

//// --------------------------------------- (Temporal NOW) -------------------------------------- TEMPORAL
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisTEMPORAL_N="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Temporal'  AND periodo in ('12 horas','Now Casting  (1 hora)','Now Casting  (2 hora)','Now Casting  (3 hora)','Now Casting  (6 horas)') order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisTEMPORAL_N = pg_query($sqlGridImpactoDiarioHisTEMPORAL_N) or die('Query failed: '.pg_last_error());














//// --------------------------------------- (Temporal) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- TEMPORAL
$sqlGridImpactoDiarioHisTEMPORAL="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Temporal' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisTEMPORAL = pg_query($sqlGridImpactoDiarioHisTEMPORAL) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Sequía) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- SEQUIA
$sqlGridImpactoDiarioHisSEQUIA="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Sequía' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisSEQUIA = pg_query($sqlGridImpactoDiarioHisSEQUIA) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Vientos Fuertes) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- VIENTOS
$sqlGridImpactoDiarioHisVIENTOS="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Vientos Fuertes' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisVIENTOS = pg_query($sqlGridImpactoDiarioHisVIENTOS) or die('Query failed: '.pg_last_error());




//// --------------------------------------- (Erupción Volcánica) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ERUPCION
$sqlGridImpactoDiarioHisERUPCION="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Erupción Volcanica' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisERUPCION = pg_query($sqlGridImpactoDiarioHisERUPCION) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Sismo) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- SISMO
$sqlGridImpactoDiarioHisSISMO="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel,(CASE WHEN publicar='1'  THEN 'Si' WHEN publicar='0'  THEN 'No' WHEN publicar isnull  THEN 'No'END) as publicar,	   
	   (CASE WHEN enviar_instituciones='1'  THEN 'Si' WHEN enviar_instituciones='0'  THEN 'No' WHEN enviar_instituciones isnull  THEN 'No'END) as enviar_instituciones, 
	   (CASE WHEN envio_general='1'  THEN 'Si' WHEN envio_general='0'  THEN 'No' WHEN envio_general isnull  THEN 'No'END) as envio_general  FROM public.unificado WHERE fenomeno='Sismo' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisSISMO = pg_query($sqlGridImpactoDiarioHisSISMO) or die('Query failed: '.pg_last_error());





?>



<script>

function getBotonPublicado(id_unificado, nivel) {
$("#contenedorprincipal").load("mapa_alertas_Publicar.php",{id_unificado:id_unificado,nivel:nivel});
console.log(id_unificado,nivel);
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

        <script src="js/jquery.lwMultiSelect.js"></script>
        <link rel="stylesheet" href="js/jquery.lwMultiSelect.css" />

        <script src="js/kendo.all.min.js" type="text/javascript"></script>
        <script src="js/kendo.aspnetmvc.min.js" type="text/javascript"></script>
        <script src="js/kendo.culture.es-SV.min.js" type="text/javascript"></script>



<style type="text/css">
  .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #2e3740!important;
} 


</style>


    <script>

OcultarTodas();
ULTIMOS.style.display = 'block';

    function visibility(id) {
        var e = document.getElementById(id);
        e.style.display = 'block'; 
    }


    function Ocultar(id) {
        OcultarTodas();  
        visibility(id);
    }


    function OcultarTodas() {
        LLUVIA.style.display = 'none';
        TEMPORAL.style.display = 'none';
        SEQUIA.style.display = 'none';
        VIENTOS.style.display = 'none';
        ERUPCION.style.display = 'none';
        SISMO.style.display = 'none';
        ULTIMOS.style.display = 'none';
    }



// $(function () {
//     $("#BotonLluvias").click(function () {


// toggle_visibility ('LLUVIA');

        
//     });


//     $("#BotonTemporal").click(function () {


// toggle_visibility ('TEMPORAL');

        
//     });

// toggle_visibility ('ULTIMOS');
// toggle_visibility ('LLUVIA');
// toggle_visibility ('TEMPORAL');
// toggle_visibility ('SEQUIA');
// toggle_visibility ('VIENTOS');
// toggle_visibility ('ERUPCION');
// toggle_visibility ('SISMO');
//  });






    </script>
   

</head>
<body>



    <div class="container-fluid">




<!--         <div class="row">
            <div class="col-md-12" style="color:#0d7997">

            <p>La dirección del Obsevatorio ambiental del Ministerio del Medio Ambiente y Recursos Naturales informa sobre la evaluación de las amenazas Meteorológicas, Hidrológicas, Oceanográficas y Geológicas por influencia de fenómenos ambientales.</p>
            <p>Mostrando el pronostico de impactos esperados por cada municio del pais, 
            </div>
        </div> -->

<div style="background: #e4e6e6; padding-top: 15px;padding-bottom: 15px;">


        <div class="row" style="margin: 5px;">
            <div class="col-xs-12">

                <button type="button" id="BotonUltimos" onclick="Ocultar('ULTIMOS');" class="list-group-item active EfectoBtN" style="background-color:#2e3740; text-align: center;">
                   
                    <h5>ÚLTIMOS PRONÓSTICOS INTEGRADOS</h5> </button>


            </div>

 
        </div>


        <div class="row" style="margin: 5px;">
              <p></p>
            <div class="col-xs-2">

                <button type="button" id='BotonLluvias' onclick="Ocultar('LLUVIA');" class="list-group-item active EfectoBtN" 
				style="background-color:#37456a; border-color:#55656f; text-align: center; padding: 3px;">
                    <img width="100%" height="100%" src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/lluvias_u.jpg">
                                    

        

            </div>

            <div class="col-xs-2">

                <button type="button" id='BotonTemporal' onclick="Ocultar('TEMPORAL');" class="list-group-item active text-center EfectoBtN" 
				style="background-color:#97931e;text-align: center; padding: 3px;">
                    <img width="100%" height="100%" src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/temporal_u.jpg">
                    
            </div>

            <div class="col-xs-2">

                <button type="button" id='Boton' onclick="Ocultar('SEQUIA');" class="list-group-item active text-center EfectoBtN" 
				style="background-color:#6f4c8a;text-align: center; padding: 3px;">
                    <img width="100%" height="100%" src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/sequia_u.jpg">
                    

            </div>



            <div class="col-xs-2">


                <button type="button" id='BotonVientos' onclick="Ocultar('VIENTOS');" class="list-group-item active text-center EfectoBtN" 
				style="background-color:#59592e;text-align: center;  padding: 3px;">
                    <img width="100%" height="100%" src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/vientos_u.jpg">
                


            </div>

            <div class="col-xs-2">

                <button type="button" id='BotonErupcion' onclick="Ocultar('ERUPCION');" class="list-group-item active text-center EfectoBtN" 
				style="background-color:#8c4255;text-align: center;  padding: 3px;" >
                    <img width="100%" height="100%" src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/erupcion_u.jpg">
                

        

            </div>

            <div class="col-xs-2">

                <button type="button" id='BotonSismo' onclick="Ocultar('SISMO');" class="list-group-item active text-center EfectoBtN" 
				style="background-color:#147f7a;text-align: center;  padding: 3px;">
                    <img width="100%" height="100%" src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Fenomenos/sismo_u.jpg">
              
            </div>



   <br>
        </div>




        
              




</div>
 <br/>

 <div class="row"> 
 


<!-- 
    //-----------------------------------------ULTIMOS------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="ULTIMOS">
	
	<div  class="col-md-12" style="background: #2e3740; color: white; text-align: center; font-size: 15px;"><h4>ÚLTIMOS PRONÓSTICOS INTEGRADOS</h4></div>

	
 <div class="bhoechie-tab-content active" style="padding-top: 0px;">

		<p></p>
	
	<ul class="nav nav-pills nav-justified" style="color:#2e3740;">
		<li class="active"><a data-toggle="pill" href="#24horas_U">24 horas</b></a></li>
		<li><a data-toggle="pill" href="#48horas_U"><b>48 horas</b></a></li>
		<li><a data-toggle="pill" href="#72horas_U"><b>72 horas</b></a></li>
		<li><a data-toggle="pill" href="#NowCasting_U"><b>Now Casting</b></a></li>
	</ul>
	
<div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>


  <div class="tab-content" >


<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->
		<div id="24horas_U" class="tab-pane fade in active">
        <div id="employee_table">  
            <table class="table table-bordered"> 
         
                <tr style="background:#afc2ce;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="10%">Fecha</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="5%">Período</th>
                        <th style="text-align: center;" width="3%">PW</th>
						<th style="text-align: center;" width="3%">CG</th>
						<th style="text-align: center;" width="3%">CI</th>
						<th style="text-align: center;" width="7%">Categoría</th>             
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisULTIMOS_24))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 


                    <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   

                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["fenomeno"]; ?></td>  
                    <td><?php echo $row["periodo"]; ?></td> 
					<td><?php echo $row["publicar"]; ?></td>
					<td><?php echo $row["envio_general"]; ?></td> 
					<td><?php echo $row["enviar_instituciones"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
         </div>

<!-- FIN 24 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 48 HORAS -->
	<div id="48horas_U" class="tab-pane fade">
        <div id="employee_table">  
            <table class="table table-bordered"> 
             
                <tr style="background:#afc2ce;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="10%">Fecha</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="5%">Período</th>
                        <th style="text-align: center;" width="3%">PW</th>
						<th style="text-align: center;" width="3%">CG</th>
						<th style="text-align: center;" width="3%">CI</th>
						<th style="text-align: center;" width="7%">Categoría</th>          
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisULTIMOS_48))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 


                    <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   

                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["fenomeno"]; ?></td>  
                    <td><?php echo $row["periodo"]; ?></td> 
					<td><?php echo $row["publicar"]; ?></td>
					<td><?php echo $row["envio_general"]; ?></td> 
					<td><?php echo $row["enviar_instituciones"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>               
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 

 </div>

<!-- FIN 48 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 72 HORAS -->
	<div id="72horas_U" class="tab-pane fade">
        <div id="employee_table">  
            <table class="table table-bordered"> 
    
                <tr style="background:#afc2ce;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="10%">Fecha</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="5%">Período</th>
                        <th style="text-align: center;" width="3%">PW</th>
						<th style="text-align: center;" width="3%">CG</th>
						<th style="text-align: center;" width="3%">CI</th>
						<th style="text-align: center;" width="7%">Categoría</th>         
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisULTIMOS_72))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 


                    <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   

                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["fenomeno"]; ?></td>  
                    <td><?php echo $row["periodo"]; ?></td> 
					<td><?php echo $row["publicar"]; ?></td>
					<td><?php echo $row["envio_general"]; ?></td> 
					<td><?php echo $row["enviar_instituciones"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div> 
	</div>
<!-- FIN 72 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO NOW CASTING   -->
	<div id="NowCasting_U" class="tab-pane fade">
        <div id="employee_table">  
            <table class="table table-bordered"> 
    
                <tr style="background:#afc2ce;">
                        <th style="text-align: center;"   width="2%"></th>
                        <th style="text-align: center;"   width="2%"></th> 
                        <th style="text-align: center;"   width="2%"></th>
                        <th style="text-align: center;"   width="2%"></th>
                        <th style="text-align: center;" width="10%">Fecha</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="15%">Fenomeno</th>
                        <th style="text-align: center;" width="15%">Período</th>
                        <th style="text-align: center;" width="2%">PW</th>
						<th style="text-align: center;" width="2%">CG</th>
						<th style="text-align: center;" width="2%">CI</th>
						<th style="text-align: center;" width="6%">Categoría</th>      
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisULTIMOS_N))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 


                    <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   

                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["fenomeno"]; ?></td>  
                    <td><?php echo $row["periodo"]; ?></td> 
					<td><?php echo $row["publicar"]; ?></td>
					<td><?php echo $row["envio_general"]; ?></td> 
					<td><?php echo $row["enviar_instituciones"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>               
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
                        <!-- train section -->
<!-- FIN NOW CASTINGS -->
<!-- -------------------------------------------------------------------------------------------------------- --> 

 </div>
<!-- 
    //----------------------------------------- LLUVIA ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="LLUVIA">
	<div  class="col-md-12" style="background: #37456a; padding: 5px; color: white; text-align: center; font-size: 15px;"><h4>LLUVIAS INTENSAS Y TORMENTAS ELÉCTRICAS</h4></div>

	
 <div class="bhoechie-tab-content active" style="padding-top: 0px;">
    <div class="col-xs-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<p></p>
	
	<ul class="nav nav-pills nav-justified" style="color:#2e3740;">
		<li class="active"><a data-toggle="pill" href="#24horas_LL"><b>24 horas</b></a></li>
		<li><a data-toggle="pill" href="#48horas_LL"><b>48 horas</b></a></li>
		<li><a data-toggle="pill" href="#72horas_LL"><b>72 horas</b></a></li>
		<li><a data-toggle="pill" href="#NowCasting_LL"><b>Now Casting</b></a></li>
	</ul>
	
<div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>


  <div class="tab-content">


<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->
		<div id="24horas_LL" class="tab-pane fade in active">
		        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#a3aecc;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>      
                        <th style="text-align: center;" width="13%">Fecha</th>
                        <th style="text-align: center;" width="67%">Título</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_24))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
</div>  
<!-- FIN 24 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 48 HORAS -->
	<div id="48horas_LL" class="tab-pane fade">
	        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#a3aecc;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="13%">Fecha</th>
                        <th style="text-align: center;" width="67%">Título</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_48))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
</div>  
<!-- FIN 48 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 72 HORAS -->
<div id="72horas_LL" class="tab-pane fade">
	        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#a3aecc;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                       
                        <th style="text-align: center;" width="13%">Fecha</th>
                        <th style="text-align: center;" width="67%">Título</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_72))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
</div>  
<!-- FIN 72 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO NOW CASTING   -->
	<div id="NowCasting_LL" class="tab-pane fade">
        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#a3aecc;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="10%">Fecha</th>
                        <th style="text-align: center;" width="57%">Título</th>
                        <th style="text-align: center;" width="13%">Período</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS_N))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["periodo"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  


</div>  
</div>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                 

							</div>

                        </div>
                        <!-- train section -->
<!-- FIN NOW CASTINGS -->
<!-- -------------------------------------------------------------------------------------------------------- --> 

</div>

         <!-- 
    //-----------------------------------------  TEMPORAL ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="TEMPORAL">
	<div  class="col-md-12" style="background: #97931e; padding: 5px; color: white; text-align: center; font-size: 15px;"><h4>TEMPORAL</h4></div>

	
 <div class="bhoechie-tab-content active" style="padding-top: 0px;">
    <div class="col-xs-12">
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<p></p>
	
	<ul class="nav nav-pills nav-justified" style="color:#2e3740;">
		<li class="active"><a data-toggle="pill" href="#24horas_T"><b>24 horas</b></a></li>
		<li><a data-toggle="pill" href="#48horas_T"><b>48 horas</b></a></li>
		<li><a data-toggle="pill" href="#72horas_T"><b>72 horas</b></a></li>
		<li><a data-toggle="pill" href="#NowCasting_T"><b>Now Casting</b></a></li>
	</ul>
	
<div class="col-xs-12" style="border: 1px solid #2e3740;">
</div>


  <div class="tab-content">


<!-- -------------------------------------------------------------------------------------------------------- -->
 <!-- INICIO 24 HORAS  -->
		<div id="24horas_T" class="tab-pane fade in active">
		        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#ccca9c;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>      
                        <th style="text-align: center;" width="13%">Fecha</th>
                        <th style="text-align: center;" width="67%">Título</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_24))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
</div>  
<!-- FIN 24 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 48 HORAS -->
	<div id="48horas_T" class="tab-pane fade">
	        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#ccca9c;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="13%">Fecha</th>
                        <th style="text-align: center;" width="67%">Título</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_48))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
</div>  
<!-- FIN 48 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO 72 HORAS -->
<div id="72horas_T" class="tab-pane fade">
	        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#ccca9c;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                       
                        <th style="text-align: center;" width="13%">Fecha</th>
                        <th style="text-align: center;" width="67%">Título</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_72))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
</div>  
<!-- FIN 72 HORAS -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- INICIO NOW CASTING   -->
	<div id="NowCasting_T" class="tab-pane fade">
        <div id="employee_table">  
            <table class="table table-bordered"> 

                <tr style="background:#ccca9c;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                        <th style="text-align: center;" width="10%">Fecha</th>
                        <th style="text-align: center;" width="57%">Título</th>
                        <th style="text-align: center;" width="13%">Período</th>
                        <th style="text-align: center;" width="8%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL_N))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                    <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    <td><?php echo $row["periodo"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  


</div>  
</div>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                 

							</div>

                        </div>
                        <!-- train section -->
<!-- FIN NOW CASTINGS -->
<!-- -------------------------------------------------------------------------------------------------------- --> 

</div>



</div>































































         <!-- 
    //-----------------------------------------  SEQUIA ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="SEQUIA">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #6f4c8a; color: white; text-align: center; font-size: 15px;">PRONOSTICOS INTEGRADOS - SEQUIA</caption>
                <tr style="background:#dccfe6;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                       
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>               
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisSEQUIA))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>    
                                        <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    
                    <td><?php echo $row["fenomeno"]; ?></td>  

                    <td><?php echo $row["periodo"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
         </div>


         <!-- 
    //-----------------------------------------  VIENTOS ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="VIENTOS">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #59592e; color: white; text-align: center; font-size: 15px;">PRONOSTICOS INTEGRADOS - VIENTOS FUERTES</caption>
                <tr style="background:#9b9b81;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                       
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>             
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisVIENTOS))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>  
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   
                              <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    
                    <td><?php echo $row["fenomeno"]; ?></td>  

                    <td><?php echo $row["periodo"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
         </div>



         <!-- 
    //-----------------------------------------  ERUPCION ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="ERUPCION">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #8c4255; color: white; text-align: center; font-size: 15px;">PRONOSTICOS INTEGRADOS - ERUPCIÓN VOLCÁNICA</caption>
                <tr style="background:#dcc6cc;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                       
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>          
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisERUPCION))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>    
                           <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    
                    <td><?php echo $row["fenomeno"]; ?></td>  

                    <td><?php echo $row["periodo"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
         </div>



         <!-- 
    //-----------------------------------------  SISMO ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="SISMO">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #147f7a; color: white; text-align: center; font-size: 15px;">PRONOSTICOS INTEGRADOS - SISMOS</caption>
                <tr style="background:#b9dddb;">
                        <th style="text-align: center;"   width="3%">View</th>
                        <th style="text-align: center;"   width="3%">Print</th> 
                        <th style="text-align: center;"   width="3%">Submit</th>
                        <th style="text-align: center;"   width="3%">Tweet</th>
                       
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="37%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>           
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisSISMO))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('mapa_alerta_unificado_ver.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                                        <td align="center"><button type="button" class="btn btn-success glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<?php echo $row["nivel"]; ?>')";></button></td>   

                              <td align="center"><button type="button" class="btn btn-primary glyphicon glyphicon glyphicon-text-width btn-xs" onClick="window.open('mapa_alerta_unificado_twett.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td><?php echo $row["fecha"]; ?></td> 
                    <td><?php echo $row["titulo_general"]; ?></td> 
                    
                    <td><?php echo $row["fenomeno"]; ?></td>  

                    <td><?php echo $row["periodo"]; ?></td> 
                    <td><?php echo $row["des_categoria"]; ?></td>                
                </tr>  
                <?php  
                }  
                ?>  
            </table>  
        </div>  
         </div>






        </div>




    </div>






</body>
</html>







      