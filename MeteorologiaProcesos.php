<?php
//fetch.php

header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');
//console.log($_POST['AgregarMuni']);

//var_dump($_POST);
//exit();
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if(isset($_POST['registrar'])){

	// IMPACTO DIARIO
	$id_impacto_diario=100;
	$id_area = $_POST["id_area"];
	$id_fenomeno= $_POST["id_fenomeno"];
	$correlativo= $_POST["correlativo"];
	$titulo= $_POST["titulo"];
	$descripcion= $_POST["descripcion"];
	$id_periodo= $_POST["periodo"];
	$id_estado_impacto= 1;
	$id_uduario = 1;
	$id_impacto_fenomeno= $_POST["ImpactoFenomeno"];
	$fecha_ini= strtotime($_POST["fecha_ini"]);
	$fecha_fin= strtotime($_POST["fecha_fin"]);

	//// INGRESO DE DATOS GENERALES
	$sqlIngresoDatosGenerales="INSERT INTO public.impacto_diario(
	 id_area, id_fenomeno, fecha, correlativo, titulo, descripcion, id_periodo, id_estado_impacto, id_impacto_fenomeno, id_usuario, fecha_ini, fecha_fin)
		VALUES ($id_area, $id_fenomeno, NOW(), $correlativo, '$titulo', '$descripcion', $id_periodo, $id_estado_impacto, $id_impacto_fenomeno, $id_uduario,
		'".date('Y-m-d', $fecha_ini)."', '".date('Y-m-d', $fecha_fin)."')";
	// var_dump($sqlIngresoDatosGenerales);
	// echo $sqlIngresoDatosGenerales;
	// exit();
	$resultIngresoDatosGenerales = pg_query($sqlIngresoDatosGenerales) or die('Query failed: '.pg_last_error()); 
	
	$sql="SELECT currval('impacto_diario_seq')";
	$result = pg_query($sql) or die('Query failed: '.pg_last_error()); 
	$con = pg_fetch_all($result);
	$con = $con[0];
	
	echo json_encode($con, JSON_FORCE_OBJECT);
	
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if(isset($_POST['formMuni'])){

$porciones = explode("&", urldecode ($_POST['formMuni']));
// echo "<pre>";
// print_r($porciones);
// echo "</pre>";
// $tipo_zona_dpto='';
// $municipio[] ='';


function xplo($val) {
	$v = explode("=", $val);
	return $v;
}
// echo xplo($porciones[0])[0];

// $id_impacto_diario = 2;
$id_usuario = 1;
$fecha_ingreso = date('Y-m-d');

for ($i=0; $i<=count($porciones)-1; $i++) {
	
	if (xplo($porciones[$i])[0] == 'tipo_zona_dpto'){ 	$tipo_zona_dpto = xplo($porciones[$i])[1];}
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
	
	if (xplo($porciones[$i])[0] == 'id_impacto_diario_m'){	$id_impacto_diario	= xplo($porciones[$i])[1];}
	// echo $i;
}

// var_dump ($tipo_zona_dpto); # Departamento/Zona
// var_dump ($zona_dpto);
// var_dump($categoria);
// var_dump($id_impacto_diario);
// var_dump($code_muni);
// var_dump($name_muni);

// var_dump ($id_impacto);
// var_dump ($id_probabilidad);
// var_dump ($id_color);
// var_dump ($id_categoria);
// var_dump($fecha_ingreso);

// var_dump($datos);
// var_dump($datosh);

// echo "<script>console.log('llego aqui')</script>";
// console.log($_POST['formMunicipios']);

$sql_co = "";
for ($i=0; $i<=count($datos)-1; $i++) {
	$sql_1 = "INSERT INTO public.impacto_diario_consecuencias(id_impacto_diario_detalle, id_consecuencia) VALUES ((SELECT currval('impacto_diario_detalle_id_impacto_diario_detalle_seq')), ".$datos[$i]."); \n";
	$sql_co .=$sql_1;
}
// echo $sql_co;

$sql_ho = "";
for ($i=0; $i<=count($datosh)-1; $i++) {
	$sql_2 = "INSERT INTO public.impacto_diario_horario(id_impacto_diario_detalle, id_horario) VALUES ((SELECT currval('impacto_diario_detalle_id_impacto_diario_detalle_seq')), ".$datosh[$i]."); \n";
	$sql_ho .=$sql_2;
}
// echo $sql_ho;

include('database_connection.php');
	
$str_sql = "";
for ($i=0; $i<=count($code_muni)-1; $i++) {
// INSERT INTO persons (lastname,firstname) VALUES ('Smith', 'John') RETURNING id;
$sql = 	"INSERT INTO public.impacto_diario_detalle(id_impacto_diario, cod_municipio, municipio, id_impacto, id_probabilidad, id_color, id_categoria, fecha_ingreso, id_usuario_ingreso, des_categoria) VALUES (".$id_impacto_diario.", '".$code_muni[$i]."', '".$name_muni[$i]."', ".$id_impacto.", ".$id_probabilidad.", ".$id_color.", ".$id_categoria.", '".$fecha_ingreso."', ".$id_usuario.",'".$categoria."') RETURNING id_impacto_diario_detalle; \n";
$sql_sum = $sql_co.$sql_ho;

// echo "--".$name_muni[$i]."\n\n";
// echo $sql."\n\n";
// echo $sql_sum."\n\n";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
$result = pg_query($sql_sum) or die('Query failed: ' . pg_last_error());
}
// exit();
// echo "<br>".$Sql."<br>";
    //$result=pg_query($connect, $Sql);

	if(isset($result))
	{
		echo 'done';
	}
// exit();

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ------------------ AGREGAR MUNICIPIOS ------------------------------
if(isset($_POST['action'])){
$estado = $_POST['query'];
	include('database_connection.php');
	@$output = '';

	if($_POST["action"] == 'tipo_zona_dpto'){
		if ($estado == 'Departamento' ) {
		$Sql =	"select t.zona_dpto from public.municipio_zona_dpto m 
				inner join public.zona_dpto t on m.id_zona_dpto=t.id_zona_dpto
				inner Join public.tipo_zona_dpto tzd on m.id_tipo_zona_dpto=tzd.id_tipo_zona_dpto where tzd.tipo_zona_dpto='$estado' GROUP BY t.zona_dpto";
		}
		else {
		$Sql =	"select t.zona_dpto from public.municipio_zona_dpto m 
				inner join public.zona_dpto t on m.id_zona_dpto=t.id_zona_dpto
				inner Join public.tipo_zona_dpto tzd on m.id_tipo_zona_dpto=tzd.id_tipo_zona_dpto where tzd.tipo_zona_dpto='$estado' AND t.id_area = 1 GROUP BY t.zona_dpto";	
		}
	
		$result=pg_query($connect, $Sql);

		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {

		$Estados[] = $row;
		} pg_free_result($result);

		# Cerrar conexion a base de datos
		pg_close($connect);		
			$result=$Estados;
			foreach($result as $row)
			{
				$output .= '<option value="'.$row["zona_dpto"].'">'.$row["zona_dpto"].'</option>';
			}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	if($_POST["action"] == 'zona_dpto'){
		$ciudad = $_POST['query'];
		$filter = $_POST['nomuni'];
		
		$Sql = "SELECT mzd.cod_municipio, m.nombre FROM public.municipio_zona_dpto as mzd inner join public.municipio as m on mzd.cod_municipio=m.cod_municipio
		inner join public.zona_dpto as zd on zd.id_zona_dpto=mzd.id_zona_dpto where zd.zona_dpto = '$ciudad' AND mzd.cod_municipio NOT IN ('$filter'); ";

		
		$result=pg_query($connect, $Sql);

		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {

		$Ciudad[] = $row;
		} pg_free_result($result);
		
		$result=$Ciudad;

		foreach($result as $row)
		{
			$output .= '<option value="'.$row["cod_municipio"].'_'.$row["nombre"].'">'.$row["nombre"].'</option>';
		}
	}
	echo $output;
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if(isset($_POST['consecuencias'])){
		$id_impacto = $_POST["impacto"];
		$id_area = $_POST["id_area"];
		$id_fenomeno = $_POST["id_fenomeno"];

		//// CHECK CONSECUENCIA
		$sqlConsecuencias="SELECT ci.id_consecuencia_impacto,ci.id_area, ci.id_fenomeno, ci.id_impacto, (SELECT c.consecuencia FROM public.consecuencia c where c.id_consecuencia=ci.id_consecuencia), ci.estado
		FROM public.consecuencia_impacto ci
		where ci.id_fenomeno= $id_fenomeno and ci.id_area=$id_area and ci.id_impacto= $id_impacto;";
		$resultConsecuencias = pg_query($sqlConsecuencias) or die('Query failed: '.pg_last_error()); 
		$con = pg_fetch_all($resultConsecuencias);
		//$con = $con[0];
		echo json_encode($con, JSON_FORCE_OBJECT);
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if(isset($_POST['categoria'])){

		header('Content-Type: application/json');

		$id_impacto= $_POST["impacto"];
		$id_probabilidad= $_POST["probabilidad"];

		$sqlCategoria="SELECT ip.id_color, c.id_categoria, c.categoria FROM public.impacto_probabilidad as ip inner join public.categoria as c on ip.id_categoria=c.id_categoria where ip.id_impacto = $id_impacto and ip.id_probabilidad=$id_probabilidad";
		$resultCategoria = pg_query($sqlCategoria) or die('Query failed: '.pg_last_error());
		$categoria = pg_fetch_all($resultCategoria);
		$categoria = $categoria[0];
		echo json_encode($categoria, JSON_FORCE_OBJECT);
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//--------------------------------------------------
// OPCIONES PARA EL FORMULARIO
//--------------------------------------------------
if(isset($_POST['opcion'])){
	
// Abrimos una conexion a la base de datos
include("cnn.php");
		
		// Obtenemos una lista de los municipios ya insertados
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
		
		// Eliminamos el registro que no necesitamos
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
				
				/*
				while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
					$ro[] = $row;
				} pg_free_result($result);

				echo "<pre>\n";
				print_r($ro);
				echo "</pre>";
				*/
			// echo json_encode($categoria, JSON_FORCE_OBJECT);
		}
		

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++




?>