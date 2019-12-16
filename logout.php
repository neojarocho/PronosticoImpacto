<?php
session_start();
// ---
// la tarea de este archivo es eliminar todo rastro de cookie

// -- eliminamos el usuario
if(isset($_SESSION['nombre'])){
	unset($_SESSION['nombre']);
}

session_destroy();
// v0 29 jul 2013
//estemos donde estemos nos redirije al index
header("Location: login.php");
?>