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
$id_estado_impacto= $_POST["id_estado_impacto"];
$id_impacto_fenomeno= $_POST["ImpactoFenomeno"];
$fecha_ini= strtotime($_POST["fecha_ini"]);
$fecha_fin= strtotime($_POST["fecha_fin"]);

//// INGRESO DE DATOS GENERALES
 $sqlIngresoDatosGenerales="INSERT INTO public.impacto_diario(
 id_area, id_fenomeno, fecha, correlativo, titulo, descripcion, id_periodo, id_estado_impacto, id_impacto_fenomeno, id_uduario, fecha_ini, fecha_fin)
 	VALUES ($id_area, $id_fenomeno, NOW(), $correlativo, '$titulo', '$descripcion', $id_periodo, 1, $id_impacto_fenomeno,1,
 	'".date('Y-m-d', $fecha_ini)."', '".date('Y-m-d', $fecha_fin)."')";
 $resultIngresoDatosGenerales = pg_query($sqlIngresoDatosGenerales) or die('Query failed: '.pg_last_error()); 
//var_dump($sqlIngresoDatosGenerales);
//exit();

$sqlId_impacto_diario="SELECT max(id_impacto_diario) FROM public.impacto_diario;";
$resultId_impacto_diario = pg_query($sqlId_impacto_diario) or die('Query failed: '.pg_last_error()); 
while($row = pg_fetch_array($resultId_impacto_diario, null, PGSQL_ASSOC)) {
	$Id_impacto_diario[] = $row;
} pg_free_result($resultId_impacto_diario);

//echo ($id_impacto_diario[0]["max"]);
$Id_impacto_diario = $Id_impacto_diario[0]["max"];
//var_dump($id_impacto_diario);
echo $Id_impacto_diario;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if(isset($_POST['AgregarMuni'])){

//console.log('llego aqui');
//console.log($_POST['formMunicipios']);

//var_dump($_POST['AgregarMuni']);



$pais = $_POST['tipo_zona_dpto'];
$estado = $_POST['zona_dpto'];
$ciudades = $_POST['municipio'];


	include('database_connection.php');
	

$Sql = "INSERT INTO public.impacto_diario_detalle(
	id_impacto_diario, cod_municipio, id_impacto, id_probabilidad, id_color, id_categoria, especial_atencion, id_usuario, descripcion, fecha_ingreso, horarios)
	VALUES (1, '$ciudades', 1, 1, 1, 1, 1, 'Especial atención en', 1, 'Descripción', 1);";
$result = pg_query($Sql) or die('Query failed: ' . pg_last_error());
// echo "<br>".$Sql."<br>";
// exit();
    //$result=pg_query($connect, $Sql);

	if(isset($result))
	{
		echo 'done';
	}

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ------------------ AGREGAR MUNICIPIOS ------------------------------
if(isset($_POST['action'])){

$estado = $_POST['query'];
	include('database_connection.php');
	$output = '';

	if($_POST["action"] == 'tipo_zona_dpto'){			
		$Sql="select t.zona_dpto from public.municipio_zona_dpto m inner join public.zona_dpto t on m.id_zona_dpto=t.id_zona_dpto
Inner Join public.tipo_zona_dpto tzd on m.id_tipo_zona_dpto=tzd.id_tipo_zona_dpto where tzd.tipo_zona_dpto='$estado' GROUP BY t.zona_dpto";	
	
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
		
		$Sql = "SELECT m.nombre FROM public.municipio_zona_dpto as mzd inner join public.municipio as m on mzd.cod_municipio=m.cod_municipio
		inner join public.zona_dpto as zd on zd.id_zona_dpto=mzd.id_zona_dpto where zd.zona_dpto = '$ciudad'";

		$result=pg_query($connect, $Sql);

		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {

		$Ciudad[] = $row;
		} pg_free_result($result);
		
		$result=$Ciudad;

		foreach($result as $row)
		{
			$output .= '<option value="'.$row["nombre"].'">'.$row["nombre"].'</option>';
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

		$sqlCategoria="SELECT ip.id_color, ip.id_categoria, c.categoria FROM public.impacto_probabilidad as ip inner join public.categoria as c on ip.id_categoria=c.id_categoria where ip.id_impacto = $id_impacto and ip.id_probabilidad=$id_probabilidad";
		$resultCategoria = pg_query($sqlCategoria) or die('Query failed: '.pg_last_error());
		$categoria = pg_fetch_all($resultCategoria);
		$categoria = $categoria[0];
		echo json_encode($categoria, JSON_FORCE_OBJECT);
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++





?>