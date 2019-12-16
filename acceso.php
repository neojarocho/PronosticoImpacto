<?php 
session_start();
include("cnn.php");
include("funciones.php");

if (@$_SESSION['error_login']=="")
{
	@$_SESSION['error_login'] = "";
}

echo $_POST['login']."<br>";
echo $_POST['usuario']."<br>";
echo $_POST['password']."<br>";

// exit();


if ($_POST['login']== "si") {
//************************************************************************************

// String to encrypt 
$string1=$_POST['password'];

if ($_POST['password']!=""){
	// EnCrypt string 
	$string2=convert($string1,$key);
} 
// echo $string1."<br>";
// echo $string2."<br>";
// exit();
//************************************************************************************	

		$usuario 	=$_POST['usuario'];
        $contra 	=@$string2;	
	
		if (($usuario=="") || ($contra==""))
		{
			$_SESSION['error_login']="";
		?>
			<script language="JavaScript">
			<!--
    		top.location="login.php";
 			//-->
			</script>
		<?php
		}
		else
		{
		$dbconn = my_dbconn1("PronosticoImpacto");
		$query = "SELECT nombre, apellido, usuario, password, cargo, id_rol FROM usuario WHERE  usuario = '$usuario';";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$totalRows = pg_num_rows($result);	
		$row = pg_fetch_array($result, null, PGSQL_ASSOC);
		pg_close($dbconn);
		
		// echo $query."<br>";
		// exit();
		
		
		// $sql = @mysql_query("SELECT usuario, clave, id_usuario, nombre, apellido FROM usuario WHERE usuario = '$usuario'");
		// $row = @mysql_fetch_array($sql);
		
		if($totalRows>0)
		{
			
			
			if($row['password'] == $contra)
			{
			
			// session_register('Usuario');
			// session_register('role');
			$_SESSION['usuario'] = $row['usuario'];
			$_SESSION['nombre'] = $row['nombre']." ".$row['apellido'];
			$_SESSION['cargo'] = $row['cargo'];
			$_SESSION['role'] = $row['id_rol']; 
			?>
			<script language="JavaScript">
			<!--
    		self.location="index.php";
 			//-->
			</script>
 			<?php
			//}
			
			}
			
			else{
			$_SESSION['error_login']="Contrase&ntilde;a incorrecta";
				
			?>
			<script language="JavaScript">
			<!--
    		top.location="login.php";
 			//-->
			</script>
 			
			<?php
			}
		}
		else
			{
			$_SESSION['error_login']="Usuario incorrecto";
			?>
			<script language="JavaScript">
			<!--
    		top.location="login.php";
 			//-->
			</script>
			<?php
			}
			// mysql_free_result($sql);
			}
			// mysql_close();
} 
else{

			?>
         	<script language="JavaScript">
			<!--
    		top.location="index.php";
 			//-->
			</script>
 			
<?php
// session_destroy();
}
?>
