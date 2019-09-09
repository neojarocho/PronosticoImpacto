<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: text/html; charset=utf-8");
include_once("cnn.php");


// $buscar = @$_REQUEST["id"];
// $nivel = @$_REQUEST["N"];

$buscar = @$arr['id_unificado'];
$nivel = @$arr['nivel'];
// echo "*************************".$buscar."*************************";
if(strlen (@$buscar)>0){$buscar = @$arr['id_unificado'];} else {$buscar = 12; $nivel=1;}
// if(strlen (@$buscar)>0){$buscar = @$_REQUEST["id"];} else {$buscar = 12; $nivel=1;}
// echo "********************************".$buscar."********************************";
// echo "********************************".$nivel."********************************";


if 		($nivel == 4){ $str_nivel = "4"; 		$s1=0; $s2=0; $s3=0; $s4=1;} 
elseif 	($nivel == 3){ $str_nivel = "3,4"; 		$s1=0; $s2=0; $s3=1; $s4=1;}
elseif 	($nivel == 2){ $str_nivel = "2,3,4"; 	$s1=0; $s2=1; $s3=1; $s4=1;} 
elseif 	($nivel == 1){ $str_nivel = "1,2,3,4"; 	$s1=1; $s2=1; $s3=1; $s4=1;} 
else 	{$str_nivel = ""; 						$s1=0; $s2=0; $s3=0; $s4=0;}

// echo $nivel.":".$str_nivel;
///----------------------*************************************-------------------------------------------------
/// INFORMACIÓN GENERAL
$dbconn = my_dbconn4("PronosticoImpacto");
$sqlUnificado="SELECT u.id_unificado,u.fenomeno, u.titulo_general, u.des_general, u.periodo, u.fecha_ingresado, u.des_categoria, u.des_categoria,	(SELECT c.codigo
	FROM public.impacto_probabilidad ip inner join public.color c on ip.id_color=c.id_color
	where ip.id_impacto_probabilidad=u.id_impacto_probabilidad) as codigo,
		CASE WHEN UPPER(u.des_categoria)='ATENCIÓN' THEN '<div style=&#quot;color:#7f7f7f !important; margin-bottom: 0px !important;&#quot;>ATENCIÓN: '||u.titulo_general||'</div>'
            ELSE UPPER(u.des_categoria)||': '||u.titulo_general END as des_categoria
    FROM public.unificado u
    WHERE u.id_unificado= $buscar;";
$resultUnificado = pg_query($dbconn, $sqlUnificado);
$Unificados = pg_fetch_all($resultUnificado);
$Unificados = $Unificados[0];

/*************************************************/
### FORMATO DE FECHA LARGA IVAN MORAN
/*************************************************/

$str_fecha = strtotime($Unificados["fecha_ingresado"]);
$fecha 	= date('Y-m-d', $str_fecha);
$dia 	= date('d', $str_fecha);
$mes 	= date('m', $str_fecha);
$ani 	= date('Y', $str_fecha);
$dow 	= date('w', $str_fecha);
$hora	= date('h:i:s A', $str_fecha);
$strmes  = Array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
$strweek = Array(0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Mieroles',4=>'Jueves',5=>'Viernes',6=>'Sabado');

$fecha_larga = $strweek[intval($dow)]." ".$dia." de ".$strmes[intval($mes)]." del ".$ani." ".$hora;

// echo  $fecha_larga;

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$AreaResumen = "";
$sqlGridAreaResumen="SELECT a.imagen, concat(a.condiciones,' ',idd.descripcion) as condiciones
	FROM public.his_impacto_diario idd inner join public.area a on idd.id_area=a.id_area
	where idd.id_his_impacto_diario in (SELECT i.id_his_impacto_diario FROM public.unificado_informe i where i.id_unificado = $buscar)";
$resultGridAreaResumen = pg_query($dbconn, $sqlGridAreaResumen);
$AreaResumen = pg_num_rows($resultGridAreaResumen);


//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------TOMAR ACCIÓN----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$sqlTomarAccion="SELECT f_reporte_unificado($buscar,'Tomar acción');";
$resultGridTomarAccion = pg_query($dbconn,$sqlTomarAccion);
$TomarAccion = pg_fetch_all($resultGridTomarAccion);
$TomarAccion = $TomarAccion[0]['f_reporte_unificado'];
if (count($TomarAccion)>0){ $sc1=1;} else { $sc1=0; }
// echo count($TomarAccion);
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------ESTAR PREPARADOS----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$sqlGridEstarPreparados="SELECT f_reporte_unificado($buscar,'Preparación');";
$resultGridEstarPreparados = pg_query($dbconn, $sqlGridEstarPreparados);
$EstarPreparados = pg_fetch_all($resultGridEstarPreparados);
$EstarPreparados = $EstarPreparados[0]['f_reporte_unificado'];
if (count($EstarPreparados)>0){ $sc2=1;} else { $sc2=0; }
// echo count($EstarPreparados);
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------ESTAR INFORMADOS----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$sqlGridEstarInformados="SELECT f_reporte_unificado($buscar,'Atención');";
$resultGridEstarInformados = pg_query($dbconn, $sqlGridEstarInformados);
$EstarInformados = pg_fetch_all($resultGridEstarInformados);
$EstarInformados = $EstarInformados[0]["f_reporte_unificado"];
if (count($EstarInformados)>0){ $sc3=1;} else { $sc3=0; }
// echo count($EstarInformados);
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//--------------------------------CONDICIONES NORMALES----------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
$sqlGridCondicionesNormales="SELECT f_reporte_unificado($buscar,'Vigilancia');";
$resultGridCondicionesNormales = pg_query($dbconn, $sqlGridCondicionesNormales);
$CondicionesNormales = pg_fetch_all($resultGridCondicionesNormales);
$CondicionesNormales = $CondicionesNormales[0]["f_reporte_unificado"];
if (count($CondicionesNormales)>0){ $sc4=1;} else { $sc4=0; }
// echo count($CondicionesNormales);
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

// $dbconn = my_dbconn("PronosticoImpacto");
$query="SELECT hd.id_his_impacto_diario_detalle, hd.id_his_impacto_diario, hd.cod_municipio, hd.municipio, (SELECT departamento FROM public.municipio m inner join public.departamento d on m.cod_departamento=d.cod_departamento and m.cod_municipio = hd.cod_municipio) as departamento, hd.no_matriz, hd.impacto, hd.probabilidad, 
co.id_color,hd.color, (SELECT c.codigo	FROM public.color c where c.color=hd.color) as codigo,(SELECT c.transparencia	FROM public.color c where c.color=hd.color) as transparencia,
(SELECT array_to_string(array(SELECT concat('<p>','<li>',hdk.consecuencias,'.</p>','<p>',hdk.especial_atencion,'<p>','<b><i>Por la ',hdk.horarios,'.</i></b>')
							  from public.his_impacto_diario_detalle hdk 
							  where  hdk.cod_municipio=hd.cod_municipio and hdk.id_his_impacto_diario in (SELECT id_his_impacto_diario 
																   FROM public.unificado_informe	
																   where id_unificado= $buscar) 
							  order by no_matriz desc), NULL))
						 as Consecuencias,
hd.categoria, hd.fecha_ingreso, hd.id_usuario_ingreso
FROM public.his_impacto_diario_detalle hd 
INNER JOIN color co ON co.color = hd.color
where hd.id_his_impacto_diario in (SELECT id_his_impacto_diario FROM public.unificado_informe	where id_unificado= $buscar)
and co.id_color IN ($str_nivel)
and hd.no_matriz= (select max(no_matriz)
							  from public.his_impacto_diario_detalle 
							  where  id_his_impacto_diario in (SELECT id_his_impacto_diario FROM public.unificado_informe	where id_unificado= $buscar)
								and cod_municipio=hd.cod_municipio
								GROUP BY cod_municipio,municipio)
ORDER BY hd.cod_municipio;";
$result=pg_query($dbconn, $query);
// echo $query;
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$sh[] = $row;
} pg_free_result($result);
// pg_close($dbconn);

if (count(@$sh)==0){
echo "<div>NO HAY MUNICIPIOS INGRESADOS TODAVIA</div>";
exit();
}

// echo "<pre>";
// print_r($sh);
// echo "</pre>";

// $dbconn = my_dbconn4("PronosticoImpacto");
$query="SELECT u.id_unificado, u.titulo_general, u.des_general, periodo, u.fecha_publicado, u.publicar, u.enviar_instituciones, u.envio_general, u.id_usuario_ingreso, fenomeno, u.id_impacto_probabilidad, u.des_categoria,
	(SELECT c.codigo
	FROM public.impacto_probabilidad ip inner join public.color c on ip.id_color=c.id_color
	where ip.id_impacto_probabilidad=u.id_impacto_probabilidad) as codigo
FROM public.unificado u where u.id_unificado = $buscar; ";
$result= pg_query($dbconn, $query);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ti[] = $row;
} pg_free_result($result);
pg_close($dbconn);
// $ti = $ti[0];

// echo "<pre>";
// print_r($ti);
// echo "</pre>";
// var_dump($sh);
?>

<meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no">
<title>MARN | Pronostico de Impacto</title>

<!-- Custom CSS -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
<!-- para correo no vale css aqui -->
</style>
   
   
<script type="text/javascript">
<!-- para correo no vale jquery -->
</script>
</head>
<body>
<div class="container" style="background: #fff;">

<table border=0 style="font: Verdana, Arial, Helvetica, sans-serif; width:100%;">           
<tr>
	<td>
		<div>
				<div id="banner" >
					<a>
						<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/Banner3.png" width="100%" id="PaginaInicio">
					</a>
				 </div>
		</div>
	</td>
</tr>

<tr>
	<td>
			<table border=0 style="width:100%;"> 
				<tr>
					<td colspan=2>
						<div style="color:#ffffff; margin-top:15px; margin-bottom:15px; background: <?php echo $Unificados["codigo"];?>;">
						
						
						
						
							<div style="text-align:center;">
							<div style="padding-top: 5px;padding-bottom: 5px; margin-bottom: 0px;"><?php echo $Unificados["des_categoria"];?></div>
							</div>
						</div>
					</td>	
				</tr>		
			
				<tr style="text-align:left; color:#428bca;font-weight: bold;">
					<td>
						<input type="hidden" id="fecha_ingresado" name="fecha_ingresado" value="<?php echo $Unificados["fecha_ingresado"];?>" style="display:none"/>
						<b><?php echo $fecha_larga;?> </b>	
					</td>
					<td style="text-align: right">
					<b>Período: <?php echo $Unificados["periodo"];?></b>
					</td>
				</tr>  
				<tr>
					<td colspan=2>
						<div><br></div>
					</td>	
				</tr>
				<tr>
					<td colspan=2>
						<div id="descripcion" style="color:black;"><?php echo $Unificados["des_general"];?></div>
					</td>
				</tr>
				
				<tr>
					<td colspan=2>
					<!-- CONTENIDO MAPA-->
						<div class="mapa_marco" align="center">
							<div id="map">
								<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/img_impacto/mapa_unificado_<?php echo $buscar; ?>.jpg" width="100%" style="display:block;">
							</div>
						</div>
					</td>
				</tr>
			</table>   
	</td>
</tr >

<tr>
<td>


		<?php if($s1==1 and $sc1==1) {?>		
		<!---------------------------------------------------------------------------------------------> 
		<!--------------------------------------------TOMAR ACCIÓN-------------------------------------> 
		<!--------------------------------------------------------------------------------------------->
				<div id="TomarAccion" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20px;">
		  
							<table class="table table-bordered" style="border: hidden;"> 
								<div class="">
								  <!--<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_tomar_accion.png"  style="width:100%"/>-->
								  <div style="color:#FFFFFF; height:25.43px; background-image: url(&quot;http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_tomar_accion.png&quot;); text-align: left !important; padding-top: 3px; padding-left: 5px;">TOMAR ACCIÓN</div>
								</div>
								
								<tr style="background:#EEEEEE" align="center"></tr>  
								 <tr style="font-size: auto;">
									<td>
								<?php  
								while($row = pg_fetch_array($resultGridTomarAccion))  
								{  
								?>  
										<div class="alin" style="padding-top: 0px; padding-bottom: 10px;"><div style="line-height: 1.2em;"><?php echo $row["f_reporte_unificado"]; ?></div></div>
								<?php  
								}  
								?>  
								</td>
								</tr>  
							</table>       
				 </div>
			<?php } ?>
			
			<?php if($s2==1 and $sc2==1) {?>
		<!---------------------------------------------------------------------------------------------> 
		<!--------------------------------------------ESTAR PREPARADOS----------------------------------> 
		<!--------------------------------------------------------------------------------------------->
				<div  id="EstarPreparados" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20px;">
							<table class="table table-bordered" style="border: hidden;"> 
								<div class="">
								  <!--<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_preparacion.png"  style="width:100%"/>-->
								  <div style="color:#FFFFFF; height:25.43px; background-image: url(&quot;http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_preparacion.png&quot;); text-align: left !important; padding-top: 3px; padding-left: 5px;">PREPARACIÓN</div>
								</div>
								
								<tr style="background:#EEEEEE" align="center"></tr>  
								 <tr style="font-size: auto;">
									<td>
								<?php  
								while($row = pg_fetch_array($resultGridEstarPreparados))  
								{  
								?>  
										<div class="alin" style="padding-top: 0px; padding-bottom: 10px;"><div style="line-height: 1.2em;"><?php echo $row["f_reporte_unificado"]; ?></div></div>
								<?php  
								}  
								?>  
								</td>
								</tr>  
							</table>  
				</div>
			<?php } ?>

			<?php if($s3==1 and $sc3==1) {?>
		<!---------------------------------------------------------------------------------------------> 
		<!---------------------------------------------ESTAR INFORMADOS--------------------------------> 
		<!--------------------------------------------------------------------------------------------->
				<div   id="EstarInformados" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20;">
							<table class="table table-bordered" style="border: hidden;"> 
								<div class="">
								  <!-- <img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_atencion.png"  style="width:100%"/> -->
								  <div style="color:#797979; height:25.43px; background-image: url(&quot;http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_atencion.png&quot;); text-align: left !important; padding-top: 3px; padding-left: 5px;">ATENCIÓN</div>
								</div>
								
								<tr style="background:#EEEEEE" align="center"></tr>  
								 <tr style="font-size: auto;">
									<td>
								<?php  
								while($row = pg_fetch_array($resultGridEstarInformados))  
								{  
								?>  
										<div class="alin" style="padding-top: 0px; padding-bottom: 10px;"><div style="line-height: 1.2em;"><?php echo $row["f_reporte_unificado"]; ?></div></div>
								<?php  
								}  
								?>  
								</td>
								</tr>  
							</table>    
				</div>
			<?php } ?>

			<?php if($s4==1 and $sc4==1) {?>
		<!---------------------------------------------------------------------------------------------> 
		<!---------------------------------------------ESTAR INFORMADOS--------------------------------> 
		<!--------------------------------------------------------------------------------------------->
				<div   id="CondicionesNormales" style="padding-left: 0px; padding-right: 0px; margin-bottom: -20;">
							 <table class="table table-bordered" style="border: hidden;"> 
								<div class="">
								  <!--<img src="http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_vigilancia.png"  style="width:100%"/>-->
								  <div style="color:#FFFFFF; height:25.43px; background-image: url(&quot;http://srt.marn.gob.sv/web/PronosticoImpacto/Imagenes/l_vigilancia.png&quot;); text-align: left !important; padding-top: 3px; padding-left: 5px;">VIGILANCIA</div>
								</div>
								
								<tr style="background:#EEEEEE" align="center"></tr>  
								 <tr style="font-size: auto;">
									<td>
								<?php  
								while($row = pg_fetch_array($resultGridCondicionesNormales))  
								{  
								?>  
									<div class="alin" style="padding-top: 0px; padding-bottom: 10px;"><div style="line-height: 1.2em;"><?php echo $row["f_reporte_unificado"]; ?></div></div>
								<?php  
								}  
								?>  
								</td>
								</tr>  
							</table>    
				</div>
			<?php } ?>
</td>
</tr>  

<tr>  
	<td >
		<div>
			<table border=0 class="table-bordered"> 
				<tr style="background:#EEEEEE" align="center"></tr>  
				<?php  
				while($row = pg_fetch_array($resultGridAreaResumen))  
				{  
				?>  
				<tr style="background:#FFFFFF;">  
						<td style="vertical-align:middle;"><div style="width:120px; height:120px;"><img src="<?php echo $row["imagen"]; ?>" width="120" height="120"></div></td> 
						<td><div style="margin: auto 8px auto 8px;"><?php echo $row["condiciones"]; ?></div></td>
				</tr>  
				<?php  
				}  
				?>  
			</table>
			
			
			
		</div>
	</td>
</tr>  
</table>  

</div>
</body>
</html>



