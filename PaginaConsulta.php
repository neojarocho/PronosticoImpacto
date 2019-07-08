<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

//// IMPACTO
$sqlGridImpactoDiarioHis="SELECT id_unificado,fenomeno, titulo_general, periodo,to_char(fecha_ingresado, 'DD/MM/YYYY - HH:MI:SS') as fecha, des_categoria, des_categoria
    FROM public.unificado order by fecha_ingresado desc;
";
$sqlGridImpactoDiarioHis = pg_query($sqlGridImpactoDiarioHis) or die('Query failed: '.pg_last_error());




?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>




    <script>



    $(function () {


        

    });











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

<div style="background: #e8ecf1; padding-top: 15px;padding-bottom: 15px;">

        <div class="row" style="margin: 5px;">
            <div class="col-md-2">

                <a class="list-group-item active text-center EfectoBtN">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Lluvias.png">
                    <h5>Lluvias intensas y tormentas eléctricas</h5>  </a>
                    </a>

        

            </div>

            <div class="col-md-2">

                <a id="BotonHidrologia" class="list-group-item active text-center EfectoBtN" style="background-color:#05c6e5;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Temporal.png">
                    <h5><br/>Temporal</h5>  </a>

            </div>

            <div class="col-md-2">

                <a id="BotonGeologia" class="list-group-item active text-center EfectoBtN" style="background-color:#8b60ad;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/sequia.png">
                    <h5><br/>Sequía</h5> </a>


            </div>



            <div class="col-md-2">


                <a id="BotonUnificado" class="list-group-item active text-center EfectoBtN" style="background-color:#e89323;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Vientos.png">
                    <h5><br/>Vientos Fuertes</h5> </a>


            </div>

            <div class="col-md-2">

                <a class="list-group-item active text-center EfectoBtN" style="background-color:#8c4255;" >
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/Erupcion.png">
                    <h5><br/>Erupción Volcánica</h5></a>

        

            </div>

            <div class="col-md-2">

                <a id="BotonHidrologia" class="list-group-item active text-center EfectoBtN" style="background-color:#178e88;">
                    <img width="100%" height="100%" src="//192.168.6.204/PronosticoImpactoPublic/Imagenes/Fenomenos/sismo.png">
                    <h5><br/>Sismo</h5>  </a>

            </div>



 
        </div>



                <p></p>



            <div class="row" style="margin: 5px;">
            <div class="col-md-12">


                <a id="BotonUnificado" class="list-group-item active text-center EfectoBtN" style="background-color:#d2527f;">
                   
                    <h5>Últimos Pronósticos</h5> </a>


            </div>

 
        </div>
</div>
 <br/>

 <div class="row">
            <div class="col-md-12">


        <div id="employee_table">  
            <table class="table table-bordered"> 
                <caption style="background: #0d7997; color: white; text-align: center; font-size: 15px;">Informes de impacto</caption>
                <tr style="background:#e8ecf1;">
                        <th style="text-align: center;"   width="3%">Ver</th>    
                        <th style="text-align: center;" width="12%">Fecha - Hora</th>
                        <th style="text-align: center;" width="40%">Título</th>
                

                        <th style="text-align: center;" width="20%">Fenomeno</th>
                        <th style="text-align: center;" width="10%">Período</th>
                        <th style="text-align: center;" width="15%">Categoría</th>
                        



                </tr>  
                <?php  
                while($row = pg_fetch_array($sqlGridImpactoDiarioHis))  
                {  
                ?>  
                <tr style="background:#FFFFFF;">
                    <td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-xs" onClick="window.open('UnificacionReporte.php?id=<?php echo $row["id_unificado"]; ?>')"></button></td> 
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
