<?php
include("cnn.php");

//// CAMPOS DEL MUNICIPIO SELECCIONADO
////------------------------------------------------------------------------------
$dbconn = my_dbconn4("PronosticoImpacto");
$sql="SELECT i.id_impacto_diario_detalle, i.id_impacto_diario, de.departamento, i.cod_municipio, i.municipio, im.id_impacto, im.impacto, pr.id_probabilidad, CONCAT(pr.probabilidad,' - ',pr.valor_probabilidad) as probabilidad, i.id_color, i.id_categoria, i.des_categoria, especial_atencion, descripcion FROM  impacto_diario_detalle i INNER JOIN departamento de ON de.cod_departamento = LEFT(i.cod_municipio, 2) INNER JOIN impacto im ON im.id_impacto = i.id_impacto INNER JOIN probabilidad pr ON pr.id_probabilidad = i.id_probabilidad WHERE i.id_impacto_diario_detalle = ".$_GET["id"]." AND municipio IS NOT NULL ORDER BY i.cod_municipio; ";
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ro[] = $row;
} pg_free_result($result);
$ro = $ro[0];

//// COMBO IMPACTO
////------------------------------------------------------------------------------
$ImpactoFenomeno = "";
$sql ="SELECT id_impacto, impacto FROM public.impacto;";
$result = pg_query($dbconn, $sql );
while($row = pg_fetch_array($result , null, PGSQL_ASSOC)) {
	$ImpactoFenomeno .= '<option value="'.$row['id_impacto'].'">'.$row['impacto'].'</option>';
} pg_free_result($result );


//// COMBO PROBABILIDAD
////------------------------------------------------------------------------------
$Probabilidad = "";
$sql="SELECT id_probabilidad, probabilidad || ' - ' || valor_probabilidad as probabilidad, des_probabilidad FROM public.probabilidad;";
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$Probabilidad .= '<option value="'.$row['id_probabilidad'].'">'.$row['probabilidad'].'</option>';
} pg_free_result($result);

//// OBTENER CONSECUENCIAS CHECKBOX
////------------------------------------------------------------------------------
$co = [];
$sql="SELECT id_consecuencia FROM public.impacto_diario_consecuencias WHERE id_impacto_diario_detalle = ".$ro['id_impacto_diario_detalle'].";";
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$co[] = $row;
} pg_free_result($result);
$co = array_column($co, 'id_consecuencia');

//// OBTENER HORARIOS CHECKBOX
////------------------------------------------------------------------------------
$ho = [];
$sql="SELECT id_horario FROM public.impacto_diario_horario WHERE id_impacto_diario_detalle = ".$ro['id_impacto_diario_detalle'].";";
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ho[] = $row;
} pg_free_result($result);
$ho = array_column($ho, 'id_horario');
// var_dump($ho);

//// CHECK HORARIO
$Horario = "";
$sql="SELECT id_horario, horario	FROM public.horario;";
$result=pg_query($dbconn, $sql);                      
while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	if (in_array($row['id_horario'], $ho)) {
		// echo "found"; 
		$Horario .= "<div class='checkbox' style='text-align:left;'><input name='datos_ho[]' checked='checked' type='checkbox' value=".$row['id_horario'].">".$row['horario']."</div>";
	} 
	else { 
		// echo "not found"; 
		$Horario .= "<div class='checkbox' style='text-align:left;'><input name='datos_ho[]' type='checkbox' value=".$row['id_horario'].">".$row['horario']."</div>";
	} 
	
} pg_free_result($result);             




// $co = $co[0];

// var_dump($co);
// echo "<pre>";
// print_r($co);
// echo "</pre>";
// exit();
?>

<script>
$( document ).ready(function() {
	
function checkValue(value,arr){
	var status = false;
	for(var i=0; i<arr.length; i++){
		var name = arr[i];
		if(name == value){
			status = true;
			break;
		}
	}

	return status;
}	
	

	//alert ('Entro en impacto');
var id_area = $("#id_area").val();
var id_fenomeno = $("#id_fenomeno").val();
var probabilidad = $("#ed_probabilidad").val();
var impacto = $("#ed_impacto").val();

$.ajax({
	url: "MeteorologiaProcesos.php",
	type: "GET",
	data: {id_area:id_area,id_fenomeno:id_fenomeno,impacto:impacto,opt:'consecuencias'},
}).done(function(con){		
var a_co  = <?php echo json_encode($co, JSON_FORCE_OBJECT); ?>;
var a_co2 = Object.values(a_co).map(Number);
var a_ho  = <?php echo json_encode($ho, JSON_FORCE_OBJECT); ?>;
var a_ho2 = Object.values(a_ho).map(Number);
console.log("co: "+a_co2);
console.log("ho: "+a_ho2);	
var obj = jQuery.parseJSON(con);
var id_consecuencia_impacto = obj[0]['id_consecuencia_impacto'];
var consecuencia = obj[0]['consecuencia'];
varCons='';
var size = Object.keys(obj).length;

for (var i = 0; i < size ; i++) {
	var co_id = obj[i]['id_consecuencia_impacto'];
	if ( checkValue(co_id, a_co2) ) {
		varCons +="<div class='checkbox'><input id="+co_id+" checked='checked' name='datos_co[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+">"+obj[i]['consecuencia']+"</div>";
	} else {
		varCons +="<div class='checkbox'><input id="+co_id+" name='datos_co[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+">"+obj[i]['consecuencia']+"</div>";
	}
}
		
// console.log(consecuencia);
$("#ed_ConteConsecuencias").val(consecuencia);
document.getElementById("ed_ConteConsecuencias").innerHTML = varCons;

//CONSULTANDO COLOR SEGUN PROBABILIDAD  -----------------------------------
	if(ed_probabilidad != ''){
		$.ajax({
			url:'MeteorologiaProcesos.php',
			method:"GET",
			data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
			success:function(categoria){
				var cat = jQuery.parseJSON(categoria);
				console.log(cat);
				$('#id_color').val(cat['id_color']);
				$('#ed_categoria').val(cat['categoria']);
				$('#id_categoria').val(cat['id_categoria']);
				$('#id_iprobabilidad').val(cat['id_impacto_probabilidad']);
				if (cat['id_color'] == 1){ $('#ed_categoria').css("background-color" , "rgba(63, 195, 128, 1)");	/*Verde*/ 		}
				if (cat['id_color'] == 2){ $('#ed_categoria').css("background-color" , "rgba(254, 241, 96, 1)");	/*Amarillo*/	}
				if (cat['id_color'] == 3){ $('#ed_categoria').css("background-color" , "rgba(252, 185, 65, 1)");	/*Anaranjado*/	}
				if (cat['id_color'] == 4){ $('#ed_categoria').css("background-color" , "rgba(240, 52, 52, 1)"); 	/*Rojo*/		}
			}
		});
	}
});
});

$('#ed_impacto').change(function() {
		var id_area = $("#id_area").val();
		var id_fenomeno = $("#id_fenomeno").val();
		var probabilidad = $("#ed_probabilidad").val();
		var impacto = $(this).val();
		
		$.ajax({
			url: "MeteorologiaProcesos.php",
			type: "GET",
			data: {id_area:id_area,id_fenomeno:id_fenomeno,impacto:impacto, opt:'consecuencias'},
			}).done(function(con){
				var obj = jQuery.parseJSON(con);
				var size = Object.keys(obj).length;
				var varCons='';
				for (var i = 0; i < size ; i++) {
					varCons +="<div class='checkbox'><input checked='checked' name='datos[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+">"+obj[i]['consecuencia']+"</div>";
				}
				document.getElementById("ed_ConteConsecuencias").innerHTML = varCons;
				if(probabilidad != ''){
					$.ajax({
						url:'MeteorologiaProcesos.php',
						method:"GET",
						data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
						success:function(categoria){
							var cat = jQuery.parseJSON(categoria);
							$('#id_color').val(cat['id_color']);
							$('#ed_categoria').val(cat['categoria']);
							$('#id_categoria').val(cat['id_categoria']);
							$('#id_iprobabilidad').val(cat['id_impacto_probabilidad']);
							if (cat['id_color'] == 1){ $('#ed_categoria').css("background-color" , "rgba(63, 195, 128, 1)");	/*Verde*/ 		}
							if (cat['id_color'] == 2){ $('#ed_categoria').css("background-color" , "rgba(254, 241, 96, 1)");	/*Amarillo*/	}
							if (cat['id_color'] == 3){ $('#ed_categoria').css("background-color" , "rgba(252, 185, 65, 1)");	/*Anaranjado*/	}
							if (cat['id_color'] == 4){ $('#ed_categoria').css("background-color" , "rgba(240, 52, 52, 1)"); 	/*Rojo*/		}
						}
					});
				}
			
			});
});

$('#ed_probabilidad').change(function() {
	var impacto = $("#ed_impacto").val();
	var probabilidad = $(this).val();
	if(impacto != ''){
		$.ajax({
			url:'MeteorologiaProcesos.php',
			method:"GET",
			data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
			success:function(categoria){
				var cat = jQuery.parseJSON(categoria);
				$('#id_color').val(cat['id_color']);
				$('#ed_categoria').val(cat['categoria']);
				$('#id_categoria').val(cat['id_categoria']);
				$('#id_iprobabilidad').val(cat['id_impacto_probabilidad']);
				if (cat['id_color'] == 1){ $('#ed_categoria').css("background-color" , "rgba(63, 195, 128, 1)");	/*Verde*/ 		}
				if (cat['id_color'] == 2){ $('#ed_categoria').css("background-color" , "rgba(254, 241, 96, 1)");	/*Amarillo*/	}
				if (cat['id_color'] == 3){ $('#ed_categoria').css("background-color" , "rgba(252, 185, 65, 1)");	/*Anaranjado*/	}
				if (cat['id_color'] == 4){ $('#ed_categoria').css("background-color" , "rgba(240, 52, 52, 1)"); 	/*Rojo*/		}
			}
		});
	}
						      
});

// ------------------------------------------
// BORRAR MUNICIPIOS DE MENU DE MUNICIPIOS //
// function upContent(va){
	// console.log(va);
	// var id_impacto_diario_detalle 	= va;
	// var id_impacto 					= $("#ed_impacto").val();
	// var id_probabilidad 			= $("#ed_probabilidad").val();

	// $.ajax({
		// async : true,
		// method: "POST",
		// url: "updateMuni.php",
		// data: "id="+va,
		// success: function(msg){
			// $("#verMunicipiosUpdate").html(msg);
		// }
	// });

// }

$('#updateMunicipios_<?php echo $ro['id_impacto_diario_detalle']; ?>').on('submit', function(event){
event.preventDefault();
		var updateMunicipios = $(this).serialize();
		$.ajax({
			url:"MeteorologiaProcesos.php",
			method:"POST",
			data:{formMuniUpdate:updateMunicipios, opcion:'updateContent'},
			success:function(data) {
				var id_imp = $('#id_impacto_diario_m').val();
				document.getElementById("curMuni").innerHTML = data;
				getnoMuni(<?php echo $ro['id_impacto_diario']; ?>);
				addContent(<?php echo $ro['id_impacto_diario']; ?>);
				setTimeout(refresh, 800);
			}
		});

});
</script>

		<form id="updateMunicipios_<?php echo $ro['id_impacto_diario_detalle']; ?>" name="updateMunicipios_<?php echo $ro['id_impacto_diario_detalle']; ?>" action="MeteorologiaProcesos.php" method="post" >
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
							<label>Departamento: <span id="depto" ><?php echo $ro['departamento']; ?></span></label>    
					</div>	
			
					<div class="col-md-6">
							<label>Municipio: <?php echo $ro['municipio']; ?></label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
							<label>Impacto</label>    
							<select name="ed_impacto" id="ed_impacto" class="form-control" placeholder="Ingrese el impacto" required data-required-msg="Ingrese el impacto">
							<option value="<?php echo $ro['id_impacto']; ?>" style="font-style: italic; color: #B2BABB;"><?php echo $ro['impacto']; ?></option>
							<?php echo $ImpactoFenomeno; ?>
							</select>
					</div>	
			
					<div class="col-md-6">
							<label>Probabilidad</label>    
							<select name="ed_probabilidad" id="ed_probabilidad" class="form-control" placeholder="Ingrese la probabilidad " required data-required-msg="Ingrese la probabilidad">
							<option value="<?php echo $ro['id_probabilidad']; ?>" style="font-style: italic; color: #B2BABB;"><?php echo $ro['probabilidad']; ?></option>
							<?php echo $Probabilidad; ?>
							</select>
					</div>
				</div>
				<!-- $("#id_idiario_det").val(va); -->
				<div class="row"><p></p>
					<div class="col-md-12">
						<input type="hidden" 	name="id_idiario"		id="id_idiario" 		value="<?php echo $ro['id_impacto_diario_detalle']; ?>" class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
						<!-- 
						<input type="text" 		name="cod_municipio"	id="cod_municipio" 	value="<?php echo $ro['cod_municipio']; ?>" class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
						<input type="text" 		name="municipio"		id="municipio" 		value="<?php echo $ro['municipio']; ?>" class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
						-->
						<input type="hidden" 	name="id_categoria" 	id="id_categoria"		value="<?php echo $ro['id_categoria']; ?>"	class="form-control k-invalid" required="" data-required-msg="id_categoria" aria-invalid="true">
						<input type="hidden" 	name="id_color" 		id="id_color"			value="<?php echo $ro['id_color'];     ?>"	class="form-control k-invalid" required="" data-required-msg="id_color" aria-invalid="true">
						<input type="hidden" 		name="id_iprobabilidad" id="id_iprobabilidad" 	value="<?php echo $ro['id_impacto_probabilidad']; ?>" class="form-control k-invalid" data-required-msg="filter" aria-invalid="true" >
						<textarea 				name="ed_categoria"		id="ed_categoria" 	class="form-control" style="font-size: 11pt;font-weight: bold"><?php echo $ro['des_categoria']; ?></textarea>
					</div>	
				</div>	
				<!------------------------------------>
				<div class="row"><p></p>
					<div class="col-md-8" style="padding-left: 25px;">
						<label>Consecuencias a afectar</label>
						<div id="ed_ConteConsecuencias" class="form-check" placeholder="Ingrese" required data-required-msg="Ingrese" style="width: 90%; height: 100%;text-align:left;">
						</div>
					</div>	
					
					<div class="col-md-4">
						<label>Horario</label> 
						<div id="contenedorHorario" class="form-check" style="background: #FFFFFF" placeholder="Ingrese horario" required data-required-msg="Ingrese horario">
							<?php echo $Horario; ?>
						</div>
					</div>	
				</div>	
				<div class="col-md-12">
						<label style="display:block; width:x; height:y; text-align:left;">Especial Atención</label>
						<input type="text"		name="atencion"			id="atencion" 		value="<?php echo $ro['especial_atencion']; ?>" class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" >
						<label style="display:block; width:x; height:y; text-align:left;">Descripción</label>
						<textarea 				name="descripcion"		id="descripcion" class="form-control" style="font-size: 11pt;font-weight: bold"><?php echo $ro['descripcion']; ?></textarea>
					<br>
				</div>	

				<div>
					<input type="button" name="cancel" id="cancel" class="btn btn-info" value="Cancelar" onclick="toggle_visibility('loading-div-popup-form')" />
					<!--<input type="button" name="update" id="update" class="btn btn-primary" value="Actualizar" onclick="upContent(<?php echo $ro['id_impacto_diario_detalle']; ?>)" />-->
					<input type="submit" name="update" id="update" class="btn btn-primary" value="Actualizar"  />
					<div><br></div>
				</div>
			</div>
		</form>
	<div id="verMunicipiosUpdate" class="row" >
		<div class="col-md-12">
		</div>
	</div>