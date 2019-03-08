<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
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

    <!-- <script src="js/jquery.min.js"></script> -->

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.min.js"></script>


            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.cs-->
        <script src="jquery.lwMultiSelect.js"></script>
        <link rel="stylesheet" href="jquery.lwMultiSelect.css" />
        


        <!----AGREGAR------------<script src="jquery.lwMultiSelectImpacto.js"></script>
        --------------<link rel="stylesheet" href="jquery.lwMultiSelectImpacto.css" />     -->
    

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- 
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/tether.min.js"></script> -->


    


    






    <script>

    $(function () {
        $("#contenedorprincipal").load("PaginaInicio.php");



            $("#PaginaInicio").click(function () {
                $("#contenedorprincipal").load("PaginaInicio.php");
               
        });



            $("#PaginaInicioTexto").click(function () {
                $("#contenedorprincipal").load("PaginaInicio.php");
               
        });

            
        });

       



    </script>

<style>
    
.widget {

}
.widget p {
  display: inline-block;  line-height: 1em;
}
.fecha {

  text-align: right;

}

</style>
        </head>






        <body>


      
            <div class="container-fluid">
                <img src="Imagenes/Banner.png" width="100%" class="img-responsive" id="PaginaInicio" />

                <!-- Content here -->
           


            <!--BARRAAAAAAA MENUUUU-->

            <nav class="navbar navbar-default"  style="background-color: #3c8293; color: black">
                
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <ul class="nav navbar-nav">
                            <li>
                                <a id="PaginaInicioTexto">Inicio</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Meteorología<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a id="Meteorologia_Nuevo">Nuevo</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a id="Meteorologia_Informes">Informes</a></li>
                                    <!--<li role="separator" class="divider"></li>
                                    <li><a id="TodasCamaras">Unidas</a></li>-->
                                </ul>
                            </li>
                        </ul>


                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hidrología<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a id="Radares">Nuevo</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a id="Aplicaciones">Informes</a></li>
                                </ul>
                            </li>
                        </ul>




                        <ul class="nav navbar-nav">
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Geología<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a id="Radares">Nuevo</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a id="Aplicaciones">Informes</a></li>
                                </ul>
                            </li>
                        </ul>
                        
                        <!--<form class="navbar-form navbar-right">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="¿Que camara buscas?">
                            </div>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        </form>-->

    <ul class="nav navbar-nav navbar-right">
<span class="navbar-text">


                    <div class="contenedor">
  <div class="widget">
    <div class="fecha">
      <p id="diaSemana" class="diaSemana"></p>
      <p id="dia" class="dia"></p>
      <p>de</p>
      <p id="mes" class="mes"></p>
      <p>del</p>
      <p id="anio" class="anio"></p>
   <p>--</p>
   <p>Hora:</p>
      <p id="horas" class="horas"></p>
      <p>:</p>
      <p id="minutos" class="minutos"></p>
      <p>:</p>
    
        
        <p id="segundos" class="segundos"></p>
        <p id="ampm" class="ampm"></p>
     
    </div>
  </div>
</div>


                </span>
    </ul>





                    </div><!-- /.navbar-collapse -->

                    


            </nav>


            </div>









            <div id="contenedorprincipal">
                <div class="row">
        



                </div>

            </div>













                <!--<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>-->
        <!--<script src="js/bootstrap.min.js"></script>-->

</body>
</html>




<script>
    $(function(){
  var actualizarHora = function(){
    var fecha = new Date(),
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