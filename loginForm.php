<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
// include("header_m.php");
session_start();
?>
	
<script>
$( document ).ready(function() {
  $( "#usuario" ).focus();
});
</script>	
</head>

<body onload="document.myform.usuario.focus()">

<div class="container" style="margin-top: 20px; width:85%; margin-left: 30px;">

			<div class="p_letrag" align="center" style="width:85%">&nbsp;</div>
			<div>&nbsp;</div>
			
		  <form class="form-horizontal" action="acceso.php" method="post" name="myform" id="myform">
			<div class="form-group">
			  <label class="control-label col-sm-2" for="usuario">Usuario:</label>
			  <div class="col-sm-10">
				<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Escriba Usuario">
			  </div>
			</div>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="password">Contraseña:</label>
			  <div class="col-sm-10">          
				<input type="password" class="form-control" id="password" name="password" placeholder="Escriba contraseña">
			  </div>
			</div>
			
		<div style="position: absolute; right: 350px; top: 325px; z-Index:999; color:FF0000">
			<?php 
			echo @$_SESSION['error_login'];
			?>
		</div>

			<div class="form-group">        
			  <div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">ENVIAR</button>
					<input type="hidden" name="Submit2" value="Limpiar" >
					<input name="login" type="hidden" value="si"></td>		
			  </div>
			</div>
		  </form>
</div>


</body>
</html>