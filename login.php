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

<link href="css/bootstrap.min.css" rel="stylesheet" />
<script src="js/bootstrap.min.js"></script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
	<nav class="navbar navbar-default"  style="background-color: #1b2020; color: black">
		
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<ul class="nav navbar-nav">
				<li>
					<a id="PaginaInicioTexto">Inicio</a>
				</li>
			</ul>
		</div>

	</nav>

</div>

<div id="contenedorprincipal">
    <div class="row">

    </div>
</div>

</body>
</html>




<script>
$(function(){
	
$("#contenedorprincipal").load("loginForm.php");
	
    $("#PaginaInicioTexto").click(function () {
        $("#contenedorprincipal").load("123.php");
	});	
	
	
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