<?php
include("cnn.php");

$fecha 		= $_GET["f"];
$periodo 	= $_GET["p"];
$id_fenomeno = $_GET["idf"];

if ($periodo==''){
	exit();
}
// echo $fecha."<->".$periodo."<->".$id_fenomeno."<->";

/*
SELECT COUNT(i.id_impacto_diario) AS ci
FROM  impacto_diario_detalle i 
WHERE i.id_impacto_diario = 128 AND municipio IS NOT NULL ;
*/

$dbconn = my_dbconn4("PronosticoImpacto");
$sql="	SELECT 
			im.id_impacto_diario AS id_impacto_diario, 
			(SELECT COUNT(cod_municipio) FROM  impacto_diario_detalle WHERE id_impacto_diario = im.id_impacto_diario) AS tim,
			im.id_area, ar.area, im.id_fenomeno, im.fecha, to_char(im.fecha, 'DD/MM/YYYY') as sfecha, 
			to_char(im.fecha, 'HH12:MI:SS') as hora, im.correlativo, im.titulo, im.descripcion, im.id_periodo, 
			im.id_estado_impacto, im.id_usuario 
		FROM public.impacto_diario im
			INNER JOIN area ar ON ar.id_area = im.id_area
		WHERE im.fecha::text LIKE '".$fecha."%' AND im.id_periodo = ".$periodo." AND im.id_fenomeno = ".$id_fenomeno." AND im.id_estado_impacto NOT IN (6) ORDER BY im.id_area;";

/*
$sql="	SELECT 
			im.id_impacto_diario, im.id_area, ar.area, im.id_fenomeno, im.fecha, to_char(im.fecha, 'DD/MM/YYYY') as sfecha, 
			to_char(im.fecha, 'HH12:MI:SS') as hora, im.correlativo, im.titulo, im.descripcion, im.id_periodo, 
			im.id_estado_impacto, im.id_usuario 
		FROM public.impacto_diario im
			INNER JOIN area ar ON ar.id_area = im.id_area
		WHERE im.fecha::text LIKE '".$fecha."%' AND im.id_periodo = ".$periodo." AND im.id_fenomeno = ".$id_fenomeno." AND im.id_estado_impacto NOT IN (6) 
		GROUP BY im.id_impacto_diario, im.id_area, ar.area, im.id_fenomeno
		HAVING (SELECT COUNT(i.id_impacto_diario) AS ci
		FROM  impacto_diario_detalle i 
		WHERE i.id_impacto_diario = im.id_impacto_diario AND municipio IS NOT NULL) > 0;";
*/

$result=pg_query($dbconn, $sql);
// echo $sql;
$totalRows = pg_num_rows($result);
if ($totalRows == 0) {
	echo "<div class='col-md-12' style='color:red;'>NO HAY COINCIDENCIAS PARA ESTA BÚSQUEDA <br><br></div>";
	exit();
}

?>
		<div class="col-md-12">
            <table class="table table-bordered">
                <tr style="background:#EEEEEE;">
                        <th width="20%">Area</th>
                        <th width="75%">Título</th>
                        <th width="75%">Impacto</th>
                        <th width="25%">Fecha</th>
                        <th width="20%">Hora</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                </tr>
                <?php  
				$i = 0;
                while($row = pg_fetch_array($result))  
                {  $i+=1;
                ?>  
				<tr id="<?php echo "tr".$i; ?>" style="background:#FFFFFF;"> 
					<td>
						<div id='<?php echo 'spa'.$row["id_area"];?>'>
						<input type='hidden' id='<?php echo 'uni'.$row["id_area"];?>' name='<?php echo 'uni'.$row["id_area"];?>' value='<?php echo $row["id_impacto_diario"]; ?>'>
						<?php echo $row["area"]; ?>
						</div>
					</td>
					<td>
						<?php echo $row["titulo"]; ?>
						<input type='hidden' id='<?php echo 'desc'.$row["id_area"];?>' name='<?php echo 'desc'.$row["id_area"];?>' value='<?php echo $row["descripcion"]; ?>'>
					</td>
					<td align="center"><?php if ($row["tim"]>0) { echo "SI (".$row["tim"].")"; }  else { echo "NO"; } ?></td>
					<td><?php echo $row["sfecha"]; ?></td>
					<td><?php echo $row["hora"]; ?></td>
					<td align="center"><button type="button" class="btn btn-info glyphicon glyphicon-search btn-sm" 	id="<?php echo $row["id_impacto_diario"]; ?>" onclick="showMyMap(<?php echo $row['id_impacto_diario']; ?>);" ></button></td>
					<td align="center"><button type="button" class="btn btn-danger glyphicon glyphicon-remove btn-sm" 	id="<?php echo "tr".$i ?>" onclick="trDetach($(this).attr('id'))"></button></td>
				</tr>
					<?php  
                }  
                ?>  
            </table>  
		</div>