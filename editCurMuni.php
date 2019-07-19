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
<<<<<<< HEAD
// echo $sql;
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$ho[] = $row;
} pg_free_result($result);
$ho = array_column($ho, 'id_horario');
// var_dump($ho);

//// CHECK HORARIO
$Horario = "";
$sql="SELECT id_horario, horario	FROM public.horario;";
<<<<<<< HEAD
$result=pg_query($dbconn, $sql);    
       
$cuentah = 0;	   
while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	if (in_array($row['id_horario'], $ho)) {
		// echo "found"; 
		$Horario .= "<div class='checkbox' style='text-align:left;'><input class='grouped1' name='datos_ho[]' type='checkbox' value=".$row['id_horario']."  checked='checked' >".$row['horario']."</div>";
		$cuentah+=1;
	} 
	else { 
		// echo "not found"; 
		$Horario .= "<div class='checkbox' style='text-align:left;'><input class='grouped1' name='datos_ho[]' type='checkbox' value=".$row['id_horario']."  >".$row['horario']."</div>";
		// $cuentah=0;
	} 
	
} pg_free_result($result);  
// echo $cuentah;     

## Especial Atencion
$EspecialAtencion = "";
$sql ="SELECT id_especial_atencion, especial_atencion FROM public.especial_atencion WHERE cod_municipio = '".$ro['cod_municipio']."' AND id_area = ".$_GET["area"]."; ";
$result=pg_query($dbconn, $sql);                      
while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$EspecialAtencion .= "<div class='checkbox' style='text-align:left;'><input id=".$row['id_especial_atencion']." name='datos_ea[]' type='checkbox' onClick='handleClick($(this).attr(&#39;id&#39;))' value=".$row['especial_atencion']." >".$row['especial_atencion']."</div>";
		$array_ea[$row['id_especial_atencion']] = $row['especial_atencion'];
} pg_free_result($result);  
// echo $EspecialAtencion;
if (count(@$array_ea)==0){
	$array_ea="";
	$EspecialAtencion .= "<div class='checkbox' style='align:center;color:red;'>NO HAY ELEMENTOS ASIGNADOS</div>";
}


// $co = $co[0];
// var_dump($co);
// echo "<pre>";
// print_r($co);
// print_r(@$array_ea);
// echo "</pre>";
// exit();

=======
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
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD
var probabilidad = $("#ed_probabilidad").val();
var id_area = $("#id_area").val();
var id_fenomeno = $("#id_fenomeno").val();
var impacto = $("#ed_impacto").val();

// ConteConsecuencias
// contenedorHorario
function validaCon(name) {

	if($("#err" + name).length != 0) {
		$("#err" + name).remove();
	}	
	if(jQuery("#"+name+" input[type=checkbox]:checked").length >=1) {
		$("#"+name).after("<div id='err"+name+"' style='text-align:center;color:red;'></div>");
		vali = true;
		} 
	else {
		$("#"+name).after("<div id='err"+name+"' style='text-align:center;color:red;'>SELECCIONA UN VALOR</div>");
		vali = false;
		}
	return vali;
}

// console.log("a:f:i");
// console.log(id_area+":"+id_fenomeno+":"+impacto);

=======
var id_area = $("#id_area").val();
var id_fenomeno = $("#id_fenomeno").val();
var probabilidad = $("#ed_probabilidad").val();
var impacto = $("#ed_impacto").val();

>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
$.ajax({
	url: "MeteorologiaProcesos.php",
	type: "GET",
	data: {id_area:id_area,id_fenomeno:id_fenomeno,impacto:impacto,opt:'consecuencias'},
}).done(function(con){		
var a_co  = <?php echo json_encode($co, JSON_FORCE_OBJECT); ?>;
var a_co2 = Object.values(a_co).map(Number);
var a_ho  = <?php echo json_encode($ho, JSON_FORCE_OBJECT); ?>;
var a_ho2 = Object.values(a_ho).map(Number);
<<<<<<< HEAD
// console.log("co: "+a_co2);
// console.log("ho: "+a_ho2);	
var obj = jQuery.parseJSON(con);
// console.log(obj);
if (obj!=false){
	var id_consecuencia_impacto = obj[0]['id_consecuencia_impacto'];
	var consecuencia = obj[0]['consecuencia'];
	varCons='';
	var size = Object.keys(obj).length;

	for (var i = 0; i < size ; i++) {
		var co_id = obj[i]['id_consecuencia_impacto'];
		if ( checkValue(co_id, a_co2) ) {
			varCons +="<div class='checkbox'><input id="+co_id+" name='datos_co[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+" checked='checked'>"+obj[i]['consecuencia']+"</div>";
		} else {
			varCons +="<div class='checkbox'><input id="+co_id+" name='datos_co[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+" >"+obj[i]['consecuencia']+"</div>";
		}
	}
} else varCons = "<div class='checkbox' style='text-align:center; color:red;'>NO HAY ELEMENTOS ASIGNADOS</div>";		
=======
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
		
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
// console.log(consecuencia);
$("#ed_ConteConsecuencias").val(consecuencia);
document.getElementById("ed_ConteConsecuencias").innerHTML = varCons;

//CONSULTANDO COLOR SEGUN PROBABILIDAD  -----------------------------------
<<<<<<< HEAD
if(ed_probabilidad != ''){
	$.ajax({
		url:'MeteorologiaProcesos.php',
		method:"GET",
		data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
		success:function(categoria){
			var cat = jQuery.parseJSON(categoria);
			// console.log(cat);
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
=======
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
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD
					varCons +="<div class='checkbox'><input checked='checked' name='datos[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+" >"+obj[i]['consecuencia']+"</div>";
=======
					varCons +="<div class='checkbox'><input checked='checked' name='datos[]' type='checkbox' value="+obj[i]['id_consecuencia_impacto']+">"+obj[i]['consecuencia']+"</div>";
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
				}
				document.getElementById("ed_ConteConsecuencias").innerHTML = varCons;
				if(probabilidad != ''){
					$.ajax({
						url:'MeteorologiaProcesos.php',
						method:"GET",
						data: {probabilidad:probabilidad,impacto:impacto, opt:'categoria'},
						success:function(categoria){
<<<<<<< HEAD
							console.log(categoria);
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD
// ConteConsecuencias
// contenedorHorario
if(validaCon('ed_ConteConsecuencias')==false)  { return;}
if(validaCon('ed_contenedorHorario')==false)  { return;}

=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD

function todoElDia() {
if($("input.grouped2").is(":checked") == true){
	$("input.grouped1").prop("disabled", true);
	// console.log('DESABILITADO');
}
else 
	$("input.grouped1").prop("disabled", false);
	// console.log('HABILITADO');
}

var cad    = new Array();
// var cad    = $('#atencion').val();
cad = $('#atencion').val().split(',');
console.log('***'+cad+'***');
if (cad.length >0 ){ cad = $('#atencion').val().split(','); }
var arrCaf = <?php echo json_encode($array_ea); ?>;
var arrObj = Object.keys(arrCaf).map(function (key) { return arrCaf[key]; });

function handleClick(e) {
var va  = "";
	if($("#"+e).is(":checked") == true){
		va = arrCaf[e];
		cad.push(va);
	}
	else { 
		cad.pop(va);
	}
	// console.log(cad.join(', '));
	$('#atencion').val(cad.join(', '));
	if ($('#atencion').val().substring(0,2)==", "){
		rep = $('#atencion').val().slice(2);
		$('#atencion').val(rep);
	}

}


function objectKeyByValue (obj, val) {
  n = Object.entries(obj).find(i => i[1] === val);
  return n[0];
}

function myFunction(item, index) {
	if(jQuery.inArray(item, arrObj)!== -1) { 
		idd = parseInt(objectKeyByValue (arrCaf, item));
		$('#'+idd).prop('checked',true);
		// console.log(idd+'-'+item);
	}
	return 
}

function popCad() {
	cd = $('#atencion').val();
	arrCad = cd.split(", ");
	// diff = $(arrCaf).not(arrCad).get();
	arrCad.forEach(myFunction);
}

popCad();
=======
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD
						<input type="hidden" 	name="id_iprobabilidad" id="id_iprobabilidad" 	value="<?php echo $ro['id_impacto_probabilidad']; ?>" class="form-control k-invalid" data-required-msg="filter" aria-invalid="true" >
=======
						<input type="hidden" 		name="id_iprobabilidad" id="id_iprobabilidad" 	value="<?php echo $ro['id_impacto_probabilidad']; ?>" class="form-control k-invalid" data-required-msg="filter" aria-invalid="true" >
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
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
<<<<<<< HEAD
						<div id="ed_contenedorHorario" class="form-check" style="background: #FFFFFF" placeholder="Ingrese horario" required data-required-msg="Ingrese horario">
							<?php echo $Horario; ?>
							<div class='checkbox' style='text-align:left;'><input class='grouped2' name='datos_ho[]' type='checkbox' value="5" onClick='todoElDia()'>Todo el día</div>
=======
						<div id="contenedorHorario" class="form-check" style="background: #FFFFFF" placeholder="Ingrese horario" required data-required-msg="Ingrese horario">
							<?php echo $Horario; ?>
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
						</div>
					</div>	
				</div>	
				<div class="col-md-12">
<<<<<<< HEAD
					<div class="col-md-6">
						<label style="text-align:left;">Especial Atención</label> 
						<div id="especialAtencion" class="form-check" style="background: #FFFFFF" placeholder="Ingrese horario" required data-required-msg="Ingrese horario">
							<?php echo $EspecialAtencion;?>
						</div>
					</div>	
					<div class="col-md-6">
						<!--<label style="display:block; width:x; height:y; text-align:left;">Especial Atención</label>-->
						<input type="hidden"		name="atencion"			id="atencion" 		value="<?php echo $ro['especial_atencion']; ?>" class="form-control k-invalid" data-required-msg="Impacto diario Detalle" aria-invalid="true" readonly="readonly">
						<label style="display:block; width:x; height:y; text-align:left;">Descripción</label>
						<textarea 				name="descripcion"		id="descripcion" class="form-control" style="font-size: 11pt;font-weight: bold; height:75px;"><?php echo $ro['descripcion']; ?></textarea>
					</div>
				</div>	

				<div style="padding:bottom;padding-top:5px;">
					<input style="margin-top:5px;" type="button" name="cancel" id="cancel" class="btn btn-info" value="Cancelar" onclick="toggle_visibility('loading-div-popup-form')" />
					<input style="margin-top:5px;" type="submit" name="update" id="update" class="btn btn-primary" value="Actualizar"  />
					<!--<input type="button" name="update" id="update" class="btn btn-primary" value="Actualizar" onclick="upContent(<?php echo $ro['id_impacto_diario_detalle']; ?>)" />-->
=======
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
>>>>>>> 2cb5af4d6d5e40748d6eae412e979d2a944a1bb3
				</div>
			</div>
		</form>
	<div id="verMunicipiosUpdate" class="row" >
		<div class="col-md-12">
		</div>
	</div>