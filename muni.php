<?php
include("cnn.php");

$dbconn = my_dbconn4("PronosticoImpacto");
$sql="SELECT i.id_impacto_diario_detalle, de.departamento, i.municipio, im.impacto, CONCAT(pr.probabilidad,' - ',pr.valor_probabilidad) as probabilidad, i.id_color FROM  impacto_diario_detalle i INNER JOIN departamento de ON de.cod_departamento = LEFT(i.cod_municipio, 2) INNER JOIN impacto im ON im.id_impacto = i.id_impacto INNER JOIN probabilidad pr ON pr.id_probabilidad = i.id_probabilidad WHERE i.id_impacto_diario = ".$_GET["id"]." AND municipio IS NOT NULL ORDER BY i.cod_municipio; ";
$result=pg_query($dbconn, $sql);

while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ro[] = $row;
} pg_free_result($result);

// echo "<pre>";
// print_r($ro);
// echo "</pre>";

function getColor($id_color) {
	if ($id_color == 1){ $color = "<td style='background: rgba(63, 195, 128, 1);'>verde</td>"; 		}
	if ($id_color == 2){ $color = "<td style='background: rgba(254, 241, 96, 1);'>Amarillo</td>"; 	}
	if ($id_color == 3){ $color = "<td style='background: rgba(252, 185, 65, 1);'>Anaranjado</td>"; }
	if ($id_color == 4){ $color = "<td style='background: rgba(240, 52, 52, 1);'>Rojo</td>"; 		}
	return $color;
}

?>
		<div class="col-md-12">
			<table class="table table-bordered"> 
				<tr style="background:#f2f2f2;">  
					<th width="20%">Departamento</th>
					<th width="20%">Municipio</th> 
					<th width="10%">Impacto</th> 
					<th width="10%">Probabilidad</th>  
					<th width="5%">Color</th>
					<th width="5%"></th>  
					<th width="5%"></th>  
				</tr>  
				<?php
				for($i=0;$i <= count(@$ro)-1 ;$i++){
				echo	"<tr>".
						"<td>".$ro[$i]['departamento']	."</td>".
						"<td>".$ro[$i]['municipio']		."</td>".
						"<td>".$ro[$i]['impacto']		."</td>".
						"<td>".$ro[$i]['probabilidad']	."</td>".
						// "<td>".$ro[$i]['id_color']		."</td>".
						getColor($ro[$i]['id_color']).
						"<td align='center'><button type='button' class='btn btn-info glyphicon glyphicon-pencil btn-sm'	onclick='myFunction(".$ro[$i]['id_impacto_diario_detalle'].");' 	id='".$ro[$i]['id_impacto_diario_detalle']."'></button></td>".
						"<td align='center'><button type='button' class='btn btn-danger glyphicon glyphicon-remove btn-sm' 	onclick='deleteContent(".$ro[$i]['id_impacto_diario_detalle'].");' 	id='".$ro[$i]['id_impacto_diario_detalle']."'></button></td>".
						"</tr>";	
				}
				?>		  
			</table>  
			<br />
		</div>
		