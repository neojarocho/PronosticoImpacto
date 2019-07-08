<?php
//fetch.php

header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
//	INSERTAR IMPACTO DIARIO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
if(isset($_POST['registrar'])){
include('database_connection.php');

	// IMPACTO DIARIO
	$id_impacto_diario=100;
	$id_area = $_POST["id_area"];
	$id_fenomeno= $_POST["id_fenomeno"];
	$correlativo= $_POST["correlativo"];
	$titulo= $_POST["titulo"];
	$descripcion= $_POST["descripcion"];
	$id_periodo= $_POST["periodo"];
	$id_estado_impacto= 1;
	$id_usuario = 1;

	//// INGRESO DE DATOS GENERALES
	$sqlIngresoDatosGenerales="INSERT INTO public.impacto_diario( id_area, id_fenomeno, fecha, correlativo, titulo, descripcion, id_periodo, id_estado_impacto, id_usuario) VALUES ($id_area, $id_fenomeno, NOW(), $correlativo, '$titulo', '$descripcion', $id_periodo, $id_estado_impacto, $id_usuario)";
	$resultIngresoDatosGenerales = pg_query($sqlIngresoDatosGenerales) or die('Query failed: '.pg_last_error()); 
	
	$sql="SELECT currval('impacto_diario_seq')";
	$result = pg_query($sql) or die('Query failed: '.pg_last_error()); 
	$con = pg_fetch_all($result);
	$con = $con[0];
	
	echo json_encode($con, JSON_FORCE_OBJECT);
	
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


if(isset($_POST['action'])){

// Abrimos una conexion a la base de datos
include("cnn.php");
include('database_connection.php');

$estado = $_POST['query'];
@$output = '';

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	CONSULTAR MUNICIPIOS (SELECT OPTION)
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["action"] == 'tipo_zona_dpto'){
		
		$id_area = $_POST["id_area"];
		if ($estado == 'Departamento' ) {
		$Sql =	"select t.zona_dpto from public.municipio_zona_dpto m 
				inner join public.zona_dpto t on m.id_zona_dpto=t.id_zona_dpto
				inner Join public.tipo_zona_dpto tzd on m.id_tipo_zona_dpto=tzd.id_tipo_zona_dpto where tzd.tipo_zona_dpto='$estado' GROUP BY t.zona_dpto";
		}
		else {
		$Sql =	"select t.zona_dpto from public.municipio_zona_dpto m 
				inner join public.zona_dpto t on m.id_zona_dpto=t.id_zona_dpto
				inner Join public.tipo_zona_dpto tzd on m.id_tipo_zona_dpto=tzd.id_tipo_zona_dpto where tzd.tipo_zona_dpto='$estado' AND t.id_area = ".$id_area." GROUP BY t.zona_dpto";	
		}
		$result=pg_query($connect, $Sql);
		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$Estados[] = $row;
		} pg_free_result($result);
		pg_close($connect);
		
		$result=$Estados;
		foreach($result as $row){
			$output .= '<option value="'.$row["zona_dpto"].'">'.$row["zona_dpto"].'</option>';
		}
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	CONSULTAR DEPARTAMENTOS (SELECT OPTION)
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["action"] == 'zona_dpto'){
		$ciudad = $_POST['query'];
		$filter = $_POST['nomuni'];
		
		$Sql = "SELECT mzd.cod_municipio, m.nombre FROM public.municipio_zona_dpto as mzd inner join public.municipio as m on mzd.cod_municipio=m.cod_municipio
		inner join public.zona_dpto as zd on zd.id_zona_dpto=mzd.id_zona_dpto where zd.zona_dpto = '$ciudad' AND mzd.cod_municipio NOT IN ('$filter') ORDER BY m.nombre;";
		$result=pg_query($connect, $Sql);
		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$Ciudad[] = $row;
		} pg_free_result($result);
		$result=$Ciudad;
		foreach($result as $row) {
			$output .= '<option value="'.$row["cod_municipio"].'_'.$row["nombre"].'">'.$row["nombre"].'</option>';
		}
	}
	echo $output;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if(isset($_GET['opt'])){

// Abrimos una conexion a la base de datos
include("cnn.php");
include('database_connection.php');

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	CONSULTAR CONSECUENCIA
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_GET["opt"] == 'consecuencias'){
		$id_impacto = $_GET["impacto"];
		$id_area = $_GET["id_area"];
		$id_fenomeno = $_GET["id_fenomeno"];

		$sqlConsecuencias="SELECT ci.id_consecuencia_impacto,ci.id_area, ci.id_fenomeno, ci.id_impacto, (SELECT c.consecuencia FROM public.consecuencia c where c.id_consecuencia=ci.id_consecuencia), ci.estado
		FROM public.consecuencia_impacto ci
		where ci.id_fenomeno= $id_fenomeno and ci.id_area=$id_area and ci.id_impacto= $id_impacto;";
		$resultConsecuencias = pg_query($sqlConsecuencias) or die('Query failed: '.pg_last_error()); 
		$con = pg_fetch_all($resultConsecuencias);
		echo json_encode($con, JSON_FORCE_OBJECT);
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	CONSULTAR CATEGORIA
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_GET["opt"] == 'categoria'){
		$id_impacto= $_GET["impacto"];
		$id_probabilidad= $_GET["probabilidad"];

		$sqlCategoria="SELECT ip.id_color, c.id_categoria, c.categoria, ip.id_impacto_probabilidad FROM public.impacto_probabilidad as ip inner join public.categoria as c on ip.id_categoria=c.id_categoria where ip.id_impacto = $id_impacto and ip.id_probabilidad=$id_probabilidad";
		$resultCategoria = pg_query($sqlCategoria) or die('Query failed: '.pg_last_error());
		$categoria = pg_fetch_all($resultCategoria);
		$categoria = $categoria[0];
		echo json_encode($categoria, JSON_FORCE_OBJECT);
	}
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//--------------------------------------------------
// OPCIONES PARA EL FORMULARIO
//--------------------------------------------------
if(isset($_POST['opcion'])){
	
// Abrimos una conexion a la base de datos
include("cnn.php");
include('database_connection.php');

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	INSERTAR MUNICIPIOS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["opcion"] == 'insertContent'){

		$porciones = explode("&", urldecode ($_POST['formMuni']));
		// echo "<pre>";
		// print_r($porciones);
		// echo "</pre>";
		// exit();

		function xplo($val) {
			$v = explode("=", $val);
			return $v;
		}
		// echo xplo($porciones[0])[0];
		// $id_impacto_diario = 2;
		$id_usuario = 1;
		$fecha_ingreso = date('Y-m-d');

		$datos=$datosh=array();
		for ($i=0; $i<=count($porciones)-1; $i++) {
			if (xplo($porciones[$i])[0] == 'tipo_zona_dpto'){	$tipo_zona_dpto = xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'zona_dpto'){ 		$zona_dpto 		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'municipio'){ 		
				$mu = explode("_", xplo($porciones[$i])[1]);
				$code_muni[] = $mu[0];
				$name_muni[] = $mu[1];
			}
			if (xplo($porciones[$i])[0] == 'impacto'){ 			$id_impacto		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'probabilidad'){		$id_probabilidad= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_categoria'){		$id_categoria	= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_color'){			$id_color		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'categoria'){		$categoria		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'datos[]'){ 			$datos[]		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'datosh[]'){			$datosh[]		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_impacto_diario_m')	 {	$id_impacto_diario			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_impacto_probabilidad'){	$id_impacto_probabilidad	= xplo($porciones[$i])[1];}
			// echo $i;
		}

		$sql_co = "";
		if (count($datos)>0) {
			for ($i=0; $i<=count($datos)-1; $i++) {
				$sql_1 = "INSERT INTO public.impacto_diario_consecuencias(id_impacto_diario_detalle, id_consecuencia,id_impacto_diario) VALUES ((SELECT currval('impacto_diario_detalle_id_impacto_diario_detalle_seq')), ".$datos[$i].",".$id_impacto_diario."); \n";
				$sql_co .=$sql_1;
			}
		}
		// echo $sql_co;

		$sql_ho = "";
		if (count($datosh)>0) {		
			for ($i=0; $i<=count($datosh)-1; $i++) {
				$sql_2 = "INSERT INTO public.impacto_diario_horario(id_impacto_diario_detalle, id_horario,id_impacto_diario) VALUES ((SELECT currval('impacto_diario_detalle_id_impacto_diario_detalle_seq')), ".$datosh[$i].",".$id_impacto_diario."); \n";
				$sql_ho .=$sql_2;
			}
		}
		// echo $sql_ho;

		$str_sql = "";
		for ($i=0; $i<=count($code_muni)-1; $i++) {
		// INSERT INTO persons (lastname,firstname) VALUES ('Moran', 'Ivan') RETURNING id;
		$sql = 	"INSERT INTO public.impacto_diario_detalle(id_impacto_diario, cod_municipio, municipio, id_impacto, id_probabilidad, id_color, id_categoria, fecha_ingreso, id_usuario_ingreso, des_categoria, id_impacto_probabilidad) VALUES (".$id_impacto_diario.", '".$code_muni[$i]."', '".$name_muni[$i]."', ".$id_impacto.", ".$id_probabilidad.", ".$id_color.", ".$id_categoria.", '".$fecha_ingreso."', ".$id_usuario.",'".$categoria."',".$id_impacto_probabilidad.") RETURNING id_impacto_diario_detalle; \n";
		$sql_sum = $sql_co.$sql_ho;

		// echo "*".strlen($sql_sum)."*";
		$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
		if (strlen($sql_sum)>0) {
		$result = pg_query($sql_sum) or die('Query failed: ' . pg_last_error());
		}
		
		
		}

		if(isset($result)){  echo 'done'; }

	}	//FIN (opcion-> insertContent)

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	ACTUALIZAR MUNICIPIOS [EACH MUNI]
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["opcion"] == 'updateContent'){

		$porciones = explode("&", urldecode ($_POST['formMuniUpdate']));
		echo "<div style='text-align:center; vertical-align:middle; height:100px;'><h2>CAMBIO EXITOSO</h2><div>";
		// echo "<pre>";
		// print_r($porciones);
		// echo "</pre>";
		// echo "<script>console.log('$porciones')</script>";
		// exit();
		$tipo_zona_dpto='';
		$municipio[] ='';

		function xplo($val) {
			$v = explode("=", $val);
			return $v;
		}

		$id_usuario = 1;
		$fecha_ingreso = date('Y-m-d');

		for ($i=0; $i<=count($porciones)-1; $i++) {
			if (xplo($porciones[$i])[0] == 'ed_impacto'){		$id_impacto					= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'ed_probabilidad'){	$id_probabilidad			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_categoria'){		$id_categoria				= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_color'){			$id_color					= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'ed_categoria'){		$categoria					= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'datos_co[]'){		$datos[]					= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'datos_ho[]'){		$datosh[]					= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'id_idiario'){		$id_impacto_diario_detalle	= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'atencion'){			$atencion					= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'descripcion'){		$descripcion				= xplo($porciones[$i])[1];}
		}

		if 		($id_impacto == 1 && $id_probabilidad == 1): 	$id_color = 1;
		elseif 	($id_impacto == 1 && $id_probabilidad == 2): 	$id_color = 1;
		elseif 	($id_impacto == 1 && $id_probabilidad == 3): 	$id_color = 1;
		elseif 	($id_impacto == 1 && $id_probabilidad == 4): 	$id_color = 1;
		elseif 	($id_impacto == 2 && $id_probabilidad == 1): 	$id_color = 1;
		elseif 	($id_impacto == 2 && $id_probabilidad == 2): 	$id_color = 1;
		elseif 	($id_impacto == 2 && $id_probabilidad == 3): 	$id_color = 2;
		elseif 	($id_impacto == 2 && $id_probabilidad == 4): 	$id_color = 2;
		elseif 	($id_impacto == 3 && $id_probabilidad == 1): 	$id_color = 2;
		elseif 	($id_impacto == 3 && $id_probabilidad == 2): 	$id_color = 2;
		elseif 	($id_impacto == 3 && $id_probabilidad == 3): 	$id_color = 3;
		elseif 	($id_impacto == 3 && $id_probabilidad == 4): 	$id_color = 3;
		elseif 	($id_impacto == 4 && $id_probabilidad == 1): 	$id_color = 2;
		elseif 	($id_impacto == 4 && $id_probabilidad == 2): 	$id_color = 3;
		elseif 	($id_impacto == 4 && $id_probabilidad == 3): 	$id_color = 3;
		elseif 	($id_impacto == 4 && $id_probabilidad == 4): 	$id_color = 4;
		else: echo "No existe la categoria";
		endif;

		// include("cnn.php");
		$dbconn = my_dbconn4("PronosticoImpacto");
		$sql="UPDATE public.impacto_diario_detalle SET id_impacto=$id_impacto, id_probabilidad=$id_probabilidad, id_color=$id_color, id_categoria=$id_categoria, des_categoria='".$categoria."', especial_atencion='".$atencion."', descripcion='".$descripcion."' WHERE id_impacto_diario_detalle = $id_impacto_diario_detalle;";
		$result=pg_query($dbconn, $sql);
		// echo $sql;
		
		if (!$result){	/*	echo	"alert-error";	*/	} else {	/*	echo	"alert-succes";	*/	}

		// BORRAMOS CONTENIDO ANTERIOR PARA INSERTAR NUEVO CONTENIDO
		$sql="DELETE FROM public.impacto_diario_consecuencias WHERE id_impacto_diario_detalle = ".$id_impacto_diario_detalle.";";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		
		$sql="DELETE FROM public.impacto_diario_horario WHERE id_impacto_diario_detalle = ".$id_impacto_diario_detalle.";";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		
		// Insertamos nuevo contenido
		$sql_co = "";
		for ($i=0; $i<=count(@$datos)-1; $i++) {
			$sql_1 = "INSERT INTO public.impacto_diario_consecuencias(id_impacto_diario_detalle, id_consecuencia) VALUES (".$id_impacto_diario_detalle.", ".$datos[$i]."); \n";
			$sql_co .=$sql_1;
		}	// echo $sql_co;

		$sql_ho = "";
		for ($i=0; $i<=count($datosh)-1; $i++) {
			$sql_2 = "INSERT INTO public.impacto_diario_horario(id_impacto_diario_detalle, id_horario) VALUES (".$id_impacto_diario_detalle.", ".$datosh[$i]."); \n";
			$sql_ho .=$sql_2;
		}	// echo $sql_ho;

		$sql_sum = $sql_co.$sql_ho;
		// echo $sql_sum;
		
		$result=pg_query($dbconn, $sql_sum);

		echo '<input type="button" name="cancel" id="cancel" class="btn btn-info" value="CERRAR" onclick="toggle_visibility(\'loading-div-popup-form\')" />';	
		
	} // FIN (opcion-> updateContent)
		
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++// 
	//	ELIMINAR MUNICIPIOS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["opcion"] == 'deleteContent'){
			$id = $_POST["id"];
			echo "borrarContenido:".$id."\n";
			// header('Content-Type: application/json');

			$dbconn = my_dbconn4("PronosticoImpacto");
			$sql="DELETE FROM public.impacto_diario_consecuencias WHERE id_impacto_diario_detalle = ".$_POST["id"].";";
			// echo $sql;
			$result=pg_query($dbconn, $sql);
			
			$sql="DELETE FROM public.impacto_diario_horario WHERE id_impacto_diario_detalle = ".$_POST["id"].";";
			// echo $sql;
			$result=pg_query($dbconn, $sql);
			
			$sql="DELETE FROM public.impacto_diario_detalle WHERE id_impacto_diario_detalle = ".$_POST["id"].";";
			// echo $sql;
			$result=pg_query($dbconn, $sql);
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	CONSULTAR MUNICIPIOS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["opcion"] == 'getnoMuni'){
		
		$dbconn = my_dbconn4("PronosticoImpacto");
		$sql="SELECT de.departamento, i.cod_municipio, i.municipio, im.impacto, CONCAT(pr.probabilidad,' - ',pr.valor_probabilidad) as probabilidad, i.id_color FROM  impacto_diario_detalle i INNER JOIN departamento de ON de.cod_departamento = LEFT(i.cod_municipio, 2) INNER JOIN impacto im ON im.id_impacto = i.id_impacto INNER JOIN probabilidad pr ON pr.id_probabilidad = i.id_probabilidad WHERE i.id_impacto_diario = ".$_POST["id"]." AND municipio IS NOT NULL; ";
		$result=pg_query($dbconn, $sql);

		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$ro[] = $row;
		} pg_free_result($result);
		
		@$nomuni = array_column($ro, 'cod_municipio');
		@$imuni = implode("','", $nomuni);
		// $imuni = "'".implode("','", $nomuni)."'";

		echo json_encode($imuni, JSON_FORCE_OBJECT);
	}		
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	// INSERTAR UNIFICADO
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["opcion"] == 'insertUnificado'){
		$porciones = explode("&", urldecode ($_POST['formMuni']));
		// echo "<pre>";
		// print_r($porciones);
		// echo "</pre>";
		
		function xplo($val) {
			$v = explode("=", $val);
			return $v;
		}

		$ar=array();		
		for ($i=0; $i<=count($porciones)-1; $i++) {
			if (xplo($porciones[$i])[0] == 'titulo'){			$ar['titulo']		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'descripcion'){		$ar['descripcion']	= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'estado'){			$ar['estado']		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'uni1'){				$ar['uni1']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'uni2'){				$ar['uni2']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'uni3'){				$ar['uni3']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'opt1'){				$ar['opt1']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'opt2'){				$ar['opt2']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'opt3'){				$ar['opt3']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'periodo_text'){		$ar['periodo_text']		= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'fenomeno_text'){	$ar['fenomeno_text']	= xplo($porciones[$i])[1];}
		}
		
		// echo "/**********************/<br>";
		
		if (isset($ar['uni1'])) {$uni1=$ar['uni1'];	$area1 = 1;} else {	$uni1=''; }
		if (isset($ar['uni2'])) {$uni2=$ar['uni2'];	$area2 = 2;} else {	$uni2=''; }
		if (isset($ar['uni3'])) {$uni3=$ar['uni3'];	$area3 = 3;} else {	$uni3=''; }
                                                            
		if (isset($ar['opt1'])) {$opt1=$ar['opt1'];} else {	$opt1=''; }
		if (isset($ar['opt2'])) {$opt2=$ar['opt2'];} else {	$opt2=''; }
		if (isset($ar['opt3'])) {$opt3=$ar['opt3'];} else {	$opt3=''; }
		// echo "/**********************/<br>";
		
		// echo $uni1;
		// echo $uni2;
		// echo $uni3;
		
		$to_uni = trim($uni1.",".$uni2.",".$uni3,',');
		$to_uni = str_replace(",,", ",",$to_uni);
		
		// echo "<pre>";
		// print_r($ar);
		// echo "</pre>";
		
		# my code here
		# ------------------------------------------------------------------------ #
		# 1) ---***-*-*-*-*-- INGRESO A HISTORICO 
		$dbconn = my_dbconn4("PronosticoImpacto");
		$sql = "INSERT INTO public.his_impacto_diario(id_his_impacto_diario, id_area, id_fenomeno, fecha_creado, correlativo, titulo, descripcion, id_periodo, id_estado, id_usuario_creo, fecha_aprobado, id_usuario_aprobo, fecha_historico) 
		SELECT id_impacto_diario, id_area, id_fenomeno, fecha, correlativo, titulo, descripcion, id_periodo, id_estado_impacto, id_usuario, fecha_aprobado, id_usuario_aprobo, now()
		FROM public.impacto_diario
		WHERE id_impacto_diario in (".$to_uni.");";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		
		# 2) ---***-*-*-*-*-- INGRESO A HISTORICO DETALLE
		$sql = "
		INSERT INTO public.his_impacto_diario_detalle(id_his_impacto_diario_detalle, id_his_impacto_diario, cod_municipio, municipio, impacto, probabilidad, color, categoria, especial_atencion, descripcion, fecha_ingreso, id_usuario_ingreso, horarios, consecuencias, no_matriz, departamento)
		SELECT 
		dd.id_impacto_diario_detalle,    
		dd.id_impacto_diario,    
		dd.cod_municipio,
		dd.municipio,
		(SELECT i.impacto FROM public.impacto i WHERE dd.id_impacto=i.id_impacto) as impacto,
		(SELECT p.probabilidad FROM public.probabilidad p WHERE dd.id_probabilidad=p.id_probabilidad) as probabilidad,
		(SELECT c.color FROM public.color c WHERE dd.id_color=c.id_color) as color,
		(SELECT ca.des_categoria FROM public.categoria ca WHERE dd.id_categoria=ca.id_categoria) as categoria,
		dd.especial_atencion,
		dd.descripcion,
		dd.fecha_ingreso,
		dd.id_usuario_ingreso,
		(SELECT array_to_string(array(select h.horario from impacto_diario_horario ho INNER JOIN horario h ON h.id_horario = ho.id_horario where ho.id_impacto_diario_detalle = dd.id_impacto_diario_detalle), ', ')) as horarios,
		(SELECT array_to_string(array(select c.consecuencia from impacto_diario_consecuencias dc INNER JOIN consecuencia c ON c.id_consecuencia = dc.id_consecuencia where dc.id_impacto_diario_detalle = dd.id_impacto_diario_detalle), ', ')) as consecuencias,
		dd.id_impacto_probabilidad,
		(SELECT departamento FROM public.departamento WHERE  cod_departamento = LEFT(dd.cod_municipio, 2)) as departamento
		FROM public.impacto_diario_detalle dd
		WHERE dd.id_impacto_diario in (".$to_uni.");";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		
		# 3) --El valor id_impacto_probabilidad mayor de los tres 36,53,81
		$sql = "
		INSERT INTO public.unificado(titulo_general, des_general, periodo, fenomeno, id_impacto_probabilidad, fecha_ingresado, id_usuario_ingreso, des_categoria)
		VALUES ('".$ar['titulo']."', '".$ar['descripcion']."', '".$ar['periodo_text']."', '".$ar['fenomeno_text']."', (select max(no_matriz) from public.his_impacto_diario_detalle WHERE id_his_impacto_diario in (".$to_uni.")),
		NOW(), 1, '".$ar['estado']."');";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		
		$values = "";
		if ($uni1 !="") { $values .= " \n((SELECT currval('unificado_id_unificado_seq1')), ".$uni1.",".$area1."),";}
		if ($uni2 !="") { $values .= " \n((SELECT currval('unificado_id_unificado_seq1')), ".$uni2.",".$area2."),";}
		if ($uni3 !="") { $values .= " \n((SELECT currval('unificado_id_unificado_seq1')), ".$uni3.",".$area3."),";}
		$values = trim($values,',');

		$sql ="INSERT INTO public.unificado_informe(id_unificado, id_his_impacto_diario,id_area) VALUES ".$values.";";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		
		# 4) ----**-*-*-*- BORRAR REGISTOS DE IMPACTO DIARIO (Por el momento Inhabilitar)
		$sql = "UPDATE public.impacto_diario SET  id_estado_impacto=6 WHERE id_impacto_diario in (".$to_uni.");";
		// echo $sql;
		$result=pg_query($dbconn, $sql);
		if(isset($result)){  echo 'done'; }

	# my code here
	# ------------------------------------------------------------------------ #

	}

	if($_POST["opcion"] == 'getUnificado'){
		
		$u1 = @$_POST["u1"];
		$u2 = @$_POST["u2"];
		$u3 = @$_POST["u3"];
		
		$to_uni = trim($u1.",".$u2.",".$u3,',');
		$to_uni = str_replace(",,", ",",$to_uni);
		
		if (strlen($to_uni)>0) {
			$dbconn = my_dbconn4("PronosticoImpacto");
			$sql = "
			SELECT id_impacto_probabilidad as imax, c.des_categoria as desc
			FROM public.categoria c 
			inner join public.impacto_probabilidad ip on ip.id_categoria = c.id_categoria
			WHERE ip.id_impacto_probabilidad IN 
			(SELECT max(id_impacto_probabilidad) FROM public.impacto_diario_detalle where id_impacto_diario in (".$to_uni."));
			";
			$result=pg_query($dbconn, $sql);
			while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				$ro[] = $row;
			} pg_free_result($result);
			$ro = $ro[0];

			// echo json_encode($ro, JSON_FORCE_OBJECT);
			echo json_encode($ro, JSON_FORCE_OBJECT);
		}
		else {
			echo json_encode("", JSON_FORCE_OBJECT);
			}
		
	}
	

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++




?>