<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

//// --------------------------------------- (ULTIMOS PRONOSTICOS DE IMPACTO) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ULTIMOS
$sqlGridImpactoDiarioHisULTIMOS="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fecha_ingresado > (CURRENT_DATE - 10) order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisULTIMOS = pg_query($sqlGridImpactoDiarioHisULTIMOS) or die('Query failed: '.pg_last_error());


//// --------------------------------------- (Lluvias intensas y tormentas eléctricas) -------------------------------------- LLUVIAS
////----------------------------------------------------------------------------------------------------------------
$sqlGridImpactoDiarioHisLLUVIAS="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Lluvias intensas y tormentas eléctricas'  order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisLLUVIAS = pg_query($sqlGridImpactoDiarioHisLLUVIAS) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Temporal) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- TEMPORAL
$sqlGridImpactoDiarioHisTEMPORAL="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Temporal' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisTEMPORAL = pg_query($sqlGridImpactoDiarioHisTEMPORAL) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Sequía) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- SEQUIA
$sqlGridImpactoDiarioHisSEQUIA="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Sequía' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisSEQUIA = pg_query($sqlGridImpactoDiarioHisSEQUIA) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Vientos Fuertes) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- VIENTOS
$sqlGridImpactoDiarioHisVIENTOS="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Vientos Fuertes' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisVIENTOS = pg_query($sqlGridImpactoDiarioHisVIENTOS) or die('Query failed: '.pg_last_error());




//// --------------------------------------- (Erupción Volcánica) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- ERUPCION
$sqlGridImpactoDiarioHisERUPCION="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Erupción Volcanica' order by fecha_ingresado desc;";
$sqlGridImpactoDiarioHisERUPCION = pg_query($sqlGridImpactoDiarioHisERUPCION) or die('Query failed: '.pg_last_error());



//// --------------------------------------- (Sismo) --------------------------------------
////---------------------------------------------------------------------------------------------------------------- SISMO
$sqlGridImpactoDiarioHisSISMO="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, extract(day from  fecha_ingresado), des_categoria, (CASE WHEN nivel_impacto_publicado ISNULL THEN '1' 
            ELSE nivel_impacto_publicado
       END) as nivel FROM public.unificado WHERE fenomeno='Sismo' order by fecha_ingresado desc;";
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
            <div class="col-md-12">


                <button type="button" id="BotonUltimos" onclick="Ocultar('ULTIMOS');" class="list-group-item active EfectoBtN" style="background-color:#55656f; text-align: center;">
                   
                    <h5>Últimos Pronósticos</h5> </button>


            </div>

 
        </div>

          <p></p>


        <div class="row" style="margin: 5px;">
              <p></p>
            <div class="col-md-2">

                <button type="button" id='BotonLluvias' onclick="Ocultar('LLUVIA');" class="list-group-item active EfectoBtN" style="background-color:#3b7db5; border-color:#55656f; text-align: center;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Lluvias.png">
                    <h5>Lluvias intensas y tormentas eléctricas</h5> </button>
                    </a>

        

            </div>

            <div class="col-md-2">

                <button type="button" id='BotonTemporal' onclick="Ocultar('TEMPORAL');" class="list-group-item active text-center EfectoBtN" style="background-color:#04b2ce;text-align: center;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Temporal.png">
                    <h5><br/>Temporal</h5></button>

            </div>

            <div class="col-md-2">

                <button type="button" id='Boton' onclick="Ocultar('SEQUIA');" class="list-group-item active text-center EfectoBtN" style="background-color:#6f4c8a;text-align: center;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/sequia.png">
                    <h5><br/>Sequía</h5></button>


            </div>



            <div class="col-md-2">


                <button type="button" id='BotonVientos' onclick="Ocultar('VIENTOS');" class="list-group-item active text-center EfectoBtN" style="background-color:#b9751c;text-align: center;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Vientos.png">
                    <h5><br/>Vientos Fuertes</h5></button>


            </div>

            <div class="col-md-2">

                <button type="button" id='BotonErupcion' onclick="Ocultar('ERUPCION');" class="list-group-item active text-center EfectoBtN" style="background-color:#8c4255;text-align: center;" >
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Erupcion.png">
                    <h5><br/>Erupción Volcánica</h5></button>

        

            </div>

            <div class="col-md-2">

                <button type="button" id='BotonSismo' onclick="Ocultar('SISMO');" class="list-group-item active text-center EfectoBtN" style="background-color:#147f7a;text-align: center;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/sismo.png">
                    <h5><br/>Sismo</h5>  </button>
            </div>



 
        </div>



              




</div>
 <br/>

 <div class="row"> 

<!-- 
    //-----------------------------------------ULTIMOS------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="ULTIMOS">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #55656f; color: white; text-align: center; font-size: 15px;">ÚLTIMOS PRONÓSTICOS DE IMPACTO</caption>
                <tr style="background:#afc2ce;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>               
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisULTIMOS))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 


                    <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>   


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
    //----------------------------------------- LLUVIA ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="LLUVIA">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #428bca; color: white; text-align: center; font-size: 15px;">PRONOSTICOS DE IMPACTOS - LLUVIAS INTENSAS Y TORMENTAS ELÉCTRICAS</caption>
                <tr style="background:#c6dcef;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>            
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisLLUVIAS))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>   
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
    //-----------------------------------------  TEMPORAL ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="TEMPORAL">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #04b2ce; color: white; text-align: center; font-size: 15px;">PRONOSTICOS DE IMPACTOS - TEMPORAL</caption>
                <tr style="background:#cdf3f9;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>                
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisTEMPORAL))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>   
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
    //-----------------------------------------  SEQUIA ------------------------------------- 
    //--------------------------------------------------------------------------------------- -->
    <div class="col-md-12" id="SEQUIA">
        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #6f4c8a; color: white; text-align: center; font-size: 15px;">PRONOSTICOS DE IMPACTOS - SEQUIA</caption>
                <tr style="background:#dccfe6;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>               
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisSEQUIA))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>    
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
                <caption style="background: #b9751c; color: white; text-align: center; font-size: 15px;">PRONOSTICOS DE IMPACTOS - VIENTOS FUERTES</caption>
                <tr style="background:#f8debd;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>               
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisVIENTOS))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>  
                                        <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>   
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
                <caption style="background: #8c4255; color: white; text-align: center; font-size: 15px;">PRONOSTICOS DE IMPACTOS - ERUPCIÓN VOLCÁNICA</caption>
                <tr style="background:#dcc6cc;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>            
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisERUPCION))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
                                        <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>    
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
                <caption style="background: #147f7a; color: white; text-align: center; font-size: 15px;">PRONOSTICOS DE IMPACTOS - SISMOS</caption>
                <tr style="background:#b9dddb;">
                        <th style="text-align: center;"   width="3%"></th>
                        <th style="text-align: center;"   width="3%"></th> 
                        <th style="text-align: center;"   width="3%"></th>     
                        <th style="text-align: center;" width="13%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="8%">Período</th>
                        <th style="text-align: center;" width="10%">Categoría</th>             
                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHisSISMO))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('ConsolidarReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                    <td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-print btn-xs" onClick="window.open('mapa_alertas_Consulta.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td>
                                        <td align="center"><button type="button" class="btn btn-warning glyphicon glyphicon-thumbs-up btn-xs" id="<?php echo $row["id_impacto_diario"]; ?>"  onclick="getBotonPublicado('<?php echo $row["id_unificado"]; ?>','<td><?php echo $row["nivel"]; ?></td>')";></button></td>   

                    
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







      