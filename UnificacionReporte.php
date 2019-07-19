<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');


$id_unificado=$_GET['id'];

///----------------------*************************************-------------------------------------------------
///----------------------*************************************-------------------------------------------------
///----------------------*************************************-------------------------------------------------
/// INFORMACIÓN GENERAL
$sqlUnificado="SELECT id_unificado,fenomeno, titulo_general, des_general, periodo, fecha_ingresado, des_categoria, des_categoria
    FROM public.unificado
    WHERE id_unificado= $id_unificado;
";
$resultUnificado = pg_query($sqlUnificado) or die('Query failed: '.pg_last_error());

$Unificados = pg_fetch_all($resultUnificado);
$Unificados = $Unificados[0];


///----------------------*************************************-------------------------------------------------
///----------------------*************************************-------------------------------------------------
///----------------------*************************************-------------------------------------------------

<<<<<<< HEAD
/// CATEGORIA TOMAR ACCIÓN (ROJO)*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
///*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
$CategoriaROJO = '';

$sqlGridCategoriaROJO="SELECT hd.categoria,hd.no_matriz, concat(ip.descripcion, ' ',hd.consecuencias, '<br> Durante: ',hd.horarios) as mensaje, string_agg(concat(hd.municipio,'',(CASE WHEN hd.especial_atencion ISNULL THEN '' 
            ELSE concat(' (', hd.especial_atencion,')')
       END)), ', ') as municipios, string_agg(distinct hd.departamento,'<br> ') as departamentos, (SELECT  a.imagen   FROM public.area a where a.id_area =ui.id_area) as imagen
FROM public.his_impacto_diario_detalle hd inner join public.impacto_probabilidad ip on ip.id_impacto_probabilidad = hd.no_matriz
inner join public.unificado_informe ui on ui.id_his_impacto_diario= hd.id_his_impacto_diario
WHERE ui.id_unificado= $id_unificado and hd.color='Rojo'
GROUP BY hd.categoria, hd.no_matriz,mensaje,imagen
ORDER BY hd.no_matriz desc;";
$resultGridCategoriaROJO = pg_query($sqlGridCategoriaROJO) or die('Query failed: '.pg_last_error());

$CategoriaROJO = pg_num_rows($resultGridCategoriaROJO);



/// CATEGORIA ESTAR PEROARADOS (ANARANJADO)*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
///*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
$CategoriaANARANJADO = '';

$sqlGridCategoriaANARANJADO="SELECT hd.categoria,hd.no_matriz, concat(ip.descripcion, ' ',hd.consecuencias, '<br> Durante: ',hd.horarios) as mensaje, string_agg(concat(hd.municipio,'',(CASE WHEN hd.especial_atencion ISNULL THEN '' 
            ELSE concat(' (', hd.especial_atencion,')')
       END)), ', ') as municipios, string_agg(distinct hd.departamento,'<br> ') as departamentos, (SELECT  a.imagen   FROM public.area a where a.id_area =ui.id_area) as imagen
FROM public.his_impacto_diario_detalle hd inner join public.impacto_probabilidad ip on ip.id_impacto_probabilidad = hd.no_matriz
inner join public.unificado_informe ui on ui.id_his_impacto_diario= hd.id_his_impacto_diario
WHERE ui.id_unificado= $id_unificado and hd.color='Anaranjado'
GROUP BY hd.categoria, hd.no_matriz,mensaje,imagen
ORDER BY hd.no_matriz desc;";
$resultGridCategoriaANARANJADO = pg_query($sqlGridCategoriaANARANJADO) or die('Query failed: '.pg_last_error());

$CategoriaANARANJADO = pg_num_rows($resultGridCategoriaANARANJADO);





/// CATEGORIA ESTAR INFORMADOS (AMARILLO)*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*
///*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
$CategoriaAMARILLO = '';

$sqlGridCategoriaAMARILLO="SELECT hd.categoria,hd.no_matriz, concat(ip.descripcion, ' ',hd.consecuencias, '<br> Durante: ',hd.horarios) as mensaje, string_agg(concat(hd.municipio,'',(CASE WHEN hd.especial_atencion ISNULL THEN '' 
            ELSE concat(' (', hd.especial_atencion,')')
       END)), ', ') as municipios, string_agg(distinct hd.departamento,'<br> ') as departamentos, (SELECT  a.imagen   FROM public.area a where a.id_area =ui.id_area) as imagen
FROM public.his_impacto_diario_detalle hd inner join public.impacto_probabilidad ip on ip.id_impacto_probabilidad = hd.no_matriz
inner join public.unificado_informe ui on ui.id_his_impacto_diario= hd.id_his_impacto_diario
WHERE ui.id_unificado= $id_unificado and hd.color='Amarillo'
GROUP BY hd.categoria, hd.no_matriz,mensaje,imagen
ORDER BY hd.no_matriz desc;";
$resultGridCategoriaAMARILLO = pg_query($sqlGridCategoriaAMARILLO) or die('Query failed: '.pg_last_error());

$CategoriaAMARILLO = pg_num_rows($resultGridCategoriaAMARILLO);



/// CATEGORIA CONDICIONES NORMALES (VERDE)*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
///*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-**-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*
$CategoriaVERDE = '';

$sqlGridCategoriaVERDE="SELECT hd.categoria,hd.no_matriz, concat(ip.descripcion, ' ',hd.consecuencias, '<br> Durante: ',hd.horarios) as mensaje, string_agg(concat(hd.municipio,'',(CASE WHEN hd.especial_atencion ISNULL THEN '' 
=======
/// CONDICIONES
$sqlGridCondiciones="SELECT hd.categoria,hd.no_matriz, concat(ip.descripcion, ' ',hd.consecuencias, '<br> Durante: ',hd.horarios) as mensaje, string_agg(concat(hd.municipio,'',(CASE WHEN hd.especial_atencion ISNULL THEN '' 
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
            ELSE concat(' (', hd.especial_atencion,')')
       END)), ', ') as municipios, string_agg(distinct hd.departamento,'<br> ') as departamentos, (SELECT  a.imagen   FROM public.area a where a.id_area =ui.id_area) as imagen
FROM public.his_impacto_diario_detalle hd inner join public.impacto_probabilidad ip on ip.id_impacto_probabilidad = hd.no_matriz
inner join public.unificado_informe ui on ui.id_his_impacto_diario= hd.id_his_impacto_diario
<<<<<<< HEAD
WHERE ui.id_unificado= $id_unificado and hd.color='Verde'
GROUP BY hd.categoria, hd.no_matriz,mensaje,imagen
ORDER BY hd.no_matriz desc;";
$resultGridCategoriaVERDE = pg_query($sqlGridCategoriaVERDE) or die('Query failed: '.pg_last_error());

$CategoriaVERDE = pg_num_rows($resultGridCategoriaVERDE);













///----------------------**********OTROOOOOOOOOOOOO**********-------------------------------------------------
///----------------------**********OTROOOOOOOOOOOOO***********-------------------------------------------------
///----------------------**********OTROOOOOOOOOOOOO***********-------------------------------------------------


$sqlGridCategoriaResumen="select aa.categoria,aa.no_matriz, aa.consecuencias,string_agg(concat(aa.municipio,' en ',aa.especial_atencion),', ') as especial_atencion                                                                    
FROM public.his_impacto_diario_detalle aa inner join public.unificado_informe ee on ee.id_his_impacto_diario= aa.id_his_impacto_diario
WHERE ee.id_unificado= 2 and aa.especial_atencion notnull
group by aa.consecuencias,aa.categoria,aa.no_matriz
order by aa.no_matriz desc;";
$resultGridCategoriaResumen = pg_query($sqlGridCategoriaResumen) or die('Query failed: '.pg_last_error());

$CategoriaResumen = pg_num_rows($resultGridCategoriaResumen);


///----------------------**********OTROOOOOOOOOOOOO**********-------------------------------------------------
///----------------------**********OTROOOOOOOOOOOOO***********-------------------------------------------------
///----------------------**********OTROOOOOOOOOOOOO***********-------------------------------------------------


///----------------------**********OTROOOOOOOOOOOOO**********-------------------------------------------------
///----------------------**********OTROOOOOOOOOOOOO***********-------------------------------------------------
///----------------------**********OTROOOOOOOOOOOOO***********-------------------------------------------------












=======
WHERE ui.id_unificado= $id_unificado
GROUP BY hd.categoria, hd.no_matriz,mensaje,imagen
ORDER BY hd.no_matriz desc;";
$resultGridCondiciones = pg_query($sqlGridCondiciones) or die('Query failed: '.pg_last_error());


// var_dump($Unificados);
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3

?>


<!DOCTYPE html>

<html lang="en">
<head>
    
    <title>Informe Impacto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/ihover.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.min.js"></script>
    <!--
	<script src="jquery.lwMultiSelect.js"></script>
    <link rel="stylesheet" href="jquery.lwMultiSelect.css" />
	-->
        


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


<title>Informe</title>
    

</head>


<body>

     
        
      
<div class="container-fluid" id="InfoUnificados">





<div class="row">
    <div class="col-md-12">
        <a>
            <img src="Imagenes/Banner1.png" width="100%" class="img-responsive" id="banner">
        </a>

	
    </div>


<form id="FormUnificado" name="FormUnificado">



 
        <div class="col-md-12">
            <div class="page-header" style="margin-top:-10px; text-align: center;" >
                <br>
                <h1 id="titulo" style="color:grey"><?php echo $Unificados['titulo_general'];?></h1>
            </div>
        </div>
   
        <div class="col-md-12">
            <div class="row" style="text-align: left; color:#428bca; font-weight: 500; margin-top:-10px;">
                <div class="col-md-6" >
              

                    <input type="hidden" id="fecha_ingresado" name="fecha_ingresado" value="<?php echo $Unificados['fecha_ingresado'];?>" style="display:none"/>


            <laber><h4>
                  <a id="diaSemana" class="diaSemana"></a>
                  <a id="dia" class="dia"></a>
                  <a>de</a>
                  <a id="mes" class="mes"></a>
                  <a>del</a>
                  <a id="anio" class="anio"></a>
               <a>--</a>
              
                  <a id="horas" class="horas"></a>
                  <a>:</a>
                  <a id="minutos" class="minutos"></a>
                  <a>:</a>
                    
                    <a id="segundos" class="segundos"></a>
                    <a id="ampm" class="ampm"></a>
            </h4></laber>



                </div>
        
                <div class="col-md-6" style="text-align: right;">
                <laber><h4>Período de validez: <?php echo $Unificados['periodo'];?></h4></laber>


                </div>
            </div>

        </div>


        <div class="col-md-12">
            <h4 id="descripcion" style="line-height: 1.5em"><?php echo $Unificados['des_general'];?> </h4>
             <br>
        </div>


        <div class="col-md-12" style="height: 620px">
            <iframe width="100%" height="100%" src="mapa_alertas_unificado.php?id=<?php echo $Unificados['id_unificado'];?>" scrolling="no" frameborder="0" style='border:none;'></iframe>

            
           
<<<<<<< HEAD
   

<!-- ----------------------------------------------------------------------------------------- --> 
<!-- ------------------------------------------TABLA ROJA------------------------------------- --> 
<!-- ----------------------------------------------------------------------------------------- --> 
        <div  class="col-md-12" id="CategoriaROJO">
       

             
            <div class="table-responsive">
                <div id="employee_table">  
                    <table class="table table-bordered"> 
                        <caption style="background: #F20505; color: #ffffff; text-align: center; font-size: 18px;">TOMAR ACCIÓN</caption>


                        <tr style="background:#EEEEEE" align="center">  



                        <th width="10%">Categoria</th>
                        <th width="10%">no_matriz</th>
                        <th width="10%">Departamentos</th>
                        <th width="30%">Municipios</th>
                        <th width="30%">Consecuencias</th> 
                        <th width="10%"></th>

                </tr>  


                        <?php  
                        while($row = pg_fetch_array($resultGridCategoriaROJO))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF; font-size: 12px;">  
                            <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["categoria"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["no_matriz"]; ?></h4></td>

                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["departamentos"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["municipios"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["mensaje"]; ?></h4></td>
                                <td style="vertical-align:middle;"><img src="<?php echo $row["imagen"]; ?>" width="150px"></td> 

                        </tr>  
                        <?php  
                        }  
                        ?>  
                    </table>  


                </div>  
            </div>  


         </div>



<!-- ----------------------------------------------------------------------------------------- --> 
<!-- ------------------------------------------TABLA ANARANJADA ------------------------------ --> 
<!-- ----------------------------------------------------------------------------------------- --> 

        <div  class="col-md-12" id="CategoriaANARANJADO">
  
            <div class="table-responsive">
                <div id="employee_table">  
                    <table class="table table-bordered"> 
                        <caption style="background: #f29e05; color: #ffffff; text-align: center; font-size: 18px;">ESTAR PREPARADOS</caption>


                        <tr style="background:#EEEEEE" align="center">  



                        <th width="10%">Categoria</th>
                        <th width="10%">no_matriz</th>
                        <th width="10%">Departamentos</th>
                        <th width="30%">Municipios</th>
                        <th width="30%">Consecuencias</th> 
                        <th width="10%"></th>

                </tr>  


                        <?php  
                        while($row = pg_fetch_array($resultGridCategoriaANARANJADO))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF; font-size: 12px;">  
                            <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["categoria"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["no_matriz"]; ?></h4></td>

                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["departamentos"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["municipios"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["mensaje"]; ?></h4></td>
                                <td style="vertical-align:middle;"><img src="<?php echo $row["imagen"]; ?>" width="150px"></td> 

                        </tr>  
                        <?php  
                        }  
                        ?>  
                    </table>  


                </div>  
            </div>  


         </div>






<!-- ----------------------------------------------------------------------------------------- --> 
<!-- ------------------------------------------TABLA AMARILLA -------------------------------- --> 
<!-- ----------------------------------------------------------------------------------------- --> 



        <div  class="col-md-12" id="CategoriaAMARILLO">
      <br> 

            <br />  
            <div class="table-responsive">
                <div id="employee_table">  
                    <table class="table table-bordered"> 
                        <caption style="background: #ecdd03; color: #ffffff; text-align: center; font-size: 18px;">ESTAR INFORMADOS</caption>


                        <tr style="background:#EEEEEE" align="center">  



                        <th width="10%">Categoria</th>
                        <th width="10%">no_matriz</th>
                        <th width="10%">Departamentos</th>
                        <th width="30%">Municipios</th>
                        <th width="30%">Consecuencias</th> 
                        <th width="10%"></th>

                </tr>  


                        <?php  
                        while($row = pg_fetch_array($resultGridCategoriaAMARILLO))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF; font-size: 12px;">  
                            <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["categoria"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["no_matriz"]; ?></h4></td>

                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["departamentos"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["municipios"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["mensaje"]; ?></h4></td>
                                <td style="vertical-align:middle;"><img src="<?php echo $row["imagen"]; ?>" width="150px"></td> 

                        </tr>  
                        <?php  
                        }  
                        ?>  
                    </table>  


                </div>  
            </div>  


         </div>




<!-- ----------------------------------------------------------------------------------------- --> 
<!-- ------------------------------------------TABLA VERDE------------------------------------- --> 
<!-- ----------------------------------------------------------------------------------------- --> 



        <div  class="col-md-12" id="CategoriaVERDE">
      <br> 
=======
        </div>


        <div class="col-md-12">
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3

            <br />  
            <div class="table-responsive">
                <div id="employee_table">  
                    <table class="table table-bordered"> 
<<<<<<< HEAD
                        <caption style="background: #6ab93c; color: #ffffff; text-align: center; font-size: 18px;">CONDICIONES NORMALES</caption>
=======
                        <caption style="background: #0d7997; color: #ffffff; text-align: center; font-size: 18px;">Información</caption>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3


                        <tr style="background:#EEEEEE" align="center">  



<<<<<<< HEAD
                        <th width="10%">Categoria</th>
=======
                        <th width="10%">categoria</th>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
                        <th width="10%">no_matriz</th>
                        <th width="10%">Departamentos</th>
                        <th width="30%">Municipios</th>
                        <th width="30%">Consecuencias</th> 
                        <th width="10%"></th>

                </tr>  


                        <?php  
<<<<<<< HEAD
                        while($row = pg_fetch_array($resultGridCategoriaVERDE))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF; font-size: 12px;">  
=======
                        while($row = pg_fetch_array($resultGridCondiciones))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF;">  
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
                            <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["categoria"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["no_matriz"]; ?></h4></td>

                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["departamentos"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["municipios"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["mensaje"]; ?></h4></td>
                                <td style="vertical-align:middle;"><img src="<?php echo $row["imagen"]; ?>" width="150px"></td> 

                        </tr>  
                        <?php  
                        }  
                        ?>  
                    </table>  


                </div>  
            </div>  


         </div>





<<<<<<< HEAD
<!-- ----------------------------------------------------------------------------------------- --> 
<!-- ------------------------------------------RESUMENNNNNNNN------------------------------------- --> 
<!-- ----------------------------------------------------------------------------------------- -->



        <div  class="col-md-12" id="CategoriaResumen">
      <br> 

            <br />  
            <div class="table-responsive">
                <div id="employee_table">  
                    <table class="table table-bordered"> 
                        <caption style="background: black; color: #ffffff; text-align: center; font-size: 18px;">RESUMEN</caption>


                        <tr style="background:#EEEEEE" align="center">  



                        <th width="10%">Categoria</th>
                        <th width="10%">no_matriz</th>
                        <th width="40%">Consecuencias</th>
                        <th width="40%">Especial atención</th>
          

                </tr>  


                        <?php  
                        while($row = pg_fetch_array($resultGridCategoriaResumen))  
                        {  
                        ?>  
                        <tr style="background:#FFFFFF; font-size: 12px;">  
                            <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["categoria"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["no_matriz"]; ?></h4></td>

                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["consecuencias"]; ?></h4></td>
                                <td><h4 style="line-height: 1.5em; font-size: 16px;"><?php echo $row["especial_atencion"]; ?></h4></td>
                             

                        </tr>  
                        <?php  
                        }  
                        ?>  
                    </table>  


                </div>  
            </div>  


         </div>









=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3








</form>


</div>


</div>



</body>
</html>




<script>
<<<<<<< HEAD

    function toggle_visibility(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'none')
        e.style.display = 'block';
    else
        e.style.display = 'none';
}




=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD


<?php
if ($CategoriaROJO==0){
?>
toggle_visibility ('CategoriaROJO');
<?php
}
?>


<?php
if ($CategoriaANARANJADO==0){
?>
toggle_visibility ('CategoriaANARANJADO');
<?php
}
?>

<?php
if ($CategoriaAMARILLO==0){
?>
toggle_visibility ('CategoriaAMARILLO');
<?php
}
?>

<?php
if ($CategoriaVERDE==0){
?>
toggle_visibility ('CategoriaVERDE');
<?php
}
?>
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
</script>