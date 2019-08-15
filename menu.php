<?php 
session_start();
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');


// $_SESSION['usuario'] = $row['usuario'];
// $_SESSION['nombre'] = $row['nombre']." ".$row['apellido'];
// $_SESSION['usuario'] = $row['cargo'];
// $_SESSION['role'] = $row['id_rol']; 

echo "<div id='usuario' style='position: absolute;font-family: arial;width: 85%;height: 250px;left: 70px; margin-left: 75px; margin-top: 30px;text-align: right;z-index: 40;'>".@$_SESSION['nombre']."</div>";
?>


