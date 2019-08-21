<?php
header('Content-Type: text/html; charset=utf-8');
include('funciones.php');
include('funcion_marketing.php');

$fecha = date('Y-m-d');
$dia = date('d');
$mes = date('m');
$ani = date('Y');
$dow = date('w');
$strmes  = Array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
$strweek = Array(0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Mieroles',4=>'Jueves',5=>'Viernes',6=>'Sabado');

$fecha_larga = $strweek[intval($dow)].", ".$dia." de ".$strmes[intval($mes)]." de ".$ani;
// echo $fecha_larga;

/*
<!--
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MARN | Envio de Correos by Ivan Moran</title>
</head>
<body>
-->
*/

if($_POST["opcion"] == 'Publicar'){
	include("cnn.php");	
	$arr = $_POST['pubData'];	
	// print_r($arr);
	
	// exit();
	
	##	Actualizar datos
	$dbconn = my_dbconn4("PronosticoImpacto");
	$sql="UPDATE public.unificado SET publicar=".$arr['pub_we'].", fecha_publicado=NOW(), nivel_impacto_publicado=".$arr['nivel'].", enviar_instituciones=".$arr['pub_in'].", envio_general=".$arr['pub_co'].", envio_redes=".$arr['pub_re']." WHERE id_unificado=".$arr['id_unificado']."; ";
	$result=pg_query($dbconn, $sql);
	// echo $sql;
	
	
	##--------------------------------------------------------------------------------------------------------
	##	PUBLICAR WEB
	##--------------------------------------------------------------------------------------------------------
	if ($arr['pub_we']== "true") {
		echo "\nPUBLICAR WEB \n";
	}
	
	##--------------------------------------------------------------------------------------------------------
	##	PUBLICAR WEB
	##--------------------------------------------------------------------------------------------------------
	if ($arr['pub_re']== "true") {
		echo "PUBLICAR EN REDES \n";
	}

	#	VALIDAR ENVIAR CORREOS
	if (($arr['pub_in']== "true") or ($arr['pub_co']== "true")) {
			ob_start();
			$buscar = $arr['id_unificado'];
			$nivel  = $arr['nivel'];
			$titulo = $arr['titulo'];
			include_once "template_co.php";
			$a_div = ob_get_contents();
	}
	
	##--------------------------------------------------------------------------------------------------------
	##	ENVIAR CORREOS A INSTITUCIONES
	##--------------------------------------------------------------------------------------------------------
	if ($arr['pub_in']== "true") {
		echo "ENVIAR CORREOS A INSTITUCIONES \n";
		
			### ----------------------------Titulo--------------------------------- ### 
			// $titulo = "Informe de Impacto";
			// $resumen = 'Ultima Prueba de la Tarde';		
			$contenido = '';	
			$mascontenido = '';
			$textBody = "correo en formato texto";
			$htmlBody = $a_div;
			
			//Correos Instituciones GOB
			$token = '9b9c5012-929f-49eb-9762-6bcd887440c2';
			$idgrupo = '8';
			/*
			//Para pruebas
			$token = '27cbc7f0-e647-429f-a531-5abb0326dcb4';
			$idgrupo = '3';

			//produccion
			$token = '817f8b19-79fb-4ab4-9d2c-67d41adc763d';
			$idgrupo = '4';
			*/

			######### ACTIVA LA SIGUIENTE LINEA PARA ENVIAR CORREOS #########
			$envio=enviar_email($titulo,$htmlBody,$idgrupo,$token,$textBody);

			if (@$envio == 1) {
				echo "<div>EL CORREO SE ENVIO CORRECTAMENTE</div>";
			}
			else {
				echo "<div>EL CORREO NO SE ENVIO CORRECTAMENTE</div>";
				
			}
		// echo @$htmlBody;	
	}
	
	##--------------------------------------------------------------------------------------------------------
	##	ENVIAR CORREOS EN GENERAL
	##--------------------------------------------------------------------------------------------------------
	if ($arr['pub_co']== "true") {
		echo "ENVIAR CORREOS EN GENERAL \n";

			### ----------------------------Titulo--------------------------------- ### 
			// $titulo = "Informe de Impacto";
			// $resumen = 'Ultima Prueba de la Tarde';		
			$contenido = '';	
			$mascontenido = '';
			$textBody = "correo en formato texto";
			$htmlBody = $a_div;

			
			//Correos General MARN
			$token = '6a52eff1-0362-478f-8e90-32a0e09c31bb';
			$idgrupo = '9';
			/*
			//Para pruebas
			$token = '27cbc7f0-e647-429f-a531-5abb0326dcb4';
			$idgrupo = '3';

			//produccion
			$token = '817f8b19-79fb-4ab4-9d2c-67d41adc763d';
			$idgrupo = '4';
			*/

			######### ACTIVA LA SIGUIENTE LINEA PARA ENVIAR CORREOS #########
			$envio=enviar_email($titulo,$htmlBody,$idgrupo,$token,$textBody);

			if (@$envio == 1) {
				echo "<div>EL CORREO SE ENVIO CORRECTAMENTE</div>";
			}
			else {
				echo "<div>EL CORREO NO SE ENVIO CORRECTAMENTE</div>";
				
			}
		// echo @$htmlBody;	
	}

}
/*
</body>
</html>
*/
?>





