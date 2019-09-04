<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
include("cnn.php");
?>

<?php 
// print_r($_POST);
// print_r($_POST['cad']);
if(isset($_POST['opcion'])){ 

	// Abrimos una conexion a la base de datos
	include_once("cnn.php");

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	//	INSERTAR MUNICIPIOS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	if($_POST["opcion"] == 'editUnificado'){

		$porciones = explode("&", urldecode ($_POST['cad']));
		// print_r($porciones);
		
		function xplo($val) {
			$v = explode("=", $val);
			return $v;
		}
	
		$ar = [];
		for ($i=0; $i<=count($porciones)-1; $i++) 			{
			if (xplo($porciones[$i])[0] == 'i_id_uni')		{	$ar['i_id_uni']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'i_titulo')		{	$ar['i_titulo']			= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'i_descripcion')	{	$ar['i_descripcion']	= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'i_u1')			{	$ar['i_u1']				= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'i_u2')			{	$ar['i_u2']				= xplo($porciones[$i])[1];}
			if (xplo($porciones[$i])[0] == 'i_u3')			{	$ar['i_u3']				= xplo($porciones[$i])[1];}
			// echo $i;
		}		
		// print_r($ar);
		// exit();
?>
<style>
	label {
		width: 100%;
		display: block;
		padding-bottom: 0px;
		padding-top: 10px;
		font-weight: bold;
		text-transform: uppercase;
		font-size: 12px;
		color: #286090;
		text-align:left;
	}
</style>
<script>
$('#updateInformeform').on('submit', function(event){
event.preventDefault();
// console.log("AQUI ESTAMOS");
var updateInformeform = $(this).serialize();
// console.log(updateInformeform);

var msg =	"<div style='padding-bottom:10px;padding-top:10px;'>"+
			"<h4 style='text-align:center;font-weight:bold;'>INFORMACIÓN GUARDADA</h4>"+
			"<div style='font-size:14px;'>Se actualizara la vista al cerrar</div>"+
			"<input style='margin-top:5px;' type='button' name='cancel'		id='cancel'		class='btn btn-info'    value='CERRAR' 	onclick='recargar();' />"+
			"</div>";

	$.ajax({
		url:"MeteorologiaProcesos.php",
		method:"POST",
		data:{updateInformeform:updateInformeform, opcion:'updateIntegrado'},
		success:function(data) {
			console.log(data);
			$("#editUnificado").html(msg);
		}
	});

});
</script>
<h4 style="text-align:center;font-weight:bold;">Modificar Informe de Pronóstico de Impactos</h4>
	<div id="success">
		<form id="updateInformeform" name="updateInformeform" action="MeteorologiaProcesos.php" method="POST" >
			<div class="col-md-12">
				<div class="row"><p></p>
					<div class="col-md-12">
						<label>Título</label>  
						<input type="hidden" name="i_id_uni"	id="i_id_uni"	value="<?php echo $ar['i_id_uni']; ?>" 	class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
						<input type="text" 	 name="i_titulo"	id="i_titulo"	value="<?php echo $ar['i_titulo']; ?>" 	class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
					</div>	
					<div class="col-md-12">
						<label>Descripción</label>  
						<textarea			name="i_descripcion"	id="i_descripcion" 	class="form-control"><?php echo $ar['i_descripcion']; ?></textarea>
					</div>					
					
					<div class="col-md-12">
						<label>Meteorológicas:</label>  
						<input type="text" 	name="i_u1"				id="i_u1"			value="<?php echo $ar['i_u1']; ?>"  	class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
					</div>	
					<div class="col-md-12">
						<label>Hidrológicas:</label>  
						<input type="text" 	name="i_u2" 			id="i_u2"			value="<?php echo $ar['i_u2']; ?>"		class="form-control k-invalid" data-required-msg="id_categoria" aria-invalid="true">
					</div>		
					
					<div class="col-md-12">
						<label>Amenaza por deslizamientos:</label>  
						<input type="text" 	name="i_u3" 			id="i_u3"			value="<?php echo $ar['i_u3']; ?>"		class="form-control k-invalid" data-required-msg="id_color" aria-invalid="true">
					</div>
					
				</div>	
				<!------------------------------------>

				<div style="padding-bottom:10px;padding-top:10px;">
					<input style="margin-top:5px;" type="button" name="cancel"		id="cancel"		class="btn btn-info"    value="Cancelar" 	onclick="HideProgressAnimation();" />
					<input style="margin-top:5px;" type="submit" name="update" id="update" class="btn btn-primary" value="Actualizar"  />
				</div>
			</div>
		</form>
	</div>
<!--		
	<div id="verMunicipiosUpdate" class="row" >
		<div class="col-md-12">
		</div>
	</div>
-->
<?php 
	}
}
?>