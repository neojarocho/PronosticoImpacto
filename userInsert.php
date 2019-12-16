<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
include("header.php");
include("cnn.php");
session_start();

$action = @$_REQUEST['a'];
if ($action=="") { $action="insert";}

/// COMBO AREA
$area = '';
$dbconn = my_dbconn4("PronosticoImpacto");
$sql="SELECT id_area, area, des_area FROM public.area ORDER BY id_area;";
$result=pg_query($dbconn, $sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$area .= '<option value="'.$row['id_area'].'">'.$row['area'].'</option>';
} pg_free_result($result);
// print_r($area);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
<script>
$( document ).ready(function() {
  $( "#usuario" ).focus();
});
</script>	
</head>

<body onload="document.myform.nombre.focus()">

<div class="container" style="margin-top: 20px; width:100%;">

<div class="p_letrag" align="center" style="width:100%;font-weight: bold;text-transform: uppercase;">Ingresar Nuevo Usuario</div>
<div>&nbsp;</div>
<!-- -------------------------------------- -->
<!-- ---------- 	INSERT FORM 	---------- -->
<!-- -------------------------------------- -->
<?php if ($_POST["action"] == "insert") { ?>
	<form class="form-horizontal" action="acceso.php" method="post" name="myform" id="myform">
		<div class="form-group">
			<label class="control-label col-sm-4" for="nombre">Nombres:</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba Nombre">
			</div>
		</div>
			

		<div class="form-group">
			<label class="control-label col-sm-4" for="apellido">Apellidos:</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Escriba Apellido">
			</div>
		</div>
		
					
		<div class="form-group">
			<label class="control-label col-sm-4" for="correo">Correo:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="correo" name="correo" placeholder="Escriba Correo">
			</div>	
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="password">Contraseña:</label>
			<div class="col-sm-6">          
				<input type="password" class="form-control" id="password" name="password" placeholder="Escriba contraseña">
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="password">Seleccione Area:</label>
			<div class="col-sm-6">  
				<select name="area" id="area" class="form-control" placeholder="Ingrese Area" required data-required-msg="Ingrese eArea">
				<?php echo $area; ?>
				</select>
			</div>
		</div>
			
			
		<div class="form-group">
			<label class="control-label col-sm-4" for="cargo">Cargo:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="cargo" name="cargo" placeholder="Escriba Cargo">
			</div>
		</div>
		
				
		<div style="padding-bottom:10px;padding-top:10px;">
			<input style="margin-top:5px;" type="button" name="cancel" id="cancel" class="btn btn-info" value="Cancelar"     onclick="HideProgressAnimation();">
			<input style="margin-top:5px;" type="button" name="guardar" id="guardar" class="btn btn-primary" value="Guardar" onclick="saUsuario();">
		</div>
	</form>
<?php } ?>
<!-- -------------------------------------- -->
<!-- ---------- 	UPDATE FORM 	---------- -->
<!-- -------------------------------------- -->
<?php 
	if ($_POST["action"] == "update") {
	$id_user = @$_POST["id"];
	// if ($id_user == "") { $id_user= 1;}
	
	$dbconn = my_dbconn4("PronosticoImpacto");
	$sql="SELECT id_usuario as id, nombre, apellido, usuario, password, id_area, cargo FROM public.usuario WHERE id_usuario = ".$id_user.";";
	$result=pg_query($dbconn, $sql);
	while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$usr[] = $row;
	} pg_free_result($result);	
	$usr = $usr[0];
	
	// echo "<pre>";
	// print_r($usr);
	// echo "</pre>";
	
?>
	<form class="form-horizontal" action="acceso.php" method="post" name="myform" id="myform">
		<div class="form-group">
			<label class="control-label col-sm-4" for="nombre">Nombres:</label>
			<div class="col-sm-6">
			<input type="hidden" class="form-control" id="id" name="id" placeholder="Escriba Nombre"				value="<?php echo $usr['id']?>">
			<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba Nombre"			value="<?php echo $usr['nombre']?>">
			</div>
		</div>
			
		<div class="form-group">
			<label class="control-label col-sm-4" for="apellido">Apellidos:</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Escriba Apellido"		value="<?php echo $usr['apellido']?>">
			</div>
		</div>
					
		<div class="form-group">
			<label class="control-label col-sm-4" for="correo">Correo:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="correo" name="correo" placeholder="Escriba Correo"				value="<?php echo $usr['usuario']?>">
			</div>	
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="password">Contraseña:</label>
			<div class="col-sm-6">          
				<input type="password" class="form-control" id="password" name="password" placeholder="Escriba contraseña"	>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="password">Seleccione Area:</label>
			<div class="col-sm-6">  
				<select name="area" id="area" class="form-control" placeholder="Ingrese Area" required data-required-msg="Ingrese eArea" value="<?php echo $usr['id_area']?>">
				<?php echo $area; ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="cargo">Cargo:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="cargo" name="cargo" placeholder="Escriba Cargo" value="<?php echo $usr['cargo']?>">
			</div>
		</div>
				
		<div class="form-group">        
			<div class="col-sm-12" style="text-align:center;">
			<input style="margin-top:5px;" type="button" name="cancel" id="cancel" class="btn btn-info" value="Cancelar"  onclick="HideProgressAnimation();">
			<input style="margin-top:5px;" type="button" name="update" id="update" class="btn btn-primary" value="Update" onclick="upUsuario();">
			</div>
		</div>
	</form>
<?php } ?>
</div>


</body>
</html>