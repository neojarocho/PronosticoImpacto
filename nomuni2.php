<?php
include("cnn.php");

$dbconn = my_dbconn4("PronosticoImpacto");
$sql="SELECT de.departamento, i.cod_municipio, i.municipio, im.impacto, CONCAT(pr.probabilidad,' - ',pr.valor_probabilidad) as probabilidad, i.id_color FROM  impacto_diario_detalle i INNER JOIN departamento de ON de.cod_departamento = LEFT(i.cod_municipio, 2) INNER JOIN impacto im ON im.id_impacto = i.id_impacto INNER JOIN probabilidad pr ON pr.id_probabilidad = i.id_probabilidad WHERE i.id_impacto_diario = ".$_GET["id"]." AND municipio IS NOT NULL; ";
$result=pg_query($dbconn, $sql);

while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ro[] = $row;
} pg_free_result($result);
$nomuni = array_column($ro, 'cod_municipio');
$imuni = $nomuni;
// $imuni = "'".implode("','", $nomuni)."'";

// echo "<pre>";
// print_r($ro);
// print_r($imuni);
// echo "</pre>";

// function getColor($id_color) {
	// if ($id_color == 1){ $color = "<td style='background: rgba(63, 195, 128, 1);'>verde</td>"; }
	// if ($id_color == 2){ $color = "<td style='background: rgba(254, 241, 96, 1);'>Amarillo</td>"; }
	// if ($id_color == 3){ $color = "<td style='background: rgba(252, 185, 65, 1);'>Anaranjado</td>"; }
	// if ($id_color == 4){ $color = "<td style='background: rgba(240, 52, 52, 1);'>Rojo</td>"; }
	// return $color;
// }

echo json_encode($imuni, JSON_FORCE_OBJECT);
?>