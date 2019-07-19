﻿<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<script>
function getBotonImpacto(id_area, id_fenomeno) {
$("#contenedorprincipal").load("MeteorogiaConsulta.php",{id_area:id_area,id_fenomeno:id_fenomeno});
console.log(id_area,id_fenomeno);
}

function getBotonUnificado(id_area, id_fenomeno) {
$("#contenedorprincipal").load("Unificacion.php",{id_area:id_area,id_fenomeno:id_fenomeno});
console.log(id_area,id_fenomeno);
}

    $(function () {
 //AREAS
    var Meteorologia='1';
    var Hidrologia='2';
    var Geologia='3';
	var Unificado='4';
//FENOMENOS
    var Lluvias='1';
    var Temporal='2';
    var Sequía='3';
    var Vientos='4';
    var Sismo='5';
    var Erupcion ='6';


// toggle_style($(this).attr('id'))


        // $("#BotonMeteorologia_1").click(function () {   
            // $("#contenedorprincipal").load("MeteorogiaConsulta.php",{id_area:Meteorologia,id_fenomeno:Lluvias});
        // });
		
		// $("#BotonHidrologia_1").click(function () {
            // $("#contenedorprincipal").load("MeteorogiaConsulta.php",{id_area:Hidrologia,id_fenomeno:Lluvias}
                // );
        // });
    });
</script>
</head>
<body>

<div class="container-fluid">

<<<<<<< HEAD
	<div style="background:#e2e4e4 " class="jumbotron">


	

	<div class="row">
            <div class="col-md-3">
                <button type="button" class="list-group-item active EfectoBtN" style="background-color:#124567; text-align: center;" >
                    <h1 class="glyphicon glyphicon-flag"></h1><br />
                    <h2>Meteorología</h2></button>
					<p></p>
                    <button type="button" id="BotonMeteorologia_1" onClick="getBotonImpacto(1,1)" class="list-group-item active center-block EfectoBtN" style="background-color:#16527b;text-align: center;">Lluvias intensas y tormentas eléctricas</button>
					<p></p>
                    <button type="button" id="BotonMeteorologia_2" onClick="getBotonImpacto(1,2)" class="list-group-item active EfectoBtN" style="background-color:#196090;text-align: center;" >Temporal</button>
					<p></p>
					<button type="button" id="BotonMeteorologia_3" onClick="getBotonImpacto(1,3)" class="list-group-item active EfectoBtN" style="background-color:#1d6ea4;text-align: center;" >Sequía</button>
					<p></p>
					<button type="button" id="BotonMeteorologia_4" onClick="getBotonImpacto(1,4)" class="list-group-item active EfectoBtN" style="background-color:#217cb9;text-align: center;" >Vientos Fuertes</button>
					<p></p>
					<button type="button" id="BotonMeteorologia_5" onClick="getBotonImpacto(1,5)" class="list-group-item active EfectoBtN" style="background-color:#217cb9;text-align: center;" >Sismo</button>
					<p></p>					
					<button type="button" id="BotonMeteorologia_6" onClick="getBotonImpacto(1,6)" class="list-group-item active EfectoBtN" style="background-color:#258ace;text-align: center;" >Erupción Volcanica</button>
=======
	<div class="jumbotron">
		<h3>Informe de Impacto</h3>
		<p>El Ministerio del Medio Ambiente y Recursos Naturales informa sobre la evaluación de las amenazas Meteorológicas, Hidrológicas, Oceanográficas y Geológicas. </p>

	</div>

	<div class="row">
            <div class="col-md-3">
                <a class="list-group-item active text-center EfectoBtN" style="background-color:#5DADE2  ;" >
                    <h1 class="glyphicon glyphicon-tint"></h1><br />
                    <h2>Meteorología</h2></a>
					<p></p>
                    <a id="BotonMeteorologia_1" onClick="getBotonImpacto(1,1)" class="list-group-item active text-center EfectoBtN" style="background-color:#5DADE2;">Lluvias intensas y tormentas eléctricas</a>
					<p></p>
                    <a id="BotonMeteorologia_2" onClick="getBotonImpacto(1,2)" class="list-group-item active text-center EfectoBtN" style="background-color:#5DADE2;">Temporal</a>
					<p></p>
					<a id="BotonMeteorologia_3" onClick="getBotonImpacto(1,3)" class="list-group-item active text-center EfectoBtN" style="background-color:#5DADE2;">Sequía</a>
					<p></p>
					<a id="BotonMeteorologia_4" onClick="getBotonImpacto(1,4)" class="list-group-item active text-center EfectoBtN" style="background-color:#5DADE2;">Vientos Fuertes</a>
					<p></p>
					<a id="BotonMeteorologia_6" onClick="getBotonImpacto(1,5)" class="list-group-item active text-center EfectoBtN" style="background-color:#5DADE2;">Erupción Volcanica</a>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
					<p></p>             
            </div>

            <div class="col-md-3">
<<<<<<< HEAD
                <button type="button" id="BotonHidrologia" class="list-group-item active text-center EfectoBtN" style="background-color:#083a30;text-align: center;" >
                    <h1 class="glyphicon glyphicon-tint"></h1><br />
                    <h2>Hidrología</h2>  </button>
					<p></p>
                    <button type="button" id="BotonHidrologia_1" onClick="getBotonImpacto(2,1)" class="list-group-item active EfectoBtN" style="background-color:#0b4e40;text-align: center;" >Lluvias intensas y tormentas eléctricas</button>
					<p></p>
                    <button type="button" id="BotonHidrologia_2" onClick="getBotonImpacto(2,2)" class="list-group-item active EfectoBtN" style="background-color:#0e6251;text-align: center;" >Temporal</button>
					<p></p>
                    <button type="button" id="BotonHidrologia_3" onClick="getBotonImpacto(2,3)" class="list-group-item active EfectoBtN" style="background-color:#3e8173;text-align: center;" >Sequía</button>
=======
                <a id="BotonHidrologia" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">
                    <h1 class="glyphicon glyphicon-tint"></h1><br />
                    <h2>Hidrología</h2>  </a>
					<p></p>
                    <a id="BotonHidrologia_1" onClick="getBotonImpacto(2,1)" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">Lluvias intensas y tormentas eléctricas</a>
					<p></p>
                    <a id="BotonHidrologia_2" onClick="getBotonImpacto(2,2)" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">Temporal</a>
					<p></p>
                    <a id="BotonHidrologia_3" onClick="getBotonImpacto(2,3)" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">Sequía</a>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
					<p></p>
            </div>

            <div class="col-md-3">

<<<<<<< HEAD
                <button type="button" id="BotonGeologia" class="list-group-item active text-center EfectoBtN" style="background-color:#602600;text-align: center;" >
                    <h1 class="glyphicon glyphicon-stop"></h1><br />
                    <h2>Geología</h2> </button>
					<p></p>
                    <button type="button" id="BotonGeologia_1" onClick="getBotonImpacto(3,1)" class="list-group-item active EfectoBtN" style="background-color:#803300;text-align: center;" >Lluvias intensas y tormentas eléctricas</button>
					<p></p>
                    <button type="button" id="BotonGeologia_2" onClick="getBotonImpacto(3,2)" class="list-group-item active EfectoBtN" style="background-color:#903900;text-align: center;" >Temporal</button>
					<p></p>
                    <button type="button" id="BotonGeologia_5" onClick="getBotonImpacto(3,5)" class="list-group-item active EfectoBtN" style="background-color:#a04000;text-align: center;" >Sismo</button>
					<p></p>
                    <button type="button" id="BotonGeologia_6" onClick="getBotonImpacto(3,6)" class="list-group-item active EfectoBtN" style="background-color:#a95319;text-align: center;" >Erupción Volcanica</button>
=======
                <a id="BotonGeologia" class="list-group-item active text-center EfectoBtN" style="background-color:#A04000;">
                    <h1 class="glyphicon glyphicon-screenshot"></h1><br />
                    <h2>Geología</h2> </a>
					<p></p>
                    <a id="BotonGeologia_1" onClick="getBotonImpacto(3,1)" class="list-group-item active text-center EfectoBtN" style="background-color:#A04000;">Lluvias intensas y tormentas eléctricas</a>
					<p></p>
                    <a id="BotonGeologia_2" onClick="getBotonImpacto(3,2)" class="list-group-item active text-center EfectoBtN" style="background-color:#A04000;">Temporal</a>
					<p></p>
                    <a id="BotonGeologia_5" onClick="getBotonImpacto(3,5)" class="list-group-item active text-center EfectoBtN" style="background-color:#A04000;">Sismo</a>
					<p></p>
                    <a id="BotonGeologia_6" onClick="getBotonImpacto(3,6)" class="list-group-item active text-center EfectoBtN" style="background-color:#A04000;">Erupción Volcanica</a>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
					<p></p>
            </div>

            <div class="col-md-3">
<<<<<<< HEAD
                <button type="button" id="BotonUnificado" class="list-group-item active text-center EfectoBtN" style="background-color:#383d3e;text-align: center;" >
                    <h1 class="glyphicon glyphicon-link"></h1><br />
                    <h2>Unificado</h2> </button>
					<p></p>
                    <button type="button" id="BotonUnificado_1" onClick="getBotonUnificado(4,1)" class="list-group-item active EfectoBtN" style="background-color:#43494a;text-align: center;" >Lluvias intensas y tormentas eléctricas</button>
					<p></p>                           
                    <button type="button" id="BotonUnificado_2" onClick="getBotonUnificado(4,2) "class="list-group-item active EfectoBtN" style="background-color:#4e5656;text-align: center;" >Temporal</button>
					<p></p>                           
                    <button type="button" id="BotonUnificado_3" onClick="getBotonUnificado(4,3)"class="list-group-item active EfectoBtN" style="background-color:#596263;text-align: center;" >Sequía</button>
					<p></p>                           
                    <button type="button" id="BotonUnificado_4" onClick="getBotonUnificado(4,4)" class="list-group-item active EfectoBtN" style="background-color:#646e6f;text-align: center;" >Vientos Fuertes</button>
					<p></p>                           
                    <button type="button" id="BotonUnificado_5" onClick="getBotonUnificado(4,5)" class="list-group-item active EfectoBtN" style="background-color:#707b7c;text-align: center;" >Sismo</button>
					<p></p>                           
                    <button type="button" id="BotonUnificado_6" onClick="getBotonUnificado(4,6)" class="list-group-item active EfectoBtN" style="background-color:#7e8889;text-align: center;" >Erupción Volcanica</button>
					<p></p>
            </div>
	</div>


</div>


=======
                <a id="BotonUnificado" class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">
                    <h1 class="glyphicon glyphicon-eye-open"></h1><br />
                    <h2>Unificado</h2> </a>
					<p></p>
                    <a id="BotonUnificado_1" onClick="getBotonUnificado(4,1)" class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">Lluvias intensas y tormentas eléctricas</a>
					<p></p>                           
                    <a id="BotonUnificado_2" onClick="getBotonUnificado(4,2) "class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">Temporal</a>
					<p></p>                           
                    <a id="BotonUnificado_3" onClick="getBotonUnificado(4,3)"class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">Sequía</a>
					<p></p>                           
                    <a id="BotonUnificado_4" onClick="getBotonUnificado(4,4)" class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">Vientos Fuertes</a>
					<p></p>                           
                    <a id="BotonUnificado_5" onClick="getBotonUnificado(4,5)" class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">Sismo</a>
					<p></p>                           
                    <a id="BotonUnificado_6" onClick="getBotonUnificado(4,6)" class="list-group-item active text-center EfectoBtN" style="background-color:#707B7C;">Erupción Volcanica</a>
					<p></p>
            </div>
	</div>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
</div>
</body>
</html>
