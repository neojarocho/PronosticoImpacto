<?php 
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
					<p></p>             
            </div>

            <div class="col-md-3">
                <a id="BotonHidrologia" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">
                    <h1 class="glyphicon glyphicon-tint"></h1><br />
                    <h2>Hidrología</h2>  </a>
					<p></p>
                    <a id="BotonHidrologia_1" onClick="getBotonImpacto(2,1)" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">Lluvias intensas y tormentas eléctricas</a>
					<p></p>
                    <a id="BotonHidrologia_2" onClick="getBotonImpacto(2,2)" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">Temporal</a>
					<p></p>
                    <a id="BotonHidrologia_3" onClick="getBotonImpacto(2,3)" class="list-group-item active text-center EfectoBtN" style="background-color:#17A589;">Sequía</a>
					<p></p>
            </div>

            <div class="col-md-3">

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
					<p></p>
            </div>

            <div class="col-md-3">
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
</div>
</body>
</html>
